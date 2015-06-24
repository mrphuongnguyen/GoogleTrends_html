<?php

include_once( 'class.conceptos.php' );
include_once( 'class.db.php' );


Class KeywordsRelation extends Concepto{



	public function doRelation(  
		$keywords_id , $categoria_id

		){

		$hoy 		= time();
		$_db 		= new myDBC();
		$_query	= "INSERT INTO keywordsRelation (agenda_id , keyword_id , type_id , categoria_id , fecha_ingreso) 
					VALUES ('$this->_agenda_id','$keywords_id','$this->_concepto_id','$categoria_id' , '$hoy');";

		//print_r($_query);
		$_db->runQuery($_query);
		return $_db->lastInsertID();

	}


	public function getAllItems(){


		$_db 			= new myDBC();
		$_query			= "Select * FROM keywordsRelation WHERE agenda_id = '$this->_agenda_id' AND type_id = '$this->_concepto_id' order by fecha_ingreso desc ;";
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



}


?>