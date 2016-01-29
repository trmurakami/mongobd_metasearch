#Exportar endereços do texto completo
mongoexport --db journals --collection ci --type=csv --fields _id,relation --query '{"journalci_title":"AtoZ"}' --out ../export/relation_atoz.csv
