#!/bin/bash

#Declarando variáveis

vocabci_result=""
vocabci_result_id=""
instautor_result=""
instautor_result_id=""


#Funções

consulta_vocabci() {
  query=$(echo $1 | sed 's/ /+/g')
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg=$query"
  vocabci_result=$(curl -s -G -L "$url" | xmlstarlet sel -t -v "//string")
  vocabci_result_id=$(curl -s -G -L "$url" | xmlstarlet sel -t -v "//term_id")
}

consulta_instautor(){
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetchRelated&arg=$1"
  instautor_result=$(curl -s -G -L "$url" | xmlstarlet sel -I -t -m '//string' -v "concat(.,'|')" | sed 's/|$//g')
  instautor_result_id=$(curl -s -G -L "$url" | xmlstarlet sel -I -t -m '//term_id' -v "concat(.,'|')" | sed 's/|$//g')
}


# Lê o arquivo, linha por linha 

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
#Procura a instituição
 instituicao=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 4 | sed -e 's/\"//g' | sed -e "s/'//g" | sed -e 's/\\n/ /g' | sed -e 's/\"//g')
#Limpa os caracteres especiais da instituição
 instituicao_limpa=$(echo "$instituicao" | sed "s/[^a-z|0-9|A-Z| ]//g")
#Procura o autor
 autor=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 3 | sed -e 's/\"//g' )
#Limpa os caracteres especiais do autor
 autor_limpo=$(echo "$autor" | sed "s/[^a-z|0-9|A-Z| ]//g")
#Consulta a instituição no Vocabci usando a função consulta_vocabci
 consulta_vocabci $instituicao_limpa
 result_inst=$(printf "$vocabci_result" | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_inst_id=$(printf "$vocabci_result_id")
#Consulta os autores no Vocabci usando a função consulta_vocabci
 consulta_vocabci $autor_limpo
 result_autor=$(printf "$vocabci_result" | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
 result_autor_id=$(printf "$vocabci_result_id")
#Verifica se o termo teve resposta
 instituicao_count=$(echo "$instituicao" | wc -m) 
 result_count=$(echo "$result_inst" | wc -m) 
 result_count_autor=$(echo "$result_autor" | wc -m)

#Se tem instituição
if [[ $instituicao_count == "1" ]]
then 
    line=$(printf "%s\n" "$line" | sed "s/\"$/\"\,\"\"/g")
else
    line=$(printf "%s\n" "$line")	
fi

#Se instituição teve resposta
if [[ $result_count -gt "1" ]] 
then
   line=$(printf "%s\n" "$line" | sed "s|"$instituicao"|"$result_inst"|g" | sed 's/$/\,\"'$result_inst_id'\"/g')
else 
   line=$(printf "%s\n" "$line" | sed "s|$|\,\""$instituicao_limpa"\"|g")
fi

#Se autor teve resposta
if  [[ $result_count_autor -gt "1" ]]
then
line=$(printf "%s\n" "$line" | sed "s|"$autor"|"$result_autor"|g" | sed 's/$/\,\"'$result_autor_id'\"/g')
else 
   line=$(printf "%s\n" "$line" | sed "s|$|\,\""$autor_limpo"\"|g")
fi

#Verifica se o autor tem ID e consulta no 
autor_id=$(echo "$line" | sed "s/\'//g" | sed 's/\"\s/\"/g' |  sed -e 's/\",\"/\|/g' | cut -d "|" -f 6 | sed -e 's/[^0-9]//g' )

if  [[ $autor_id -gt "0" ]]
then
    consulta_instautor $autor_id
    line=$(printf "%s\n" "$line" | sed 's/\"\"\,\"\"/\"'$instautor_result'\"\,\"'$instautor_result_id'\"/g')
else
    line=$(printf "%s\n" "$line")
fi      


#Imprime resultado
printf "%s\n" "$line"

done

