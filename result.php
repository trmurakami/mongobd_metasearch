<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title><?php echo gettext("branch");?> - Resultados de Busca</title>
<?php
/* recupera as variáveis do GET */
  if(isset($_GET['full_text'])) {
    $query_array = array();
    $qstring = "?";
    foreach($_GET as $key => $val)
    {
        $qstring .= '' . $val . ' ';
    }

    $query = array ('$text' => array('$search'=>''.$qstring.''));

  } elseif (isset($_GET['references']) == 1 ) {

  $query = array('references' => new MongoRegex('/'.$_GET['references'].'/i'));

  } else {
    $query_array = array();
      foreach ($_GET as $key=>$value) {
        $query[$key] = $value;
    }
  }
/* Pegar a URL atual */
  $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
  $pattern = '/page=\d/i';
  $url_sem_page = preg_replace($pattern,'',$escaped_url);
/* Pagination variables */
  $page  = isset($_POST['page']) ? (int) $_POST['page'] : 1;
  $limit = 12;
  $skip  = ($page - 1) * $limit;
  $next  = ($page + 1);
  $prev  = ($page - 1);
  $sort  = array('facebook_url_total' => -1);
  /* Consultas */
    $cursor = $c->find($query)->skip($skip)->limit($limit)->sort($sort);
    $total= $cursor->count();
