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
<br /><br /><br /><br /><br /><br />
<div class="ui grid container">
  <div class="sixteen wide column">
<form class="ui form" action="list_sources.php" method="POST">
    <div class="ui form">
        <div class="field">
          <label>Título</label>
          <input type="text" name="journalci_title">
        </div>
        <div class="field">
          <label>URL</label>
          <input type="text" name="url_principal">
        </div>
        <div class="field">
          <label>URL do OAI-PMH</label>
          <input type="text" name="url_oai">
        </div>
        <div class="field">
          <label>Qualis 2014</label>
          <input type="text" name="qualis2014">
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
