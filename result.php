<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title><?php echo gettext("branch");?> - Resultados de Busca</title>
</head>
<body>
<?php

/* Pegar a URL atual */
  $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
/* Pagination variables */
  $page  = isset($_POST['page']) ? (int) $_POST['page'] : 1;
  $limit = 15;
  $skip  = ($page - 1) * $limit;
  $next  = ($page + 1);
  $prev  = ($page - 1);
  $sort  = array('facebook_url_total' => -1);

if (empty($_GET)) {
    $query = json_decode('{}');
      $query = json_decode('{'.$consult.'"$text": {"$search":"'.$q.'"}}');
      $query_json = json_encode($query);
      $query_new = json_decode('[{"$match":'.$query_json.'},{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}},{"$sort":{"altmetrics.facebook_url_total":-1}},{"$skip":'.$skip.'},{"$limit":'.$limit.'}]');
      $query_count = json_decode('[{"$match":'.$query_json.'},{"$group":{"_id":null,"count":{"$sum": 1}}}]');
} elseif ($_GET["category"] == "altmetrics.references") {
        unset ($_GET["category"]);
        $q = str_replace('"','\\"',$_GET["q"]);
        unset ($_GET["q"]);
        $consult = "";
        foreach ($_GET as $key => $value) {
          $consult .= '"'.$key.'":"'.$value.'",';
        }
        $query = json_decode('{'.$consult.'"altmetrics.references": {"$regex":"'.$q.'", "$options": "si"}}');
        $query_json = json_encode($query);
        $query_new = json_decode('[{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}},{"$match":'.$query_json.'},{"$sort":{"altmetrics.facebook_url_total":-1}},{"$skip":'.$skip.'},{"$limit":'.$limit.'}]');
        $query_count = json_decode('[{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}},{"$match":'.$query_json.'},{"$group":{"_id":null,"count":{"$sum": 1}}}]');
} elseif (!empty($_GET["category"])) {
    unset ($_GET["category"]);
    $q = str_replace('"','\\"',$_GET["q"]);
    unset ($_GET["q"]);
    $consult = "";
    foreach ($_GET as $key => $value) {
      $consult .= '"'.$key.'":"'.$value.'",';
    }
    $query = json_decode('{'.$consult.'"$text": {"$search":"'.$q.'"}}');
    $query_json = json_encode($query);
    $query_new = json_decode('[{"$match":'.$query_json.'},{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}},{"$sort":{"altmetrics.facebook_url_total":-1}},{"$skip":'.$skip.'},{"$limit":'.$limit.'}]');
    $query_count = json_decode('[{"$match":'.$query_json.'},{"$group":{"_id":null,"count":{"$sum": 1}}}]');
} else {
    $query = array();
    foreach ($_GET as $key => $value) {
        $query[$key] = $value;
    }
    $query = json_decode('{'.$consult.'"$text": {"$search":"'.$q.'"}}');
    $query_json = json_encode($query);
    $query_new = json_decode('[{"$match":'.$query_json.'},{"$lookup":{"from": "ci_altmetrics", "localField": "_id", "foreignField": "_id", "as": "altmetrics"}},{"$sort":{"altmetrics.facebook_url_total":-1}},{"$skip":'.$skip.'},{"$limit":'.$limit.'}]');
    $query_count = json_decode('[{"$match":'.$query_json.'},{"$group":{"_id":null,"count":{"$sum": 1}}}]');

}

  /* Consultas */
echo "<br/><br/>";


$cursor = $c->aggregate($query_new);
$total_count = $c->aggregate($query_count);
$total = $total_count["result"][0]["count"];

