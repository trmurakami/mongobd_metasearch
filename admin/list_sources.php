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
<title><?php echo gettext("branch");?> - Listar fontes</title>
</head>
<body>
  <?php
    include_once('../inc/analytics.php');
    include '../inc/navbar.php';
  ?>
<div class="ui container">
<br/><br/><br/>
<h3>Lista de fontes</h3>
<table class="ui celled table">
    <thead>
      <tr>
        <th>Título</th>
        <th>URL principal</th>
        <th>URL do OAI-PMH</th>
        <th>Qualis 2014</th>
        <th>Harvest</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($sources as $src):?>
  <tr>
    <td scope="row"><?php echo $src["source"]["journalci_title"];?></td>
    <td><?php echo $src["source"]["url_principal"]; ?></td>
    <td><?php echo $src["source"]["url_oai"]; ?></td>
    <td><?php echo $src["source"]["qualis2014"]; ?></td>
    <td><a href="update_harvest.php?fonte=<?php echo $src["source"]["journalci_title"];?>&url_oai=<?php echo $src["source"]["url_oai"]; ?>&qualis2014=<?php echo $src["source"]["qualis2014"]; ?>">Atualizar harvest</a></td>
  </tr>
<?php endforeach;?>
    </tbody>
</table>
</div>
<br/><br/><br/><br/>

<?php
  include "../inc/footer.php";
?>
</body>
</html>
