<!-- Homepage -->

<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Repertório da Produção Periódica Brasileira de Ciência da Informação</title>
<style type="text/css">
  .ui.inverted.segment {
    background-image: url("inc/images/maceio.jpg");
    width: 100%;
    height: auto;
    background-repeat: no-repeat;
    background-size: cover;

  }

  .hidden.menu {
    display: none;
  }
  .masthead.segment {
    min-height: 700px;
    padding: 1em 0em;
  }
  .masthead .logo.item img {
    margin-right: 1em;
  }
  .masthead .ui.menu .ui.button {
    margin-left: 0.5em;
  }
  .masthead h1.ui.header {
    margin-top: 3em;
    margin-bottom: 0em;
    font-size: 4em;
    font-weight: normal;
  }
  .masthead h2 {
    font-size: 1.7em;
    font-weight: normal;
  }

  .ui.vertical.stripe {
    padding: 8em 0em;
  }
  .ui.vertical.stripe h3 {
    font-size: 2em;
  }
  .ui.vertical.stripe .button + h3,
  .ui.vertical.stripe p + h3 {
    margin-top: 3em;
  }
  .ui.vertical.stripe .floated.image {
    clear: both;
  }
  .ui.vertical.stripe p {
    font-size: 1.33em;
  }
  .ui.vertical.stripe .horizontal.divider {
    margin: 3em 0em;
  }

  .quote.stripe.segment {
    padding: 0em;
  }
  .quote.stripe.segment .grid .column {
    padding-top: 5em;
    padding-bottom: 5em;
  }

  .footer.segment {
    padding: 5em 0em;
  }

  .secondary.pointing.menu .toc.item {
    display: none;
  }


  @media only screen and (max-width: 700px) {
    .ui.fixed.menu {
      display: none !important;
    }
    .secondary.pointing.menu .item,
    .secondary.pointing.menu .menu {
      display: none;
    }
    .secondary.pointing.menu .toc.item {
      display: block;
    }
    .masthead.segment {
      min-height: 350px;
    }
    .masthead h1.ui.header {
      font-size: 2em;
      margin-top: 1.5em;
    }
    .masthead h2 {
      margin-top: 0.5em;
      font-size: 1.5em;
    }
  }


</style>
<script>
  $(document)
    .ready(function() {

      // fix menu when passed
      $('.masthead')
        .visibility({
          once: false,
          onBottomPassed: function() {
            $('.fixed.menu').transition('fade in');
          },
          onBottomPassedReverse: function() {
            $('.fixed.menu').transition('fade out');
          }
        })
      ;

      // create sidebar and attach to menu open
      $('.ui.sidebar')
        .sidebar('attach events', '.toc.item')
      ;

    })
  ;
  </script>
</head>
<body>
<?php include_once('inc/analytics.php') ?>

<?php
/*Conta a quantidade de artigos na base */
  $num_documentos = ($c->count());
?>
<?php
/*Conta a quantidade de referencias na base */
$aggregate_references_count=array(
  array(
    '$lookup' => array(
      "from" => "ci_altmetrics",
      "localField" => "_id",
      "foreignField" => "_id",
      "as" => "altmetrics"
    )
  ),
  array(
    '$unwind'=>'$altmetrics'
  ),
  array(
    '$unwind'=>'$altmetrics.references'
  ),
  array(
    '$group' => array(
      "_id"=>'$_id',
      "sum"=>array('$sum'=>1)
      )
  ),
  array(
    '$group' => array(
      "_id"=>"null",
      "total_sum"=>array('$sum'=>'$sum')
      )
  )
);
$references_count = $c->aggregate($aggregate_references_count);
?>

<!-- Following Menu -->
<div class="ui large top fixed hidden menu">
  <div class="ui container">
    <a class="active item" href="index.php"><?php echo gettext('branch');?></a>
    <a class="item" href="statistics.php">Estatísticas</a>
    <a class="item" href="contact.php">Contato</a>
    <a class="item" href="about.php">Sobre</a>
    <div class="right menu">
      <div class="item">
        <div class="ui transparent icon input">
          <form class="form-inline pull-xs-right" action="result.php" method="get">
          <i class="search icon"></i>
          <input type="text" name="q" placeholder="Buscar em Títulos, Autores e Resumos">
          <select class="ui dropdown" name="category" style="color:black;">
            <option value="buscaindice">Título, autores e resumos</option>
            <option value="altmetrics.references">Referências</option>
            <!-- <option value="full_text">Texto completo dos artigos</option> -->
            <option value="autor">Nome do autor</option>
            <option value="subject">Assunto</option>
          </select>
          <button class="ui button">Buscar</button>
          </form>
        </div>
      </div>
      <div class="item">
        <a class="ui button" href="admin/login.php">Login</a>
      </div>
    </div>
  </div>
