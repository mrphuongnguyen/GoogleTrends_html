<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./Classes/TwitterTrendsPlaceBD.php');
date_default_timezone_set('America/Mexico_City');


// Intanciamos la clase de lugares
$trends = new TrendsPlaceBD();


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


  <?php

    // Incluimos le meni
    include_once('globalHeader.php');

  ?>

  <div class="row" style="text-align: left; padding-left:40px;">
    <div class="col-md-2">
     
      <h4> Tendencias México </h4>
      
    <?php
    
    $hoy = time();
    $fecha = date("Y-m-d" , $hoy);
    $total_dias_restar = 5;

    for( $i = 0; $i <= $total_dias_restar; $i++ ){

      $new_date = date('d-m-Y',strtotime("-$i days", strtotime($fecha)));
      echo "<a href='?date=$new_date'>".$new_date."</a><br/>";

    }

    ?> 

    <h4> Tendencias Hoy </h4>

    <?php

    foreach ($trends->get_places() as $key => $value) {
      
      echo "<a href='?woeid=$key'>$key</a><br/>"; 

    }

    ?>



    </div>
    <div class="col-md-10">
      
      <?php

      $array_table = array();
        if( isset ($_GET["woeid"]) ){

          $trends->place = $_GET["woeid"];
          $array_table = $trends->get_tweets_today();
          echo "<h3>Tendencias en ".$_GET["woeid"]."</h3>";

        }elseif ( isset ($_GET["date"]) ){

          $date_id = str_replace("-", "", $_GET["date"]);
          $array_table = $trends->get_trends_by_dateid( $date_id );
          echo "<h3>Tendencias en México ".$_GET["date"]."</h3>";

        }else{

          $date_id = date('dmY',time());
          $array_table = $trends->get_trends_by_dateid( $date_id );
          echo "<h3>Tendencias en México ".date("d-m-Y",time())."</h3>";

        }


      ?>



      <table class="table table-hover">
        <thead>
        <tr>
          <th>#</th>
          <th>Tweet</th>
          <th>URL</th>
          <th>Hora Ingreso</th>
          
        </tr>
      </thead>
      <tbody>

        <?php

        // Verificamos por ciudad

        if(count($array_table) > 0){
          $cont = 1;
          foreach ($array_table as $key => $value) {
            
              echo "<tr>
                    <td>".$cont."</td>
                    <td><b>".$value["twitter_name"]."</b></td>
                    <td><a href='".$value["twitter_url"]."'>".$value["twitter_url"]."</a></td>
                    <td>".date('H:i:s' ,$value["fecha_ingreso"] ) ."</td>
                  </tr>";
            $cont ++;

          }
        }

        ?>
     
      </tbody>

    </div>
    <!--div class="col-md-4" id="detailBox" style="text-align: left;">
      
      Aqui es donde ponemos todas las tablas y la informacion que debe de llevar

  </div -->

</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


</html>
