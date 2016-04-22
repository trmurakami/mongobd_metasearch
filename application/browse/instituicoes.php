<?php
  include '../../inc/config.php';
  include '../../inc/header.php';
?>
<title><?php echo gettext('branch');?> - Instituições</title>
</head>
<body>
<?php
  include_once('../../inc/analytics.php');
  include '../../inc/navbar.php';
?>

<div class="ui container">

  <?php
  /* Listar facetas de instituições */

  $aggregate_query_instituicao = array(
    array(
      '$unwind' => '$instituicao',
    ),
    array(
      '$group' => array(
        '_id' => '$instituicao',
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array('count' => -1),
    ),
  );

  $facet_instituicao = $c->aggregate($aggregate_query_instituicao);

  echo '<h3>Instituições</h3></br>
        <div class="ui small horizontal divided list">';
  foreach ($facet_instituicao ['result'] as $it) {
      echo '<div class="item"><div class="content"><div class="header"><a href="result.php?instituicao='.$it['_id'].'">'.$it['_id'].' ('.$it['count'].')</a></div></div></div>';
  };
  echo '</div>';

?>
</div>
<?php
  include '../../inc/footer.php';
?>

</body>
</html>
