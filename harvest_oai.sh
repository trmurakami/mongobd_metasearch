#!/bin/bash

# Ciência da Informação em Revista
catmandu import OAI --url http://www.seer.ufal.br/index.php/cir/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
#Revista ACB
catmandu import OAI --url http://revista.acbsc.org.br/racb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Transinformação
catmandu import OAI --url http://periodicos.puc-campinas.edu.br/seer/index.php/transinfo/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2