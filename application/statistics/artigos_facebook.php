<?php
  include '../../inc/config.php';
  include '../../inc/header.php';

?>
<title><?php echo gettext('branch');?> - Artigos com mais interações no facebook</title>
</head>
<body>
<?php
  include_once('../../inc/analytics.php');
  include '../../inc/navbar.php';
?>

<div class="ui container">

<?php

$aggregate_facebook_top = array(
  array(
    '$lookup' => array(
      "from" => "ci_altmetrics",
      "localField" => "_id",
      "foreignField" => "_id",
      "as" => "altmetrics"
    )
  ),
  array(
    '$project'=>array(
      "_id"=>1,
      "title"=>1,
      "autor"=>1,
      "journalci_title"=>1,
      "year"=>1,
      "altmetrics"=>1
    )
  ),
  array(
    '$unwind'=> '$altmetrics'
  ),
  array(
    '$unwind'=> '$journalci_title'
  ),
  array(
    '$unwind'=> '$year'
  ),
  array(
    '$sort' => array('altmetrics.facebook_url_total' => -1),
  ),
  array(
    '$limit'=>100,
  ),
);

$top_facebook = $c->aggregate($aggregate_facebook_top);

?>

<h3>Top 100 - Interações no facebook</h3></br>

<table class="ui celled table">
  <thead>
    <tr>
    <th>Título</th>
    <th>Autores</th>
    <th>Periódico</th>
    <th>Ano de publicação</th>
    <th>Curtidas</th>
    <th>Comentários</th>
    <th>Compartilhamentos</th>
    <th>Total</th>
    </tr>
  </thead>
  <tbody>

<?php foreach ($top_facebook["result"] as $r): ?>
<tr>
<td>
<a href="/rppbci/single.php?_id=<?php echo $r["_id"];?>"><?php echo $r["title"][0];?></a>
</td>
<td>
  <?php foreach ($r["autor"] as $autores): ?>
    <?php echo $autores;?><br/>
  <?php endforeach;?>
</td>
<td>
<?php echo $r["journalci_title"];?>
</td>
<td>
<?php echo $r["year"];?>
</td>
<td>
<?php echo $r["altmetrics"]["facebook_url_likes"];?>
</td>
<td>
<?php echo $r["altmetrics"]["facebook_url_comments"];?>
</td>
<td>
<?php echo $r["altmetrics"]["facebook_url_shares"];?>
</td>
<td>
<?php echo $r["altmetrics"]["facebook_url_total"];?>
</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<br/><br/>
</div>
<?php
  include '../../inc/footer.php';
?>

</body>
</html>
