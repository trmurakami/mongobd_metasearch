<!-- Barra de navegação -->
<nav class="navbar navbar-fixed-top navbar-light bg-faded">
  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
    &#9776;
  </button>
  <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">

  <a class="navbar-brand" href="index.php"><?php echo gettext("branch");?></a>
  <ul class="nav navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="about.php">Sobre</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Contato</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Login</a>
    </li>
  </ul>
  <form class="form-inline pull-xs-right" action="result.php" method="get">
    <input class="form-control" type="text" name="full_text" placeholder="Buscar" >
    <button class="btn btn-primary-outline" type="submit">Buscar</button>
  </form>
  </div>
</nav>
<br/><br/>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4"><a href="index.php" style="color: white"><?php echo gettext("branch");?> (Beta)</a></h1>
    <p class="lead" style="background-color: white">Metabuscador em periódicos de Ciência da Informação disponíveis em OAI-PMH.</p>
  </div>
</div>
