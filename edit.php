<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title>MetaBuscaCI - Detalhes do registro</title>
</head>
<body>
<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
if (!empty($_GET["_id"])) {
$_id = ''.$_GET['_id'].'';
}
elseif (!empty($_POST["_id"])) {
$_id = ''.$_POST['_id'].'';
}
else{
}

/* Update */
if (!empty($_POST)) {
$query =  array('_id' => ''.$_POST['_id'].'');

<<<<<<< HEAD
$c->update(array('_id'=>$_id),
           array('$set'=>array(
             'references_ok'=>$_POST["references_ok"],
             'references'=>$_POST["references"],
             'citation'=>$_POST["citation"]
           )));
=======

$new_citation = array(
  "references_id" => $_POST["references_id"],
  "references_citation" => $_POST["references_citation"]
);
$c->update(
  array("_id" =>$_id),
  array('$push' => array("references" => $new_citation)),
  array('references_ok'=>$_POST["references_ok"])
);


>>>>>>> 44f729644a42424a786c0e06370fd28c066ee2e0

echo '
<div class="alert alert-success" role="alert">
  <strong>Sucesso!</strong> Registro alterado com sucesso.
  <a href="single.php?_id='.$_id.'">Ver registro</a>
</div>
';
}
else{
$query =  array('_id' => ''.$_GET['_id'].'');
}
$cursor = $c->findOne($query);
?>

<<<<<<< HEAD
<div class="container-fluid">
<?php
  include "inc/navbar.php";
?>

<form action="edit.php" method="POST">
  <div class="form-group row">
    <label for="disabledTextInput" class="col-sm-2 form-control-label">Sysno ou ID</label>
    <div class="col-sm-10">
    <div class="radio">
       <label>
         <input type="radio" name="_id" id="radio_id" value="<?php echo "$_id";  ?>" checked>
         <?php echo "$_id";  ?>
       </label>
     </div>
   </div>
=======
<div class="row">
  <div class="col-md-12">

<h3>Detalhes do registro</h3>

<a href="single.php?_id=<?php echo "$_id"; ?>">Ver registro</a>

<form action="edit.php" method="POST">
  <div class="form-group row">
  <div class="checkbox">
    <label>
      <?php
      if (!empty($cursor["references_ok"])) {
        if ($cursor["references_ok"] == "true") {
        echo '<input type="checkbox" name="references_ok" value="true" checked>Referência completa';
        } else
        {
        echo '<input type="checkbox" name="references_ok" value="true">Referência completa';
        }
      }
      ?>
    </label>
  </div>
>>>>>>> 44f729644a42424a786c0e06370fd28c066ee2e0
</div>
  <div class="form-group row">
    <label class="col-sm-2">Referências completas?</label>
    <div class="col-sm-10">
<?php
if ($cursor["references_ok"] == "true") {
echo '
<div class="radio">
<label>
<input type="radio" name="references_ok" id="gridRadios1" value="true" checked>
Sim
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="references_ok" id="gridRadios2" value="false">
Não
</label>
</div>
';
} else {
echo '
<div class="radio">
<label>
<input type="radio" name="references_ok" id="gridRadios1" value="true">
Sim
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="references_ok" id="gridRadios2" value="false" checked>
Não
</label>
</div>
';
}
?>
  </div>
  </div>
  <div class="form-group row list-inline">
    <label for="references" class="col-sm-2 form-control-label">Referências</label>
    <div class="col-sm-10">
    <div class="input_fields_wrap form-group">
<?php
if (!empty($cursor["references"])) {
<<<<<<< HEAD
  foreach ($cursor["references"] as $rf) {
    echo '<div><textarea class="form-control" id="exampleTextarea" rows="4" name="references[]">'.$rf.'</textarea><a href="#" class="remove_field">Remover</a></div>';
  }
} else {
  echo '<div><textarea class="form-control" id="exampleTextarea" rows="4" name="references[]"></textarea><a href="#" class="remove_field">Remover</a></div>';
}
=======

$references_count=0;
for ($references_count = 1; $references_count <= $count_references; $references_count++) {
echo '<input type="hidden" name="count" value="1" />';
echo '<div class="form-group row">';
echo '<div class="control-group" id="fields">';
echo '<div class="controls" id="profs">';
echo '<label for="inputAutor" class="col-sm-2 form-control-label">Referências</label>';
echo '<div class="col-sm-10">';
/*echo '<input type="text" class="form-control" id="inputPassword3" placeholder="Autor" name="references[]" value="'.$cursor["references"][$references_count-1].'">';*/
echo '<div id="field'.$references_count.'">';
echo '<input type="text" class="form-control" id="field'.$references_count.'" placeholder="ID no MetabuscaCI" name="references_id" value="'.$cursor["references"][$references_count-1]["references_id"].'">';
echo '<textarea class="form-control" id="field'.$references_count.'" rows="5" placeholder="Referência completa" name="references_citation" >'.$cursor["references"][$references_count-1]["references_citation"].'</textarea><button id="remove'.$references_count.'" class="btn btn-danger remove-me" >-</button></div><div id="field"></div>';
echo '</div></div></div></div><button id="b'.$references_count.'" class="btn add-more" type="button">+</button>';
}
}
else {
  echo '<input type="hidden" name="count" value="1" />';
  echo '<div class="form-group row">';
  echo '<div class="control-group" id="fields">';
  echo '<div class="controls" id="profs">';
  echo '<label for="inputAutor" class="col-sm-2 form-control-label">Referências</label>';
  echo '<div class="col-sm-10">';
  echo '<div id="field1">';
  echo '<input type="text" class="form-control" id="field1" placeholder="ID no MetabuscaCI" name="references_id">';
  echo '<textarea class="form-control" id="field1" rows="5" placeholder="Referências" name="references_citation" ></textarea><button id="b1" class="btn add-more" type="button">+</button><button id="remove1" class="btn btn-danger remove-me" >-</button></div><div id="field"></div>';
  echo '</div></div></div></div>';
}


>>>>>>> 44f729644a42424a786c0e06370fd28c066ee2e0
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
    if (!empty($cursor["citation"])) {
      foreach ($cursor["citation"] as $ct) {
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
<<<<<<< HEAD
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
=======
$(document).ready(function(){
    var next = Number(<?php echo json_encode($references_count) ?>)-1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<div id="field' + next + '"><input type="text" class="form-control" id="field' + next + '" placeholder="ID no MetabuscaCI" name="references_id"><textarea class="form-control" id="field' + next + '" rows="3" placeholder="Referências" name="references_citation"></textarea><button id="remove' + (next) + '" class="btn btn-danger remove-me" >-</button></div></div>';
        var newInput = $(newIn);
  /*    var removeBtn = '<button id="remove' + (next) + '" class="btn btn-danger remove-me" >-</button></div>';
        var removeButton = $(removeBtn); */
        $(addto).after(newInput);
    /*    $(addRemove).after(removeButton); */
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);
>>>>>>> 44f729644a42424a786c0e06370fd28c066ee2e0

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><textarea class="form-control" id="exampleTextarea" rows="4" name="references[]"></textarea><a href="#" class="remove_field">Remover</a></div>'); //add input box
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

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
