curl -s -G -L 'http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=search&arg='$1'' | \
xpath //string | 
sed -re 's/<\/?\w+>//g' 
