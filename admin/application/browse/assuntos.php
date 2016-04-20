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

  $aggregate_query_subject = array(
    array(
      '$unwind' => '$subject',
    ),
    array(
      '$group' => array(
        '_id' => '$subject',
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array('count' => -1),
    ),
  );

$facet_subject = $c->aggregate($aggregate_query_subject);

echo '<h3>Assuntos</h3></br><ul class="list-inline-button">';
foreach ($facet_subject['result'] as $sj) {
    echo '<li style="padding:5px;"><button type="button" class="btn btn-primary" ><a href="result.php?subject='.$sj['_id'].'" style="color:white">'.$sj['_id'].' <span class="label label-default label-pill">'.$sj['count'].'</span></a></button></li>';
};
echo '</ul>';

?>
</div>
<?php
  include '../../inc/footer.php';
?>

</body>
</html>
