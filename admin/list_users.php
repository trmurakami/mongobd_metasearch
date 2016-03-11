<?php
  include ('../inc/config_admin.php');
  include ('../inc/header.php');
?>

<?php

if (!empty($_POST)) {
  $c->insert(array('user'=> array(
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'nome' => $_POST['nome'],
    'sobrenome' => $_POST['sobrenome'],
    'role' => $_POST['role']
  )));
}
$query = json_decode('{"user":{"$exists":"true"}}');
$users = ($c->find($query));
?>
<title><?php echo gettext("branch");?> - Administração</title>
</head>
<body>
  <?php
    include_once('../inc/analytics.php');
    include '../inc/navbar.php';
  ?>
<div class="ui container">
<br/><br/><br/>
<h3>Lista de usuários</h3>
<table class="ui celled table">
    <thead>
      <tr>
        <th>e-mail</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Papel</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($users as $usr):?>
  <tr>
    <td scope="row"><?php echo $usr["user"]["username"];?></td>
    <td><?php echo $usr["user"]["nome"]; ?></td>
    <td><?php echo $usr["user"]["sobrenome"]; ?></td>
    <td><?php echo $usr["user"]["role"]; ?></td>
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
