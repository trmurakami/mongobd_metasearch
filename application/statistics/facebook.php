<?php
  include '../../inc/config.php';
  include '../../inc/header.php';

?>
<title><?php echo gettext('branch');?> - Estatísticas</title>
</head>
<body>
<?php
  include_once('../../inc/analytics.php');
  include '../../inc/navbar.php';
?>

<div class="ui container">

<?php

$aggregate_facebook_total = array(
  array(
    '$unwind' => '$journalci_title',
  ),
  array(
    '$lookup' => array(
      "from" => "ci_altmetrics",
      "localField" => "_id",
      "foreignField" => "_id",
      "as" => "altmetrics"
    )
  ),
  array(
    '$unwind'=> '$altmetrics'
  ),
  array(
    '$group' => array(
      '_id' => '$journalci_title',
      'likes' => array('$sum' => '$altmetrics.facebook_url_likes'),
      'shares' => array('$sum' => '$altmetrics.facebook_url_shares'),
      'comments' => array('$sum' => '$altmetrics.facebook_url_comments'),
      'interacoes' => array('$sum' => '$altmetrics.facebook_url_total'),
      ),
  ),
  array(
    '$sort' => array('_id' => 1),
  ),
);

$facet_facebook = $c->aggregate($aggregate_facebook_total);

$facebook = array();
array_push($facebook, ['Titulo do periódico', 'Curtidas', 'Compartilhamentos', 'Comentários']);
foreach ($facet_facebook['result'] as $fb) {
    array_push($facebook, [$fb['_id'], $fb['likes'], $fb['shares'], $fb['comments']]);
};

?>

<h3>Facebook</h3></br>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMaterial);

function drawMaterial() {
      var data = google.visualization.arrayToDataTable(
        <?= json_encode($facebook); ?>
        );

      var options = {
        chart: {
          title: 'Interações (Curtidas, Comentários e Compartilhamentos) no Facebook dos Periódicos de CI',
          subtitle: 'Atualizado em 2016-01-23',
          isStacked: true,
        },
        hAxis: {
          title: 'Interações',
          minValue: 0,
        },
        vAxis: {
          title: 'Título'
        },
        bars: 'horizontal'
      };
      var material = new google.charts.Bar(document.getElementById('chart_div'));
      material.draw(data, options);
    }
</script>

<div id="chart_div" style="width: 100%; height: 1000px;"></div>

<br/><br/>      
    
<table class="ui celled table">
  <tbody>
      <?php 
            $sum_1 = "";
            $sum_2 = "";
            $sum_3 = "";
            $sum_4 = "";
        foreach ($facebook as $facebook_row){
            $sum_1 +=intval($facebook_row[1]);
            $sum_2 += intval($facebook_row[2]);
            $sum_3 += intval($facebook_row[3]);
            $sum_4 += (intval($facebook_row[1])+intval($facebook_row[2])+intval($facebook_row[3]));
            echo '<tr>';
            echo '<td>'.$facebook_row[0].'</td>';
            echo '<td>'.$facebook_row[1].'</td>';
            echo '<td>'.$facebook_row[2].'</td>';
            echo '<td>'.$facebook_row[3].'</td>';
            echo '<td>'.(intval($facebook_row[1])+intval($facebook_row[2])+intval($facebook_row[3])).'</td>';
            echo '</tr>';
            
        }     
      
      ?>
      <tr>
        <?php
            echo '<td>Total:</td>';
            echo '<td>'.$sum_1.'</td>';
            echo '<td>'.$sum_2.'</td>';
            echo '<td>'.$sum_3.'</td>';
            echo '<td>'.$sum_4.'</td>';
            
        ?>
      </tr>
          
  </tbody>
</table>
<br/><br/>    
</div>
<?php
  include '../../inc/footer.php';
?>
</body>
</html>
