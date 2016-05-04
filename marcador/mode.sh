#!/bin/bash -x

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

IFS=: read -r h m s <<<"$inicio"
inicio_s=$(((h * 60 + m) * 60 + s))

video=$"${arquivo}_${lado}_${inicio_s}_${duracao}"
echo "${video}, $dia_pasta,Inicio: $now_ini Jogador: $jogador " >> log.txa
t
if (( $equipe == 3 )); then crop=""; else crop="crop=1400:787:${direita[$lado]}:150"; fi

ffmpeg -i ../../../videos/${arquivo}.mp4 -ss $inicio -t $duracao -vf "$crop" ./lances/${video}.mp4  & wait

mysql --host=localhost --user=root --password=k1llersql esportes_co << EOF
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
echo "${video}, $dia_pasta,Inicio: $now_ini Final : $now_fim" >> log.txt
