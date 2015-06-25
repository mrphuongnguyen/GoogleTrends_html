<?php

include_once( 'TwitterTrendsPlaceBD.php' );

$myTrends = new TrendsPlaceBD();
$myTrends->place = "Puebla";
$myTrends->insert_db();

?>