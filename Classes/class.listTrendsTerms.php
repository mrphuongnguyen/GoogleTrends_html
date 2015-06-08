<?php
// Class enlista todos los elementos
include_once('class.googleTrendsDB.php');
date_default_timezone_set('America/Mexico_City');
header('Content-Type: text/html; charset=utf-8');


class listTrendsTerms{

	public function listI(
	 $limit = false

	){	

		$limit_sentence = ($limit)? 'limit 100' : '';

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM trendsTerms order by fecha_reporte desc $limit_sentence ;";
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
		echo "<tr><td width='180px'><b>Fecha de publicación</b>
			</td><td width='300px'><b>Termino de búsqueda</b></td>
			<td width='180px'><b>Volúmen de búsqueda</b></td>
			<td width='100px'><b>Mejor página de destino según Google</b></td>";
		
		$lista = $this->listI(true);

		foreach ($lista as $key => $value) {

		
			$bdTerms = new dbTrends();
			$trendsTermsData = $bdTerms->getTrendsTermsData( $value["trendsTerms_id"] );
			
			$residuo = $key % 2 ;
			if( $residuo == 0){

				$color = "#ffffff";
			}else{

				$color = "e2e2e2";
			}

			echo "
			<tr bgcolor='$color'><td>".date('d/m/Y H:i:s',$value["fecha_reporte"])."</td>
			<td><a href='./class.reportHTML.php?termino=".$value["termino"]."'>".$value["termino"]."</a></td>
			<td>".$trendsTermsData[0]["trafico"]."</td>";

			$trendsSource = $bdTerms->getTrendsTermsSource( $trendsTermsData[0]["trendsTermsData_id"] );

			echo "<td>";

			for($i=0; $i < count( $trendsSource ); $i++){

				echo "
				Fuente: <b>".$trendsSource[ $i ]["fuente"]." </b>
				<br/>URL:<a href='".$trendsSource[ $i ]["url"]."'>".$trendsSource[ $i ]["titulo"]."</a>
				<br/>";
			}

			echo "</td>";

		}


		echo "</tr>";
		echo "</table>";

	}



}



$list = new listTrendsTerms();
$list->show();

?>
