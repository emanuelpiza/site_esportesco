#!/bin/bash -x
#exec >> ./log.txt 2>&1
set -x

#Log
now_ini=$(date +"%Y-%m-%d %T")

arquivo="$1"
inicio="$2"
duracao="$3"
lado="$4"
jogada="$5"
jogador="$6"
equipe="$7"
direita=(0 1400)
if (( $lado == 0 )); then gol="b"; else gol="f"; fi

IFS=: read -r h m s <<<"$inicio"
inicio_ss=$(((h * 60 + m) * 60 + s - 10 ))

s=$(echo $2| cut -d : -f 3)
m=$(echo $2| cut -d : -f 2)
h=$(echo $2| cut -d : -f 1)
if [ -z "$s" ]; then s=$m; m=$h; h=0; fi

video="${arquivo}_${gol}_${h}h${m}m${s}s_${duracao}"
echo "$now_ini arquivo= $1 inicio= $inicio_ss  duracao= $3  lado= $4  jogada= $5  jogador= $6  equipe= $7" >> log.txt
if (( $equipe == 3 )); then filters=""; else filters="-vf crop=1400:787:${direita[$lado]}:150 -movflags faststart"; fi

ffmpeg -i ../../../videos/${arquivo}.mp4 -ss $inicio_ss -t $duracao $filters ./lances/${video}.mp4 2>&1  & wait

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
	datetime) 
values
	('$video', 
	'$jogador', 
	(select players_name from players where id_players='$jogador'),
	(select teams_name from teams where id_teams='$equipe'),
	'$jogada',
	'$lado',
	'$duracao',
	'$inicio',
	'$now_ini');
EOF


now_fim=$(date +"%Y%m%d %T")
echo "\n${video}, $dia_pasta,Inicio: $now_ini Final : $now_fim" >> log.txt

