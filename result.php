<html>
<head>
<title>MetaBuscaCI - Resultados de Busca</title>

<!-- Jquery -->
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">

  <?php
    include ('inc/config.php');
    include ('inc/header.php');
    include ('inc/navbar.php');
  ?>

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

?>
  <div class="row">
    <div class="col-md-4"><h2>Sumário dos registros</h2>
    <p>

<?php

        $aggregate_query_language=array(
          array(
            '$match'=>$query
          ),
          array(
            '$unwind'=>'$language'
          ),
          array(
            '$group' => array(
              "_id"=>'$language',
              "count"=>array('$sum'=>1)
              )
          ),
          array(
            '$sort' => array("count"=>-1)
          )
        );

        $aggregate_journal_title=array(
          array(
            '$match'=>$query
          ),
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
            '$sort' => array("count"=>-1)
          )
        );

        $aggregate_query_subject=array(
          array(
            '$match'=>$query
          ),
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

        $aggregate_query_year=array(
          array(
            '$match'=>$query
          ),
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
            '$sort' => array("count"=>-1)
          )
        );

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

        $aggregate_autor=array(
          array(
            '$match'=>$query
          ),
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

        $aggregate_instituicao=array(
          array(
            '$match'=>$query
          ),
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

        $facet_language = $c->aggregate($aggregate_query_language);
        $facet_journal_title = $c->aggregate($aggregate_journal_title);
        $facet_subject = $c->aggregate($aggregate_query_subject);
        $facet_year = $c->aggregate($aggregate_query_year);
        $facet_autor = $c->aggregate($aggregate_autor);
        $facet_instituicao = $c->aggregate($aggregate_instituicao);
        $facet_facebook = $c->aggregate($aggregate_facebook);


        echo "<h3>Periódico</h3></br><ul class=\"list-group\">";
        foreach ($facet_journal_title["result"] as $jt) {
          echo '<li class="list-group-item"><span class="badge">'.$jt["count"].'</span><a href="'.$url.'&journalci_title='.$jt["_id"].'">'.$jt["_id"].'</a></li>';
        };
        echo "</ul>";
        echo "<h3>Interações no Facebook</h3></br><ul class=\"list-group\">";
        foreach ($facet_facebook["result"] as $fb) {
          echo '<li class="list-group-item"><span class="badge">'.$fb["likes"].'</span>Curtidas</li>';
          echo '<li class="list-group-item"><span class="badge">'.$fb["shares"].'</span>Compartilhamentos</li>';
          echo '<li class="list-group-item"><span class="badge">'.$fb["comments"].'</span>Comentários</li>';
          echo '<li class="list-group-item"><span class="badge">'.$fb["total"].'</span>Total</li>';
        };
        echo "</ul>";
        echo "<h3>Autores (20)</h3></br><ul class=\"list-group\">";
        $i = 0;
        foreach ($facet_autor["result"] as $at) {
          echo '<li class="list-group-item"><span class="badge">'.$at["count"].'</span><a href="'.$url.'&autor='.$at["_id"].'">'.$at["_id"].'</a></li>';
          if(++$i > 20) break;
        };
        echo "</ul>";
        echo "<h3>Instituições (20)</h3></br><ul class=\"list-group\">";
        $ia = 0;
        foreach ($facet_instituicao["result"] as $it) {
          echo '<li class="list-group-item"><span class="badge">'.$it["count"].'</span><a href="'.$url.'&instituicao='.$it["_id"].'">'.$it["_id"].'</a></li>';
          if(++$ia > 20) break;
        };
        echo "</ul>";
        echo "<h3>Ano de publicação</h3></br><ul class=\"list-group\">";
        foreach ($facet_year["result"] as $yr) {
            echo '<li class="list-group-item"><span class="badge">'.$yr["count"].'</span><a href="'.$url.'&year='.$yr["_id"].'">'.$yr["_id"].'</a></li>';
        };
        echo "</ul>";
        echo "<h3>Principais assuntos</h3></br><ul class=\"list-group\">";
        $ib = 0;
        foreach ($facet_subject["result"] as $sj) {
          echo '<li class="list-group-item"><span class="badge">'.$sj["count"].'</span><a href="'.$url.'&subject='.$sj["_id"].'">'.$sj["_id"].'</a></li>';
          if(++$ib > 20) break;
        };
        echo "</ul>";
        echo "<h3>Idioma</h3></br><ul class=\"list-group\">";
        foreach ($facet_language["result"] as $fl) {
            echo '<li class="list-group-item"><span class="badge">'.$fl["count"].'</span><a href="'.$url.'&language='.$fl["_id"].'">'.$fl["_id"].'</a></li>';
        };
        echo "</ul>";
      ?>
    </p>
    </div>
    <div class="col-md-8">

<?php
$page  = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$limit = 12;
$skip  = ($page - 1) * $limit;
$next  = ($page + 1);
$prev  = ($page - 1);
$sort  = array('createdAt' => -1);

$cursor = $c->find($query)->skip($skip)->limit($limit)->sort($sort);
$total= $cursor->count();

print_r("<div class=\"page-header\"><h3>Resultado da busca <small>($total)</small></h3></div>");

if($page > 1){
    echo '<div class="btn-group btn-group-justified" role="group" aria-label="pagination">';
            echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$prev.'" class="btn btn-default">Anterior</button></form></div>';
    if($page * $limit < $total) {
                echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$next.'" class="btn btn-default">Próximo</button></form></div>';
    }
    echo '</div>';
} else {
    if($page * $limit < $total) {
        echo '<div class="btn-group btn-group-justified" role="group" aria-label="pagination">';
        echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$next.'" class="btn btn-default">Próximo</button></form></div>';
        echo '</div>';
    }
}

echo "<br/>";

foreach ($cursor as $r) {

  echo '<div class="media"><div class="media-left"><a href="single.php?idx=_id&q='.$r["_id"].'"><button type="button" class="list-group-item"><center><span class="glyphicon glyphicon-file" aria-hidden="true"></span></center><br/>'.$r["tipo"][0].'</button></a></div><div class="media-body">';
  echo '<div class="panel panel-info">';
  if (!empty($r["title"][2])) {
     echo '<div class="panel-heading"><h4 class="media-heading"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][2].' ('.$r["year"][0].')</a></h4>';
     echo '<small>Outros títulos:'.$r["title"][1].'</small><br/>';
     echo '<small>Outros títulos:'.$r["title"][0].'</small><br/></div>';
  }
  elseif (empty($r["title"][2]) && !empty($r["title"][1])) {
    echo '<div class="panel-heading"><h4 class="media-heading"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][1].' ('.$r["year"][0].')</a></h4>';
    echo '<small>Outros títulos:'.$r["title"][0].'</small><br/></div>';
  }
  else {
    echo '<div class="panel-heading"><h4 class="media-heading"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][0].' ('.$r["year"][0].')</a></h4></div>';
  }
  echo '</div><div class="panel-body">';
  echo '<span class="badge">'.$r["journalci_title"][0].'</span><br/>';
  echo "<br/>";
  foreach ($r["autor"] as $autores){
    echo '<b>Autor</b>:'.$autores.'<br/>';
  }

  echo '<b>Acesso online</b>: <a href="'.$r["url_principal"].'">'.$r["url_principal"].'</a><br/>';

  if (!empty($r["doi"])) {
    echo '<b>DOI</b>: <a href="http://dx.doi.org/'.$r["doi"].'">'.$r["doi"].'</a><br/>';
  }

  echo '<small><br/><ul class="nav nav-pills" role="tablist">';
  echo '<li role="presentation" class="active"><a href="#">Facebook</a></li>';
  echo '<li role="presentation"><a href="#">Comentários <span class="badge">'.$r["facebook_url_comments"].'</span></a></li>';
  echo '<li role="presentation"><a href="#">Curtidas <span class="badge">'.$r["facebook_url_likes"].'</span></a></li>';
  echo '<li role="presentation"><a href="#">Compartilhamentos <span class="badge">'.$r["facebook_url_shares"].'</span></a></li>';
  echo '</ul></small>';
  echo '</div>';
  echo '</div>';
}

if($page > 1){
    echo '<div class="btn-group btn-group-justified" role="group" aria-label="pagination">';
            echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$prev.'" class="btn btn-default">Anterior</button></form></div>';
    if($page * $limit < $total) {
                echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$next.'" class="btn btn-default">Próximo</button></form></div>';
    }
    echo '</div>';
} else {
    if($page * $limit < $total) {
        echo '<div class="btn-group btn-group-justified" role="group" aria-label="pagination">';
        echo '<div class="btn-group" role="group"><form method="post" action="'.$escaped_url.'"><input type="hidden" name="extra_submit_param" value="extra_submit_value"><button type="submit" name="page" value="'.$next.'" class="btn btn-default">Próximo</button></form></div>';
        echo '</div>';
    }
}
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
