#!/bin/bash

#Declarando variáveis

vocabci_result=""
vocabci_result_id=""
instautor_result=""
instautor_result_id=""


#Funções

consulta_termo() {
  query=$(echo $1 | sed 's/ /+/g')
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetch&arg=$query"
  vocabci_result_id=$(curl -s -G -L $url | xmlstarlet sel -t -v "//term_id")
  url2="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetchTerm&arg=$vocabci_result_id"
  vocabci_result=$(curl -s -G -L $url2 | xmlstarlet sel -t -v "//string" | sed 's/(/\\(/g' | sed 's/)/\\)/g')
}

consulta_instautor(){
  url="http://bdpife2.sibi.usp.br/vocabci/vocab/services.php?task=fetchRelated&arg=$1"
  instautor_result=$(curl -s -G -L "$url" | xmlstarlet sel -I -t -m '//string' -v "concat(.,'|')" | sed 's/|$//g')
  instautor_result_id=$(curl -s -G -L "$url" | xmlstarlet sel -I -t -m '//term_id' -v "concat(.,'|')" | sed 's/|$//g')
}



IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
line=$(printf "%s\n" "$line" | sed "s/,\"\[/#\[/g")
_id=$(printf "%s\n" "$line" | cut -d "#" -f 1 | sed 's/\"//g')
creator=$(printf "%s\n" "$line" | cut -d "#" -f 2 | sed 's/\"\",\"\"/|/g' | sed 's/\"//g' | sed 's/\[//g' | sed 's/\]//g' | sed 's/\% /\%/g'  )

	IFS='|' read -ra creator <<< "$creator"
	for i in "${creator[@]}"; do
		autor=$(echo $i | cut -d "%" -f 1 | sed 's/^\s//g' | sed 's/\s$//g')
		autor_limpo=$(echo "$autor" | sed "s/[^a-z|0-9|A-Z| ]//g")

    if [[ $i == *"%"* ]] ;

		then

		instituicao=$(echo $i | cut -d "%" -f 2 | sed 's/^\s//g' | sed 's/\s$//g')
		instituicao_count=$(echo "$instituicao" | wc -m)

		else

		instituicao=""
		instituicao_count=0

		fi

		#Consulta os autores no Vocabci usando a função consulta_vocabci
		consulta_termo $autor_limpo
		result_autor=$(printf "$vocabci_result" | sed -e '1h;2,$H;$!d;g' -e "s/).*/)/g")
		result_autor_id=$(printf "$vocabci_result_id")
		result_count_autor=$(echo "$result_autor" | wc -m)

			#Se autor teve resposta
			if  [[ $result_count_autor -gt "1" ]]
			then
				autor_tematres=$(printf "$result_autor")
				autor_tematres_id=$(printf "$result_autor_id")
			else
			  autor_tematres=$(printf "$autor_limpo")
				autor_tematres_id=$(printf "$autor_limpo")
			fi


			#Se tem instituição

			if [[ "$instituicao_count" -gt '1' ]]
			then

					instituicao_limpa=$(echo $instituicao | sed "s/[^a-z|0-9|A-Z| ]//g" | sed 's/^\s//' | sed 's/  / /g')

				    #Consulta a instituição no Vocabci usando a função consulta_vocabci
					  consulta_termo $instituicao_limpa


					  result_inst=$(printf "$vocabci_result" | head -n 1)
					  result_inst_id=$(printf "$vocabci_result_id" | head -n 1 )
					  result_count=$(echo "$result_inst" | wc -m)



						#Se instituição teve resposta
						if [[ $result_count -gt "1" ]]
						then
						   instituicao_tematres=$(printf "$result_inst")
						   instituicao_tematres_id=$(printf "$result_inst_id")
						else
						   instituicao_tematres=$(printf "$instituicao_limpa")
						   instituicao_tematres_id=$(printf "$instituicao_limpa")
						fi



					line=$(printf "%s\n" "\"$_id\",\"$autor_tematres\",\"$autor_tematres_id\",\"$instituicao_tematres\",\"$instituicao_tematres_id\"")


			else
			   	  line=$(printf "%s\n" "\"$_id\",\"$date\",\"$autor_tematres\",\"$autor_tematres_id\"")


					#Verifica se o autor tem ID e consulta no


				        autor_tematres_id_numero=$(printf "$autor_tematres_id" | sed 's/[^0-9]//g')


					if  [[ $autor_tematres_id_numero -eq NULL ]]
					then
						line=$(printf "%s\n" "\"$_id\",\"$journalci_title\",\"$_setSpec\",\"$language\",\"$date\",\"$autor_tematres\",\"$autor_tematres_id\",\"\",\"\"")
            instituicao_tematres=""
					else
					    consulta_instautor $result_autor_id
					    instituicao_tematres=$(printf "$instautor_result")
					    instituicao_tematres_id=$(printf "$instautor_result_id")
					    line=$(printf "%s\n" "\"$_id\",\"$autor_tematres\",\"$autor_tematres_id\",\"$instituicao_tematres\",\"$instituicao_tematres_id\"")

					fi

			fi

      echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {autor: \"$autor_tematres\"}})" | mongo journals
      echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {instituicao: \"$instituicao_tematres\"}})" | mongo journals
      printf "%s\n" "$line" >> $2

	done

done
