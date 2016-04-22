<?php
  include '../../inc/config.php';
  include '../../inc/header.php';
?>
<title><?php echo gettext('branch');?> - Assuntos</title>
</head>
<body>
<?php
  include_once('../../inc/analytics.php');
  include '../../inc/navbar.php';
?>

<div class="ui container">

  <?php
  /* Listar facetas de instituições */

  $aggregate_query_assunto_tematres = array(
    array(
      '$unwind' => '$assunto_tematres',
    ),
    array(
      '$group' => array(
        '_id' => '$assunto_tematres',
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array('count' => -1),
    ),
  );

$facet_assunto_tematres = $c->aggregate($aggregate_query_assunto_tematres);

echo '<h3>Assuntos tratados pelo Vocabulário Controlado</h3></br><ul class="list-inline-button">';
foreach ($facet_assunto_tematres['result'] as $aterm) {
    echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?assunto_tematres='.$aterm['_id'].'" style="color:white">'.$aterm['_id'].' <span class="label label-default label-pill">'.$aterm['count'].'</span></a></button></li>';
};
echo '</ul>';

?>
</div>
<?php
  include '../../inc/footer.php';
?>

</body>
</html>
