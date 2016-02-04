#!/bin/bash

for i in {1..10};
do
#jq '._metadata[2][0][2][1][2][4][2]['$i']' export/records_exemplo.json

jq '._metadata[2][0][2][1][2][4][2]['$i'][1][]' export/records_exemplo.json -r


done

#delete field
db.ci.update({},{$unset: {words:1}},false,true)


#create index
db.ci.createIndex({title:"text",autor:"text",subject:"text",instituicao:"text",description:"text"},{language_override:"pt",weights:{title: 10,autor: 9,subject:9,instituicao:9,description:1},name:"TextIndex"})

#jq '._id,._metadata[2][0][2][1][2][4][2][][1][],._metadata[2][0][2][1][2][4][2][][2][0][2][0][2][],._metadata[2][0][2][1][2][4][2][][2][0][2][0][2][]' export/records_exemplo.json -r

#pegar as citações
db.ci.aggregate([{ "$unwind" : "$citation" },{ "$group" : { "_id" : "$citation", count : { "$sum" : 1 } } },{ "$sort" : { "_id" : 1 } }])
