<?php
  include ('../inc/config_admin.php');
  include ('../inc/header.php');
?>

<?php

if (!empty($_POST)) {
  $c->insert(array('source'=> array(
    'journalci_title' => $_POST['journalci_title'],
    'url_principal' => $_POST['url_principal'],
    'url_oai' => $_POST['url_oai'],
    'qualis2014' => $_POST['qualis2014']
  )));
}
$query = json_decode('{"source":{"$exists":"true"}}');
$sources = ($c->find($query));
?>
<title><?php echo gettext("branch");?> - Atualizar harvest</title>
</head>
<body>
  <?php
    include_once('../inc/analytics.php');
    include '../inc/navbar.php';
  ?>
<div class="ui container">
<br/><br/><br/><br/><br/><br/>

<?php
$fonte = ($_GET["fonte"]);
$url_oai = ($_GET["url_oai"]);
$qualis2014 = ($_GET["qualis2014"]);
$catmandu_parameters = 'import OAI --fix \'set_array("journalci_title","'.$fonte.'")\' --fix \'set_array("qualis2014","'.$qualis2014.'")\' --fix ../sh/harvest/fixes.txt --url '.$url_oai.' --metadataPrefix oai_dc to MongoDB --database_name journals --bag ci --verbose';

// Atualiza uma fonte
echo shell_exec("catmandu {$catmandu_parameters}");

echo "Harvest concluido";
?>



<br/><br/><br/><br/><br/><br/>
</div>
<?php
  include "../inc/footer.php";
?>
</body>
</html>
