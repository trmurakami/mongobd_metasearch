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
  include "inc/header.php";
?>

<?php
  include "inc/navbar.php";
?>


<h4>Metabuscador em periódicos de Ciência da Informação brasileiros disponíveis em OAI-PMH</p></h4>

<?php
$m    = new MongoClient();
$d   = $m->journals;
$c = $d->ci;

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
    '$sort' => array("_id"=>1)
  )
);
$facet_journal_title = $c->aggregate($aggregate_journal_title_total);

echo "<h3>Periódicos indexados</h3></br><ul class=\"list-group\">";
foreach ($facet_journal_title["result"] as $jt) {
  echo '<li class="list-group-item"><span class="badge">'.$jt["count"].'</span><a href="result.php?idx=journalci_title&q='.$jt["_id"].'">'.$jt["_id"].'</a></li>';
};
echo "</ul>";

?>

<?php
  include "inc/footer.php";
?>

</div>
</body>
</html>
