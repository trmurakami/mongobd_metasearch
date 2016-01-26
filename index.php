<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<head>
<title>MetaBuscaCI - Metabuscador em periódicos e eventos de Ciência da Informação</title>
</head>
<body>
<div class="container-fluid">

<?php
  include ('inc/navbar.php');
?>

<div class="container">
<div class="card-deck-wrapper">
  <div class="card-deck">
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="images/harvesting.png" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Coleta</h4>
        <p class="card-text">Os dados dos periódicos disponíveis em OAI-PHM são coletados utilizando a ferramenta <a href="http://librecat.org/">Librecat/Catmandu</a> e armazenados em um banco de dados NoSQL <a href="https://www.mongodb.org/">MongoDB.</a></p>
      </div>
    </div>
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="images/openrefine.jpg" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Tratamento</h4>
        <p class="card-text">Os dados são tratados utilizando o webservice do <a href="http://bdpife2.sibi.usp.br/vocabci/vocab/">Vocabulário Controlado de Ciência da Informação no Brasil</a> que foi criado utilizando o software livre para vocabulários controlados <a href="http://www.vocabularyserver.com">Tematres</a> e são incluídos dados altmétricos do Facebook recuperados de sua API.</p>
      </div>
    </div>
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="images/data-visualization-examples.png" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Visualização de dados</h4>
        <p class="card-text">Dados são visualizados por meio de facetas nos resultados de busca. São adicionados gráficos utilizando as bibliotecas <a href="http://d3js.org/">d3.js</a> e <a href="https://developers.google.com/chart/">Google Charts</a>.</p>
      </div>
    </div>
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

$aggregate_query_assunto_tematres=array(
  array(
    '$unwind'=>'$assunto_tematres'
  ),
  array(
    '$group' => array(
      "_id"=>'$assunto_tematres',
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
      "interacoes"=>array('$sum'=>'$facebook_url_total')
      )
  ),
  array(
    '$sort' => array("_id"=>1)
  )
);


$facet_journal_title = $c->aggregate($aggregate_journal_title_total);
$facet_year = $c->aggregate($aggregate_year_total);
$facet_subject = $c->aggregate($aggregate_query_subject);
$facet_assunto_tematres = $c->aggregate($aggregate_query_assunto_tematres);
$facet_autor = $c->aggregate($aggregate_query_autor);
$facet_instituicao = $c->aggregate($aggregate_query_instituicao);
$facet_facebook = $c->aggregate($aggregate_facebook_total);



$facebook = array();
array_push($facebook,['Titulo do periódico','Curtidas','Compartilhamentos','Comentários']);
foreach ($facet_facebook["result"] as $fb) {
  array_push($facebook,[$fb['_id'],$fb['likes'],$fb['shares'],$fb['comments']]);
};

?>
<br/>
<h3>Facebook</h3></br>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMaterial);

function drawMaterial() {
      var data = google.visualization.arrayToDataTable(
        <?= json_encode($facebook); ?>
        );

      var options = {
        chart: {
          title: 'Interações (Curtidas, Comentários e Compartilhamentos) no Facebook dos Periódicos de CI',
          subtitle: 'Atualizado em 2016-01-23',
          isStacked: true,
        },
        hAxis: {
          title: 'Interações',
          minValue: 0,
        },
        vAxis: {
          title: 'Título'
        },
        bars: 'horizontal'
      };
      var material = new google.charts.Bar(document.getElementById('chart_div'));
      material.draw(data, options);
    }
</script>

 <div id="chart_div" style="width: 100%; height: 1000px;"></div>

<?php

echo "<h3>Periódicos indexados</h3></br><ul class=\"list-inline-button\">";
foreach ($facet_journal_title["result"] as $jt) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?journalci_title='.$jt["_id"].'" style="color:white">'.$jt["_id"].' <span class="label label-pill label-default">'.$jt["count"].'</span></a></button></li>';
};
echo '</ul>';
echo "<h3>Autores</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_autor["result"] as $at) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?autor='.$at["_id"].'" style="color:white">'.$at["_id"].' <span class="label label-default label-pill">'.$at["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo '</ul>';
echo "<h3>Instituições</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_instituicao ["result"] as $it) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?instituicao='.$it["_id"].'" style="color:white">'.$it["_id"].' <span class="label label-default label-pill">'.$it["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Ano</h3></br><ul class=\"list-inline-button\">";
foreach ($facet_year["result"] as $yr) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?year='.$yr["_id"].'" style="color:white">'.$yr["_id"].' <span class="label label-default label-pill">'.$yr["count"].'</span></a></button></li>';
};
echo "</ul>";
echo "<h3>Principais assuntos</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_subject["result"] as $sj) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?subject='.$sj["_id"].'" style="color:white">'.$sj["_id"].' <span class="label label-default label-pill">'.$sj["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Assuntos tratados pelo Vocabulário Controlado</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_assunto_tematres["result"] as $aterm) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?assunto_tematres='.$aterm["_id"].'" style="color:white">'.$aterm["_id"].' <span class="label label-default label-pill">'.$aterm["count"].'</span></a></button></li>';
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
