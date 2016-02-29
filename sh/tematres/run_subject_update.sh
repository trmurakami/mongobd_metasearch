#!/bin/bash

rm ../../export/subject_update.csv
rm ../../export/subject_corrigido_update.csv
sleep 2
mongoexport --db journals --collection ci --type=csv --fields _id,subject --query '{ "assunto_tematres" : { "$exists" : false } }' --out ../../export/subject_update.csv
sleep 2
./transform_assunto.sh ../../export/subject_update.csv ../../export/subject_corrigido_update.csv
