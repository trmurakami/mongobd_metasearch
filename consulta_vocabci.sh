#!/bin/bash

query=$(php -r "echo urlencode('$1');")
url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg=$query"
result=$(curl -s -G -L $url | xmlstarlet sel -t -v "//string")
printf "$result"

