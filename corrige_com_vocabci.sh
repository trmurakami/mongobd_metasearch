#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
semmudanca=$(echo $line) 
 instituicao=$(echo "$line"|cut -d "," -f 5 | sed -e 's/\"//g')
 result=$(./consulta_vocabci.sh $instituicao)
result_count=$(echo "$result" | wc -m) 
 if [ $result_count -gt "1" ]
   then
    printf "%s\n" "$line" | sed "s/\"$instituicao\"/\"$result\"/g"
   else
    printf "%s\n" "$line"
   fi
done 
