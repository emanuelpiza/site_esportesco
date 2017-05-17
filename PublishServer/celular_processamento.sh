#!/bin/bash

echo "Equipe $1 data $2 inicio: $3 Final: $4 Field: $5 Match: $6 Duas Cameras: $7" >> /tmp/file

#Declaracao de variaveis utilizadas e Log inicial
equipe="$1"
data=$(date "--date=$2" +%Y%m%d)
dia=$(date "--date=$2" +%d)
mes=$(date "--date=$2" +%m)
data_pasta=$(date "--date=$2" +%Y-%m-%d)
inicio="$3"
dir="/var/www/videos/uploads/"
field_id="$5"
match_id="$6"
is_two_cameras="$7"

MONTHS=(ZERO Janeiro Fevereiro Março Abril Maio Junho Julho Agosto Setembro Outubro Novembro Dezembro)

now_ini=$(date +"%Y%m%d %T")

#Concatenando
find ${dir}${match_id}/files/* -type f -printf "file './files/%f'\n" > ${dir}/${match_id}/upload_list.txt
sort --output=${dir}/${match_id}/upload_list.txt ${dir}/${match_id}/upload_list.txt
< /dev/null ffmpeg -f concat -safe 0 -i ${dir}/${match_id}/upload_list.txt -c copy ${dir}${match_id}/final.mp4 & wait

/usr/bin/mysql --host=localhost --user=root --password=k1llersql Esportes << EOF
	update matches set 
        	status = 6,
                last_status = NOW()
        where id= $match_id;
EOF
