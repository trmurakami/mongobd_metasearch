#!/bin/bash

rm ../export/export_update.csv
sleep 2
mongoexport --db journals --collection ci --type=csv --fields _id,creator --query '{ "autor" : { "$exists" : false } }' --out ../../export/export_update.csv -v
sleep 2
./transform_autor_e_instituicao.sh ../../export/export_update.csv ../../export/export_final.csv
