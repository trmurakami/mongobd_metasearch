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
$query =  array('_id' => ''.$_GET['_id'].'');
$cursor = $database->ci->findOne($query);


echo '<div class="media"><div class="media"><a href="single.php?idx=_id&q='.$cursor["_id"].'"><button type="button" class="list-group-item"><center><span class="glyphicon glyphicon-file" aria-hidden="true"></span> '.$cursor["tipo"][0].'</button></a></center></div><br/>';


echo '<div class="card">';
echo '<div class="card-block">';


if (!empty($cursor["title"][2])) {
   echo '<h4 class="card-title">'.$cursor["title"][2].' ('.$cursor["year"][0].')</h4>';
   echo '<h6 class="card-subtitle text-muted"><p>Outros títulos:'.$cursor["title"][1].'</p></h6>';
   echo '<h6 class="card-subtitle text-muted">Outros títulos:'.$cursor["title"][0].'</h6>';
}
elseif (empty($cursor["title"][2]) && !empty($cursor["title"][1])) {
  echo '<h4 class="card-title">'.$cursor["title"][1].' ('.$cursor["year"][0].')</h4>';
  echo '<h6 class="card-subtitle text-muted">Outros títulos:'.$cursor["title"][0].'</h6>';
}
else {
  echo '<h4 class="card-title">'.$cursor["title"][0].' ('.$cursor["year"][0].')</h4>';
}

echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Autores</label>';
echo '<div class="col-sm-10">';


if (!empty($cursor["autor"])) {
  foreach ($cursor["autor"] as $autores){
    echo '<li>'.$autores.'</li>';    
  }
echo '</div>';
echo '</div>';
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Instituições</label>';
echo '<div class="col-sm-10">';

  foreach ($cursor["instituicao"] as $instituicoes){
    echo '<li>'.$instituicoes.'</li>';
  }
echo '</div>';
echo '</div>';


}
else
{
  foreach ($cursor["creator"] as $autores){
    echo '<b>Autor</b>:'.$autores.'<br/>';
 }
}

echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">URLs</label>';
echo '<div class="col-sm-10">';
echo '<b>URL principal</b>: <a href="'.$cursor["url_principal"].'">'.$cursor["url_principal"]."</a><br />";
if (!empty($cursor["doi"])) {
  echo '<b>DOI</b>: <a href="'.$cursor["doi"].'">'.$cursor["doi"]."</a><br />";
}
if (!empty($cursor["relation"])) {
  foreach ($cursor["relation"] as $cursorelation){
    echo '<b>URL relacionada</b>: <a href="'.$cursorelation.'">'.$cursorelation.'</a><br />';
  }
}

echo '</div>';
echo '</div>';


echo '<span class="badge">'.$cursor["journalci_title"][0].'</span><br/>';
echo '<b>_id:</b> '.$cursor["_id"]."<br />";
echo '<b>Qualis2014</b>: '.$cursor["qualis2014"][0]."<br />";
echo "<b>Facebook:</b><ul>";
echo '<li>Data de atualização dos dados obtidos no facebook: '.$cursor["facebook_atualizacao"]."</li>";
echo '<li>Comentários no facebook: '.$cursor["facebook_url_comments"]."</li>";
echo '<li>Likes no facebook: '.$cursor["facebook_url_likes"]."</li>";
echo '<li>Compartilhamentos no facebook: '.$cursor["facebook_url_shares"]."</li>";
echo '<li>Total de interações no facebook: '.$cursor["facebook_url_total"]."</li></ul>";

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

echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Assuntos</label>';
echo '<div class="col-sm-10">';
if (!empty($cursor["subject"])) {
  foreach ($cursor["subject"] as $subject){
    echo '<li>'.$subject."</li>";
  }
}
echo '</div>';
echo '</div>';



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

foreach ($cursor["type"] as $tipo){
  echo '<b>Tipo</b>: '.$tipo."<br />";
}
foreach ($cursor["_setSpec"] as $set_oai){
  echo '<b>Set OAI</b>: '.$set_oai."<br />";
}
echo "</br></br>";




if (!empty($cursor["references"])) {
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Referências</label>';
echo '<div class="col-sm-10">';
  foreach ($cursor["references"] as $referencias){
    echo '<li>'.$referencias."</li>";
  }
echo '</div>';
echo '</div>';
}





echo '<form method="get" action="edit.php">';
echo '<input type="hidden">';
echo '<button type="submit" name="_id" class="btn btn-primary-outline" value="'.$cursor["_id"].'">Editar referências</button>';


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
