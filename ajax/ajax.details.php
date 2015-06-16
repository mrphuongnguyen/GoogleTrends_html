<?php
include_once("./../Classes/class.reportHTML.php");
date_default_timezone_set('America/Mexico_City');
$termino = $_GET["termino"];
$report = new reportHTML($termino);
$report->showReport();

?>