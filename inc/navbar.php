<div class="ui large top fixed hidden menu">
  <div class="ui container">
    <a class="active item" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>index.php"><?php echo gettext("branch");?></a>
    <a class="item" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>statistics.php">Estatísticas</a>
    <a class="item" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>contact.php">Contato</a>
    <a class="item" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>about.php">Sobre</a>
    <div class="right menu">
      <div class="item">
        <div class="ui transparent icon input">
          <form class="form-inline pull-xs-right" action="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>result.php" method="get">
          <i class="search icon"></i>
          <input type="text" name="buscaindice" placeholder="Buscar em Títulos, Autores e Resumos">
          <button class="ui button">Buscar</button>
          </form>
        </div>
      </div>
      <div class="item">
        <a class="ui button" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] ."/".$SERVER_DIRECTORY."/"; ?>admin/login.php">Login</a>
      </div>
    </div>
  </div>
</div>
<br/><br/><br/>
