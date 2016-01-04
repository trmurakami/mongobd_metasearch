#!/bin/bash

# AtoZ: novas práticas em informação e conhecimento
catmandu import OAI --fix 'add_field("journalci_title","AtoZ")' --url http://ojs.c3sl.ufpr.br/ojs2/index.php/atoz/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "AtoZ OK"
echo 'db.ci.find({"journalci_title":"AtoZ"}).count()' | mongo journals
sleep 2
# BIBLIONLINE
catmandu import OAI --fix 'add_field("journalci_title","Biblionline")' --url http://periodicos.ufpb.br/ojs2/index.php/biblio/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Biblionline OK"
echo 'db.ci.find({"journalci_title":"Biblionline"}).count()' | mongo journals
sleep 2
# Bibliotecas Universitárias: Pesquisas, experiências e perspectivas
catmandu import OAI --fix 'add_field("journalci_title","RBU")' --url https://www.bu.ufmg.br/rbu/index.php/localhost/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Bibliotecas Universitárias OK"
echo 'db.ci.find({"journalci_title":"RBU"}).count()' | mongo journals
sleep 2
# Brazilian Journal of Information Science: Research Trends - BJIS
catmandu import OAI --fix 'add_field("journalci_title","BJIS")'  --url http://www2.marilia.unesp.br/revistas/index.php/bjis/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "BJIS OK"
echo 'db.ci.find({"journalci_title":"BJIS"}).count()' | mongo journals
sleep 2
# Ciência da Informação em Revista - CIR
catmandu import OAI --fix 'add_field("journalci_title","CIR")' --url http://www.seer.ufal.br/index.php/cir/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "CIR OK"
echo 'db.ci.find({"journalci_title":"CIR"}).count()' | mongo journals
sleep 2
# CRB-8 Digital
catmandu import OAI --fix 'add_field("journalci_title","crb8digital")' --url http://revista.crb8.org.br/index.php/crb8digital/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "CRB-8 OK"
echo 'db.ci.find({"journalci_title":"crb8digital"}).count()' | mongo journals
sleep 2
# Em Questão
catmandu import OAI --fix 'add_field("journalci_title","EmQuestao")' --url http://www.seer.ufrgs.br/index.php/EmQuestao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Em Questão OK"
echo 'db.ci.find({"journalci_title":"EmQuestao"}).count()' | mongo journals
sleep 2
# Encontros Bibli: revista eletrônica de biblioteconomia e ciência da informação
catmandu import OAI --fix 'add_field("journalci_title","EncontrosBibli")' --url https://periodicos.ufsc.br/index.php/eb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Encontros Bibli OK"
echo 'db.ci.find({"journalci_title":"EncontrosBibli"}).count()' | mongo journals
sleep 2
# Informação & Informação
catmandu import OAI --fix 'add_field("journalci_title","Informacao&Informacao")' --url http://www.uel.br/revistas/uel/index.php/informacao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação & Informação OK"
echo 'db.ci.find({"journalci_title":"Informacao&Informacao"}).count()' | mongo journals
sleep 2
# Informação & Sociedade: Estudos
catmandu import OAI --fix 'add_field("journalci_title","IES")' --url http://www.ies.ufpb.br/ojs2/index.php/ies/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação & Sociedade OK"
echo 'db.ci.find({"journalci_title":"IES"}).count()' | mongo journals
sleep 2
# Informação@Profissões - INFOPROF
catmandu import OAI --fix 'add_field("journalci_title","INFOPROF")' --url http://www.uel.br/revistas/uel/index.php/infoprof/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação@Profissões OK"
echo 'db.ci.find({"journalci_title":"INFOPROF"}).count()' | mongo journals
sleep 2
# Informação & Tecnologia - ITEC
catmandu import OAI --fix 'add_field("journalci_title","ITEC")' --url http://periodicos.ufpb.br/ojs/index.php/itec/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "ITEC OK"
echo 'db.ci.find({"journalci_title":"ITEC"}).count()' | mongo journals
sleep 2
# Liinc em Revista - Liinc
catmandu import OAI  --fix 'add_field("journalci_title","Liinc")' --url http://revista.ibict.br/liinc/index.php/liinc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Liinc OK"
echo 'db.ci.find({"journalci_title":"Liinc"}).count()' | mongo journals
sleep 2
# Perspectivas em Ciência da Informação - PCI
catmandu import OAI --fix 'add_field("journalci_title","PCI")' --url http://portaldeperiodicos.eci.ufmg.br/index.php/pci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PCI OK"
echo 'db.ci.find({"journalci_title":"PCI"}).count()' | mongo journals
sleep 2
# Perspectivas em Gestão & Conhecimento - PGC
catmandu import OAI --fix 'add_field("journalci_title","PGC")' --url http://periodicos.ufpb.br/ojs2/index.php/pgc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PGC OK" 
echo 'db.ci.find({"journalci_title":"PGC"}).count()' | mongo journals
sleep 2
# Pesquisa Brasileira em Ciência da Informação e Biblioteconomia - PBCIB
catmandu import OAI --fix 'add_field("journalci_title","PBCIB")' --url http://periodicos.ufpb.br/ojs2/index.php/pbcib/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PBCIB OK"
echo 'db.ci.find({"journalci_title":"PBCIB"}).count()' | mongo journals
sleep 2
# PontodeAcesso
catmandu import OAI --fix 'add_field("journalci_title","PontodeAcesso")' --url http://www.portalseer.ufba.br/index.php/revistaici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
echo "PontodeAcesso OK"
echo 'db.ci.find({"journalci_title":"PontodeAcesso"}).count()' | mongo journals
sleep 2
#Revista ACB - RACB
catmandu import OAI --fix 'add_field("journalci_title","RACB")' --url http://revista.acbsc.org.br/racb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RACB OK"
echo 'db.ci.find({"journalci_title":"RACB"}).count()' | mongo journals
sleep 2
# Revista Brasileira de Biblioteconomia e Documentação - RBBD
catmandu import OAI --fix 'add_field("journalci_title","RBBD")' --url http://rbbd.febab.org.br/rbbd/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RBBD OK"
echo 'db.ci.find({"journalci_title":"RBBD"}).count()' | mongo journals
sleep 2
# Revista Brasileira de Educação em Ciência da Informação - Rebecin
catmandu import OAI --fix 'add_field("journalci_title","Rebecin")' --url http://www.abecin.org.br/revista/index.php/rebecin/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Rebecin OK"
echo 'db.ci.find({"journalci_title":"Rebecin"}).count()' | mongo journals
sleep 2
#Revista Ciência da Informação - CIInf
catmandu import OAI --fix 'add_field("journalci_title","CIInf")' --url http://revista.ibict.br/cienciadainformacao/index.php/ciinf/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "CIInf OK"
echo 'db.ci.find({"journalci_title":"CIInf"}).count()' | mongo journals
sleep 2
# Revista Digital de Biblioteconomia e Ciência da Informação - RDBCI
catmandu import OAI --fix 'add_field("journalci_title","RDBCI")' --url http://www.sbu.unicamp.br/seer/ojs/index.php/rbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RDBCI OK"
echo 'db.ci.find({"journalci_title":"RDBCI"}).count()' | mongo journals
sleep 2
# Revista Ibero-Americana de Ciência da Informação - RICI
catmandu import OAI --fix 'add_field("journalci_title","RICI")' --url http://periodicos.unb.br/index.php/rici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RICI OK"
echo 'db.ci.find({"journalci_title":"RICI"}).count()' | mongo journals
sleep 2
# Tendências da Pesquisa Brasileira em Ciência da Informação - TPBCI
catmandu import OAI --fix 'add_field("journalci_title","TPBCI")' --url http://inseer.ibict.br/ancib/index.php/tpbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "TPBCI OK"
echo 'db.ci.find({"journalci_title":"TPBCI"}).count()' | mongo journals
sleep 2
# Transinformação
catmandu import OAI --fix 'add_field("journalci_title","TRANSINFO")' --url http://periodicos.puc-campinas.edu.br/seer/index.php/transinfo/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "TRANSINFO OK"
echo 'db.ci.find({"journalci_title":"TRANSINFO"}).count()' | mongo journals
sleep 2
#InCID: Revista de Ciência da Informação e Documentação
catmandu import OAI --fix 'add_field("journalci_title","InCID")' --url http://www.revistas.usp.br/incid/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "InCID OK"
echo 'db.ci.find({"journalci_title":"InCID"}).count()' | mongo journals
sleep 2

