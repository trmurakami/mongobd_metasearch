#!/bin/bash

mongoexport --db journals --collection ci --type=csv --fields _id,journalci_title,title,date,identifier,"facebook_atualizacao","facebook_url_likes","facebook_url_shares","facebook_url_comments","facebook_url_clicks","facebook_url_total" --query '{"_status" : {$not: /deleted/}}' --out ../../export/facebook.csv




#Pesquisar no mongo pela URL
#db.ci.find({"identifier.0" : "http://ojs.c3sl.ufpr.br/ojs2/index.php/atoz/article/view/41320"})
