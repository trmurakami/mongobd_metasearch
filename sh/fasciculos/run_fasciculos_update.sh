#!/bin/bash
rm ../../export/source_update.csv
mongoexport --db journals --collection ci --type=csv --fields _id,source --query '{ "fasciculo" : { "$exists" : false } }' --out ../../export/source_update.csv
./transform_source.sh ../../export/source_update.csv
