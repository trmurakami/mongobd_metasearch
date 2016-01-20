<html>
<head>
<title>Resultados de Busca</title>

<!-- Jquery -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">

<?php
  include "inc/header.php";
?>

<?php
  include "inc/navbar.php";
?>

  <div class="row">
    <div class="col-md-4"><h2>Refine os resultados</h2></div>
    <div class="col-md-8">

<h2>Resultado da busca</h2>
<?php
/*
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
*/
$mongodb    = new MongoClient();
$database   = $mongodb->journals;
$collection = $database->ci;
$query =  array(''.$_GET['idx'].'' => ''.$_GET['q'].'');
$cursor = $database->ci->findOne($query);

  foreach ($cursor["title"] as $title){
    echo 'Título: '.$title."<br />";
  }
  foreach ($cursor["creator"] as $autores){
    echo 'Autor: '.$autores."<br />";
  }
  foreach ($cursor["identifier"] as $identifier){
    echo 'URL: <a href="'.$identifier.'">'.$identifier."</a><br />";
  }
  echo 'Título do periódico: '.$cursor["journalci_title"]."<br />";
  echo '_id: '.$cursor["_id"]."<br />";
  echo 'Status: '.$cursor["_status"]."<br />";
  echo 'Qualis2014: '.$cursor["Qualis2014"]."<br />";
  echo 'Data de atualização dos dados obtidos no facebook: '.$cursor["facebook_atualizacao"]."<br />";
  echo 'Comentários no facebook: '.$cursor["facebook_url_comments"]."<br />";
  echo 'Likes no facebook: '.$cursor["facebook_url_likes"]."<br />";
  echo 'Compartilhamentos no facebook: '.$cursor["facebook_url_shares"]."<br />";
  echo 'Total de interações no facebook: '.$cursor["facebook_url_total"]."<br />";

  foreach ($cursor["relation"] as $cursorelation){
    echo 'URLs relacionadas: '.$cursorelation."<br />";
  }
  foreach ($cursor["description"] as $cursoresumo){
    echo 'Resumo: '.$cursoresumo."<br />";
  }
  foreach ($cursor["language"] as $idioma){
    echo 'Idioma: '.$idioma."<br />";
  }
  foreach ($cursor["publisher"] as $publisher){
    echo 'Editora: '.$publisher."<br />";
  }
  foreach ($cursor["source"] as $source){
    echo 'Fonte: '.$source."<br />";
  }
  foreach ($cursor["subject"] as $subject){
    echo 'Assuntos: '.$subject."<br />";
  }
  foreach ($cursor["date"] as $data_de_publicacao){
    echo 'Data de publicação: '.$data_de_publicacao."<br />";
  }
  foreach ($cursor["format"] as $formato){
    echo 'Formato: '.$formato."<br />";
  }
  foreach ($cursor["rights"] as $direitos_autorais){
    echo 'Direitos Autorais: '.$direitos_autorais."<br />";
  }
  foreach ($cursor["type"] as $tipo){
    echo 'Tipo: '.$tipo."<br />";
  }
  foreach ($cursor["_setSpec"] as $set_oai){
    echo 'Set OAI: '.$set_oai."<br />";
  }
  echo "</br></br>";

$mongodb->close();
?>

</div>
</div>

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
