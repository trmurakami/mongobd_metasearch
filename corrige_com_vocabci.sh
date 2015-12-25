#!/bin/bash

consulta() {
curl -s -G -L 'http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg='$1'' | xmlstarlet sel -t -v "//string"
}

while read p;
do
 instituicao=$(cut -d "," -f 5 | sed -e 's/\"//g')
 echo -e "$instituicao\n" 
consulta $instituicao
done<$1

