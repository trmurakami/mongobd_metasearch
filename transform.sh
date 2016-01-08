#!/bin/bash

printf "_id,date,creator,institution,institution_id,creator_id\\n"

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
line=$(printf "%s\n" "$line" | sed "s/\",\"/|/g")
_id=$(printf "%s\n" "$line" | cut -d "|" -f 1 | sed 's/\"//g')
journalci_title=$(printf "%s\n" "$line" | cut -d "|" -f 2)
language=$(printf "%s\n" "$line" | cut -d "|" -f 3 | sed 's/, /|/g' | sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/\s//g')
date=$(printf "%s\n" "$line" | cut -d "|" -f 4 | sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/\s//g')
creator=$(printf "%s\n" "$line" | cut -d "|" -f 5 | sed 's/\", \"/|/g' | sed 's/\"\"/\"/g'| sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/^\s//g' | sed 's/\s$//g')


IFS='|' read -ra creator <<< "$creator"
	for i in "${creator[@]}"; do
		autor=$(printf "$i" | cut -d ";" -f 1)
		autor_limpo=$(printf "$i" | cut -d ";" -f 1 | sed "s/[^a-z|0-9|A-Z| ]//g")
		instituicao=$(printf "$i" | cut -d ";" -f 2 | sed 's/^\s//g' | sed 's/,/|/g')
		instituicao_limpa=$(echo "$instituicao" | sed "s/[^a-z|0-9|A-Z| ]//g")
		line=$(printf "%s\n" "\"$_id\",\"$journalci_title\",\"$language\",\"$date\",\"$autor_limpo\",\"$instituicao_limpa\"")
	done

#Imprime resultado

printf "%s\n" "$line"
	

done

