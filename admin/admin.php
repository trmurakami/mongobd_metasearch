<?php
  include ('../inc/config_admin.php');
  include ('../inc/header.php');
?>
<?php
if (!empty($_POST)) {
$username = $_POST["username"];
$password = $_POST["password"];
$user = $c->findOne(array("username" => $username, "password" => $password));
$user->limit(1);
if ($user->count(true) > 0) {
    return $user;
return null;
}
}
?>
<title><?php echo gettext("branch");?> - Administração</title>
</head>
<body>
  <?php
    include_once('../inc/analytics.php');
    include '../inc/navbar.php';
  ?>
<?php print_r($user); ?>

<div class="ui container">
<p><a href="list_users.php">Listar usuários</a></p>
<p><a href="add_user.php">Adicionar usuário</a></p>
<p><a href="list_sources.php">Listar fontes</a></p>
<p><a href="add_source.php">Adicionar fonte</a></p>
<p><a href="remove_deleted.php">Remover registros marcados com "deleted" no _status</a></p>

</div>
<?php
  include "../inc/footer.php";
?>
</body>
</html>
