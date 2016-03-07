<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Detalhes do registro</title>
</head>
<body>
<?php
  include_once('inc/analytics.php');
  include 'inc/navbar.php';
?>
<div class="ui container">
<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
if (!empty($_GET['_id'])) {
    $_id = ''.$_GET['_id'].'';
} elseif (!empty($_POST['_id'])) {
    $_id = ''.$_POST['_id'].'';
} else {
}

/* Update */
if (!empty($_POST)) {
    $query = array('_id' => ''.$_POST['_id'].'');
    if (empty($_POST['references']) && empty($_POST['citation'])) {
        $c->update(array('_id' => $_id),
             array('$set' => array(
               'references_ok' => $_POST['references_ok'],
             )));
    } elseif (empty($_POST['citation'])) {
        $c->update(array('_id' => $_id),
             array('$set' => array(
               'references_ok' => $_POST['references_ok'],
               'references' => $_POST['references'],
             )));
    } else {
        $c->update(array('_id' => $_id),
           array('$set' => array(
             'references_ok' => $_POST['references_ok'],
             'references' => $_POST['references'],
             'citation' => $_POST['citation'],
           )));
    }
    echo '
<div class="alert alert-success" role="alert">
  <strong>Sucesso!</strong> Registro alterado com sucesso.
  <a href="single.php?_id='.$_id.'">Ver registro</a>
</div>
';
} else {
    $query = array('_id' => ''.$_GET['_id'].'');
}
$cursor = $c->findOne($query);
?>


<a href="single.php?_id=<?php echo "$_id"; ?>">Voltar ao registro</a>

<form action="edit.php" method="POST" class="ui form">
  <div class="inline fields">
    <label for="disabledTextInput" class="col-sm-2 form-control-label">Sysno ou ID</label>
    <div class="field">
    <div class="ui radio checkbox">
      <input type="radio" name="_id" id="radio_id" tabindex="0" class="hidden" value="<?php echo "$_id";  ?>" checked>
      <label><?php echo "$_id";  ?></label>
     </div>
   </div>
 </div>


<div class="inline fields">
    <label for="references_ok">Referências completas?</label>
<?php
if (!empty($cursor['references'])) {
} else {
    $cursor['references_ok'] = 'false';
}

if ($cursor['references_ok'] == 'true') {
    echo '
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="references_ok" id="gridRadios1" value="true" tabindex="0" class="hidden" checked>
        <label>Sim</label>
    </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
      <input type="radio" name="references_ok" id="gridRadios2" value="false" tabindex="0" class="hidden">
      <label>Não</label>
      </div>
    </div>
';
} else {
    echo '
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="references_ok" id="gridRadios1" value="true" tabindex="0" class="hidden">
        <label>Sim</label>
    </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
      <input type="radio" name="references_ok" id="gridRadios2" value="false" tabindex="0" class="hidden" checked>
      <label>Não</label>
      </div>
    </div>
';
}
?>
  </div>


  <div class="ui form">
    <div class="field">
      <label for="references">Referências</label>
      <div class="input_fields_wrap form-group">
<?php
if (!empty($cursor['references'])) {
    foreach ($cursor['references'] as $rf) {
        echo '<div><textarea class="form-control" id="exampleTextarea" rows="6" name="references[]">'.$rf.'</textarea><a href="#" class="remove_field">Remover</a></div>';
    }
} else {
    echo '<div><textarea class="form-control" id="exampleTextarea" rows="6" name="references[]"></textarea><a href="#" class="remove_field">Remover</a></div>';
}
?>
    </div>
  </div>
</div>
<button class="add_field_button">+ referências</button>
<div class="form-group row list-inline">
  <label for="references" class="col-sm-2 form-control-label">ID das citações</label>
  <div class="col-sm-10">
  <div class="input_fields_citation form-group">
    <?php
    if (!empty($cursor['citation'])) {
        foreach ($cursor['citation'] as $ct) {
            echo '<div><input type="text" class="form-control" id="exampleTextarea" name="citation[]" placeholder="ID da citação" value="'.$ct.'"><a href="#" class="remove_field">Remover</a></div>';
        }
    } else {
        echo '<div><input type="text" class="form-control" id="exampleTextarea" name="citation[]" placeholder="ID da citação"><a href="#" class="remove_field">Remover</a></div>';
    }
    ?>
  </div>
</div>
</div>
<button class="add_field_citation">+ citações</button>

<div class="form-group row list-inline">
  <label for="references" class="col-sm-2 form-control-label"></label>
  <div class="col-sm-10">
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><textarea class="form-control" id="exampleTextarea" rows="6" name="references[]"></textarea><a href="#" class="remove_field">Remover</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_citation"); //Fields wrapper
    var add_button      = $(".add_field_citation"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" class="form-control" id="exampleTextarea" name="citation[]" placeholder="ID da citação"><a href="#" class="remove_field">Remover</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
</div>
<?php
  include 'inc/footer.php';
?>
<script>
$('.ui.checkbox')
  .checkbox()
;
</script>

</body>
</html>
