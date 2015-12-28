#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
 instituicao=$(echo "$line" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 4 | sed -e 's/\"//g' )
 result=$(./consulta_vocabci.sh $instituicao | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_count=$(echo "$result" | wc -m) 
 if [ $result_count -gt "1" ]
   then
    printf "%s\n" "$line" | sed "s|"$instituicao"|"$result"|g"
   else
    printf "%s\n" "$line"
   fi
done 
