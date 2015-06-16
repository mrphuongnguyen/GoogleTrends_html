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
    <!-- Css Personalizados -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="./Cloud/jquery.awesomeCloud-0.2.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  <script type="text/javascript">

    function showDetails( id ){

        $.ajax({url: "./ajax/ajax.details.php?termino="+id, success: function(result){
            $("#detailBox").html(result);
        }});


    }


    // Funciones cloud tags
    $(document).ready(function(){
        
        $("#detailBox2").awesomeCloud({
          "size" : {
            "grid" : 9,
            "factor" : 1
          },
          "options" : {
            "color" : "random-dark",
            "rotationRatio" : 0.35
          },
          "font" : "'Times New Roman', Times, serif",
          "shape" : "circle"
        });
        
      });


  </script>

  <style type="text/css">
  #detailBox2 {
  height: 300px;
  margin: 0.5in auto;
  width: 100%;
  }
  </style>

  </head>
  <body>




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
          <a class="navbar-brand" href="#">Trends Tool</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Google Trends <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Twitter</a></li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Buscar Termino">
            </div>
            <button type="submit" class="btn btn-default">Buscar</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Exportar</a></li>
            <li><a href="#">Salir</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

  <div class="row" style="text-align: center;">
    <div class="col-md-2">
     
      <h4> Menú </h4>
      
    <?php
    
    $hoy = time();
    $fecha = date("Y-m-d" , $hoy);
    $total_dias_restar = 14;

    for( $i = 0; $i <= $total_dias_restar; $i++ ){

      $new_date = date('d-m-Y',strtotime("-$i days", strtotime($fecha)));
      echo "<a href='?query=$new_date'>".$new_date."</a><br/>";

    }


    ?> 

    <h4> Tags </h4>
    <li>Elecciones 2015 </li>
    <li>Fifa </li>

    </div>
    <div class="col-md-6">
      <?php

      $fecha_actual = date('d-m-Y' , time());
      $date = ($_GET["query"]) ? $_GET["query"] : $fecha_actual;
      $trendsBD = new dbTrends();
      $list = $trendsBD->listByDateTerms( $date );

      if($list){

        for ($k = 0 ; $k < count( $list ); $k++){

          $trendsTermsData = $trendsBD->getTrendsTermsData( $list[$k]["trendsTerms_id"] );

          
          if (!empty($trendsTermsData[0]["imagen"])) {
            $imagen = 'https:'.$trendsTermsData[0]["imagen"];

          } else {
            $imagen = './imagenes/no-disponible.png';

          } 

          echo "<table width='100%' border=1 cellpadding ='2'>";
          echo "<tr><td rowspan='2' width='100px' valign='top' style='padding: 10px; font-size:12px'><img src='".$imagen."'>
          <br/><a href='javascript:showDetails(\"".$list[$k]["termino"]."\")'>Seguimiento</a><br/>
          <a href='#'>Etiquetar</a><br/>

          </td><td align='left' style='padding: 10px;'><h4> ".$list[$k]["termino"]." </h4></td><td width='100px'><h4>".$trendsTermsData[0]["trafico"]."</h4></td></tr>";
          echo "<tr><td colspan='2' align='left' style='padding: 10px; font-size:11px'>";

          // Ingresamos la informacion de Termino
          echo "<b>Búsquedas Relacionadas:</b><br/>";
          echo $list[$k]["descripcion"];

          $trendsSource = $trendsBD->getTrendsTermsSource( $trendsTermsData[0]["trendsTermsData_id"] );

          echo "<br/>";

          for($i=0; $i < count( $trendsSource ); $i++){

            echo "
            Fuente: <b>".$trendsSource[ $i ]["fuente"]." </b>
            <br/>URL:<a href='".$trendsSource[ $i ]["url"]."'>".$trendsSource[ $i ]["titulo"]."</a>
            <br/>";
          }


          echo "</td></tr>";
          echo "</table>";
          echo "<br/>";

        }


      }else{
        echo "No se encontraron registros en la fecha seleccionada $date";

      }

      ?>

    </div>
    <div class="col-md-4" id="detailBox" style="text-align: left;">
      <!-- Incluimos nueve de tags -->
      <h4>Cloud Términos </h4>
      <hr/>
      <div id="detailBox2">

        <?php

          $trendsBD = new dbTrends();
          $list = $trendsBD->listByDateTerms( $date );

          if($list){

            $array_cloud = array();
            for ($k = 0 ; $k < count( $list ); $k++){

              $trendsTermsData = $trendsBD->getTrendsTermsData( $list[$k]["trendsTerms_id"] );

              $temino   = $list[$k]["termino"];
              $trafico  = intval($trendsTermsData[0]["trafico"]);
              
              $array_cloud[ $temino ] =  $trafico;

            }
          }

          arsort( $array_cloud );
          $max_traffic = reset($array_cloud);

          foreach ($array_cloud as $key => $value) {

            $proporcion = round( ( $value * 50 ) / $max_traffic );
            
            echo '<span data-weight="'.$proporcion.'">'.$key.'</span>';
            
          }

        ?>

        </div>

  </div>

</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


</html>
