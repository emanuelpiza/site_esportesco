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
partida="$7"
campo="$8"
is_two_cameras="$9"
direita=(0 1400)
canal=$(($lado+(($campo-1)*2)))
altura=(650 615 630 630) 
IFS=: read -r h m s <<<"$inicio"
inicio_ss=$(((h * 60 + m) * 60 + s - 14 ))

s=$(echo $2| cut -d : -f 3)
m=$(echo $2| cut -d : -f 2)
h=$(echo $2| cut -d : -f 1)
if [ -z "$s" ]; then s=$m; m=$h; h=0; fi

video="${arquivo}_${gol}_${h}h${m}m${s}s_${duracao}"
echo "$now_ini arquivo= $1 inicio= $inicio_ss  duracao= $3  lado= $4  jogada= $5  jogador= $6  equipe= $7" >> log.txt
if (( $is_two_cameras == 0 )); then filters=""; else filters="-vf crop=1400:787:${direita[$lado]}:500 -movflags faststart"; fi
ffmpeg -ss $inicio_ss -i ../../../videos/${arquivo}.mp4 -ss 00:00:05 -t $duracao $filters ./lances/${video}.mp4 2>&1  & wait

mysql --host=localhost --user=root --password=k1llersql Esportes << EOF
insert into plays 
	(video_id,
	plays_players_id,
	players_name, 
	match_id, 
	plays_play_types_id, 
	plays_left_side, 
	plays_duration, 
	initial_time,
	datetime) 
values
	('$video', 
	'$jogador', 
	(select players_name from players where id_players='$jogador'),
	'$partida',
	'$jogada',
	'$lado',
	'$duracao',
	'$inicio',
	'$now_ini');
EOF


now_fim=$(date +"%Y%m%d %T")
echo "\n${video}, $dia_pasta,Inicio: $now_ini Final : $now_fim" >> log.txt

