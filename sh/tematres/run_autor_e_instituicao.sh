#!/bin/bash

rm ../export/export.csv
sleep 2
mongoexport --db journals --collection ci --type=csv --fields _id,creator --out ../../export/export.csv -v
sleep 2
echo 'db.ci.update({},{$unset: {autor:1}},false,true)' | mongo journals
echo 'db.ci.update({},{$unset: {instituicao:1}},false,true)' | mongo journals
sleep 2
./transform_autor_e_instituicao.sh ../../export/export.csv ../../export/export_final.csv
