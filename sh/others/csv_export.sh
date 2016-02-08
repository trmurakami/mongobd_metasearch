#!/bin/bash

mongoexport --db journals --collection ci --type=csv --fields _id,creator --out ../export/export.csv -v
mongoexport --db journals --collection ci --type=csv --fields identifier --out ../export/identifier.csv
mongoexport --db journals --collection ci --type=csv --fields relation --query --out ../export/relation.csv
mongoexport --db journals --collection ci --type=csv --fields _id,subject --out ../export/subject.csv
