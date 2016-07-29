#!/bin/bash -x
#exec >> ./log.txt 2>&1

lado="$1"
campo="$2"
direita=(0 1400)
canal=$(($lado+(($campo-1)*2)))
altura=(x 150 150)
echo $canal
