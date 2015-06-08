<?php
// Class enlista todos los elementos
include_once('class.googleTrendsDB.php');
date_default_timezone_set('America/Mexico_City');
header('Content-Type: text/html; charset=utf-8');


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
		echo "<tr><td width='100px'><b>Imagen</b>
			</td><td width='200px'><b>Termino</b></td>
			<td width='200px'><b>Fecha de impresión</b></td>
			<td width='100px'><b>Tráfico</b></td>
			<td width='400'><b>Fuente</b></td></tr>";
		
		$lista = $this->listI();

		foreach ($lista as $key => $value) {

		
			$bdTerms = new dbTrends();
			$trendsTermsData = $bdTerms->getTrendsTermsData( $value["trendsTerms_id"] );
			
			echo "<tr><td><img src='https:".$trendsTermsData[0]["imagen"]."'></td>
				<td><a href='./class.reportHTML.php?termino=".$value["termino"]."'>".$value["termino"]."</a></td>
				<td>".date('d/m/Y H:i:s',$value["fecha_reporte"])."</td>";

			echo "<td>".$trendsTermsData[0]["trafico"]."</td>";

			$trendsSource = $bdTerms->getTrendsTermsSource( $trendsTermsData[0]["trendsTermsData_id"] );

			echo "<td> Fuente: ".$trendsSource[0]["fuente"]."
			<br>URL:<a href='".$trendsSource[0]["url"]."'>".$trendsSource[0]["url"]."</a></td>";

		}


		echo "</tr>";
		echo "</table>";

		//print_r();

	}



}



$list = new listTrendsTerms();
$list->show();

?>
