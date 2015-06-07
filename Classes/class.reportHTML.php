<?php
// Clase encargada de generar un reporte HTML bajo un termino 
header('Content-Type: text/html; charset=utf-8');
include_once('class.db.php');

class reportHTML{

	var $_post_termino;
	var $_title_termino;
	var $_error_pointer 		= false;
	var $_trendsTermID;


	function __construct( $termino ){

		$this->_post_termino = $termino;

	}


	// Metodo para buscar el ID del termino 

	public function getTermsID(){

		if( $this->_post_termino ){

			// Buscamos el id mediante una cosulta a la base de datos

		}else{

			$this->_error_pointer = true;
		}


	}


	public function getTrendsTermID(){


		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select trendsTerms_id FROM trendsTerms WHERE termino = '$this->_post_termino';";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			$this->_trendsTermID = $array_return[0]["trendsTerms_id"];
		}else{

			$this->_trendsTermID = false;
		}

	}


	public function getData(){

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM trendsTerms WHERE trendsTerms_id = '$this->_trendsTermID';";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return  $array_return;
		}else{

			return  0;
		}


	}

	public function getPosition(){

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM trendsTermsData WHERE trendsTerms_id = '$this->_trendsTermID' order by fecha_reporte desc;";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return  $array_return;
		}else{

			return  0;
		}


	}


	public function getSource($id){

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM trendsTermsSource WHERE trendsTermsData_id = '$id' order by fecha_reporte desc;";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return  $array_return;
		}else{

			return  0;
		}


	}



	public function showReport(){

		if( !$this->_error_pointer ){

			
			// Obtenemos el id del termino 
			$this->getTrendsTermID();

			echo "<h2> Termino: '".$this->_post_termino."'</h2>";
			echo "<hr/>";
			
			// Generamos datos
			if($arrayData = $this->getData()){

				//print_r($arrayData);
				echo "Descripcion: ".$arrayData[0]["descripcion"]."<br/>";
				echo "Link: <a href='".$arrayData[0]["link"]."'>".$arrayData[0]["link"]."</a><br/>";
				echo "Fecha publicacion: ".$arrayData[0]["fecha_publicacion"]."<br/>";
				//echo "Fecha reporte: ".date('d/m/Y',$arrayData[0]["fecha_reporte"])."<br/>";

			}

			echo "<hr/>";

			if ( $arrayPosicion = $this->getPosition() ){

				
				foreach( $arrayPosicion as $value ){
					
					echo "Fecha reporte: ".date('d/m/Y H:i:s',$value["fecha_reporte"])."<br/>";
					echo "Posicion: ".$value["posicion"]."<br/>";
					echo "Trafico: ".$value["trafico"]."<br/>";
					

					if ( $array_source = $this->getSource(  $value["trendsTermsData_id"] ) ){


						foreach ($array_source as $key => $valueSource) {
							
							echo "<li> Titulo de la fuente: ".$valueSource["titulo"]."</li>";
							echo "<li> URL: ".$valueSource["url"]."</li>";
							echo "<li> Fuente: ".$valueSource["fuente"]."</li><br/>";


						}


					}



				}

				

			}
			


		}else{

			echo "El termino no existe";
			die();

		}
	} 


}

$termino = $_GET["termino"];

$report = new reportHTML($termino);
$report->showReport();
echo "Listo";

?>