# print_r($cursor);
#    $cursor = $c->find($query)->skip($skip)->limit($limit)->sort($sort);
#    $total= $cursor->count();

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

  echo '<div class="item">';
  echo '<a class="active title"><i class="dropdown icon"></i>'.$facet_display_name.'</a>';
  echo '<div class="content">';
  echo '<div class="ui list">';
  $i = 0;
  foreach ($facet["result"] as $facets) {
  echo '<div class="item">';
  echo '<a href="'.$url.'&'.substr($facet_name, 1).'='.$facets["_id"].'">'.$facets["_id"].'</a><span> ('.$facets["count"].')</span>';
  echo '</div>';
  if(++$i > $limit) break;
  };
  echo   '</div>
        </div>
    </div>';  
}

function generateFacetReferences($url,$c,$query,$facet_name,$sort_name,$sort_value,$facet_display_name,$limit){
    $aggregate_facet=array(
      array(
        '$lookup' => array(
          "from" => "ci_altmetrics",
          "localField" => "_id",
          "foreignField" => "_id",
          "as" => "altmetrics"
        )
      ),
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

echo '<div class="item">';
echo '<a class="active title"><i class="dropdown icon"></i>'.$facet_display_name.'</a>';
echo '<div class="content">';
echo '<div class="ui list">';
$i = 0;
foreach ($facet["result"] as $facets) {
echo '<div class="item">';
echo '<a href="'.$url.'&'.substr($facet_name, 1).'='.$facets["_id"].'">'.$facets["_id"].'</a><span> ('.$facets["count"].')</span>';
echo '</div>';
if(++$i > $limit) break;
};
echo   '</div>
      </div>
  </div>';
}

?>
<?php include_once('inc/analytics.php') ?>
<?php
  include ('inc/navbar.php');
?>
<div class="ui container">
<div class="ui two column stackable grid">
<div class="four wide column">
  <?php
  /* Generate facebook facets */
    $aggregate_facebook=array(
      array(
        '$match'=>$query
      ),
      array(
        '$lookup' => array(
          "from" => "ci_altmetrics",
          "localField" => "_id",
          "foreignField" => "_id",
          "as" => "altmetrics"
        )
      ),
      array(
        '$unwind'=> '$altmetrics'
      ),
      array(
        '$group' => array(
          "_id"=>"Total de interações no facebook",
          "likes"=>array('$sum'=>'$altmetrics.facebook_url_likes'),
          "shares"=>array('$sum'=>'$altmetrics.facebook_url_shares'),
          "comments"=>array('$sum'=>'$altmetrics.facebook_url_comments'),
          "total"=>array('$sum'=>'$altmetrics.facebook_url_total')
          )
      )
    );

    $facet_facebook = $c->aggregate($aggregate_facebook);

    echo '<div class="ui list">';
    echo '<a href="#" class="list-group-item active">Interações no Facebook</a>';
    foreach ($facet_facebook["result"] as $fb) {
      echo '<div class="item">Curtidas <span class="yellow ui label">'.$fb["likes"].'</span></div>';
      echo '<div class="item">Compartilhamentos <span class="green ui label">'.$fb["shares"].'</span></div>';
      echo '<div class="item">Comentários <span class="red ui label">'.$fb["comments"].'</span></div>';
      echo '<div class="item">Total <span class="blue ui label">'.$fb["total"].'</span></div>';
    };
    echo "</div>";
  ?>

  <div class="ui fluid vertical accordion menu">
    <div class="item">
      <a class="active title">
        <i class="dropdown icon"></i>
        Filtros ativos
      </a>
      <div class="active content">
        <div class="ui form">
          <div class="grouped fields">
            <?php foreach ($_GET as $filters): ?>
                <div class="field">
                <div class="ui checkbox">
                  <input type="checkbox" name="<?php echo $filters;?>">
                <label><?php echo $filters;?></label>
                </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  <?php
  /* Gerar facetas */
if ($_GET["category"] == "altmetrics.references") {
  generateFacetReferences($url,$c,$query,"\$tipo","count",-1,"Tipo de publicação",10);
  generateFacetReferences($url,$c,$query,"\$journalci_title","count",-1,"Título da publicação",20);
  generateFacetReferences($url,$c,$query,"\$year","_id",-1,"Ano de publicação",50);
  generateFacetReferences($url,$c,$query,"\$fasciculo","_id",-1,"Fascículos",30);
  generateFacetReferences($url,$c,$query,"\$autor","count",-1,"Autores",20);
  generateFacetReferences($url,$c,$query,"\$instituicao","count",-1,"Instituições",20);
  generateFacetReferences($url,$c,$query,"\$subject","count",-1,"Principais assuntos",20);
  generateFacetReferences($url,$c,$query,"\$language","count",-1,"Idioma",10);
  generateFacetReferences($url,$c,$query,"\$citation","count",-1,"Principais citações",20);
  generateFacetReferences($url,$c,$query,"\$references_ok","count",-1,"Referências",10);
} else {
    generateFacet($url,$c,$query,"\$tipo","count",-1,"Tipo de publicação",10);
    generateFacet($url,$c,$query,"\$journalci_title","count",-1,"Título da publicação",20);
    generateFacet($url,$c,$query,"\$year","_id",-1,"Ano de publicação",50);
    generateFacet($url,$c,$query,"\$fasciculo","_id",-1,"Fascículos",30);
    generateFacet($url,$c,$query,"\$autor","count",-1,"Autores",20);
    generateFacet($url,$c,$query,"\$instituicao","count",-1,"Instituições",20);
    generateFacet($url,$c,$query,"\$subject","count",-1,"Principais assuntos",20);
    generateFacet($url,$c,$query,"\$language","count",-1,"Idioma",10);
    generateFacet($url,$c,$query,"\$citation","count",-1,"Principais citações",20);
    generateFacet($url,$c,$query,"\$references_ok","count",-1,"Referências",10);
}
  ?>
  </div>
</div>
<div class="ten wide column">
<div class="page-header"><h3>Resultado da busca <small><?php print_r($total);?></small></h3></div>

<?php
/* Pagination - Start */
echo '<br/><div class="ui buttons">';
if($page > 1){
  echo '<form method="post" action="'.$escaped_url.'">';
  echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
  echo '<button type="submit" name="page" class="ui labeled icon button active" value="'.$prev.'"><i class="left chevron icon"></i>Anterior</button>';
  if($page * $limit < $total) {
    echo '<button type="submit" name="page" value="'.$next.'" class="ui right labeled icon button active">Próximo<i class="right chevron icon"></i></button>';
  }
  else {
    echo '<button class="ui right labeled icon button disabled">Próximo<i class="right chevron icon"></i></button>';
  }
  echo '</form>';
} else {
    if($page * $limit < $total) {
      echo '<form method="post" action="'.$escaped_url.'">';
      echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
      echo '<button class="ui labeled icon button disabled"><i class="left chevron icon"></i>Anterior</button>';
      echo '<button type="submit" name="page" value="'.$next.'" class="ui right labeled icon button active">Próximo<i class="right chevron icon"></i></button>';
      echo '</form>';
    }
}
echo '</div><br/>';
/* Pagination - End */
?>



<div class="ui divided items">
<?php foreach ($cursor["result"] as $r): ?>
  <div class="item">
    <div class="image">
      <h4 class="ui center aligned icon header">
        <i class="circular file icon"></i>
        <a href="result.php?journalci_title=<?php echo $r["journalci_title"][0];?>"><?php echo $r["journalci_title"][0];?></a> | <a href="result.php?tipo=<?php echo $r["tipo"][0];?>"><?php echo $r["tipo"][0];?></a>
      </h4>
      <div class="ui horizontal list">
        <div class="item" style="margin-left:0px;">
            <button class="ui circular facebook icon button">
              <i class="facebook icon"></i>
            </button>
          </div>
          <div class="item" style="margin-left:3px;"><span class="yellow ui label"><?php echo $r["altmetrics"][0]["facebook_url_likes"];?></span></div>
          <div class="item" style="margin-left:3px;"><span class="green ui label"><?php echo $r["altmetrics"][0]["facebook_url_shares"];?></span></div>
          <div class="item" style="margin-left:3px;"><span class="red ui label"><?php echo $r["altmetrics"][0]["facebook_url_comments"];?></span></div>
        </div>
      </div>
      <div class="content">
        <?php if (!empty($r["title"][2])): ?>
          <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].''); ?>
          <a class="header" href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][2];?> (<?php echo $r["year"][0]; ?>)</a>
          <div class="meta">
          <p><span class="cinema"><b>Outros títulos:</b> <?php echo $r["title"][1];?></span></p>
          <p><span class="cinema"><b>Outros títulos:</b> <?php echo $r["title"][0];?></span></p>
        </div>
        <?php elseif (empty($r["title"][2]) && !empty($r["title"][1])): ?>
          <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].''); ?>
          <a class="header" href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][1];?> (<?php echo $r["year"][0]; ?>)</a>
          <div class="meta">
          <span class="cinema"><b>Outros títulos:</b> <?php echo $r["title"][0];?></span>
          </div>
        <?php else: ?>
          <a class="header" href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][0];?> (<?php echo $r["year"][0]; ?>)</a>
        <?php endif; ?>
        <!--List authors -->
        <div class="extra">
        <?php if (!empty($r["autor"])): ?>
          <?php foreach ($r["autor"] as $autores): ?>
            <div class="ui label" style="color:black;"><i class="user icon"></i><a href="result.php?autor=<?php echo $autores;?>"><?php echo $autores;?></a></div>
          <?php endforeach;?>
          </ul>
        <?php else: ?>
        <?php foreach ($r["creator"] as $autores): ?>
            <div class="ui label" style="color:black;"><i class="user icon"></i><?php echo $autores;?></div>
        <?php endforeach;?>
        <?php endif; ?>
      </div>
        <div class="description">
          <p></p>
        </div>
        <div class="extra">
          <?php if (!empty($r["subject"])): ?>
            <?php foreach ($r["subject"] as $assunto): ?>
              <div class="ui label" style="color:black;"><i class="globe icon"></i><a href="result.php?subject=<?php echo $assunto;?>"><?php echo $assunto;?></a></div>
            <?php endforeach;?>
          <?php endif; ?>
        <a href="<?php echo $r["url_principal"];?>">
        <div class="ui right floated primary button">
          Acesso online
          <i class="right chevron icon"></i>
        </div></a>
        </div>
  </div>
