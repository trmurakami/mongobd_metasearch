<?php
  include '../../inc/config.php';
  include '../../inc/header.php';

?>
<title><?php echo gettext('branch');?> - Status</title>
</head>
<body>
<?php include_once('../../inc/analyticstracking.php') ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=90128977252";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
  include '../../inc/navbar.php';
?>

<div class="ui container">


</div>
<?php
  include '../../inc/footer.php';
?>

</body>
</html>
