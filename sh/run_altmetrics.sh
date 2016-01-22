#!/bin/bash

./altmetrics_facebook.sh ../export/identifier.csv
sleep 2
mongoexport --db journals --collection ci --csv --fields _id,journalci_title,title,date,identifier,"facebook_atualizacao","facebook_url_likes","facebook_url_shares","facebook_url_comments","facebook_url_clicks","facebook_url_total" --query '{"_status" : {$not: /deleted/}}' --out export/facebook_url.csv
sleep 2
./altmetrics_facebook_relation.sh ../export/relation.csv
sleep 2
mongoexport --db journals --collection ci --csv --fields _id,journalci_title,title,date,identifier,"facebook_atualizacao","facebook_url_likes","facebook_url_shares","facebook_url_comments","facebook_url_clicks","facebook_url_total" --query '{"_status" : {$not: /deleted/}}' --out export/facebook_final.csv
