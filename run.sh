#!/bin/bash

sudo rm export/*.*
sleep 2
./csv_export.sh
sleep 2
./transform.sh export/export.csv export/final.csv
sleep 2
./corrige_com_vocabci.sh export/final.csv > export/final_corrigido.csv
#iconv -f ISO-8859-15 -t UTF-8 export/final.csv >  finalutf8.csv