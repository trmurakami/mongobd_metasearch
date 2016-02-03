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

/*
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
*/
$query =  array('_id' => ''.$_GET['_id'].'');
$cursor = $d->ci->findOne($query);

$query_citation = array('citation' => ''.$_GET['_id'].'');
$cursor_citation = $d->ci->find($query_citation);

?>

  <div class="row">
    <div class="col-md-4">

<?php
if (!empty($cursor_citation)) {
echo '<ul class="list-group">';
echo '<a href="#" class="list-group-item active">Citado por</a>';
foreach ($cursor_citation as $cit_data) {
echo '<li class="list-group-item"><a href="single.php?_id='.$cit_data["_id"].'">'.$cit_data["title"][0].'</a></li>';
}
echo '</ul>';
}
?>
<?php
echo '<ul class="list-group">';
echo '<a href="#" class="list-group-item active">Facebook</a>';
echo '<li class="list-group-item"><span class="label label-default label-pill pull-xs-right">'.$cursor["facebook_atualizacao"].'</span>Data de atualização</li>';
echo '<li class="list-group-item"><span class="label label-success label-pill pull-xs-right">'.$cursor["facebook_url_likes"].'</span>Curtidas</li>';
echo '<li class="list-group-item"><span class="label label-warning label-pill pull-xs-right">'.$cursor["facebook_url_shares"].'</span>Compartilhamentos</li>';
echo '<li class="list-group-item"><span class="label label-danger label-pill pull-xs-right">'.$cursor["facebook_url_comments"].'</span>Comentários</li>';
echo '<li class="list-group-item"><span class="label label-default label-pill pull-xs-right">'.$cursor["facebook_url_total"].'</span>Total de interações</li>';
echo '</ul>';
?>

	<h3>Exportar</h3>
    </div>
    <div class="col-md-8">

<h3>Detalhes do registro</h3>
<?php


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


if (!empty($cursor["autor"])) {
    echo '<div class="form-group row">';
    echo '<label class="col-sm-2 form-control-label">Autores</label>';
    echo '<div class="col-sm-10">';
        foreach ($cursor["autor"] as $autores){
            echo '<li><a href="result.php?autor='.$autores.'">'.$autores.'</a></li>';
    }
    echo '</div>';
    echo '</div>';

    if (!empty($cursor["instituicao"])) {
    echo '<div class="form-group row">';
    echo '<label class="col-sm-2 form-control-label">Instituições</label>';
    echo '<div class="col-sm-10">';
        foreach ($cursor["instituicao"] as $instituicoes){
    	    echo '<li>'.$instituicoes.'</li>';
  	}
    echo '</div>';
    echo '</div>';
    }

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
echo 'URL principal: <a href="'.$cursor["url_principal"].'">'.$cursor["url_principal"]."</a><br />";
if (!empty($cursor["doi"])) {
  echo 'DOI: <a href="'.$cursor["doi"].'">'.$cursor["doi"]."</a><br />";
}
if (!empty($cursor["relation"])) {
  foreach ($cursor["relation"] as $cursorelation){
    echo 'URL relacionada: <a href="'.$cursorelation.'">'.$cursorelation.'</a><br />';
  }
}

echo '</div>';
echo '</div>';

echo '<div class="form-group row">';
    echo '<label class="col-sm-2 form-control-label">Dados da publicação</label>';
    echo '<div class="col-sm-10">';
    echo 'Título do periódico:<a href="result.php?journalci_title='.$cursor["journalci_title"][0].'">'.$cursor["journalci_title"][0].'</a><br />';
    echo 'Qualis2014: '.$cursor["qualis2014"][0].'<br />';
    foreach ($cursor["publisher"] as $publisher){
        echo 'Editora: '.$publisher."<br />";
    }
    echo '_id:'.$cursor["_id"]."<br />";
    foreach ($cursor["date"] as $data_de_publicacao){
        echo 'Data de publicação: '.$data_de_publicacao."<br />";
    }
    foreach ($cursor["_setSpec"] as $set_oai){
        echo 'Set OAI: '.$set_oai."<br />";
    }
    foreach ($cursor["format"] as $formato){
        echo 'Formato: '.$formato."<br />";
    }
    foreach ($cursor["source"] as $source){
        echo 'Fonte: '.$source."<br />";
    }
    echo '</div>';
echo '</div>';

if (!empty($cursor["description"])) {
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Resumo(s)</label>';
echo '<div class="col-sm-10">';
  foreach ($cursor["description"] as $cursoresumo){
    echo '<p>'.$cursoresumo."</p>";
  }
echo '</div>';
echo '</div>';
}


echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Idioma(s)</label>';
echo '<div class="col-sm-10">';
foreach ($cursor["language"] as $idioma){
  echo '<li>'.$idioma.'</li>';
}
echo '</div>';
echo '</div>';


if (!empty($cursor["subject"])) {
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Assuntos</label>';
echo '<div class="col-sm-10">';
  foreach ($cursor["subject"] as $subject){
    echo '<li>'.$subject."</li>";
  }
echo '</div>';
echo '</div>';
}

if (!empty($cursor["assunto_tematres"])) {
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Assuntos do Vocabulário Controlado</label>';
echo '<div class="col-sm-10">';
  foreach ($cursor["assunto_tematres"] as $assunto_tematres){
    echo '<li>'.$assunto_tematres."</li>";
  }
echo '</div>';
echo '</div>';
}

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

if (!empty($cursor["citation"])) {
echo '<div class="form-group row">';
echo '<label class="col-sm-2 form-control-label">Citações de trabalhos no MetabuscaCI</label>';
echo '<div class="col-sm-10">';
  foreach ($cursor["citation"] as $citation){
    echo '<li><a href="single.php?_id='.$citation.'">'.$citation.'</a></li>';
  }
echo '</div>';
echo '</div>';
}




echo '<form method="get" action="edit.php">';
echo '<input type="hidden">';
echo '<button type="submit" name="_id" class="btn btn-primary-outline" value="'.$cursor["_id"].'">Editar referências</button>';

?>

</div>
</div>

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
