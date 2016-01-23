<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>MetaBuscaCI - Metabuscador em periódicos de Ciência da Informação</title>

<!-- Jquery -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!-- Folha de estilos -->
<link rel="stylesheet" href="css/style.css" type="text/css">

</head>
<body>
<div class="container">

<?php
  include ('inc/config.php');
  include ('inc/header.php');
  include ('inc/navbar.php');
?>

<div class="jumbotron">
  <div class="container">
    <h1>MetaBuscaCI</h1>
    <p style="background-color: white">Metabuscador em periódicos de Ciência da Informação brasileiros disponíveis em OAI-PMH.</p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <h2>Coleta</h2>
      <p>Os dados dos periódicos disponíveis em OAI-PHM são coletados utilizando a ferramenta <a href="http://librecat.org/">Librecat/Catmandu</a> e armazenados em um banco de dados NoSQL <a href="https://www.mongodb.org/">MongoDB.</a></p>
    </div>
    <div class="col-md-4">
      <h2>Tratamento</h2>
      <p>Os dados são tratados utilizando o webservice do <a href="http://bdpife2.sibi.usp.br/vocabci/vocab/">Vocabulário Controlado de Ciência da Informação no Brasil</a> que foi criado utilizando o software livre para vocabulários controlados <a href="http://www.vocabularyserver.com">Tematres</a> e são incluídos dados altmétricos do Facebook recuperados de sua API.</p>
   </div>
    <div class="col-md-4">
      <h2>Visualização de dados</h2>
      <p>Dados são visualizados por meio de facetas nos resultados de busca. São adicionados gráficos utilizando as bibliotecas <a href="http://d3js.org/">d3.js</a> e <a href="https://developers.google.com/chart/">Google Charts</a>.</p>
    </div>
  </div>



<?php

$aggregate_journal_title_total=array(
  array(
    '$unwind'=>'$journalci_title'
  ),
  array(
    '$group' => array(
      "_id"=>'$journalci_title',
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array("_id"=>1)
  )
);

$aggregate_year_total=array(
  array(
    '$unwind'=>'$year'
  ),
  array(
    '$group' => array(
      "_id"=>'$year',
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array("_id"=>1)
  )
);

$aggregate_query_subject=array(
  array(
    '$unwind'=>'$subject'
  ),
  array(
    '$group' => array(
      "_id"=>'$subject',
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array("count"=>-1)
  )
);

$aggregate_query_autor=array(
  array(
    '$unwind'=>'$autor'
  ),
  array(
    '$group' => array(
      "_id"=>'$autor',
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array("count"=>-1)
  )
);

$aggregate_query_instituicao=array(
  array(
    '$unwind'=>'$instituicao'
  ),
  array(
    '$group' => array(
      "_id"=>'$instituicao',
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array("count"=>-1)
  )
);

$aggregate_facebook_total=array(
  array(
    '$unwind'=>'$journalci_title'
  ),
  array(
    '$group' => array(
      "_id"=>'$journalci_title',
      "likes"=>array('$sum'=>'$facebook_url_likes'),
      "shares"=>array('$sum'=>'$facebook_url_shares'),
      "comments"=>array('$sum'=>'$facebook_url_comments'),
      "interações"=>array('$sum'=>'$facebook_url_total')
      )
  )
);



$facet_journal_title = $c->aggregate($aggregate_journal_title_total);
$facet_year = $c->aggregate($aggregate_year_total);
$facet_subject = $c->aggregate($aggregate_query_subject);
$facet_autor = $c->aggregate($aggregate_query_autor);
$facet_instituicao = $c->aggregate($aggregate_query_instituicao);
$facet_facebook = $c->aggregate($aggregate_facebook_total);

var_dump($facet_facebook);


echo "<h3>Periódicos indexados</h3></br><ul class=\"nav nav-pills\" role=\"tablist\">";
foreach ($facet_journal_title["result"] as $jt) {
  echo '<li role="presentation" class="active" style="padding-top:5px;"><a href="result.php?journalci_title='.$jt["_id"].'">'.$jt["_id"].'<span class="badge">'.$jt["count"].'</span></a></li>';
};
echo "</ul>";
echo "<h3>Autores</h3></br><ul class=\"nav nav-pills\" role=\"tablist\">";
$i = 0;
foreach ($facet_autor["result"] as $at) {
  echo '<li role="presentation" class="active" style="padding-top:5px;"><a href="result.php?autor='.$at["_id"].'">'.$at["_id"].'<span class="badge">'.$at["count"].'</span></a></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Instituições</h3></br><ul class=\"nav nav-pills\" role=\"tablist\">";
$i = 0;
foreach ($facet_instituicao ["result"] as $it) {
  echo '<li role="presentation" class="active" style="padding-top:5px;"><a href="result.php?instituicao='.$it["_id"].'">'.$it["_id"].'<span class="badge">'.$it["count"].'</span></a></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Ano</h3></br><ul class=\"nav nav-pills\" role=\"tablist\">";
foreach ($facet_year["result"] as $yr) {
  echo '<li role="presentation" class="active" style="padding-top:5px;"><a href="result.php?year='.$yr["_id"].'">'.$yr["_id"].'<span class="badge">'.$yr["count"].'</span></a></li>';
};
echo "</ul>";
echo "<h3>Principais assuntos</h3></br><ul class=\"nav nav-pills\" role=\"tablist\">";
$i = 0;
foreach ($facet_subject["result"] as $sj) {
  echo '<li role="presentation" class="active" style="padding-top:5px;"><a href="result.php?subject='.$sj["_id"].'">'.$sj["_id"].'<span class="badge">'.$sj["count"].'</span></a></li>';
  if(++$i > 60) break;
};
echo "</ul>";
?>

<?php
  include "inc/footer.php";
?>

</div>
</body>
</html>
