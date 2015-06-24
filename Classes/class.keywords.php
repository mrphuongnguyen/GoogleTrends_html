<?php
include_once('class.db.php');


Class Keywords{


	var $_unix_time;
	var $_prioridad = array(

							"baja" => 0 , 
							"media" => 1 , 
							"alta"	=> 3,
							"muy alta" => 4

							);

	function __construct(){

		$this->_unix_time = time();

	}

	
	public function parseKeyword( $keyword ){

		return trim ( strtolower ( $keyword ) );

	}


	public function insert (
		$keyword , $prioridad = 0 , $status = 1 

	){

		// Verificamos si existe el keyword
		if ( $keyword_id = $this->getIdByKeyword( $keyword ) ){

			return $keyword_id;

		}else{

			// En caso de que no exista generamos un insert
			$keyword 	= $this->parseKeyword( $keyword );
			$hoy		= $this->_unix_time;
			$_db 		= new myDBC();
			$_query	= "INSERT INTO keywords (keyword,prioridad,estatus,fecha_ingreso) 
						VALUES ('$keyword','$prioridad','$status','$hoy');";

			//print_r($_query);
			$_db->runQuery($_query);
			return $_db->lastInsertID();

		}

	}


	public function getIdByKeyword( $keyword ){

		$keyword 		= $this->parseKeyword( $keyword );
		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select keyword_id FROM keywords WHERE keyword = '$keyword';";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return $array_return[0]["keyword_id"];
		}else{

			return false;
		}

	}



	public function getKeywordById( $id ){

		$keyword 		= $this->parseKeyword( $keyword );
		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM keywords WHERE keyword_id = '$id';";
		$_result 		= $_db->runQuery($_query);
		
		if(isset( $_result )){
			while( $row = mysqli_fetch_assoc(  $_result ) ){
				
				$array_return[] = $row;
				
			}
			
		}

		if( count( $array_return ) > 0 ){

			return $array_return;
		}else{

			return false;
		}

	}


	public function getPrioridad(){

		return $this->_prioridad;

	}


	public function getKeyPrioridadValue( $value_insert ){

		foreach ($this->_prioridad  as $key => $value) {
			
			if( $value_insert == $value ){
				return $key;

				break;
			}


		}


	}



}


?>