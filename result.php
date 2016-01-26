<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title>MetaBuscaCI - Resultados de Busca</title>

<?php
/* recupera as variáveis do GET */

if(isset($_GET['full_text'])) {
  $query_array = array();
    foreach ($_GET as $key=>$value) {
      $query[$key] = $value;
  }

  $qstring = "?";
  foreach($_GET as $key => $val)
  {
      $qstring .= '"' . $val . '"&';
  }

  $query = array ('$text' => array('$search'=>''.$qstring.''));
}
else {
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
    <?php
      foreach ($_GET as $filters) {
        echo '<li class="list-group-item">'.$filters.'</a>';
        echo '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '</li>';
      }
       ?>
     </ul>
     <br/>


<?php

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
generateFacet($url,$c,$query,"\$tipo","count",-1,"Tipo de publicação",10);
generateFacet($url,$c,$query,"\$journalci_title","count",-1,"Publicação",20);
generateFacet($url,$c,$query,"\$autor","count",-1,"Autores",20);
generateFacet($url,$c,$query,"\$instituicao","count",-1,"Instituições",20);
generateFacet($url,$c,$query,"\$year","_id",-1,"Ano de publicação",20);
generateFacet($url,$c,$query,"\$subject","count",-1,"Principais assuntos",20);
generateFacet($url,$c,$query,"\$language","count",-1,"Idioma",10);


 ?>

</div>
<div class="col-xs-12 col-sm-6 col-md-9">


<?php


$cursor = $c->find($query)->skip($skip)->limit($limit)->sort($sort);
$total= $cursor->count();

print_r("<div class=\"page-header\"><h3>Resultado da busca <small>($total)</small></h3></div>");


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
echo '<div class="card-columns">';
foreach ($cursor as $r) {
  echo '<div class="card " >';

  /* Journal or Event Title */
      echo '<div class="card-footer card-inverse card-primary text-muted" style="color:white;"><a href="result.php?journalci_title='.$r["journalci_title"][0].'" style="color:white">'.$r["journalci_title"][0].'</a> | <a href="result.php?tipo='.$r["tipo"][0].'" style="color:white">'.$r["tipo"][0].'</a></div>';
echo '<div class="card-block">';
/* List titles */

    if (!empty($r["title"][2])) {
      $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].'');
      echo '<h5 class="card-title"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][2].' ('.$r["year"][0].')</a> <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#'.$id.'" aria-expanded="false" aria-controls="'.$id.'">+</button></h5>';
      echo '<div class="collapse" id="'.$id.'">';
      echo '<div class="card card-block">';
      echo '<small class="text-muted"><b>Outros títulos:</b> '.$r["title"][1].'</small><br/>';
      echo '<small class="text-muted"><b>Outros títulos:</b> '.$r["title"][0].'</small>';
      echo '</div>';
      echo '</div>';
    }
    elseif (empty($r["title"][2]) && !empty($r["title"][1])) {
      $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].'');
      echo '<h5 class="card-title"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][1].' ('.$r["year"][0].')</a> <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#'.$id.'" aria-expanded="false" aria-controls="'.$id.'">+</button></h5>';
      echo '<div class="collapse" id="'.$id.'">';
      echo '<div class="card card-block">';
      echo '<small class="text-muted"><b>Outros títulos:</b> '.$r["title"][0].'</small>';
      echo '</div>';
      echo '</div>';
    }
    else {
      echo '<h5 class="card-title"><a href="single.php?idx=_id&q='.$r["_id"].'" >'.$r["title"][0].' ('.$r["year"][0].')</a></h5>';
    }
/* List authors */
    echo '<small><h6 class="card-subtitle text-muted">Autor(es):</h6>';
    if (!empty($r["autor"])) {
      echo '<ul>';
      foreach ($r["autor"] as $autores){
        echo "<li><a href=\"result.php?autor=$autores\">$autores</a></li>";
      }
        echo '</ul></small>';
    }
    else
    {
      foreach ($r["creator"] as $autores){
          echo '<b>Autor</b>:'.$autores.'<br/>';
     }
    }
    echo '<small><ul class="nav nav-pills list-inline-facebook" role="tablist">';
    echo '<li role="presentation" class="active">Facebook:</li>';
    echo '<li role="presentation"><span class="label label-success label-pill pull-xs-right">'.$r["facebook_url_comments"].'</span></li>';
    echo '<li role="presentation"><span class="label label-warning label-pill pull-xs-right">'.$r["facebook_url_likes"].'</span></li>';
    echo '<li role="presentation"><span class="label label-danger label-pill pull-xs-right">'.$r["facebook_url_shares"].'</span></li>';
    echo '</ul></small>';
    echo '<a href="'.$r["url_principal"].'" class="btn btn-info">Acesso online</a>';


    echo '</div>';
echo '</div>';

}

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
