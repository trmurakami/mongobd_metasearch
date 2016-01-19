  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Início</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="pagination.php">Pagination <span class="sr-only">(current)</span></a></li>
        </ul>

        <form class="form-inline navbar-form navbar-left" role="form" id="yourformID-form" action="result.php" method="get">
            <div class="input-group">
        <span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span>

                <div class="form-group">
                    <input size="50" maxlength="50" class="form-control" name="q" type="text">
                </div>

                <div class="form-group">
                    <select class="form-control" name="idx">
                        <option value="">Escolha</option>
                        <option value="journalci_title">Periódico</option>
                        <option value="title">Título</option>
                        <option value="creator">Autor</option>
                    </select>
                    <button type="submit" class="btn btn-default" id="searchsubmit">Enviar</button>
                </div>
            </div>
        </form>


        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
