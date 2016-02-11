<!-- Homepage -->

<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title><?php echo gettext("branch");?> - Metabuscador em periódicos de Ciência da Informação</title>
</head>
<body>
<?php include_once("inc/analyticstracking.php") ?>
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=90128977252";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
<?php
  include ('inc/navbar.php');
/* Conta a quantidade de artigos na base */
  $num_documentos=($c->count());
?>

<!-- Global Search -->
<form class="form-inline global-search" role="form" action="result.php" method="get">
  <div class="form-group">
    <label class="sr-only" for="">Digite os termos de busca</label>
    <input type="search" class="form-control" id="global_search" name="buscaindice" placeholder="Digite os termos de busca nos artigos" style="width:400px;">
  </div>
  <button type="submit" id="s" class="btn btn-primary-outline">Buscar</button> <a href="#">Ajuda</a>
</form>

<!-- Busca por referências -->
<form class="form-inline global-search" role="form" action="result.php" method="get">
  <div class="form-group">
    <label class="sr-only" for="">Digite os termos de busca</label>
    <input type="search" class="form-control" id="global_search" name="references" placeholder="Faça uma busca nas referências" style="width:400px;">
  </div>
  <button type="submit" id="s" class="btn btn-primary-outline">Buscar</button> <a href="#">Ajuda</a>
</form>

<!-- Busca em texto completo -->
<form class="form-inline global-search" role="form" action="result.php" method="get">
  <div class="form-group">
    <label class="sr-only" for="">Digite os termos de busca</label>
    <input type="search" class="form-control" id="global_search" name="full_text" placeholder="Faça uma busca no texto completo" style="width:400px;">
  </div>
  <button type="submit" id="s" class="btn btn-primary-outline">Buscar</button> <a href="#">Ajuda</a>
</form>

<br/>
<div class="container">

<div class="card-deck-wrapper">
  <div class="card-deck">
    <div class="card">
      <img class="card-img-top" data-src="holder.js/100px200/" alt="100%x200" src="images/harvesting.png" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
      <div class="card-block">
        <h4 class="card-title">Coleta</h4>
        <p class="card-text">Os dados dos periódicos disponíveis em OAI-PHM são coletados utilizando a ferramenta <a href="http://librecat.org/">Librecat/Catmandu</a> e armazenados em um banco de dados NoSQL <a href="https://www.mongodb.org/">MongoDB.</a>. Os dados são coletados automaticamente, totalizando: <?php echo $num_documentos; ?> documentos </p>
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
        <p class="card-text">Dados são visualizados por meio de facetas nos resultados de busca. São adicionados gráficos utilizando as bibliotecas <a href="http://sigmajs.org/">Sigma.js</a> e <a href="https://developers.google.com/chart/">Google Charts</a>.</p>
      </div>
    </div>
  </div>
</div>

<?php
/* Cria as consultas para o aggregate */

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

/* Consultas */
$facet_journal_title = $c->aggregate($aggregate_journal_title_total);
$facet_year = $c->aggregate($aggregate_year_total);
$facet_subject = $c->aggregate($aggregate_query_subject);
$facet_assunto_tematres = $c->aggregate($aggregate_query_assunto_tematres);
$facet_autor = $c->aggregate($aggregate_query_autor);
$facet_instituicao = $c->aggregate($aggregate_query_instituicao);
?>

<h3>Periódicos indexados</h3>
<ul class="list-inline-button">
<?php foreach ($facet_journal_title["result"] as $jt): ?>
  <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?journalci_title=<?php echo $jt["_id"]; ?>" style="color:white"><?php echo $jt["_id"]; ?> <span class="label label-pill label-default"><?php echo $jt["count"]; ?></span></a></button></li>
<?php endforeach; ?>
</ul>

<h3>Ano</h3>
  <ul class="list-inline-button">
  <?php foreach ($facet_year["result"] as $yr): ?>
    <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?year=<?php echo $yr["_id"]; ?>" style="color:white"><?php echo $yr["_id"]; ?> <span class="label label-default label-pill"><?php echo $yr["count"]; ?></span></a></button></li>
  <?php endforeach; ?>
  </ul>

<h3>Autores</h3>
<ul class="list-inline-button">
<?php $i = 0; foreach ($facet_autor["result"] as $at): ?>
  <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?autor=<?php echo $at["_id"]; ?>" style="color:white"><?php echo $at["_id"]; ?> <span class="label label-default label-pill"><?php echo $at["count"]; ?></span></a></button></li>
<?php if(++$i > 15) break; endforeach; ?>
</ul>
<p><a href="autores.php">Ver todos os autores</a></p>

<h3>Instituições</h3>
<ul class="list-inline-button">
<?php $i = 0; foreach ($facet_instituicao ["result"] as $it): ?>
  <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?instituicao=<?php echo $it["_id"]; ?>" style="color:white"><?php echo $it["_id"]; ?> <span class="label label-default label-pill"><?php echo $it["count"]; ?></span></a></button></li>
  <?php if(++$i > 15) break; endforeach; ?>
</ul>
<p><a href="instituicoes.php">Ver todas as instituições</a></p>

<h3>Principais assuntos</h3>
<ul class="list-inline-button">
<?php $i = 0; foreach ($facet_subject["result"] as $sj): ?>
  <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?subject=<?php echo $sj["_id"]; ?>" style="color:white"><?php echo $sj["_id"];?> <span class="label label-default label-pill"><?php echo $sj["count"];?></span></a></button></li>
<?php if(++$i > 25) break; endforeach; ?>
</ul>
<p><a href="assuntos.php">Ver todos os assuntos</a></p>
<h3>Assuntos tratados pelo Vocabulário Controlado</h3>
<ul class="list-inline-button">
<?php $i = 0; foreach ($facet_assunto_tematres["result"] as $aterm): ?>
  <li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?assunto_tematres=<?php  echo $aterm["_id"];?>" style="color:white"><?php echo $aterm["_id"];?> <span class="label label-default label-pill"><?php echo $aterm["count"];?></span></a></button></li>
<?php if(++$i > 25) break; endforeach; ?>
</ul>
<p><a href="assuntos_tematres.php">Ver todos os assuntos tratados pelo Vocabulário Controlado</a></p>
<br/>
<?php
  include "inc/footer.php";
?>
</div>
</body>
</html>
