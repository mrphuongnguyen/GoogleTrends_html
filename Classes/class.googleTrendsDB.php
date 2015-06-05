<?php
// Incluimos las dependientecias
include_once('class.db.php');

Class dbTrends{

	var $_unix_time;

	function __construct(){

		$this->_unix_time = time();
	}

	// Metodo Insert Terminos
	public function insertTrendsTerms(
		$termino , $descripcion , $link , $fecha_publicacion
	){

		$hoy	= $this->_unix_time;
		$_db 	= new myDBC();
		$_query	= "INSERT INTO trendsTerms (termino,descripcion,link,fecha_publicacion,fecha_reporte) 
					VALUES ('$termino','$descripcion','$link','$fecha_publicacion' , '$hoy');";

		$_db->runQuery($_query);
		return $_db->lastInsertID();

	}


	public function insertTrendsTermsData(
		$term_id ,$posicion , $trafico , $fecha_publicacion , $imagen , $imagen_fuente
	){

		$hoy	= $this->_unix_time;
		$_db 	= new myDBC();
		$_query	= "INSERT INTO trendsTermsData (trendsTerms_id,posicion,trafico,imagen,imagen_fuente, fecha_publicacion , fecha_reporte) 
					VALUES ('$term_id','$posicion','$trafico','$imagen' , '$imagen_fuente', '$fecha_publicacion' ,'$hoy');";

		$_db->runQuery($_query);
		return $_db->lastInsertID();


	}

	public function insertTrendsTermsSource(
		$termData_id , $titulo , $descripcion , $url , $fuente
	){

		$hoy	= $this->_unix_time;
		$_db 	= new myDBC();
		$_query	= "INSERT INTO trendsTermsSource (trendsTermsData_id,titulo,descripcion ,url, fuente , fecha_reporte) 
					VALUES ('$termData_id','$titulo','$descripcion','$url' , '$fuente','$hoy');";

		$_db->runQuery($_query);
		return $_db->lastInsertID();

	}


	public function seachIDByLink( 
		$link 
	){

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select trendsTerms_id FROM trendsTerms WHERE link = '$link';";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return $array_return[0]["trendsTerms_id"];
		}else{

			return false;
		}

	}




}

/*
$bd = new dbTrends();
$last_id_trendsTerms 		= $bd->insertTrendsTerms("termino" , "descripcion" , "mi link","date");
$last_id_trendsTermsData	= $bd->insertTrendsTermsData( $last_id_trendsTerms , "3" , "5000+" , "fecha_publicacion" , "url_image" , "Televisa Deportes");
$last_id_trendsTermsSource	= $bd->insertTrendsTermsSource( $last_id_trendsTermsData , "titulos news" , "descripcion news" , "url_news" , "fuente_news" );
echo "Inser trendsTerms: ".$last_id_trendsTerms;
echo "Insert trendsTermsData: ".$last_id_trendsTermsData;
echo "Insert trendsTermsSource: ".$last_id_trendsTermsSource;

echo "<p>";
echo "Test Search:";
echo $bd->seachIDByLink( 'mi+link2' );
*/



