#!/bin/bash

sudo mongoexport --db journals --collection ci --csv --fields _id,journalci_title,language,date,creator --query '{"_status" : {$not: /deleted/}}' --out export/export.csv -v