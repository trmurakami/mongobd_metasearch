#!/bin/bash

# AtoZ: novas práticas em informação e conhecimento
catmandu import OAI --url http://ojs.c3sl.ufpr.br/ojs2/index.php/atoz/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# BIBLIONLINE
catmandu import OAI --url http://periodicos.ufpb.br/ojs2/index.php/biblio/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Bibliotecas Universitárias: Pesquisas, experiências e perspectivas
catmandu import OAI --url https://www.bu.ufmg.br/rbu/index.php/localhost/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Brazilian Journal of Information Science: Research Trends
catmandu import OAI --url http://www2.marilia.unesp.br/revistas/index.php/bjis/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Ciência da Informação em Revista - CIR
catmandu import OAI --url http://www.seer.ufal.br/index.php/cir/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# CRB-8 Digital
catmandu import OAI --url http://revista.crb8.org.br/index.php/crb8digital/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Em Questão
catmandu import OAI --url http://www.seer.ufrgs.br/index.php/EmQuestao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Encontros Bibli: revista eletrônica de biblioteconomia e ciência da informação
catmandu import OAI --url https://periodicos.ufsc.br/index.php/eb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
#InCID: Revista de Ciência da Informação e Documentação
catmandu import OAI --url http://www.revistas.usp.br/incid/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Informação & Informação
catmandu import OAI --url http://www.uel.br/revistas/uel/index.php/informacao/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Informação & Sociedade: Estudos
catmandu import OAI --url http://www.ies.ufpb.br/ojs2/index.php/ies/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Informação@Profissões
catmandu import OAI --url http://www.uel.br/revistas/uel/index.php/infoprof/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Informação & Tecnologia
catmandu import OAI --url http://periodicos.ufpb.br/ojs/index.php/itec/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Liinc em Revista
catmandu import OAI --url http://revista.ibict.br/liinc/index.php/liinc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Perspectivas em Ciência da Informação
catmandu import OAI --url http://portaldeperiodicos.eci.ufmg.br/index.php/pci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Perspectivas em Gestão & Conhecimento
catmandu import OAI --url http://periodicos.ufpb.br/ojs2/index.php/pgc/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Pesquisa Brasileira em Ciência da Informação e Biblioteconomia - PBCIB
catmandu import OAI --url http://periodicos.ufpb.br/ojs2/index.php/pbcib/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# PontodeAcesso
catmandu import OAI --url http://www.portalseer.ufba.br/index.php/revistaici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
#Revista ACB - RABC
catmandu import OAI --url http://revista.acbsc.org.br/racb/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Revista Brasileira de Biblioteconomia e Documentação - RBBD
catmandu import OAI --url http://rbbd.febab.org.br/rbbd/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Revista Brasileira de Educação em Ciência da Informação - Rebecin
catmandu import OAI --url http://www.abecin.org.br/revista/index.php/rebecin/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
#Revista Ciência da Informação - CIInf
catmandu import OAI --url http://revista.ibict.br/cienciadainformacao/index.php/ciinf/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Revista Digital de Biblioteconomia e Ciência da Informação - RDBCI
catmandu import OAI --url http://www.sbu.unicamp.br/seer/ojs/index.php/rbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Revista Ibero-Americana de Ciência da Informação
catmandu import OAI --url http://periodicos.unb.br/index.php/rici/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Tendências da Pesquisa Brasileira em Ciência da Informação
catmandu import OAI --url http://inseer.ibict.br/ancib/index.php/tpbci/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2
# Transinformação
catmandu import OAI --url http://periodicos.puc-campinas.edu.br/seer/index.php/transinfo/oai --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci
sleep 2