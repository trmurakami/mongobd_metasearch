<?php
  include ('../inc/config.php');
  include ('../inc/header.php');
?>

<?php

$query_remove = json_decode('{"_status":"deleted"}');
$c->remove($query_remove);

?>
<title><?php echo gettext("branch");?> - Remover excluídos</title>
</head>
<body>
  <?php
    include_once('../inc/analytics.php');
    include '../inc/navbar.php';
  ?>
<div class="ui container">
<br/><br/><br/><br/><br/><br/>

Registros removidos

<br/><br/><br/><br/><br/><br/>
</div>
<?php
  include "../inc/footer.php";
?>
</body>
</html>
