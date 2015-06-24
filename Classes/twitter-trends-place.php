<?php

include_once( 'TwitterTrendsPlaceBD.php' );

$myTrends = new TrendsPlaceBD();

$_place 	= $myTrends->get_places();

foreach ($_place as $key => $value) {
	
	$myTrends->place = $key;
	$myTrends->insert_db();

}

?>