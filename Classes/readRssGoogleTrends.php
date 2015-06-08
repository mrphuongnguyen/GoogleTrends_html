<?php
// Este archivo sera el encargado de ejectura el cron
header('Content-Type: text/html; charset=utf-8');
include_once('class.googleTrendsDB.php');
include_once('class.googleTrendsApi.php');


// Nos conectamos a la Api de Google Trends y obtenemos todos los elementos
$googleTrends = new GoogleTrendsApi();
$googleTrends->getAllItems();
$pointer_date = 0;
$posicionTrends = 0;
for ($i = 0; $i < $googleTrends->totalItemsInFeed(); $i++){

	
	// Seleccionamos el index
	$googleTrends->selectItem( $i );

	// Establecemos la posicion del registro
	$date 			= $googleTrends->getpubDate(true);
	if ($date != $pointer_date){

		$posicionTrends = 1;
		$pointer_date 	= $date;

	}else{

		//$posicionTrends = $posicionTrends + 1;
	}

		
	// Manipulamos los elementos dbTermino
	$title 			= $googleTrends->getTitle();
	$description	= $googleTrends->getDescription();
	$link			= $googleTrends->getLink();
	$fechaPub		= $googleTrends->getpubDate();
	

	// Funciones para hacer inserts en la BD
	// 1.- Verificamos si existe el registro de la Base de datos
	// ****** Proceso BD *********
	$bd = new dbTrends();

	//
	if( !$trendsTrems_id = $bd->seachIDByLink( $link ) ){

		$last_id_trendsTerms = $bd->insertTrendsTerms( $title , $description , $link , $fechaPub);		

	}else{

		$last_id_trendsTerms = $trendsTrems_id;

		// Actualizamos el campo descripcion
		$bd->updateDescription( $description , $last_id_trendsTerms );


	}

	echo $title."<br/>";
	echo $description."<br/>";
	echo "<a href='".$link."'>".$link."</a><br/>";
	echo $date."<br/>";
	echo $fechaPub."<br/>";

	// 2.- Insertamos la data del termino
	// ****** Proceso BD *********

	echo "<b>Posicion ".$posicionTrends."</b><br/>";
	
	$traffic 		= $googleTrends->gethtApproxTraffic();
	$fechaPub		= $googleTrends->getpubDate();
	$image_url		= $googleTrends->gethtPicture();
	$image_source	= $googleTrends->gethtPictureSource();

	echo "<b>Tráfico: $traffic</b><br/>";
	$last_id_trendsTermsData	= $bd->insertTrendsTermsData( 	$last_id_trendsTerms , 
																$posicionTrends , 
																$traffic , 
																$fechaPub , 
																$image_url , 
																$image_source);


	// 3.- Insertamos la realcion de fuentes
	$googleTrends->selectNewsItem(0);

	$source_title 			= $googleTrends->gethtNewsItemTitle();
	$source_description		= $googleTrends->gethtNewsItemSnippet();
	$source_url				= $googleTrends->gethtNewsItemURL();
	$source_name			= $googleTrends->gethtNewsItemSource();

	/*
	$last_id_trendsTermsSource	= $bd->insertTrendsTermsSource( $last_id_trendsTermsData ,
																 $source_title , 
																 $source_description , 
																 $source_url , 
																 $source_name );*/

	$last_id_trendsTermsSource	= $bd->insertTrendsTermsSource( $last_id_trendsTermsData ,
																 "$source_title" , 
																 "source_description" , 
																 "$source_url" , 
																 "$source_name");


	echo "<br>Fuente:<br/>";
	echo $last_id_trendsTermsSource.'<br>';
	echo "<li>Titulo:".$source_title."</li>";
	echo "<li>Descripcion:".$source_description."</li>";
	echo "<li>URL:".$source_url."</li>";
	echo "<li>Fuente News:".$source_name."</li>";

	$googleTrends->selectNewsItem(1);
	$title2 = $googleTrends->gethtNewsItemTitle();
	if(!empty( $title2 )){

	
		$source_title 			= $googleTrends->gethtNewsItemTitle();
		$source_description		= $googleTrends->gethtNewsItemSnippet();
		$source_url				= $googleTrends->gethtNewsItemURL();
		$source_name			= $googleTrends->gethtNewsItemSource();

		$last_id_trendsTermsSource	= $bd->insertTrendsTermsSource( $last_id_trendsTermsData ,
																	 $source_title , 
																	 $source_description , 
																	 $source_url , 
																	 $source_name );


	echo "<br>Fuente:<br/>";
	echo "<li>Titulo:".$googleTrends->gethtNewsItemTitle()."</li>";
	echo "<li>Descripcion:".$googleTrends->gethtNewsItemSnippet()."</li>";
	echo "<li>URL:".$googleTrends->gethtNewsItemURL()."</li>";
	echo "<li>Fuente News:".$googleTrends->gethtNewsItemSource()."</li>";

	}

	

	echo "<hr/>";

	$posicionTrends ++;

}

/*

$xml->selectItem(0);

$title 	= $xml->getTitle();
$fecha	= $xml->getpubDate();
$trafic = $xml->gethtApproxTraffic();
echo $trafic.'<br/>';

$xml->selectNewsItem(0);
echo $xml->gethtNewsItemTitle()."<br/>";
echo $xml->gethtNewsItemSnippet()."<br/>";
*/
?>