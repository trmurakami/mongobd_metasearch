#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
 instituicao=$(echo "$line"|cut -d "," -f 5 | sed -e 's/\"//g')
 #printf "%s\n" "$instituicao"
 result=$(./consulta_vocabci.sh $instituicao)
result_count=$(echo "$result" | wc -m) 
#printf $result_count

 if [ $result_count -gt "1" ]
   then
    printf "%s\n" "$result"
   else
    printf "%s\n" "else"
   fi
#printf "%s\n" "$instituicao:" "$result"
done 
