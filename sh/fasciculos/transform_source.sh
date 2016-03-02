#!/bin/bash

IFS=$'\n'       # make newlines the only separator
for line in $(cat $1);
do
line=$(printf "%s\n" "$line" | sed "s/,\"\[/#/g" | sed 's/,$/#/g')
_id=$(printf "%s\n" "$line" | cut -d "#" -f 1 | sed 's/\"//g')
fonte=$(printf "%s\n" "$line" | cut -d "#" -f 2 | sed 's/\"\",\"\"/|/g' | sed 's/\"//g' | sed 's/\]//g' | sed 's/\[//g' | sed 's/^\s//g' | sed 's/\s$//g' | sed 's/;/|/g' | sed "s/\",\"/|/g" | sed 's/| /|/g')
fasciculo=$(printf "$fonte" | cut -d "|" -f 2)
paginas=$(printf "$fonte" | cut -d "|" -f 3)

echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {fasciculo: \"$fasciculo\"}})" | mongo journals
echo "db.ci.update({\"_id\" : \""$_id"\"},{\$addToSet: {paginas: \"$paginas\"}})" | mongo journals

done
