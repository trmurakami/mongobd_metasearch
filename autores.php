<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Autores</title>
</head>
<body>
<?php include_once('inc/analyticstracking.php') ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=90128977252";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
  include 'inc/navbar.php';
?>

<div class="ui container">

  <?php
  /* Listar facetas de instituições */

  $aggregate_query_autor = array(
    array(
      '$unwind' => '$autor',
    ),
    array(
      '$group' => array(
        '_id' => '$autor',
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array('count' => -1),
    ),
  );

  $aggregate_creator_total = array(
    array(
      '$unwind' => '$creator_total',
    ),
    array(
      '$group' => array(
        '_id' => '$creator_total',
        'count' => array('$sum' => 1),
        ),
    ),
    array(
      '$sort' => array('_id' => 1),
    ),
  );

$facet_autor = $c->aggregate($aggregate_query_autor);
$facet_creator_total = $c->aggregate($aggregate_creator_total);

$creator_count = array();
array_push($creator_count, ['Número de autores', 'quantidade']);
foreach ($facet_creator_total['result'] as $cc) {
    array_push($creator_count, [$cc['_id'], $cc['count']]);
};
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMaterial);

function drawMaterial() {
      var data = google.visualization.arrayToDataTable(
        <?= json_encode($creator_count); ?>
        );

      var options = {
        chart: {
          title: 'Quantidade de autores por trabalhos',
          subtitle: '',
        },
        hAxis: {
          title: 'Quantidade',
          minValue: 0,
        },
        vAxis: {
          title: 'Número de autores por trabalho'
        },
        bars: 'horizontal'
      };
      var material = new google.charts.Bar(document.getElementById('chart_div_1'));
      material.draw(data, options);
    }
</script>
<div id="chart_div_1" style="width: 100%; height: 1000px;"></div>

<?php
echo '<h3>Autores</h3></br>
      <div class="ui small horizontal divided list">';
foreach ($facet_autor['result'] as $at) {
    echo '<div class="item"><div class="content"><div class="header"><a href="result.php?autor='.$at['_id'].'">'.$at['_id'].' ('.$at['count'].')</a></div></div></div>';
};
echo '</div>';

?>

<?php
  include 'inc/footer.php';
?>

</body>
</html>
