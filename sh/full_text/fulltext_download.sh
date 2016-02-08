rm -rf ../../pdfs/$2
mkdir ../../pdfs/$2

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
line=$(printf "%s\n" "$line" | sed 's/,"\[""/#/g')
_id=$(printf "%s\n" "$line" | cut -d "#" -f 1)
urls=$(printf "%s\n" "$line" | cut -d "#" -f 2 | sed 's/"",""/|/g' | sed 's/"//g' | sed 's/\]//g' | sed 's/view/download/g')

  IFS='|' read -ra url <<< "$urls"
  for i in "${url[@]}"; do
    pdf_name=$(printf "$i" | sed 's/http\:\/\/ojs.c3sl.ufpr.br\/ojs2\/index.php\/atoz\/article\/download\///g' | sed 's/http\:\/\/ojs.c3sl.ufpr.br\/ojs2\/index.php\/atoz\/article\/downloadSuppFile\///g' | sed 's/\//-/g' | sed 's/$/.pdf/g')
    curl -o ../../pdfs/$2/$pdf_name $i
    pdftotext ../../pdfs/$2/$pdf_name ../../pdfs/$2/$pdf_name.txt
    egrep -A 2500 'Referências' ../../pdfs/$2/$pdf_name.txt > ../../pdfs/$2/$pdf_name.references.txt
    egrep -A 2500 'References' ../../pdfs/$2/$pdf_name.txt >> ../../pdfs/$2/$pdf_name.references.txt
    egrep -A 2500 'REFERÊNCIAS' ../../pdfs/$2/$pdf_name.txt >> ../../pdfs/$2/$pdf_name.references.txt
    sed -i 's/"//g' ../../pdfs/$2/$pdf_name.txt
    sed -i 's/"//g' ../../pdfs/$2/$pdf_name.references.txt
    full_text=$(cat ../../pdfs/$2/$pdf_name.txt)
    reference_text=$(cat ../../pdfs/$2/$pdf_name.references.txt)


    echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {full_text: cat(\"../../pdfs/$2/$pdf_name.txt\")}})" | mongo journals
    echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {references: cat(\"../../pdfs/$2/$pdf_name.references.txt\")}})" | mongo journals
  done


done

find ../../pdfs/$2/. -type f -size 0b -delete
