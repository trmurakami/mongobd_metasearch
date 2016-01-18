#!/bin/bash

printf "_id,title,date,subject,subject_id,\\n"

#Declarando variáveis

vocabci_result=""
vocabci_result_id=""

#Funções

consulta_termo() {
  query=$(echo $1 | sed 's/ /+/g')
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetch&arg=$query"
  vocabci_result_id=$(curl -s -G -L $url | xmlstarlet sel -t -v "//term_id")
  url2="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetchTerm&arg=$vocabci_result_id"
  vocabci_result=$(curl -s -G -L $url2 | xmlstarlet sel -t -v "//string")
}


IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
line=$(printf "%s\n" "$line" | sed "s/\",\"/|/g")
_id=$(printf "%s\n" "$line" | cut -d "|" -f 1 | sed 's/\"//g')
title=$(printf "%s\n" "$line" | cut -d "|" -f 2)
date=$(printf "%s\n" "$line" | cut -d "|" -f 3 | sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/\s//g')
subject=$(printf "%s\n" "$line" | cut -d "|" -f 4 | sed 's/\", \"/|/g' | sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/^\s//g' | sed 's/\s$//g' | sed 's/;/|/g' | sed "s/\",\"/|/g" )

	IFS='|' read -ra subject <<< "$subject"
	for i in "${subject[@]}"; do
     subject_one=$(echo $i | sed 's/^ //g' | sed 's/ $//g')

     consulta_termo $subject_one
    result_count_subject=$(echo "$vocabci_result" | wc -m)

     			#Se autor teve resposta
     			if  [[ $result_count_subject -gt "1" ]]
     			then
     				subject_tematres=$(printf "$vocabci_result")
     				subject_tematres_id=$(printf "$vocabci_result_id")
     			else
     			  subject_tematres=$(printf "$subject_one")
     				subject_tematres_id=$(printf "$subject_one")
     			fi



    line=$(printf "%s\n" "\"$_id\",\"$date\",\"$subject_tematres\",\"$subject_tematres_id\"")
    printf "%s\n" "$line"
  done

done
