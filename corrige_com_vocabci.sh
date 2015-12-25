#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
 instituicao=$(echo "$line"|cut -d "," -f 5 | sed -e 's/\"//g')
 #printf "%s\n" "$instituicao"
 result=$(./consulta_vocabci.sh $instituicao)
 printf "%s\n" "$instituicao:" "$result"
done 
