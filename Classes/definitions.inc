<?php
// Definciiones
if ( $_SERVER['SERVER_NAME'] == 'googletrends.dev' ){
	// Desarrollo
	define("BD_USER", "root");
	define("BD_PASSWORD", "");
	define("BD_NAME", "dbTrends");
	define("BD_SERVER", "localhost");
}else{

	// Producción 
	define("BD_USER", "root");
	define("BD_PASSWORD", "AAKBgQCtNFZpXIDoab00ce0BeVe5Jqjgc+");
	define("BD_NAME", "dbTrends");
	define("BD_SERVER", "localhost");

}