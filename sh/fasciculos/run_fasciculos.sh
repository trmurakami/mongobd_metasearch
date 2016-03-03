#!/bin/bash
rm ../../export/source.csv
mongoexport --db journals --collection ci --type=csv --fields _id,source --out ../../export/source.csv
./transform_source.sh ../../export/source.csv
