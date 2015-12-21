#!/bin/bash

#catmandu import OAI --url http://revista.acbsc.org.br/racb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
#sleep 2
catmandu import OAI --url http://www.seer.ufal.br/index.php/cir/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
#catmandu import OAI --url http://periodicos.puc-campinas.edu.br/seer/index.php/transinfo/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci