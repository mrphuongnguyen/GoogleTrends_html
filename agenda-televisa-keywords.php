<?php
header('Content-Type: text/html; charset=utf-8');
include_once('./Classes/class.keywordsRelation.php');
include_once('./Classes/class.keywords.php');
date_default_timezone_set('America/Mexico_City');

// Intanciamos clases [conceptos, keywords]

$conceptos  = new KeywordsRelation();
$keywords   = new Keywords(); 


$conceptos->setAgenda("Televisa");
$conceptos->setConcepto("Coyontura");

// Verificamos las acciones
if( isset ($_GET['action']) ){

  if ($_GET['action'] == "insert"){

      $input_keywords   = $_POST['keyword'];
      $select_categoria = $_POST['categoria'];
      $select_prioridad = $_POST['prioridad'];

      if(!empty( $input_keywords ) ){

          $id_keyword = $keywords->insert( $input_keywords , $select_prioridad ); 
          $conceptos->doRelation( $id_keyword , $select_categoria );

      }

      
  }

}



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

  <div class="row" style="text-align: left; padding-left:40px;">
    <div class="col-md-2">
     
      <?php include_once('./agenda-televisa-menu.php'); ?>

    </div>
    <div class="col-md-10">
      
      <h3>Añadir keywords de coyontura </h3>
      <hr/>

      <form action="?action=insert" method="post">
        <b>Término:&nbsp;&nbsp;&nbsp;</b>
        <input type="text" name="keyword" size="45" value="">
        <br>
        <b>Categoria:</b>
        <select name="categoria">
          <?php

          
          foreach( $conceptos->getCategoria() as $key => $value){
            echo "<option value='$value'>$key</option>";
          }

          ?>

        </select>
        <br>
        <b>Prioridad:&nbsp;</b>
         <select name="prioridad">
        <?php

        $Prioridad = $keywords->getPrioridad();
        foreach ($Prioridad as $key => $value) {
          echo "<option value='$value'>$key</option>";
        }
        ?>  
        </select>

       
        
        <br><br>
        <input type="submit" value="Agregar">
      </form>

         


      <h3>Listado keywords de coyontura</h3>
      <hr/>

      <?php

        //print_r( $conceptos->getAllItems() );

      ?>


      <table class="table table-hover">
        <thead>
        <tr>
          <th>Término</th>
          <th>Prioridad</th>
          <th>Categoria</th>
          <th>Estatus</th>
          <th>Fecha Ingreso</th>
        </tr>
      </thead>
      <tbody>

        <?php

          foreach ($conceptos->getAllItems() as $key => $value) {

              $id = $value['keyword_id'];
              $arrayKeywords = $keywords->getKeywordById( $id );
              
              $status = ( $arrayKeywords[0]["estatus"] ) ? "Activo" : "- -";

            echo "<tr>
                  <td>".$arrayKeywords[0]["keyword"]."</td>
                  <td>".$keywords->getKeyPrioridadValue( $arrayKeywords[0]["prioridad"] )."</td>
                  <td>".$conceptos->getKeyCategoriaByID( $value['categoria_id'] )."</td>
                  <td>".$status."</td>
                  <td>".date('d-m-Y H:i:s' ,$arrayKeywords[0]["fecha_ingreso"] )."</td>
                </tr>";
            # code...
          
          }

        ?>
      </tbody>

      </table>

    </div>
    
  </div>

</body>
</html>
