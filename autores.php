<?php
  include ('inc/config.php');
  include ('inc/header.php');
?>
<title>MetaBuscaCI - Autores</title>
</head>
<body>
<?php include_once("inc/analyticstracking.php") ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=90128977252";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
  include ('inc/navbar.php');
?>

<div class="container">

  <?php
  /* Listar facetas de instituições */

  $aggregate_query_autor=array(
    array(
      '$unwind'=>'$autor'
    ),
    array(
      '$group' => array(
        "_id"=>'$autor',
        "count"=>array('$sum'=>1)
        )
    ),
    array(
      '$sort' => array("count"=>-1)
    )
  );

$facet_autor = $c->aggregate($aggregate_query_autor);

echo "<h3>Autores</h3></br><ul class=\"list-inline-button\">";
foreach ($facet_autor["result"] as $at) {
  echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?autor='.$at["_id"].'" style="color:white">'.$at["_id"].' <span class="label label-default label-pill">'.$at["count"].'</span></a></button></li>';
};
echo '</ul>';

?>

<?php
  include "inc/footer.php";
?>

</body>
</html>
