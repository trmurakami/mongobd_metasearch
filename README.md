# journals_ci
Extração de dados dos periódicos da CI


== No notepad++ ==

FIND: ^(.*?)(\",")(.*?)(\",")(.*?)\"\", \"\"(.*)

REPLACE: \1\2\3\4\5\"\"\]\"\n\1\2\3\4[ \"\"\6

