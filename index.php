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

function generateFacetInit($c,$facet_name,$sort_name,$sort_value,$facet_display_name,$limit,$link){

  $aggregate_facet_init=array(
    array(
      '$unwind'=>$facet_name
    ),
    array(
      '$group' => array(
        "_id"=>$facet_name,
        "count"=>array('$sum'=>1)
        )
    ),
    array(
      '$sort' => array($sort_name=>$sort_value)
    )
  );

$facet_init = $c->aggregate($aggregate_facet_init);

echo '<h3><a href="'.$link.'">'.$facet_display_name.'</a></h3>';
echo '<ul class="list-inline-button">';
$i = 0;
foreach ($facet_init["result"] as $facets) {
  echo '<li style="padding:5px;">
        <button type="button" class="btn btn-primary">
        <a href="result.php?'.substr($facet_name, 1).'='.$facets["_id"].'" style="color:white">'.$facets["_id"].'
        <span class="label label-pill label-default">'.$facets["count"].'</span></a>
        </button>
        </li>';
        if(++$i > $limit) break;
};
echo "</ul>";
};

generateFacetInit($c,"\$journalci_title","_id",1,"Periódicos indexados",100,"#");
generateFacetInit($c,"\$year","_id",-1,"Ano de publicação",100,"#");
generateFacetInit($c,"\$autor","count",-1,"Autores",20,"autores.php");
generateFacetInit($c,"\$instituicao","count",-1,"Instituições",20,"instituicoes.php");
generateFacetInit($c,"\$subject","count",-1,"Principais assuntos",20,"assuntos.php");
generateFacetInit($c,"\$assunto_tematres","count",-1,"Assuntos tratados pelo Vocabulário Controlado",20,"assuntos_tematres.php");

?>
<?php
  include "inc/footer.php";
?>
</div>
</body>
</html>
