<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Detalhes do registro</title>
</head>
<body>
<?php
  include 'inc/navbar.php';

/*
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
*/
$query = array('_id' => ''.$_GET['_id'].'');
$cursor = $d->ci->findOne($query);

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
<?php
echo '<div class="ui list">';
echo '<a href="#" class="list-group-item active">Interações no Facebook</a>';
  echo '<div class="item">Curtidas <span class="yellow ui label">'.$cursor['facebook_url_likes'].'</span></div>';
  echo '<div class="item">Compartilhamentos <span class="green ui label">'.$cursor['facebook_url_shares'].'</span></div>';
  echo '<div class="item">Comentários <span class="red ui label">'.$cursor['facebook_url_comments'].'</span></div>';
  echo '<div class="item">Total <span class="blue ui label">'.$cursor['facebook_url_total'].'</span></div>';
  echo '<small>Data de atualização: '.$cursor['facebook_atualizacao'].'</small>';
echo '</div>';
?>

	<h3>Exportar</h3>
</div>
<div class="ten wide column">

  <h2 class="ui center aligned icon header">
    <i class="circular file icon"></i>
    Detalhes do registro / <?php echo ''.$cursor['tipo'][0].''; ?>
  </h2>

  <div class="ui top attached tabular menu">
    <a class="item active" data-tab="first">Visualização</a>
    <a class="item" data-tab="second">Registro Completo</a>
  </div>
  <div class="ui bottom attached tab segment active" data-tab="first">
    <?php if (!empty($cursor['title'][2])): ?>
        <h2><?php echo $cursor['title'][2];?> (<?php echo $cursor['year'][0]; ?>)</h2>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor['title'][1];?></small><br/>
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor['title'][0];?></small>
      </div>
      <?php elseif (empty($cursor['title'][2]) && !empty($cursor['title'][1])): ?>
      <h2><?php echo $cursor['title'][1];?> (<?php echo $cursor['year'][0]; ?>)</h2>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $cursor['title'][0];?></small>
      </div>
    <?php else: ?>
      <h2><?php echo $cursor['title'][0];?> (<?php echo $cursor['year'][0]; ?>)</h2>
    <?php endif; ?>

  <!--List authors -->
  <div class="ui middle aligned selection list">

  <?php if (!empty($cursor['autor'])): ?>
    <h4>Autor(es):</h4>
    <?php foreach ($cursor['autor'] as $autores): ?>
      <div class="item">
        <i class="user icon"></i>
        <div class="content">
          <a href="result.php?autor=<?php echo $autores;?>"><?php echo $autores;?></a>
          </div>
        </div>
  <?php endforeach;?>

  <?php else: ?>
  <?php foreach ($cursor['creator'] as $autores): ?>
      <b>Autor</b>:<?php echo $autores;?><br/>
  <?php endforeach;?>
  <?php endif; ?>

  <?php if (!empty($cursor['instituicao'])): ?>
    <h4>Instituições em que os autores estão vinculados:</h4>
    <?php foreach ($cursor['instituicao'] as $instituicoes): ?>
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
        <?php echo '<p>URL principal: <a href="'.$cursor['url_principal'].'">'.$cursor['url_principal'].'</a></p>'; ?>
      </div>
  </div>
  <?php if (!empty($cursor['doi'])): ?>
    <div class="item" style="color:black;">
      <i class="linkify icon"></i>
      <div class="content">
          <?php echo '<p>DOI: <a href="'.$cursor['doi'].'">'.$cursor['doi'].'</a></p>'; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor['relation'])): ?>
    <?php foreach ($cursor['relation'] as $cursorelation): ?>
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
        <?php echo 'ID: '.$cursor['_id'].''; ?>
    </div>
  </div>
  <?php if (!empty($cursor['journalci_title'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Título do periódico: <a href="result.php?journalci_title='.$cursor['journalci_title'][0].'">'.$cursor['journalci_title'][0].'</a>'; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor['fasciculo'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Fascículo: '.$cursor['fasciculo'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor['paginas'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Paginação: '.$cursor['paginas'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor['qualis2014'])): ?>
    <div class="item" style="color:black;">
      <i class="book icon"></i>
      <div class="content">
          <?php echo 'Qualis 2014: '.$cursor['qualis2014'][0].''; ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (!empty($cursor['publisher'])): ?>
    <?php foreach ($cursor['publisher'] as $cursorpublisher): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Editora: '.$cursorpublisher.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['date'])): ?>
    <?php foreach ($cursor['date'] as $cursordate): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Data de publicação: '.$cursordate.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['language'])): ?>
    <?php foreach ($cursor['language'] as $cursorlanguage): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo 'Idioma: '.$cursorlanguage.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['subject'])): ?>
  <h4>Assuntos</h4>
    <?php foreach ($cursor['subject'] as $cursorsubject): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursorsubject.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['assunto_tematres'])): ?>
    <h4>Assuntos do Vocabulário Controlado</h4>
    <?php foreach ($cursor['assunto_tematres'] as $cursorassunto_tematres): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursorassunto_tematres.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['description'])): ?>
    <h4>Resumo(s)</h4>
    <?php foreach ($cursor['description'] as $cursordescription): ?>
      <div class="item" style="color:black;">
        <i class="book icon"></i>
        <div class="content">
            <?php echo ''.$cursordescription.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['references'])): ?>
    <h4>Referências</h4>
    <?php foreach ($cursor['references'] as $cursorreferences): ?>
      <div class="item" style="color:black;">
        <i class="quote left icon"></i>
        <div class="content">
            <?php echo ''.$cursorreferences.''; ?>
        </div>
      </div>
  <?php endforeach;?>
  <?php endif; ?>
  <?php if (!empty($cursor['citation'])): ?>
    <h4>Citações de trabalhos no RPPBCI</h4>
    <?php foreach ($cursor['citation'] as $citation): ?>
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
if ($cursor['references_ok'] == 'false') {
    echo '<form method="get" action="edit.php">';
    echo '<input type="hidden">';
    echo '<button type="submit" name="_id" class="btn btn-primary-outline" value="'.$cursor['_id'].'">Editar referências</button>';
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
