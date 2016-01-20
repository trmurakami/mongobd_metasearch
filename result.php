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

        $aggregate_query_language_total=array(
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

        if ($idx_query == ''){
        $facet_language = $c->aggregate($aggregate_query_language_total);
        $facet_journal_title = $c->aggregate($aggregate_journal_title_total);
        }
        else{
        $facet_language = $c->aggregate($aggregate_query_language);
        $facet_journal_title = $c->aggregate($aggregate_journal_title);
        }


        echo "<h3>Periódico:</h3>";
        foreach ($facet_journal_title["result"] as $jt) {
          echo '<b>'.$jt["_id"].'</b>:'.$jt["count"].'<br/>';
        };

        echo "<h3>Idioma:</h3>";
        foreach ($facet_language["result"] as $fl) {
          echo '<b>'.$fl["_id"].'</b>:'.$fl["count"].'<br/>';
        };

      ?>
    </p>
    </div>
    <div class="col-md-8">

<h2>Resultado da busca</h2>

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


print_r("Quantidade de resultados: $total<br/><br/>");


if($page > 1){
    echo '<a href="' . $url_sem_page . '&page=' . $prev . '">Anterior</a>';
    if($page * $limit < $total) {
        echo ' - <a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a>';
    }
} else {
    if($page * $limit < $total) {
        echo ' <a href="' . $url_sem_page . '&page=' . $next . '">Próximo</a>';
    }
}

echo "<br/><br/>";

foreach ($cursor as $r) {
  foreach ($r["title"] as $title){
    echo '<b>Título</b>: '.$title."<br />";
  }
  foreach ($r["creator"] as $autores){
    echo '<b>Autor</b>:'.$autores[0].',<b>Instituição</b>:'.$autores[1].'<br/>';
}
  foreach ($r["identifier"] as $identifier){
    echo '<b>URL</b>: <a href="'.$identifier.'">'.$identifier."</a><br />";
  }
  foreach ($r["journalci_title"] as $journalci_title){
  echo '<b>Periódico</b>: '.$journalci_title."<br />";
  }
  echo '<b>_id</b>: <a href="single.php?idx=_id&q='.$r["_id"].'">'.$r["_id"]."</a><br />";
  echo '<b>Facebook: Comentários</b>: '.$r["facebook_url_comments"]."<br />";
  echo '<b>Facebook: Curtidas</b>: '.$r["facebook_url_likes"]."<br />";
  echo '<b>Facebook: Compartilhamentos</b>: '.$r["facebook_url_shares"]."<br />";
  echo '<b>Facebook: Total de interações</b>: '.$r["facebook_url_total"]."<br />";
  echo '<b>Data de atualização dos dados obtidos no facebook</b>: '.$r["facebook_atualizacao"]."<br />";
  echo "</br></br>";
}

if($page > 1){
    echo '<a href="?page=' . $prev . '">Previous</a>';
    if($page * $limit < $total) {
        echo ' <a href="?page=' . $next . '">Next</a>';
    }
} else {
    if($page * $limit < $total) {
        echo ' <a href="?page=' . $next . '">Next</a>';
    }
}



$mongodb->close();
?>

</div>
</div>

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
