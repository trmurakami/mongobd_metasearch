<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Detalhes do registro</title>
</head>
<body>
<?php include_once('inc/analytics.php') ?>
<?php
  include 'inc/navbar.php';


error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

$query = json_decode('[{"$match":{"_id":"'.$_GET['_id'].'"}},{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}}]');
$cursor = $d->ci->aggregate($query);

$query_citation = array('citation' => ''.$_GET['_id'].'');
$cursor_citation = $d->ci->find($query_citation);

?>
<div class="ui two column stackable grid">
<div class="four wide column">

<?php
if (!empty($cursor_citation)) {
    echo '<ul class="list-group">';
    echo '<a href="#" class="list-group-item active">Citado por</a>';
    foreach ($cursor_citation as $cit_data) {
        echo '<li class="list-group-item"><a href="single.php?_id='.$cit_data['_id'].'">'.$cit_data['title'][0].'</a></li>';
    }
    echo '</ul>';
}
?>
<div class="ui list">
  <?php if (!empty($cursor["result"][0]["altmetrics"][0]['facebook_atualizacao'])): ?>
    <a href="#" class="list-group-item active">Interações no Facebook</a>
    <div class="item">Curtidas <span class="yellow ui label"><?php echo ''.$cursor["result"][0]["altmetrics"][0]['facebook_url_likes'].''; ?></span></div>
    <div class="item">Compartilhamentos <span class="green ui label"><?php echo ''.$cursor["result"][0]["altmetrics"][0]['facebook_url_shares'].''; ?></span></div>
    <div class="item">Comentários <span class="red ui label"><?php echo ''.$cursor["result"][0]["altmetrics"][0]['facebook_url_comments'].''; ?></span></div>
    <div class="item">Total <span class="blue ui label"><?php echo ''.$cursor["result"][0]["altmetrics"][0]['facebook_url_total'].''; ?></span></div>
    <small>Data de atualização: <?php echo ''.$cursor["result"][0]["altmetrics"][0]['facebook_atualizacao'].'';?></small>
  <?php endif; ?>
</div>

	<h3>Exportar</h3>
