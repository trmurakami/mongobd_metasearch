#!/bin/bash
rm ../../export/identifier_update.csv
mongoexport --db journals --collection ci --type=csv --fields _id,identifier --query '{ "facebook_atualizacao" : "00000000"}' --out ../../export/identifier_update.csv
./altmetrics_facebook.sh ../../export/identifier_update.csv
sleep 2
rm ../../export/relation_update.csv
mongoexport --db journals --collection ci --type=csv --fields relation --query '{ "facebook_atualizacao" : "00000000"}' --out ../../export/relation.csv
./altmetrics_facebook_relation.sh ../../export/relation_update.csv
