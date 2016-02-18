<?php
  include ('inc/config.php');
  include ('inc/header.php');

?>
<title><?php echo gettext("branch");?> - Estatísticas</title>
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

<?php
$aggregate_citations=array(
  array(
    '$match'=>array(
      "citation"=>array('$exists'=>true)
    )
  ),
  array(
    '$unwind'=>'$citation'
  ),
  array(
    '$lookup'=>array(
      'from'=>"ci",
      'localField'=>"citation",
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
  )
);

$citations = $c->aggregate($aggregate_citations);

?>

<div class="ui container">
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
    <th scope="row"><?php echo $ct["_id"]["journal_citador"][0];?></th>
    <td><?php if (!empty($ct["_id"]["journal"][0][0])): ?><?php echo $ct["_id"]["journal"][0][0]; ?><?php endif;?></td>
    <td><?php echo $ct["count"];?></td>
  </tr>
<?php endforeach;?>
    </tbody>
</table>
<br/>
<p><a href="facebook.php">Facebook</a></p>
<p><a href="network.php">Rede de colaboração entre instituições</a></p>
</div>
<?php
  include "inc/footer.php";
?>

</body>
</html>
