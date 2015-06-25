<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./Classes/TwitterTrendsPlaceBD.php');
include_once('./Classes/TwitterUserTimeline.php');
date_default_timezone_set('America/Mexico_City');


// Intanciamos la clase de lugares
$trends       = new TrendsPlaceBD();
$userTimeline = new TwitterUserTimeline();
$userTimeline->total_results = 50;


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
      echo "<a href='./twitter.php?date=$new_date'>".$new_date."</a><br/>";

    }

    ?> 

    <h4> Tendencias Hoy </h4>

    <?php

    foreach ($trends->get_places() as $key => $value) {
      
      echo "<a href='./twitter.php?woeid=$key'>$key</a><br/>"; 

    }

    ?>

    <h4> Seguimiento Uno a uno </h4>

    <?php

    foreach ($userTimeline->get_users() as $key => $value) {
      
      echo "<a href='./twitter-timeline.php?user=$value'>$value</a><br/>"; 

    }

    ?>

    </div>
    <div class="col-md-10">
      
     <?php

     $userTimeline->query_user = $_GET["user"];
     $userTimeline->get_json();
     $userTimeline->get_profile_info();

     $objHeader = $userTimeline->get_profile_info();

     if ( $userTimeline->get_error()  ){

        echo "Usuario no autorizado";

     }else{

     ?>

     <table border=1 cellpadding ='2' width="95%">

      <tr>
        <td width="20px" rowspan="2" style='padding: 10px;'><?php echo "<img src='".$objHeader->profile_image_url."'>" ?></td>
        <td style='padding: 10px;'><h3> <?php echo "@".$objHeader->screen_name ?> </h3></td>
        <td align='center'> <b>Seguidores</b><br> <?php echo number_format($objHeader->followers_count , 0); ?> </td>
      </tr>
      <tr>
        <td colspan="2" style='padding: 10px;'> <?php echo $objHeader->description; ?> </td>
      </tr>

     </table>


     <?php

      // Creamos listado de tweets
      $obj_json = $userTimeline->json_decode;
      
      $cont = 1;
      foreach ($obj_json as $key => $value) {

       
        echo "<br>";
        echo "<table border=1 cellpadding ='2' width='95%''>
        <tr>
        <td rowspan='3' width='50px' align='center' style='background-color: #e2e2e2;'><h4>".$cont."</h4></td><td colspan='2' style='padding: 10px;'>Fecha: ".$value->created_at."</td>
        </tr>
        <tr>
        <td colspan='2' style='padding: 10px;'><b>".$value->text."</b></td>
        </tr>
        <td style='padding: 5px;'>Retweet: ".$value->retweet_count." </td><td style='padding: 5px;'>Favorite:  ".$value->favorite_count."</td>
        </tr>
        </table>";
        
        $cont ++;
      }



      }
     ?>


    </div>
    <!--div class="col-md-4" id="detailBox" style="text-align: left;">
      
      Aqui es donde ponemos todas las tablas y la informacion que debe de llevar

  </div -->

</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->


</html>
