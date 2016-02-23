<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title><?php echo gettext("branch");?> - Resultados de Busca</title>
</head>
<body>
<?php
if (isset($_POST["page"])) {
  unset ($_REQUEST["page"]);
  unset ($_REQUEST["extra_submit_value"]);
  unset ($_REQUEST["extra_submit_param"]);
}

if (isset($_GET["category"])) {
  if ($_GET["category"] === "buscaindice") {
    $_GET["buscaindice"] = str_replace('"','\\"',$_GET["q"]);
    unset ($_GET["category"]);
    unset ($_GET["q"]);
    unset ($_REQUEST["q"]);
    unset ($_REQUEST["category"]);
    $consult="";

  }

  if ($_GET["category"] == "full_text") {
    $_GET["full_text"] = $_GET["q"];
    unset ($_GET["category"]);
    unset ($_GET["q"]);
    unset ($_REQUEST["q"]);
    unset ($_REQUEST["category"]);
    $consult="";
  }

  if ($_GET["category"] == "references") {
    $_GET["references"] = $_GET["q"];
    unset ($_GET["category"]);
    unset ($_GET["q"]);
    unset ($_REQUEST["q"]);
    unset ($_REQUEST["category"]);
    $consult="";
  }

  if ($_GET["category"] == "autor") {
    $_GET["autor"] = $_GET["q"];
    unset ($_GET["category"]);
    unset ($_GET["q"]);
    unset ($_REQUEST["q"]);
    unset ($_REQUEST["category"]);
    $consult="";
  }

  if ($_GET["category"] == "subject") {
    $_GET["subject"] = $_GET["q"];
    unset ($_GET["category"]);
    unset ($_GET["q"]);
    unset ($_REQUEST["q"]);
    unset ($_REQUEST["category"]);
    $consult="";
  }
}

if (!empty($_GET["buscaindice"])) {
  unset ($_REQUEST["buscaindice"]);
}
if (!empty($_GET["full_text"])) {
  unset ($_REQUEST["full_text"]);
}
if (!empty($_GET["references"])) {
  unset ($_REQUEST["references"]);
}
foreach ($_REQUEST as $key => $value) {
  $consult .= '"'.$key.'":"'.$value.'",';
}

switch (true) {
    case (!empty($_GET["full_text"])):
        $query = json_decode('{'.$consult.'"full_text": {"$regex": "'.$_GET["full_text"].'", "$options": "i"}}');
    break;
    case (!empty($_GET["references"])):
        $query = json_decode('{'.$consult.'"references": {"$regex": "'.$_GET["references"].'", "$options": "i"}}');
    break;
    case (!empty($_GET["buscaindice"])):
          $query = json_decode('{'.$consult.'"$text": {"$search":"'.$_GET["buscaindice"].'"}}');
    break;
    case (!empty($_GET["autor"])):
        $query = json_decode('{'.$consult.'"autor": {"$regex": "'.$_GET["autor"].'", "$options": "i"}}');
    break;
    case (!empty($_GET["subject"])):
        $query = json_decode('{'.$consult.'"subject": {"$regex": "'.$_GET["subject"].'", "$options": "i"}}');
    break;
    default:
        foreach ($_GET as $key=>$value) {
          $query[$key] = $value;
    }

}

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

<?php
  include ('inc/navbar.php');
?>
<div class="ui two column stackable grid">
<div class="four wide column">
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
  ?>
  </div>
</div>
<div class="ten wide column">
<div class="page-header"><h3>Resultado da busca <small><?php print_r($total);?></small></h3></div>

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

<div class="ui three stackable cards">
<?php foreach ($cursor as $r): ?>
  <div class="ui card">
  <!-- Journal or Event Title -->
  <div class="content" style="flex-grow:0;">
    <a href="result.php?journalci_title=<?php echo $r["journalci_title"][0];?>"><?php echo $r["journalci_title"][0];?></a> | <a href="result.php?tipo=<?php echo $r["tipo"][0];?>"><?php echo $r["tipo"][0];?></a>
    </div>
    <div class="content" style="flex-grow:0;">
    <div class="header">
    <!-- List titles -->
    <?php if (!empty($r["title"][2])): ?>
      <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].''); ?>
      <a href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][2];?> (<?php echo $r["year"][0]; ?>)</a>
    </div>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][1];?></small><br/>
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][0];?></small>
    </div>
    <?php elseif (empty($r["title"][2]) && !empty($r["title"][1])): ?>
      <?php $id = preg_replace('/[^A-Za-z0-9\-]/', '', ''.$r["_id"].''); ?>
      <a href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][1];?> (<?php echo $r["year"][0]; ?>)</a>
      </div>
      <div class="meta">
      <small class="text-muted"><b>Outros títulos:</b> <?php echo $r["title"][0];?></small>
      </div>
    <?php else: ?>
      <a href="single.php?_id=<?php echo $r["_id"]; ?>"><?php echo $r["title"][0];?> (<?php echo $r["year"][0]; ?>)</a>
      </div>
    <?php endif; ?>
    </div>
    <!--List authors -->
    <div class="content" style="flex-grow:0;">
    <h5 class="card-subtitle text-muted">Autor(es):</h5>
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
    <?php if (!empty($r["references"])): ?>
      <small>Referências cadastradas: <?php echo sizeof($r["references"]);?></small></br>
    <?php endif; ?>
    <?php if (!empty($r["references_ok"])): ?>
      <small>Referências OK: <?php echo $r["references_ok"];?></small></br>
    <?php endif; ?>
    <a href="<?php echo $r["url_principal"];?>" class="btn btn-info">Acesso online</a><br/>
    </div>
    <div class="extra content" style="flex-grow:0;">
      <small><ul class="nav nav-pills list-inline-facebook" role="tablist">
      <li role="presentation" class="active">
        <button class="ui circular facebook icon button">
          <i class="facebook icon"></i>
        </button>
      </li>
      <li role="presentation"><span class="yellow ui label"><?php echo $r["facebook_url_likes"];?></span></li>
      <li role="presentation"><span class="green ui label"><?php echo $r["facebook_url_shares"];?></span></li>
      <li role="presentation"><span class="red ui label"><?php echo $r["facebook_url_comments"];?></span></li>
      </ul></small>
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
