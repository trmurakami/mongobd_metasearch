<?php
  include ('inc/config.php');
  include ('inc/header.php');

?>
<title>MetaBuscaCI - Estatísticas</title>
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

$aggregate_facebook_total=array(
  array(
    '$unwind'=>'$journalci_title'
  ),
  array(
    '$group' => array(
      "_id"=>'$journalci_title',
      "likes"=>array('$sum'=>'$facebook_url_likes'),
      "shares"=>array('$sum'=>'$facebook_url_shares'),
      "comments"=>array('$sum'=>'$facebook_url_comments'),
      "interacoes"=>array('$sum'=>'$facebook_url_total')
      )
  ),
  array(
    '$sort' => array("_id"=>1)
  )
);

$facet_facebook = $c->aggregate($aggregate_facebook_total);

$facebook = array();
array_push($facebook,['Titulo do periódico','Curtidas','Compartilhamentos','Comentários']);
foreach ($facet_facebook["result"] as $fb) {
  array_push($facebook,[$fb['_id'],$fb['likes'],$fb['shares'],$fb['comments']]);
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


<?php
  include "inc/footer.php";
?>

</body>
</html>
