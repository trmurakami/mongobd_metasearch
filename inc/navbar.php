<div class="ui large top fixed hidden menu">
  <div class="ui container">
    <a class="active item" href="index.php"><?php echo gettext("branch");?></a>
    <a class="item" href="statistics.php">Estatísticas</a>
    <a class="item" href="contact.php">Contato</a>
    <a class="item" href="about.php">Sobre</a>
    <div class="right menu">
      <div class="item">
        <div class="ui transparent icon input">
          <form class="form-inline pull-xs-right" action="result.php" method="get">
          <i class="search icon"></i>
          <input type="text" name="buscaindice" placeholder="Buscar em Títulos, Autores e Resumos">
          <button class="ui button">Buscar</button>
          </form>
        </div>
      </div>
      <div class="item">
        <a class="ui button">Log in</a>
      </div>
    </div>
  </div>
</div>
<br/><br/><br/>
