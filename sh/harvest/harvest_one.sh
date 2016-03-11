#!/usr/bin/env bash
catmandu import OAI --fix fixes.txt --url http://ojs.c3sl.ufpr.br/ojs2/index.php/atoz/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
sleep 2
echo 'db.ci.remove( { "_status" : "deleted" } )' | mongo journals
sleep 2
echo "Completo"
