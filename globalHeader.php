<?php

// Inclumos el menu

?>
<nav class="navbar navbar-inverse">
<div class="container-fluid">
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="/">Trends Tool</a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <li><a href="./">Google Trends</a></li>
    <li><a href="./twitter.php">Twitter</a></li>
  </ul>
  <form class="navbar-form navbar-left" role="search">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Buscar Termino">
    </div>
    <button type="submit" class="btn btn-default">Buscar</button>
  </form>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="./agenda-televisa.php">Agenda Televisa</a></li>
    <li><a href="#">Agenda Telecom</a></li>
    <li><a href="#">Agenda Política</a></li>
    <li><a href="#">Exportar</a></li>
    <li><a href="#">Salir</a></li>
  </ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

