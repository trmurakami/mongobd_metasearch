#!/bin/bash


#resultado=$(curl --data-urlencode -s -G -L 'http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg='$1'' | xpath //string | sed -re 's/<\/?\w+>//g')
query=$(php -r "echo urlencode('$1');")
url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg=$query"
result=$(curl -s -G -L $url | xmlstarlet sel -t -v "//string")



#echo "O resultado e:  $resultado"
echo "Query: $query"
echo "URL: $url"
echo "O resultado2 e: $result"
