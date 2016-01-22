#!/bin/bash

mongoexport --db journals --collection ci --csv --fields _id,journalci_title,_setSpec,language,date,creator --query '{"_status" : {$not: /deleted/}}' --out export/export.csv -v
mongoexport --db journals --collection ci --csv --fields identifier --query '{"_status" : {$not: /deleted/}}' --out export/identifier.csv
mongoexport --db journals --collection ci --csv --fields relation --query '{"_status" : {$not: /deleted/}}' --out export/relation.csv
mongoexport --db journals --collection ci --csv --fields _id,title,date,subject --query '{"_status" : {$not: /deleted/}}' --out export/subject.csv
