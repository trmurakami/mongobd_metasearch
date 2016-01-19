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



<p>Dados coletados de periódicos de Ciência da Informação disponíveis em OAI</p>




<?php
$mongodb    = new MongoClient();
$database   = $mongodb->journals;
$collection = $database->ci;
$cursor = 	$database->command(array("distinct" => "ci", "key" => "journalci_title"));

echo "<br/><br/><h3>Revistas indexadas</h3></br>";

reset($cursor);
while (list($key, $value) = each($cursor["values"])) {
    echo '<a href="result.php?idx=journalci_title&q='.$value.'">'.$value.'</a>, ';
}

?>

<?php
  include "inc/footer.php";
?>

</div>
</body>
</html>
