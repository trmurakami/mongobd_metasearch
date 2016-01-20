#!/bin/bash

# AtoZ: novas práticas em informação e conhecimento
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","AtoZ: novas praticas em informacao e conhecimento")' --fix 'set_array("qualis2014","B5")' --url http://ojs.c3sl.ufpr.br/ojs2/index.php/atoz/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "AtoZ OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"AtoZ: novas práticas em informação e conhecimento"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# BIBLOS
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Biblos")' --fix 'set_array("qualis2014","B3")' --url http://www.seer.furg.br/biblos/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Biblos OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Biblos"}).count()' | mongo journals >> export/oai_result.txt
# BIBLIONLINE
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Biblionline")' --fix 'set_array("qualis2014","B1")' --url http://periodicos.ufpb.br/ojs2/index.php/biblio/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Biblionline OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Biblionline"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Biblioteca Escolar em Revista - berev
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Biblioteca Escolar em Revista")' --fix 'set_array("qualis2014","B3")' --url http://www.revistas.usp.br/berev/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Biblioteca Escolar em Revista OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Biblioteca Escolar em Revista"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Bibliotecas Universitárias: Pesquisas, experiências e perspectivas
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Bibliotecas Universitarias: Pesquisas, experiencias e perspectivas")' --fix 'set_array("qualis2014","Nao possui")' --url https://www.bu.ufmg.br/rbu/index.php/localhost/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Bibliotecas Universitárias OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Bibliotecas Universitárias: Pesquisas, experiências e perspectivas"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Brazilian Journal of Information Science: Research Trends - BJIS
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","BJIS")' --fix 'set_array("qualis2014","B1")' --url http://www2.marilia.unesp.br/revistas/index.php/bjis/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "BJIS OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"BJIS"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Cadernos de Informação Jurídica (Cajur)
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Cajur")' --fix 'set_array("qualis2014","Nao possui")' --url http://www.cajur.com.br/index.php/cajur/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Cajur OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Cajur"}).count()' | mongo journals >> export/oai_result.txt
# Ciência da Informação em Revista - CIR
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Ciencia da Informacao em Revista")' --fix 'set_array("qualis2014","Nao possui")' --url http://www.seer.ufal.br/index.php/cir/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Ciencia da Informação em Revista OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Ciencia da Informacao em Revista"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# CRB-8 Digital
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","crb8digital")' --fix 'set_array("qualis2014","B5")' --url http://revista.crb8.org.br/index.php/crb8digital/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "CRB-8 OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"crb8digital"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Em Questão
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","EmQuestao")' --fix 'set_array("qualis2014","B1")' --url http://www.seer.ufrgs.br/index.php/EmQuestao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Em Questão OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"EmQuestao"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Encontros Bibli: revista eletrônica de biblioteconomia e ciência da informação
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","EncontrosBibli")' --fix 'set_array("qualis2014","B1")' --url https://periodicos.ufsc.br/index.php/eb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Encontros Bibli OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"EncontrosBibli"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Informação & Informação
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Informacao&Informacao")' --fix 'set_array("qualis2014","B1")' --url http://www.uel.br/revistas/uel/index.php/informacao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação & Informação OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Informacao&Informacao"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Informação & Sociedade: Estudos
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","IES")' --fix 'set_array("qualis2014","A1")' --url http://www.ies.ufpb.br/ojs2/index.php/ies/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação & Sociedade OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"IES"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Informação@Profissões - INFOPROF
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","INFOPROF")' --fix 'set_array("qualis2014","Nao possui")' --url http://www.uel.br/revistas/uel/index.php/infoprof/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Informação@Profissões OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"INFOPROF"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Informação & Tecnologia - ITEC
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","ITEC")' --fix 'set_array("qualis2014","Nao possui")' --url http://periodicos.ufpb.br/ojs/index.php/itec/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "ITEC OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"ITEC"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Liinc em Revista - Liinc
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Liinc")' --fix 'set_array("qualis2014","B1")' --url http://revista.ibict.br/liinc/index.php/liinc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Liinc OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Liinc"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Perspectivas em Ciência da Informação - PCI
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","PCI")' --fix 'set_array("qualis2014","A1")' --url http://portaldeperiodicos.eci.ufmg.br/index.php/pci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PCI OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"PCI"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Perspectivas em Gestão & Conhecimento - PGC
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","PGC")' --fix 'set_array("qualis2014","Nao possui")' --url http://periodicos.ufpb.br/ojs2/index.php/pgc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PGC OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"PGC"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Pesquisa Brasileira em Ciência da Informação e Biblioteconomia - PBCIB
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","PBCIB")' --fix 'set_array("qualis2014","B1")' --url http://periodicos.ufpb.br/ojs2/index.php/pbcib/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "PBCIB OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"PBCIB"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# PontodeAcesso
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","PontodeAcesso")' --fix 'set_array("qualis2014","B1")' --url http://www.portalseer.ufba.br/index.php/revistaici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
echo "PontodeAcesso OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"PontodeAcesso"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
#Revista ACB - RACB
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","RACB")' --fix 'set_array("qualis2014","B2")' --url http://revista.acbsc.org.br/racb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RACB OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"RACB"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Revista Brasileira de Biblioteconomia e Documentação - RBBD
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","RBBD")' --fix 'set_array("qualis2014","B1")' --url http://rbbd.febab.org.br/rbbd/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RBBD OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"RBBD"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Revista Brasileira de Educação em Ciência da Informação - Rebecin
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","Rebecin")' --fix 'set_array("qualis2014","Nao possui")' --url http://www.abecin.org.br/revista/index.php/rebecin/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "Rebecin OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"Rebecin"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
#Revista Ciência da Informação - CIInf
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","CIInf")' --fix 'set_array("qualis2014","B1")' --url http://revista.ibict.br/cienciadainformacao/index.php/ciinf/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "CIInf OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"CIInf"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Revista Digital de Biblioteconomia e Ciência da Informação - RDBCI
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","RDBCI")' --fix 'set_array("qualis2014","B1")' --url http://www.sbu.unicamp.br/seer/ojs/index.php/rbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RDBCI OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"RDBCI"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Revista Ibero-Americana de Ciência da Informação - RICI
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","RICI")' --fix 'set_array("qualis2014","Nao possui")' --url http://periodicos.unb.br/index.php/rici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "RICI OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"RICI"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Tendências da Pesquisa Brasileira em Ciência da Informação - TPBCI
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","TPBCI")' --fix 'set_array("qualis2014","B1")' --url http://inseer.ibict.br/ancib/index.php/tpbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "TPBCI OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"TPBCI"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Transinformação
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","TRANSINFO")' --fix 'set_array("qualis2014","A1")' --url http://periodicos.puc-campinas.edu.br/seer/index.php/transinfo/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "TRANSINFO OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"TRANSINFO"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
#InCID: Revista de Ciência da Informação e Documentação
catmandu import OAI --fix fixes.txt --fix 'set_array("journalci_title","InCID")' --fix 'set_array("qualis2014","Nao possui")' --url http://www.revistas.usp.br/incid/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose
echo "InCID OK" >> export/oai_result.txt
echo 'db.ci.find({"journalci_title":"InCID"}).count()' | mongo journals >> export/oai_result.txt
sleep 2
# Apaga os registros deletados
echo 'db.ci.remove( { "_status" : "deleted" } )' | mongo journals
echo 'db.ci.createIndex( { "$**": "text" },{ language_override: "dummy" } )' | mongo journals
