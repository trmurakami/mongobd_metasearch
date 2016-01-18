<html>
<head>
<title>Dados coletados de periódicos de Ciência da Informação disponíveis em OAI</title>
</head>
<body>

<h1>Testando o MongoDB com PHP</h1>
<p>
<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
$mongo = new MongoClient('mongodb://localhost');
$db = $mongo->journals;
$col = $db->ci;
$consulta = array('journalci_title' => 'CIR');
/*$consulta2 = array('_status' => array( '$not:' => 'deleted'));*/
$rows = $col->find($consulta);


// iterate through the results
foreach ($rows as $linha) {
    echo 'Título do periódico: '.$linha["journalci_title"]."<br />";
    echo '_id: '.$linha["_id"]."<br />";
    echo 'Status: '.$linha["_status"]."<br />";
    echo 'Qualis2014: '.$linha["Qualis2014"]."<br />";
    echo 'Data de atualização dos dados obtidos no facebook: '.$linha["facebook_atualizacao"]."<br />";
    echo 'Comentários: '.$linha["facebook_url_comments"]."<br />";
    echo 'Likes: '.$linha["facebook_url_likes"]."<br />";
    echo 'Compartilhamentos: '.$linha["facebook_url_shares"]."<br />";
    echo 'Total de interações no facebook: '.$linha["facebook_url_total"]."<br />";
    foreach ($linha["title"] as $title){
      echo 'Título: '.$title."<br />";
    }
    foreach ($linha["creator"] as $autores){
      echo 'Autor: '.$autores."<br />";
    }
    foreach ($linha["identifier"] as $identifier){
      echo 'URL: '.$identifier."<br />";
    }
    foreach ($linha["relation"] as $relation){
      echo 'URLs relacionadas: '.$relation."<br />";
    }
    foreach ($linha["description"] as $resumo){
      echo 'Resumo: '.$resumo."<br />";
    }
    foreach ($linha["language"] as $idioma){
      echo 'Idioma: '.$idioma."<br />";
    }
    foreach ($linha["publisher"] as $publisher){
      echo 'Editora: '.$publisher."<br />";
    }
    foreach ($linha["source"] as $source){
      echo 'Fonte: '.$source."<br />";
    }
    foreach ($linha["subject"] as $subject){
      echo 'Assuntos: '.$subject."<br />";
    }
    foreach ($linha["date"] as $data_de_publicacao){
      echo 'Data de publicação: '.$data_de_publicacao."<br />";
    }
    foreach ($linha["format"] as $formato){
      echo 'Formato: '.$formato."<br />";
    }
    foreach ($linha["rights"] as $direitos_autorais){
      echo 'Direitos Autorais: '.$direitos_autorais."<br />";
    }
    foreach ($linha["type"] as $tipo){
      echo 'Tipo: '.$tipo."<br />";
    }
    foreach ($linha["_setSpec"] as $set_oai){
      echo 'Set OAI: '.$set_oai."<br />";
    }
    echo "</br></br>";
}

/*
print_r(array_values ($rows));

var_dump($rows);


echo $rows[0]


*/


// iterate through the results
/*foreach ($rows as $document) {
    echo '"_id": '.$document["._id"]."<br />";
}*/


/*foreach ($rows as $obj) {
  echo $obj['_id'] ."<br/>";
  echo "<strong>Nome:</strong> " . $obj['nome'] . "<br/>";
  echo "<strong>Tweet:</strong> " . $obj['tweet'] . "<br/>";
  echo "<br/>"; }*/





/*var_dump($col->count());*/
/*$total = $col->count(true);
echo ($total) ." registros encontrados.<p>";*/
$mongo->close();

?>

</body>
</html>
