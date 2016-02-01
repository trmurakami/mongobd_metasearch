<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title>MetaBuscaCI - Detalhes do registro</title>
</head>
<body>
<div class="container-fluid">
<?php
  include "inc/navbar.php";
?>

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

$c->update(array('_id'=>$_id),
           array('$set'=>array(
             'references'=>$_POST["references"],
	     'references_ok'=>$_POST["references_ok"]
           )));

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

if (!empty($cursor["references"])) {
$count_references = count($cursor["references"]);
}
else {
  $count_references = 0;
  $references_count=1;
}
?>

<div class="row">
  <div class="col-md-4"><h3>Exportar</h3></div>
  <div class="col-md-8">

<h3>Detalhes do registro</h3>

<a href="single.php?_id=<?php echo "$_id"; ?>">Ver registro</a>

<form action="edit.php" method="POST">
  <div class="form-group row">
  <div class="checkbox">
    <label>
      <?php 
      if ($cursor["references_ok"] == "true") {
      echo '<input type="checkbox" name="references_ok" value="true" checked>Referência completa';
      } else
      {
      echo '<input type="checkbox" name="references_ok" value="true">Referência completa';
      }
      ?>
    </label>
  </div>
</div>
  <div class="form-group row">
    <label for="disabledTextInput" class="col-sm-2 form-control-label">Sysno ou ID</label>
    <div class="col-sm-10">
    <input type="text" id="disabledTextInput" name="_id" class="form-control" placeholder="<?php echo "$_id";  ?>" value="<?php echo "$_id";  ?>">
    </div>
  </div>

<?php
if (!empty($cursor["references"])) {
$references_count=0;
for ($references_count = 1; $references_count <= $count_references; $references_count++) {
echo '<input type="hidden" name="count" value="1" />';
echo '<div class="form-group row">';
echo '<div class="control-group" id="fields">';
echo '<div class="controls" id="profs">';
echo '<label for="inputAutor" class="col-sm-2 form-control-label">Referências</label>';
echo '<div class="col-sm-10">';
/*echo '<input type="text" class="form-control" id="inputPassword3" placeholder="Autor" name="references[]" value="'.$cursor["references"][$references_count-1].'">';*/
echo '<div id="field">';
echo '<textarea class="form-control" id="field'.$references_count.'" rows="5" placeholder="Referências" name="references[]" >'.$cursor["references"][$references_count-1].'</textarea><button id="b'.$references_count.'" class="btn add-more" type="button">+</button><button id="remove'.$references_count.'" class="btn btn-danger remove-me" >-</button></div><div id="field"></div>';
echo '</div></div></div></div>';
}
}
else {
  echo '<input type="hidden" name="count" value="1" />';
  echo '<div class="form-group row">';
  echo '<div class="control-group" id="fields">';
  echo '<div class="controls" id="profs">';
  echo '<label for="inputAutor" class="col-sm-2 form-control-label">Referências</label>';
  echo '<div class="col-sm-10">';
  echo '<div id="field">';
  echo '<textarea class="form-control" id="field1" rows="5" placeholder="Referências" name="references[]" ></textarea><button id="b1" class="btn add-more" type="button">+</button><button id="remove1" class="btn btn-danger remove-me" >-</button></div><div id="field"></div>';
  echo '</div></div></div></div>';
}


?>

<script type="text/javascript">
$(document).ready(function(){
    var next = Number(<?php echo json_encode($references_count) ?>)-1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<textarea class="form-control" id="field' + next + '" rows="3" placeholder="Referências" name="references[]"></textarea>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);

            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });



});
</script>





  <div class="form-group row">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-secondary">Salvar</button>
    </div>
  </div>
</form>


</div>
</div>

<?php
  include "inc/footer.php";
?>


</div>
</body>
</html>