</div>
<div class="ten wide column">
  <h2 class="ui center aligned icon header">
    <i class="circular file icon"></i>
    Detalhes do registro / <?php echo ''.$cursor["result"][0]['tipo'][0].''; ?>
  </h2>

  <div class="ui top attached tabular menu">
    <a class="item active" data-tab="first">Visualização</a>
    <a class="item" data-tab="second">Registro Completo</a>
  </div>
  <div class="ui bottom attached tab segment active" data-tab="first">
    <?php if (!empty($cursor["result"][0]['title'][2])): ?>
        <h2><?php echo $cursor["result"][0]['title'][2];?> (<?php echo $cursor["result"][0]['year'][0]; ?>)</h2>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor["result"][0]['title'][1];?></small><br/>
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor["result"][0]['title'][0];?></small>
      </div>
      <?php elseif (empty($cursor["result"][0]['title'][2]) && !empty($cursor["result"][0]['title'][1])): ?>
      <h2><?php echo $cursor["result"][0]['title'][1];?> (<?php echo $cursor["result"][0]['year'][0]; ?>)</h2>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor["result"][0]['title'][0];?></small>
      </div>
    <?php else: ?>
      <h2><?php echo $cursor["result"][0]['title'][0];?> (<?php echo $cursor["result"][0]['year'][0]; ?>)</h2>
    <?php endif; ?>

  <!--List authors -->
  <div class="ui middle aligned selection list">

  <?php if (!empty($cursor["result"][0]['autor'])): ?>
    <h4>Autor(es):</h4>
    <?php foreach ($cursor["result"][0]['autor'] as $autores): ?>
      <div class="item">
        <i class="user icon"></i>
        <div class="content">
          <a href="result.php?autor=<?php echo $autores;?>"><?php echo $autores;?></a>
          </div>
        </div>
  <?php endforeach;?>

  <?php else: ?>
  <?php foreach ($cursor["result"][0]['creator'] as $autores): ?>
      <b>Autor</b>:<?php echo $autores;?><br/>
  <?php endforeach;?>
  <?php endif; ?>

  <?php if (!empty($cursor["result"][0]['instituicao'])): ?>
    <h4>Instituições em que os autores estão vinculados:</h4>
    <?php foreach ($cursor["result"][0]['instituicao'] as $instituicoes): ?>
      <div class="item">
        <i class="university icon"></i>
        <div class="content">
            <a href="result.php?instituicao=<?php echo $instituicoes;?>"><?php echo $instituicoes;?></a>
          </div>
        </div>
  <?php endforeach;?>
  <?php endif; ?>
  <h4>URLs</h4>
  <div class="item" style="color:black;">
    <i class="linkify icon"></i>
    <div class="content">
        <?php echo '<p>URL principal: <a href="'.$cursor["result"][0]['url_principal'].'">'.$cursor["result"][0]['url_principal'].'</a></p>'; ?>
      </div>
  </div>
  <?php if (!empty($cursor["result"][0]['doi'])): ?>
    <div class="item" style="color:black;">
      <i class="linkify icon"></i>
      <div class="content">
          <?php echo '<p>DOI: <a href="'.$cursor["result"][0]['doi'].'">'.$cursor["result"][0]['doi'].'</a></p>'; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['relation'])): ?>
    <?php foreach ($cursor["result"][0]['relation'] as $cursorelation): ?>
      <div class="item" style="color:black;">
        <i class="linkify icon"></i>
        <div class="content">
            <?php echo '<p>URL relacionada: <a href="'.$cursorelation.'">'.$cursorelation.'</a></p>'; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <h4>Dados da publicação</h4>
  <div class="item" style="color:black;">
    <i class="book icon"></i>
    <div class="content">
        <?php echo 'ID: '.$cursor["result"][0]['_id'].''; ?>
    </div>
  </div>
  <?php if (!empty($cursor["result"][0]['journalci_title'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Título do periódico: <a href="result.php?journalci_title='.$cursor["result"][0]['journalci_title'][0].'">'.$cursor["result"][0]['journalci_title'][0].'</a>'; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['fasciculo'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Fascículo: '.$cursor["result"][0]['fasciculo'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['paginas'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Paginação: '.$cursor["result"][0]['paginas'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['qualis2014'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Qualis 2014: '.$cursor["result"][0]['qualis2014'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['publisher'])): ?>
    <?php foreach ($cursor["result"][0]['publisher'] as $cursorpublisher): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Editora: '.$cursorpublisher.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['date'])): ?>
    <?php foreach ($cursor["result"][0]['date'] as $cursordate): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Data de publicação: '.$cursordate.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['language'])): ?>
    <?php foreach ($cursor["result"][0]['language'] as $cursorlanguage): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Idioma: '.$cursorlanguage.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['subject'])): ?>
  <h4>Assuntos</h4>
    <?php foreach ($cursor["result"][0]['subject'] as $cursorsubject): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursorsubject.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['assunto_tematres'])): ?>
    <h4>Assuntos do Vocabulário Controlado</h4>
    <?php foreach ($cursor["result"][0]['assunto_tematres'] as $cursorassunto_tematres): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursorassunto_tematres.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['description'])): ?>
    <h4>Resumo(s)</h4>
    <?php foreach ($cursor["result"][0]['description'] as $cursordescription): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursordescription.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['references'])): ?>
    <h4>Referências</h4>
    <?php foreach ($cursor["result"][0]['references'] as $cursorreferences): ?>
      <div class="item" style="color:black;">
        <i class="quote left icon"></i>
        <div class="content">
            <?php echo ''.$cursorreferences.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor["result"][0]['citation'])): ?>
    <h4>Citações de trabalhos no RPPBCI</h4>
    <?php foreach ($cursor["result"][0]['citation'] as $citation): ?>
      <div class="item" style="color:black;">
        <i class="quote left icon"></i>
        <div class="content">
            <?php echo '<a href="single.php?_id='.$citation.'">'.$citation.'</a>'; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  </div>
  </div>
  <div class="ui bottom attached tab segment" data-tab="second">
    Second
  </div>

<?php
if ($cursor["result"][0]['references_ok'] == 'false') {
    echo '<form method="get" action="edit.php">';
    echo '<input type="hidden">';
    echo '<button type="submit" name="_id" class="btn btn-primary-outline" value="'.$cursor["result"][0]['_id'].'">Editar referências</button>';
}
?>


</div>
</div>
</div></div>
</div>
<?php
  include 'inc/footer.php';
?>
<script>
$('.menu .item')
  .tab()
;
</script>
</body>
</html>