</div>

<!-- Sidebar Menu -->
<div class="ui vertical inverted sidebar menu">
  <a class="active item" href="index.php"><?php echo gettext('branch');?></a>
  <a class="item" href="statistics.php">Estatísticas</a>
  <a class="item" href="contact.php">Contato</a>
  <a class="item" href="about.php">Sobre</a>
  <a class="item" href="admin/login.php">Login</a>
</div>


<!-- Page Contents -->
<div class="pusher">
  <div class="ui inverted vertical masthead center aligned segment">

    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="active item" href="index.php"><?php echo gettext('branch');?></a>
        <a class="item" href="statistics.php">Estatísticas</a>
        <a class="item" href="contact.php">Contato</a>
        <a class="item" href="about.php">Sobre</a>
        <div class="right item">
          <div class="item">
            <div class="ui transparent inverted icon input">
              <form class="form-inline pull-xs-right" action="result.php" method="get">
              <i class="search icon"></i>
              <input type="text" name="q" placeholder="Buscar em Títulos, Autores e Resumos">
              <select class="ui dropdown" name="category" style="color:black;">
                <option value="buscaindice">Título, autores e resumos</option>
                <option value="altmetrics.references">Referências</option>
                <!-- <option value="full_text">Texto completo dos artigos</option> -->
                <option value="autor">Nome do autor</option>
                <option value="subject">Assunto</option>
              </select>
              <button class="ui button">Buscar</button>
              </form>
            </div>
          </div>
          <a class="ui inverted button" href="admin/login.php">Login</a>
        </div>
      </div>
    </div>

    <div class="ui text container">
      <h1 class="ui inverted header">
        <?php echo gettext('branch');?> (Beta)
      </h1>
      <h2>Repertório da Produção Periódica Brasileira de Ciência da Informação disponível em OAI-PMH.</h2>
      <a href="#search"><div class="ui huge primary button">Começe a pesquisar <i class="right arrow icon"></i></div></a>
    </div>

  </div>

  <div class="ui vertical stripe segment" id="search">
    <div class="ui text container">
      <h3 class="ui header" >Faça uma busca no repertório</h3>
      <form class="ui form" role="form" action="result.php" method="get">
        <div class="inline fields">
          <div class="eight wide field">
            <input name="q" type="text" placeholder="Digite os termos de busca">
          </div>
          <div class="six wide field">
            <select class="ui fluid dropdown" name="category">
              <option value="buscaindice">Título, autores e resumos</option>
              <option value="altmetrics.references">Referências</option>
              <!-- <option value="full_text">Texto completo dos artigos</option> -->
              <option value="autor">Nome do autor</option>
              <option value="subject">Assunto</option>
            </select>
            </div>
          <button type="submit" id="s" class="ui large button">Buscar</button>
      </div>
      </form>
      <p>A equipe do Lab-iMetrics está constantemente estudando novas formas de disponibilizar os dados para os usuários. Atualmente, você pode fazer a busca nos campos "Título, Autores e Resumos", ou somente nas Referências (Regex), também é possível fazer uma busca no texto completo (Regex) ou nos campos de Autores (Regex) e Assunto (Regex).</p>
      <a class="ui large button" href="advanced_search.php">Busca avançada</a>
<!--
    <div class="ui negative message">
      <i class="close icon"></i>
      <div class="header">
        Atenção: A busca nas referências está funcionando de maneira parcial
      </div>
      <p>Estamos trabalhando para completar essa funcionalidade</p></div>
      </div>
  </div>
