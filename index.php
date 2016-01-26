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
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22241%22%20height%3D%22200%22%20viewBox%3D%220%200%20241%20200%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px200%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_1527a28094f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A12pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1527a28094f%22%3E%3Crect%20width%3D%22241%22%20height%3D%22200%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%2290%22%20y%3D%22105.4%22%3E241x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Coleta</h4>
        <p class="card-text">Os dados dos periódicos disponíveis em OAI-PHM são coletados utilizando a ferramenta <a href="http://librecat.org/">Librecat/Catmandu</a> e armazenados em um banco de dados NoSQL <a href="https://www.mongodb.org/">MongoDB.</a></p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22242%22%20height%3D%22200%22%20viewBox%3D%220%200%20242%20200%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px200%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_1527a282b02%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A12pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1527a282b02%22%3E%3Crect%20width%3D%22242%22%20height%3D%22200%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%2290.5%22%20y%3D%22105.4%22%3E242x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Tratamento</h4>
        <p class="card-text">Os dados são tratados utilizando o webservice do <a href="http://bdpife2.sibi.usp.br/vocabci/vocab/">Vocabulário Controlado de Ciência da Informação no Brasil</a> que foi criado utilizando o software livre para vocabulários controlados <a href="http://www.vocabularyserver.com">Tematres</a> e são incluídos dados altmétricos do Facebook recuperados de sua API.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22242%22%20height%3D%22200%22%20viewBox%3D%220%200%20242%20200%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px200%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_1527a28515b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A12pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1527a28515b%22%3E%3Crect%20width%3D%22242%22%20height%3D%22200%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%2290.5%22%20y%3D%22105.4%22%3E242x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Visualização de dados</h4>
        <p class="card-text">Dados são visualizados por meio de facetas nos resultados de busca. São adicionados gráficos utilizando as bibliotecas <a href="http://d3js.org/">d3.js</a> e <a href="https://developers.google.com/chart/">Google Charts</a>.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?journalci_title='.$jt["_id"].'" style="color:white">'.$jt["_id"].' <span class="label label-pill label-info">'.$jt["count"].'</span></a></button></li>';
};
echo "<h3>Autores</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_autor["result"] as $at) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?autor='.$at["_id"].'" style="color:white">'.$at["_id"].' <span class="label label-success label-pill pull-xs-right">'.$at["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo "<h3>Instituições</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_instituicao ["result"] as $it) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?instituicao='.$it["_id"].'" style="color:white">'.$it["_id"].'<span class="label label-warning label-pill pull-xs-right">'.$it["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Ano</h3></br><ul class=\"list-inline-button\">";
foreach ($facet_year["result"] as $yr) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?year='.$yr["_id"].'" style="color:white">'.$yr["_id"].'<span class="label label-warning label-pill pull-xs-right">'.$yr["count"].'</span></a></button></li>';
};
echo "</ul>";
echo "<h3>Principais assuntos</h3></br><ul class=\"list-inline-button\">";
$i = 0;
foreach ($facet_subject["result"] as $sj) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?subject='.$sj["_id"].'" style="color:white">'.$sj["_id"].'<span class="label label-warning label-pill pull-xs-right">'.$sj["count"].'</span></a></button></li>';
  if(++$i > 60) break;
};
echo "</ul>";
echo "<h3>Assuntos tratados pelo Vocabulário Controlado</h3></br><ul class=\"list-inline-button\"";
$i = 0;
foreach ($facet_assunto_tematres["result"] as $aterm) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?assunto_tematres='.$aterm["_id"].'" style="color:white">'.$aterm["_id"].'<span class="label label-warning label-pill pull-xs-right">'.$aterm["count"].'</span></a></button></li>';
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
