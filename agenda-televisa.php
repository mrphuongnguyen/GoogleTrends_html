<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./Classes/class.googleTrendsDB.php');
date_default_timezone_set('America/Mexico_City');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title> Trends Tool </title>

    <!-- Bootstrap -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Libreria JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  </head>
  <body>


  <?php

    // Incluimos le menú
    include_once('globalHeader.php');

  ?>

  <div class="row" style="text-align: center;">
    <div class="col-md-2" style="text-align: left; padding-left:40px;">
     
      <?php include_once('./agenda-televisa-menu.php'); ?>

    </div>
    <div class="col-md-6">
      Cuerpo
    </div>
    <div class="col-md-4" id="detailBox" style="text-align: left;">
    Tags

    </div>
  </div>

</body>
</html>
