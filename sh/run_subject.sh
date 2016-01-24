#!/bin/bash

rm ../export/subject.csv
rm ../export/subject_corrigido.csv
sleep 2
mongoexport --db journals --collection ci --type=csv --fields _id,subject --out ../export/subject.csv
sleep 2
echo 'db.ci.update({},{$unset: {assunto_tematres:1}},false,true)' | mongo journals
sleep 2
./transform_assunto.sh ../export/subject.csv ../export/subject_corrigido.csv
