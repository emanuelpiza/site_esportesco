#!/bin/bash -x
exec > ./log.txt 2>&1
set -x

#Log
now_ini=$(date +"%Y%m%d %T")

arquivo="$1"
inicio="$2"
duracao="$3"
lado="$4"
jogada="$5"
jogador="$6"
equipe="$7"
direita=(0 1400)
if (( $lado == 0 )); then gol="bar"; else gol="fundo"; fi
duracao="17"
IFS=: read -r h m s <<<"$inicio"
#inicio_s=$(((h * 60 + m) * 60 + s - 8))
#Começando 8 segundos antes do momento do gol

video="${arquivo}_${gol}_h${h}m${m}s${s}_dur${duracao}"
echo "arquivo= $1 inicio= $2  duracao= $3  lado= $4  jogada= $5  jogador= $6  equipe= $7" >> log.txt
if (( $equipe > 2 )); then filters=""; else filters="-vf crop=1400:787:${direita[$lado]}:150 -movflags faststart"; fi

/home/ubuntu/bin/ffmpeg -i ../../../videos/${arquivo}.mp4 -ss $inicio -t $duracao $filters ./lances/${video}.mp4 2>&1  & wait

mysql --host=localhost --user=root --password=k1llersql Esportes << EOF
insert into plays 
	(video_id,
	plays_players_id,
	players_name, 
	teams_name, 
	plays_play_types_id, 
	plays_left_side, 
	plays_duration, 
	initial_time,
	date) 
values
	('$video', 
	'$jogador', 
	(select players_name from players where id_players='$jogador'),
	(select teams_name from teams where id_teams='$equipe'),
	'$jogada',
	'$lado',
	'$duracao',
	'$inicio_s',
	(select datetime from videos where webaddress='$arquivo'));
EOF


now_fim=$(date +"%Y%m%d %T")
echo "\n${video}, $dia_pasta,Inicio: $now_ini Final : $now_fim" >> log.txt

