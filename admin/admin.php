<?php
  include ('../inc/config_admin.php');
  include ('../inc/header.php');
?>
<title><?php echo gettext("branch");?> - Administração</title>
</head>
<body>
<?php include_once("../inc/analyticstracking.php") ?>
<?php
  include "../inc/navbar.php";
?>

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
