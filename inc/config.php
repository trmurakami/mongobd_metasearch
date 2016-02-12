<?php
/* Banco de dados */
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
$m  = new MongoClient();
$d  = $m->journals;
$c = $d->ci;

/* Tradução */

$language = "pt_BR";
putenv("LANG=".$language);
setlocale(LC_ALL, $language);

$domain = "messages";
bindtextdomain($domain, "locale");
textdomain($domain);

?>