/* Function to generate facets */
function generateFacet($url,$c,$query,$facet_name,$sort_name,$sort_value,$facet_display_name,$limit){
  $aggregate_facet=array(
    array(
      '$match'=>$query
    ),
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
$facet = $c->aggregate($aggregate_facet);

echo '<ul class="list-group">';
echo '<a href="#" class="list-group-item active">'.$facet_display_name.'</a>';
$i = 0;
foreach ($facet["result"] as $facets) {
  echo '<li class="list-group-item"><span class="label label-default label-pill pull-xs-right">'.$facets["count"].'</span><a href="'.$url.'&'.substr($facet_name, 1).'='.$facets["_id"].'">'.$facets["_id"].'</a></li>';
  if(++$i > $limit) break;
};
echo "</ul>";
}

?>
</head>
<body>
<div class="container-fluid">
<?php
  include ('inc/navbar.php');
?>
<div class="row">
  <div class="col-xs-6 col-md-3">
    <ul class="list-group">
    <a href="#" class="list-group-item active">Filtros ativos</a>
    <?php foreach ($_GET as $filters): ?>
        <li class="list-group-item"><?php echo $filters;?></a>
        <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </li>
    <?php endforeach;?>
     </ul>

<?php
/* Generate facebook facets */
  $aggregate_facebook=array(
    array(
      '$match'=>$query
    ),
    array(
      '$group' => array(
        "_id"=>"Total de interações no facebook",
        "likes"=>array('$sum'=>'$facebook_url_likes'),
        "shares"=>array('$sum'=>'$facebook_url_shares'),
        "comments"=>array('$sum'=>'$facebook_url_comments'),
        "total"=>array('$sum'=>'$facebook_url_total')
        )
    )
  );
  $facet_facebook = $c->aggregate($aggregate_facebook);
  echo '<ul class="list-group">';
  echo '<a href="#" class="list-group-item active">Interações no Facebook</a>';
  foreach ($facet_facebook["result"] as $fb) {
    echo '<li class="list-group-item"><span class="label label-success label-pill pull-xs-right">'.$fb["likes"].'</span>Curtidas</li></a>';
    echo '<li class="list-group-item"><span class="label label-warning label-pill pull-xs-right">'.$fb["shares"].'</span>Compartilhamentos</li>';
    echo '<li class="list-group-item"><span class="label label-danger label-pill pull-xs-right">'.$fb["comments"].'</span>Comentários</li>';
    echo '<li class="list-group-item"><span class="label label-default label-pill pull-xs-right">'.$fb["total"].'</span>Total</li>';
  };
  echo "</ul>";
?>
<?php
/* Gerar facetas */
  generateFacet($url,$c,$query,"\$fasciculo","_id",-1,"Fascículo",30);
  generateFacet($url,$c,$query,"\$tipo","count",-1,"Tipo de publicação",10);
  generateFacet($url,$c,$query,"\$journalci_title","count",-1,"Publicação",20);
  generateFacet($url,$c,$query,"\$autor","count",-1,"Autores",20);
  generateFacet($url,$c,$query,"\$instituicao","count",-1,"Instituições",20);
  generateFacet($url,$c,$query,"\$year","_id",-1,"Ano de publicação",20);
  generateFacet($url,$c,$query,"\$subject","count",-1,"Principais assuntos",20);
  generateFacet($url,$c,$query,"\$language","count",-1,"Idioma",10);
  generateFacet($url,$c,$query,"\$citation","count",-1,"Principais citações",20);
  generateFacet($url,$c,$query,"\$references_ok","count",-1,"Referências",10);
?>
</div>
<div class="col-xs-12 col-sm-6 col-md-9">
<div class="page-header"><h3>Resultado da busca <small><?php print_r($total);?></small></h3></div>

<?php
/* Pagination - Start */
echo '<nav>';
echo '<ul class="pager">';
if($page > 1){
  echo '<form method="post" action="'.$escaped_url.'">';
  echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
  echo '<li><button type="submit" name="page" class="btn btn-primary-outline" value="'.$prev.'">Anterior</button></li>';
  if($page * $limit < $total) {
    echo '<li><button type="submit" name="page" value="'.$next.'" class="btn btn-primary-outline">Próximo</button></li>';
  }
  else {
    echo '<li><button class="btn btn-secondary" disabled>Próximo</button></li>';
  }
  echo '</form>';
} else {
    if($page * $limit < $total) {
      echo '<form method="post" action="'.$escaped_url.'">';
      echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
      echo '<li><button class="btn btn-secondary" disabled>Anterior</button></li>';
      echo '<li><button type="submit" name="page" value="'.$next.'" class="btn btn-primary-outline">Próximo</button></li>';
      echo '</form>';
    }
}
echo '</ul>';
echo '</nav>';
/* Pagination - End */
?>

<div class="card-columns">
<?php foreach ($cursor as $r): ?>
  <div class="card " >
  <!-- Journal or Event Title -->
    <div class="card-footer card-inverse card-primary text-muted" style="color:white;"><a href="result.php?journalci_title=<?php echo $r["journalci_title"][0];?>" style="color:white"><?php echo $r["journalci_title"][0];?></a> | <a href="result.php?tipo=<?php echo $r["tipo"][0];?>" style="color:white"><?php echo $r["tipo"][0];?></a>
    </div>
    <div class="card-block">
    <!-- List titles -->
    <?php if (!empty($r["title"][2])): ?>
      <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].''); ?>
      <h5 class="card-title"><a href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][2];?> (<?php echo $r["year"][0]; ?>)</a> <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#<?php echo $id;?>" aria-expanded="false" aria-controls="<?php echo $id;?>">+</button></h5>
      <div class="collapse" id="<?php echo $id;?>">
      <div class="card card-block">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][1];?></small><br/>
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][0];?></small>
      </div>
      </div>
    <?php elseif (empty($r["title"][2]) && !empty($r["title"][1])): ?>
    <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].'') ?>
      <h5 class="card-title"><a href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][1];?> (<?php echo $r["year"][0];?>)</a> <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#<?php echo $id;?>" aria-expanded="false" aria-controls="<?php echo $id;?>">+</button></h5>
      <div class="collapse" id="<?php echo $id;?>">
      <div class="card card-block">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][0];?></small>
      </div>
      </div>
    <?php else: ?>
      <h5 class="card-title"><a href="single.php?_id=<?php echo $r["_id"]; ?>" ><?php echo $r["title"][0];?>  (<?php echo $r["year"][0];?>)</a></h5>
    <?php endif; ?>
    <!--List authors -->
    <small><h6 class="card-subtitle text-muted">Autor(es):</h6>
    <?php if (!empty($r["autor"])): ?>
      <ul>
      <?php foreach ($r["autor"] as $autores): ?>
        <li><a href="result.php?autor=<?php echo $autores;?>"><?php echo $autores;?></a></li>
      <?php endforeach;?>
      </ul>
    <?php else: ?>
    <?php foreach ($r["creator"] as $autores): ?>
        <b>Autor</b>:<?php echo $autores;?><br/>
    <?php endforeach;?>
    <?php endif; ?>
    </small>
    <small><ul class="nav nav-pills list-inline-facebook" role="tablist">
    <li role="presentation" class="active">Facebook:</li>
    <li role="presentation"><span class="label label-success label-pill pull-xs-right"><?php echo $r["facebook_url_comments"];?></span></li>
    <li role="presentation"><span class="label label-warning label-pill pull-xs-right"><?php echo $r["facebook_url_likes"];?></span></li>
    <li role="presentation"><span class="label label-danger label-pill pull-xs-right"><?php echo $r["facebook_url_shares"];?></span></li>
    </ul></small>
    <?php if (!empty($r["references"])): ?>
      <small>Referências cadastradas: <?php echo sizeof($r["references"]);?></small></br>
    <?php endif; ?>
    <?php if (!empty($r["references_ok"])): ?>
      <small>Referências OK: <?php echo $r["references_ok"];?></small></br>
    <?php endif; ?>

    <a href="<?php echo $r["url_principal"];?>" class="btn btn-info">Acesso online</a><br/>

</div>
</div>
<?php endforeach;?>

<?php
/* Pagination - Start */
echo '</div>';
echo '<nav>';
echo '<ul class="pager">';
if($page > 1){
  echo '<form method="post" action="'.$escaped_url.'">';
  echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
  echo '<li><button type="submit" name="page" class="btn btn-primary-outline" value="'.$prev.'">Anterior</button></li>';
  if($page * $limit < $total) {
    echo '<li><button type="submit" name="page" value="'.$next.'" class="btn btn-primary-outline">Próximo</button></li>';
  }
  else {
    echo '<li><button class="btn btn-secondary" disabled>Próximo</button></li>';
  }
  echo '</form>';
} else {
    if($page * $limit < $total) {
      echo '<form method="post" action="'.$escaped_url.'">';
      echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
      echo '<li><button class="btn btn-secondary" disabled>Anterior</button></li>';
      echo '<li><button type="submit" name="page" value="'.$next.'" class="btn btn-primary-outline">Próximo</button></li>';
      echo '</form>';
    }
}
echo '</ul>';
echo '</nav>';

/* Pagination - End */
?>

</div>
</div>
</div></div></div>

<?php
  include "inc/footer.php";
?>
</div>
</body>
</html>
