<?php
// Class enlista todos los elementos
include_once('class.db.php');


class listTrendsTerms{

	public function listI(){	

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM trendsTerms order by fecha_reporte desc;";
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

	public function show(){

		echo "<table>";
		echo "<tr><td width='200px'><b>Fecha</b></td><td width='400'><b>Termino</b></td>";
		
		$lista = $this->listI();

		foreach ($lista as $key => $value) {
			//print_r($value);

			echo "<tr><td width='300px'>".$value["fecha_publicacion"]."</td><td width='400'><a href='./class.reportHTML.php?termino=".$value["termino"]."'>".$value["termino"]."</a></td>";
		}


		echo "<tr>";
		echo "</table>";

		//print_r();

	}



}



$list = new listTrendsTerms();
$list->show();

?>
