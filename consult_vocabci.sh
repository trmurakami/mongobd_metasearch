#!/bin/bash


#resultado=$(curl -s -G -L 'http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg='$1'' | xpath //string | sed -re 's/<\/?\w+>//g')
result=$(curl -s -G -L 'http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg='$1'' | xmlstarlet sel -t -v "//string")


#echo "O resultado e:  $resultado"
echo "O resultado2 e: $result"
