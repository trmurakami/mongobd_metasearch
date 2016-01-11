#!/bin/bash

for i in {1..10};
do
#jq '._metadata[2][0][2][1][2][4][2]['$i']' export/records_exemplo.json

jq '._metadata[2][0][2][1][2][4][2]['$i'][1][]' export/records_exemplo.json -r


done 


#jq '._id,._metadata[2][0][2][1][2][4][2][][1][],._metadata[2][0][2][1][2][4][2][][2][0][2][0][2][],._metadata[2][0][2][1][2][4][2][][2][0][2][0][2][]' export/records_exemplo.json -r