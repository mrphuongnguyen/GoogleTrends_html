<?php

include_once( 'TwitterTrendsPlaceBD.php' );

$myTrends = new TrendsPlaceBD();
$myTrends->place = "Monterrey";
$myTrends->insert_db();

?>