<html>
<head>
<title>Resultados de Busca</title>

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
  include "inc/header.php";
?>

<?php
  include "inc/navbar.php";
?>

<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
$m    = new MongoClient();
$d   = $m->journals;
$c = $d->ci;

/* recupera as variáveis do GET */
$idx_query = $_GET['idx'];
$search_string = $_GET['q'];

?>
  <div class="row">
    <div class="col-md-4"><h2>Sumário dos registros</h2>
    <p>
    <?php

        $aggregate_query_language=array(
          array(
            '$match'=>array(''.$_GET['idx'].''=>new MongoRegex("/.*{$search_string}.*/i"))
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
            '$match'=>array(''.$_GET['idx'].''=>new MongoRegex("/.*{$search_string}.*/i"))
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
            '$match'=>array(''.$_GET['idx'].''=>new MongoRegex("/.*{$search_string}.*/i"))
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

        $aggregate_query_language_total=array(
          array(
            '$match'=>array ('$text' => array('$search'=>''.$_GET['q'].''))
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


        $aggregate_journal_title_total=array(
          array(
            '$match'=>array ('$text' => array('$search'=>''.$_GET['q'].''))
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

        $aggregate_query_subject_total=array(
          array(
            '$match'=>array ('$text' => array('$search'=>''.$_GET['q'].''))
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

        if ($idx_query == ''){
        $facet_language = $c->aggregate($aggregate_query_language_total);
        $facet_journal_title = $c->aggregate($aggregate_journal_title_total);
        $facet_subject = $c->aggregate($aggregate_query_subject_total);
        }
        else{
        $facet_language = $c->aggregate($aggregate_query_language);
        $facet_journal_title = $c->aggregate($aggregate_journal_title);
        $facet_subject = $c->aggregate($aggregate_query_subject);
        }

        echo "<h3>Periódico:</h3></br><ul class=\"list-group\">";
        foreach ($facet_journal_title["result"] as $jt) {
          echo '<li class="list-group-item"><span class="badge">'.$jt["count"].'</span><a href="#">'.$jt["_id"].'</a></li>';
        };
        echo "</ul>";
        echo "<h3>Idioma:</h3></br><ul class=\"list-group\">";
        foreach ($facet_language["result"] as $fl) {
            echo '<li class="list-group-item"><span class="badge">'.$fl["count"].'</span><a href="#">'.$fl["_id"].'</a></li>';
        };
        echo "</ul>";
        echo "<h3>Assunto:</h3></br><ul class=\"list-group\">";
        foreach ($facet_subject["result"] as $sj) {
            echo '<li class="list-group-item"><span class="badge">'.$sj["count"].'</span><a href="#">'.$sj["_id"].'</a></li>';
        };
        echo "</ul>";
      ?>
    </p>
    </div>
    <div class="col-md-8">

<?php
$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 12;
$skip  = ($page - 1) * $limit;
$next  = ($page + 1);
$prev  = ($page - 1);
$sort  = array('createdAt' => -1);

$text_query = array ('$text' => array('$search'=>''.$_GET['q'].''));
$query =  array(''.$_GET['idx'].'' =>new MongoRegex("/.*{$search_string}.*/i"));

if ($idx_query == ''){
 $cursor = $c->find($text_query)->skip($skip)->limit($limit)->sort($sort);
}
else{
$cursor = $c->find($query)->skip($skip)->limit($limit)->sort($sort);
}

$total= $cursor->count();

/* Pegar a URL atual */
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$pattern = '/page=\d/i';
$url_sem_page = preg_replace($pattern,'',$escaped_url);

print_r("<div class=\"page-header\"><h3>Resultado da busca <small>($total)</small></h3></div>");


if($page > 1){
    echo '<nav><ul class="pager">';
    echo '<li><a href="' . $url_sem_page . '&page=' . $prev . '">Anterior</a></li>';
    if($page * $limit < $total) {
        echo '<li><a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a></li></ul></nav>';
    }
} else {
    if($page * $limit < $total) {
        echo '<nav><ul class="pager">';
        echo '<li><a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a></li></ul></nav>';
    }
}

echo "<br/>";

foreach ($cursor as $r) {
  echo "<div class=\"media\"><div class=\"media-left\"><a href=\"#\"><img class=\"media-object\" data-src=\"holder.js/64x64\" alt=\"64x64\" src=\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTI2MDRjNzVhYSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MjYwNGM3NWFhIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==\" data-holder-rendered=\"true\" style=\"width: 64px; height: 64px;\"></a></div><div class=\"media-body\">";
  echo '<h4 class="media-heading"><a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["title"][0].'</a></h4>';
  echo '<span class="badge">'.$r["journalci_title"][0].'</span><br/>';
  if (!empty($r["title"][1])) {
  echo '<small>Outros títulos:'.$r["title"][1].'</small><br/>';
  }
  if (!empty($r["title"][2])) {
  echo '<small>Outros títulos:'.$r["title"][2].'</small><br/>';
  }

  foreach ($r["creator"] as $autores){
    if (!empty($autores[1])) {
    echo '<b>Autor</b>:'.$autores[0].',<b>Instituição</b>:'.$autores[1].'<br/>';
  }else {
    echo '<b>Autor</b>:'.$autores[0].'<br/>';
  }
}


  echo '<b>Acesso online</b>: <a href="#">'.$r["url_principal"].'</a><br/>';

  if (!empty($r["doi"])) {
    echo '<b>DOI</b>: <a href="http://dx.doi.org/'.$r["doi"].'">'.$r["doi"].'</a><br/>';
  }

  echo '<ul class="nav nav-pills" role="tablist">';
  echo '<li role="presentation" class="active"><a href="#">Facebook</a></li>';
  echo '<li role="presentation"><a href="#">Comentários <span class="badge">'.$r["facebook_url_comments"].'</span></a></li>';
  echo '<li role="presentation"><a href="#">Curtidas <span class="badge">'.$r["facebook_url_likes"].'</span></a></li>';
  echo '<li role="presentation"><a href="#">Compartilhamentos <span class="badge">'.$r["facebook_url_shares"].'</span></a></li>';
  echo '</ul>';
  echo '</div>';
}

if($page > 1){
    echo '<nav><ul class="pager">';
    echo '<li><a href="' . $url_sem_page . '&page=' . $prev . '">Anterior</a></li>';
    if($page * $limit < $total) {
        echo '<li><a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a></li></ul></nav>';
    }
} else {
    if($page * $limit < $total) {
        echo '<nav><ul class="pager">';
        echo '<li><a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a></li></ul></nav>';
    }
}
?>

</div>
</div>
</div>

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
