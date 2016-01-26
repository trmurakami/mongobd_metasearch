<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title>MetaBuscaCI - Detalhes do registro</title>
</head>
<body>
<div class="container-fluid">
<?php
  include "inc/navbar.php";
?>

  <div class="row">
    <div class="col-md-4"><h3>Exportar</h3></div>
    <div class="col-md-8">

<h3>Detalhes do registro</h3>
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


echo '<div class="media"><div class="media"><a href="single.php?idx=_id&q='.$cursor["_id"].'"><button type="button" class="list-group-item"><center><span class="glyphicon glyphicon-file" aria-hidden="true"></span> '.$cursor["tipo"][0].'</button></a></center></div><br/>';

if (!empty($cursor["title"][2])) {
   echo '<h4 class="media-heading"><a href="'.$cursor["url_principal"].'">'.$cursor["title"][2].' ('.$cursor["year"][0].')</a></h4>';
   echo '<small>Outros títulos:'.$cursor["title"][1].'</small><br/>';
   echo '<small>Outros títulos:'.$cursor["title"][0].'</small><br/>';
}
elseif (empty($cursor["title"][2]) && !empty($cursor["title"][1])) {
  echo '<h4 class="media-heading"><a href="'.$cursor["url_principal"].'">'.$cursor["title"][1].' ('.$cursor["year"][0].')</a></h4>';
  echo '<small>Outros títulos:'.$cursor["title"][0].'</small><br/>';
}
else {
  echo '<h4 class="media-heading"><a href="'.$cursor["url_principal"].'">'.$cursor["title"][0].' ('.$cursor["year"][0].')</a></h4>';
}
echo "<br/>";

if (!empty($cursor["autor"])) {
  foreach ($cursor["autor"] as $autores){
    echo '<b>Autor</b>:'.$autores.'<br/>';
  }
  foreach ($cursor["instituicao"] as $instituicoes){
    echo '<b>Instituições em que os autores estão vinculados</b>:'.$instituicoes.'<br/>';
  }
}
else
{
  foreach ($cursor["creator"] as $autores){
    echo '<b>Autor</b>:'.$autores.'<br/>';
 }
}



echo '<b>URL</b>: <a href="'.$cursor["url_principal"].'">'.$cursor["url_principal"]."</a><br />";

if (!empty($cursor["doi"])) {
  echo '<b>DOI</b>: <a href="'.$cursor["doi"].'">'.$cursor["doi"]."</a><br />";
}

echo '<span class="badge">'.$cursor["journalci_title"][0].'</span><br/>';
echo '<b>_id:</b> '.$cursor["_id"]."<br />";
echo '<b>Qualis2014</b>: '.$cursor["qualis2014"][0]."<br />";
echo "<b>Facebook:</b><ul>";
echo '<li>Data de atualização dos dados obtidos no facebook: '.$cursor["facebook_atualizacao"]."</li>";
echo '<li>Comentários no facebook: '.$cursor["facebook_url_comments"]."</li>";
echo '<li>Likes no facebook: '.$cursor["facebook_url_likes"]."</li>";
echo '<li>Compartilhamentos no facebook: '.$cursor["facebook_url_shares"]."</li>";
echo '<li>Total de interações no facebook: '.$cursor["facebook_url_total"]."</li></ul>";

if (!empty($cursor["relation"])) {
  foreach ($cursor["relation"] as $cursorelation){
    echo '<b>URL relacionada</b>: <a href="'.$cursorelation.'">'.$cursorelation.'</a><br />';
  }
}
if (!empty($cursor["description"])) {
  foreach ($cursor["description"] as $cursoresumo){
    echo '<b>Resumo</b>: <p>'.$cursoresumo."</p>";
  }
}
foreach ($cursor["language"] as $idioma){
  echo '<b>Idioma</b>: '.$idioma."<br />";
}
foreach ($cursor["publisher"] as $publisher){
  echo '<b>Editora</b>: '.$publisher."<br />";
}
foreach ($cursor["source"] as $source){
  echo '<b>Fonte</b>: '.$source."<br />";
}
if (!empty($cursor["subject"])) {
  foreach ($cursor["subject"] as $subject){
    echo '<b>Assuntos</b>: '.$subject."<br />";
  }
}
if (!empty($cursor["assunto_tematres"])) {
  foreach ($cursor["assunto_tematres"] as $assunto_tematres){
    echo '<b>Assuntos do Vocabulário Controlado</b>: '.$assunto_tematres."<br />";
  }
}
foreach ($cursor["date"] as $data_de_publicacao){
  echo '<b>Data de publicação</b>: '.$data_de_publicacao."<br />";
}
foreach ($cursor["format"] as $formato){
  echo '<b>Formato</b>: '.$formato."<br />";
}
if (!empty($cursor["rights"])) {
  foreach ($cursor["rights"] as $direitos_autorais){
    echo '<b>Direitos Autorais</b>: '.$direitos_autorais."<br />";
  }
}
foreach ($cursor["type"] as $tipo){
  echo '<b>Tipo</b>: '.$tipo."<br />";
}
foreach ($cursor["_setSpec"] as $set_oai){
  echo '<b>Set OAI</b>: '.$set_oai."<br />";
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