</div>
<?php endforeach;?>
</div>

<?php
/* Pagination - Start */
echo '<div class="ui buttons">';
if($page > 1){
  echo '<form method="post" action="'.$escaped_url.'">';
  echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
  echo '<button type="submit" name="page" class="ui labeled icon button active" value="'.$prev.'"><i class="left chevron icon"></i>Anterior</button>';
  if($page * $limit < $total) {
    echo '<button type="submit" name="page" value="'.$next.'" class="ui right labeled icon button active">Próximo<i class="right chevron icon"></i></button>';
  }
  else {
    echo '<button class="ui right labeled icon button disabled">Próximo<i class="right chevron icon"></i></button>';
  }
  echo '</form>';
} else {
    if($page * $limit < $total) {
      echo '<form method="post" action="'.$escaped_url.'">';
      echo '<input type="hidden" name="extra_submit_param" value="extra_submit_value">';
      echo '<button class="ui labeled icon button disabled"><i class="left chevron icon"></i>Anterior</button>';
      echo '<button type="submit" name="page" value="'.$next.'" class="ui right labeled icon button active">Próximo<i class="right chevron icon"></i></button>';
      echo '</form>';
    }
}
echo '</div>';
/* Pagination - End */
?>

</div>
</div>
</div>
</div></div></div>

<?php
  include "inc/footer.php";
?>
</div>
<script>
$('.ui.accordion')
  .accordion()
;
</script>
</body>
</html>
