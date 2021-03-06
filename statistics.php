<?php
  include ('inc/config.php');
  include ('inc/header.php');

?>
<title><?php echo gettext("branch");?> - Estatísticas</title>
</head>
<body>
<?php include_once('inc/analytics.php') ?>
<?php
  include ('inc/navbar.php');
?>
<?php
/*Conta a quantidade de artigos na base */
  $num_documentos = ($c->count());
?>
<?php
/*Conta a quantidade de referencias na base */
$aggregate_references_count=array(
  array(
    '$lookup' => array(
      "from" => "ci_altmetrics",
      "localField" => "_id",
      "foreignField" => "_id",
      "as" => "altmetrics"
    )
  ),
  array(
    '$unwind'=>'$altmetrics'
  ),
  array(
    '$unwind'=>'$altmetrics.references'
  ),
  array(
    '$group' => array(
      "_id"=>'$_id',
      "sum"=>array('$sum'=>1)
      )
  ),
  array(
    '$group' => array(
      "_id"=>"null",
      "total_sum"=>array('$sum'=>'$sum')
      )
  )
);
$references_count = $c->aggregate($aggregate_references_count);
?>
<?php
$aggregate_citations=array(
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
      "journalci_title"=>1,
      "altmetrics.citation"=>1
    )
  ),
  array(
	'$unwind'=>'$altmetrics'
  ),
  array(
    '$unwind'=> '$journalci_title'
  ),  
  array(
    '$match'=>array(
      "altmetrics.citation"=>array('$exists'=>true)
    )
  ),
  array(
    '$unwind'=>'$altmetrics.citation'
  ),
  array(
    '$lookup'=>array(
      'from'=>"ci",
      'localField'=>"altmetrics.citation",
      'foreignField'=>"_id",
      'as'=>"cited"
    )
  ),
  array(
    '$project'=>array(
      "_id"=>1,
      "journalci_title"=>1,
      "cited._id"=>1,
      "cited.journalci_title"=>1
    )
  ),
  array(
    '$group' => array(
      "_id"=>array("journal_citador"=>'$journalci_title',
                    "journal"=>'$cited.journalci_title'
                  ),
      "count"=>array('$sum'=>1)
      )
  ),
  array(
    '$sort' => array('cited.journalci_title'=>1,'count'=>-1)
  ),
  array(
    '$limit'=>20000,
  ),
);

$citations = $c->aggregate($aggregate_citations);

?>

<?php
/*   include ('inc/navbar.php');
Conta a quantidade de artigos na base */
  $num_documentos = ($c->count());
?>

<div class="ui container">

<h3>Alguns números</h3>
<div class="ui three statistics">
  <div class="statistic">
    <div class="value">
      31
    </div>
    <div class="label">
      Periódicos coletados
    </div>
  </div>
  <div class="statistic">
    <div class="value">
      <i class="file icon"></i> <?php echo $num_documentos; ?>
    </div>
    <div class="label">
      Documentos
    </div>
  </div>
  <div class="statistic">
    <div class="value">
      <?php print_r($references_count["result"][0]["total_sum"]); ?>
    </div>
    <div class="label">
      referências cadastradas
    </div>
  </div>
</div>
<h3>Citações entre as revistas indexadas pelo <?php echo gettext("branch");?></h3>
<table class="ui celled table">
    <thead>
      <tr>
        <th>Revista que fez a citação</th>
        <th>Revista que recebeu a citação</th>
        <th>Quantidade</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($citations["result"] as $ct):?>
  <tr>
    <td scope="row"><?php echo $ct["_id"]["journal_citador"];?></td>
    <td><?php if (!empty($ct["_id"]["journal"][0][0])): ?><?php echo $ct["_id"]["journal"][0][0]; ?><?php endif;?></td>
    <td><?php echo $ct["count"];?></td>
  </tr>
<?php endforeach;?>
    </tbody>
</table>
<br/>
<p><a href="application/statistics/facebook.php">Facebook</a></p>
<p><a href="application/statistics/network.php">Rede de colaboração entre instituições</a></p>
</div>
<?php
  include "inc/footer.php";
?>

</body>
</html>
