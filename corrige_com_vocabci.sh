#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
 instituicao=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 4 | sed -e 's/\"//g' | sed -e "s/'//g" )
 autor=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 3 | sed -e 's/\"//g' )
 result_inst=$(./consulta_vocabci.sh $instituicao | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_autor=$(./consulta_vocabci.sh $autor | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_count=$(echo "$result_inst" | wc -m) 
 result_count_autor=$(echo "$result_autor" | wc -m)

if [[ $result_count -gt "1" ]] 
   then
   line=$(printf "%s\n" "$line" | sed "s|"$instituicao"|"$result_inst"|g")
else 
   line=$(printf "%s\n" "$line")
fi
if  [[ $result_count_autor -gt "1" ]]
then
line=$(printf "%s\n" "$line" | sed "s|"$autor"|"$result_autor"|g")
else 
   line=$(printf "%s\n" "$line")
fi
printf "%s\n" "$line"
done

