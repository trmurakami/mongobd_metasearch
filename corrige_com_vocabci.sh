#!/bin/bash

vocabci_result=""
vocabci_result_id=""

consulta_vocabci() {
  query=$(echo $1 | sed 's/ /+/g')
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg=$query"
  vocabci_result=$(curl -s -G -L $url | xmlstarlet sel -t -v "//string")
  vocabci_result_id=$(curl -s -G -L $url | xmlstarlet sel -t -v "//term_id")
}

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
 instituicao=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 4 | sed -e 's/\"//g' | sed -e "s/'//g" | sed -e 's/\\n/ /g' | sed -e 's/\"//g')
 instituicao_limpa=$(echo "$instituicao" | sed "s/[^a-z|0-9|A-Z| ]//g")
 autor=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 3 | sed -e 's/\"//g' )
 autor_limpo=$(echo "$autor" | sed "s/[^a-z|0-9|A-Z| ]//g")
 consulta_vocabci $instituicao_limpa
 result_inst=$(printf "$vocabci_result" | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_inst_id=$(printf "$vocabci_result_id")
 consulta_vocabci $autor_limpo
 result_autor=$(printf "$vocabci_result" | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_autor_id=$(printf "$vocabci_result_id")
 instituicao_count=$(echo "$instituicao" | wc -m) 
 result_count=$(echo "$result_inst" | wc -m) 
 result_count_autor=$(echo "$result_autor" | wc -m)

if [[ $instituicao_count == "1" ]]
then 
    line=$(printf "%s\n" "$line" | sed "s/\"$/\"\,\"\"/g")
else
    line=$(printf "%s\n" "$line")	
fi

if [[ $result_count -gt "1" ]] 
then
   line=$(printf "%s\n" "$line" | sed "s|"$instituicao"|"$result_inst"|g" | sed 's/$/\,\"'$result_inst_id'\"/g')
else 
   line=$(printf "%s\n" "$line" | sed "s|$|\,\""$instituicao_limpa"\"|g")
fi

if  [[ $result_count_autor -gt "1" ]]
then
line=$(printf "%s\n" "$line" | sed "s|"$autor"|"$result_autor"|g" | sed 's/$/\,\"'$result_inst_id'\"/g')
else 
   line=$(printf "%s\n" "$line" | sed "s|$|\,\""$autor_limpo"\"|g")
fi
printf "%s\n" "$line" 
done

