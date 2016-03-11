<?php
  include '../inc/config_admin.php';
  include '../inc/header.php';
?>

<title><?php echo gettext('branch');?> - Adicionar usuário</title>
</head>
<body>
<?php
  include_once('../inc/analytics.php');
  include '../inc/navbar.php';
?>
<br /><br /><br /><br /><br /><br /><br /><br />
<div class="ui grid container">
  <div class="sixteen wide column">
<form class="ui form" action="list_users.php" method="POST">
    <div class="ui equal width form">
      <div class="fields">
        <div class="field">
          <label>E-mail</label>
          <input type="email" placeholder="E-mail" name="username">
        </div>
        <div class="field">
          <label>Senha</label>
          <input type="password" name="password">
        </div>
      </div>
      <div class="fields">
        <div class="field">
          <label>Nome</label>
          <input type="text" placeholder="Nome" name="nome">
        </div>
        <div class="field">
          <label>Sobrenome</label>
          <input type="text" placeholder="Sobrenome" name="sobrenome">
        </div>
      </div>
      <div class="inline fields">
    <label for="fruit">Tipo de usuário:</label>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="role" checked="" tabindex="0" class="hidden" value="admin">
        <label>Admin</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="role" tabindex="0" class="hidden" value="reader">
        <label>Leitor</label>
      </div>
    </div>
  </div>
      <button class="ui submit button" type="submit">Enviar</button>
    </div>
</form>


    </div>

 </div>
</div>
<br /><br /><br /><br /><br /><br /><br />
<?php
  include '../inc/footer.php';
?>
<script>
$('.ui.radio.checkbox')
  .checkbox()
;
</script>
</body>
</html>
