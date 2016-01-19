<html>
<head>
<title>Dados coletados de periódicos de Ciência da Informação disponíveis em OAI</title>

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
/**

* Description of StringUtil

*

* @author  Rafael Goulart

*/

class StringUtil {

const ACCENT_STRINGS = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïĩðñòóôõöøùúûüýÿ';

const NO_ACCENT_STRINGS = 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy';

/**
* Returns a string with accent to REGEX expression to find any combinations
* in accent insentive way
*
* @param string $text The text.
* @return string The REGEX text.
*/

static public function accentToRegex($text)
{
$from = str_split(utf8_decode(self::ACCENT_STRINGS));
$to   = str_split(strtolower(self::NO_ACCENT_STRINGS));
$text = utf8_decode($text);
$regex = array();

foreach ($to as $key => $value)
{
if (isset($regex[$value]))
{
$regex[$value] .= $from[$key];
} else {
$regex[$value] = $value;
}
}

foreach ($regex as $rg_key => $rg)
{
$text = preg_replace("/[$rg]/", "_{$rg_key}_", $text);
}

foreach ($regex as $rg_key => $rg)
{
$text = preg_replace("/_{$rg_key}_/", "[$rg]", $text);
}
return utf8_encode($text);
}
}
?>

<?php
  include "inc/header.php";
?>

<?php
  include "inc/navbar.php";
?>

  <div class="row">
    <div class="col-md-4"><h2>Refine os resultados</h2></div>
    <div class="col-md-8">

<h2>Resultado da busca</h2>
<?php
/*error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);*/
$mongodb    = new MongoClient();
$database   = $mongodb->journals;
$collection = $database->ci;
$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 12;
$skip  = ($page - 1) * $limit;
$next  = ($page + 1);
$prev  = ($page - 1);
$sort  = array('createdAt' => -1);

$search_string = StringUtil::accentToRegex(''.$_GET['q'].'');
$query =  array(''.$_GET['idx'].'' =>new MongoRegex("/.*{$search_string}.*/i"));

$cursor = $collection->find($query)->skip($skip)->limit($limit)->sort($sort);
$total= $cursor->count();

/* Pegar a URL atual */
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );


print_r("Quantidade de resultados: $total<br/><br/>");

if($page > 1){
    echo '<a href="' . $escaped_url . '&page=' . $prev . '">Anterior</a>';
    if($page * $limit < $total) {
        echo ' <a href="' . $escaped_url . '&page=' . $next . '">Próximo</a>';
    }
} else {
    if($page * $limit < $total) {
        echo ' <a href="' . $escaped_url . '&page=' . $next . '">Próximo</a>';
    }
}

echo "<br/><br/>";

foreach ($cursor as $r) {
  foreach ($r["title"] as $title){
    echo 'Título: '.$title."<br />";
  }
  foreach ($r["creator"] as $autores){
    echo 'Autor: '.$autores."<br />";
  }
  foreach ($r["identifier"] as $identifier){
    echo 'URL: <a href="'.$identifier.'">'.$identifier."</a><br />";
  }
  echo 'Título do periódico: '.$r["journalci_title"]."<br />";
  echo '_id: '.$r["_id"]."<br />";
  echo 'Status: '.$r["_status"]."<br />";
  echo 'Qualis2014: '.$r["Qualis2014"]."<br />";
  echo 'Data de atualização dos dados obtidos no facebook: '.$r["facebook_atualizacao"]."<br />";
  echo 'Comentários no facebook: '.$r["facebook_url_comments"]."<br />";
  echo 'Likes no facebook: '.$r["facebook_url_likes"]."<br />";
  echo 'Compartilhamentos no facebook: '.$r["facebook_url_shares"]."<br />";
  echo 'Total de interações no facebook: '.$r["facebook_url_total"]."<br />";

/*  foreach ($r["relation"] as $relation){
    echo 'URLs relacionadas: '.$relation."<br />";
  }
  foreach ($r["description"] as $resumo){
    echo 'Resumo: '.$resumo."<br />";
  }
  foreach ($r["language"] as $idioma){
    echo 'Idioma: '.$idioma."<br />";
  }
  foreach ($r["publisher"] as $publisher){
    echo 'Editora: '.$publisher."<br />";
  }
  foreach ($r["source"] as $source){
    echo 'Fonte: '.$source."<br />";
  }
  foreach ($r["subject"] as $subject){
    echo 'Assuntos: '.$subject."<br />";
  }
  foreach ($r["date"] as $data_de_publicacao){
    echo 'Data de publicação: '.$data_de_publicacao."<br />";
  }
  foreach ($r["format"] as $formato){
    echo 'Formato: '.$formato."<br />";
  }
  foreach ($r["rights"] as $direitos_autorais){
    echo 'Direitos Autorais: '.$direitos_autorais."<br />";
  }
  foreach ($r["type"] as $tipo){
    echo 'Tipo: '.$tipo."<br />";
  }
  foreach ($r["_setSpec"] as $set_oai){
    echo 'Set OAI: '.$set_oai."<br />";
  }*/
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
