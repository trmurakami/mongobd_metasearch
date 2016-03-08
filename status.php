<?php
  include 'inc/config.php';
  include 'inc/header.php';
?>
<title><?php echo gettext('branch');?> - Status</title>
<?php
/*Conta a quantidade de artigos na base */
  $num_documentos = ($c->count());
?>
<?php
function generateStatus($c,$campo,$campo_nome){
  $campo_count_sim=array(
    $campo => array(
      '$exists'=>true
    ),
  );
  $campo_count_nao=array(
    $campo => array(
      '$exists'=>false
    ),
  );
  $campo_sim = $c->find($campo_count_sim)->count();
  $campo_nao = $c->find($campo_count_nao)->count();

echo '<h3>'.$campo_nome.'</h3>';
echo '<div class="ui two statistics">';
echo '<div class="statistic">';
echo '<div class="value">'.$campo_sim.'</div>';
echo '<div class="label">com '.$campo_nome.'</div>';
echo '</div>';
echo '<div class="statistic">';
echo '<div class="value">'.$campo_nao.'</div>';
echo '<div class="label">sem '.$campo_nome.'</div>';
echo '</div></div>';
}
?>
</head>
<body>
<?php
  include_once('inc/analytics.php');
  include 'inc/navbar.php';
?>
<div class="ui container">
  <div class="ui one statistics">
    <div class="statistic">
      <div class="value">
        <?php echo $num_documentos; ?>
      </div>
      <div class="label">
        número de documentos
      </div>
    </div>
  </div>
  <?php
  generateStatus($c,"autor","autor");
  generateStatus($c,"instituicao","instituição");
  generateStatus($c,"assunto_tematres","assunto do vocabulário controlado");
  generateStatus($c,"full_text","texto completo");
  generateStatus($c,"references","referências");
  ?>
</div>



</div>
<?php
  include 'inc/footer.php';
?>
</body>
</html>