-->

  <div class="ui vertical stripe segment">
    <div class="ui text container">
    <h3 class="ui header">Como funciona?</h3><br/><br/>
    <div class="ui middle aligned stackable grid container">
      <div class="ui container">
        <div class="ui relaxed divided items">
          <div class="item">
            <div class="ui small image">
              <img src="inc/images/harvesting.png">
            </div>
            <div class="content">
              <a class="header">Coleta</a>
              <div class="description">
                Os dados dos periódicos disponíveis em OAI-PHM são coletados utilizando a ferramenta <a href="http://librecat.org/">Librecat/Catmandu</a> e armazenados em um banco de dados NoSQL <a href="https://www.mongodb.org/">MongoDB</a>. Os dados são coletados automaticamente, totalizando: <?php echo $num_documentos; ?> documentos
              </div>
            </div>
          </div>
          <div class="item">
            <div class="ui small image">
              <img src="inc/images/openrefine.jpg">
            </div>
            <div class="content">
              <a class="header">Tratamento</a>
              <div class="description">
                Os dados são tratados utilizando o webservice do <a href="http://www.labimetrics.inf.br/vocabci/vocab/index.php">Vocabulário Controlado de Ciência da Informação no Brasil</a> que foi criado utilizando o software livre para vocabulários controlados <a href="http://www.vocabularyserver.com">Tematres</a> e são incluídos dados altmétricos do Facebook recuperados de sua API.
              </div>
            </div>
          </div>
          <div class="item">
            <div class="ui small image">
              <img src="inc/images/data-visualization-examples.png">
            </div>
            <div class="content">
              <a class="header">Visualização de dados</a>
              <div class="description">
                Dados são visualizados por meio de facetas nos resultados de busca. São adicionados gráficos utilizando as bibliotecas <a href="http://sigmajs.org/">Sigma.js</a> e <a href="https://developers.google.com/chart/">Google Charts</a>.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="ui vertical stripe segment">
<div class="ui text container">
<h3 class="ui header">Alguns números</h3><br/><br/>
<div class="ui three statistics">
  <div class="statistic">
    <div class="value">
      32
    </div>
    <div class="label">
      Periódicos coletados
    </div>
  </div>
  <div class="statistic">
    <div class="value">
      <i class="file icon"></i> <?php echo $num_documentos; ?>
    </div>
    <div class="label">
      Artigos indexados
    </div>
  </div>
  <?php if (!empty($references_count["result"][0]["total_sum"])): ?>
    <div class="statistic">
      <div class="value">
        <?php print_r($references_count["result"][0]["total_sum"]); ?>
      </div>
      <div class="label">
        referências cadastradas
      </div>
    </div>
  <?php endif; ?>
</div>
</div>
</div>

  <div class="ui vertical stripe segment">
    <div class="ui text container">
      <h3 class="ui header">Explorar o repertório pelos índices</h3>

<?php
/* Cria as consultas para o aggregate */

function generateFacetInit($c, $facet_name, $sort_name, $sort_value, $facet_display_name, $limit, $link)
{
    $aggregate_facet_init = array(
    array(
      '$unwind' => $facet_name,
    ),
    array(
      '$group' => array(
        '_id' => $facet_name,
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array($sort_name => $sort_value),
    ),
  );

    $facet_init = $c->aggregate($aggregate_facet_init);

    echo '<h3><a href="'.$link.'">'.$facet_display_name.'</a></h3>';
    echo '<div class="ui horizontal list">';
    $i = 0;
    foreach ($facet_init['result'] as $facets) {
        echo '<div class="item">
        <div class="content">
        <div class="ui labeled button" tabindex="0">
        <div class="header">
          <a href="result.php?'.substr($facet_name, 1).'='.$facets['_id'].'">'.$facets['_id'].'</a>
        </div>
        ('.$facets['count'].')
        </div></div>
        </div>';
        if (++$i > $limit) {
            break;
        }
    };
    echo '</div>';
};

generateFacetInit($c, '$journalci_title', '_id', 1, 'Periódicos indexados', 100, '#');
generateFacetInit($c, '$year', '_id', -1, 'Ano de publicação', 100, '#');
generateFacetInit($c, '$autor', 'count', -1, 'Autores', 20, 'application/browse/autores.php');
generateFacetInit($c, '$instituicao', 'count', -1, 'Instituições', 20, 'application/browse/instituicoes.php');
generateFacetInit($c, '$subject', 'count', -1, 'Principais assuntos', 20, 'application/browse/assuntos.php');
generateFacetInit($c, '$assunto_tematres', 'count', -1, 'Assuntos tratados pelo Vocabulário Controlado', 20, 'application/browse/assuntos_tematres.php');

?>
</div>
</div>
</div>
<?php
  include 'inc/footer.php';
?>
</div>
</body>
</html>
