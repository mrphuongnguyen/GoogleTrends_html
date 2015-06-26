<?php

include_once( 'TwitterTrendsPlace.php' );
include_once('class.db.php');



Class TrendsPlaceBD extends TrendsPlace{



	public function insert_db(){

		$this->get_json();
		$json = json_decode( $this->json_buffer );		
		$trends = $json[0]->trends;

		$hoy = time();

		foreach ($trends as $key => $value) {

			$twitter_name 	= $value->name;
			$twitter_query	= $value->query;
			$twitter_url	= $value->url;
			$woeid_id		= $this->get_woeid();
			$date_id		= $this->get_dateid();

			

			
			if(! $this->find_tweet_today( $twitter_name ) ){

				echo $twitter_name."<br/>";

				$_db 	= new myDBC();
				$_query	= "INSERT INTO twitterTerms (woeid_id , twitter_name , twitter_query , twitter_url , date_id , fecha_ingreso) 
						VALUES ('$woeid_id','$twitter_name','$twitter_query','$twitter_url' , '$date_id','$hoy');";

				$_db->runQuery($_query);
			}
			
			
		}


	}


	public function find_tweet_today( $tweet ){

		$woeid_id		= $this->get_woeid();
		$date_id		= $this->get_dateid();

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM twitterTerms WHERE twitter_name = '$tweet' AND woeid_id = '$woeid_id' AND date_id = '$date_id';";
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


	public function get_tweets_today( ){

		$woeid_id		= $this->get_woeid();
		$date_id		= $this->get_dateid();

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM twitterTerms WHERE woeid_id = '$woeid_id' AND date_id = '$date_id' Order by fecha_ingreso desc;";
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


	public function find_tweets_dateid( $date_id ){


		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM twitterTerms WHERE date_id = '$date_id' Order by fecha_ingreso DESC;";
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


	public function get_trends_by_dateid( $date_id ){

		$array_terms = array();
		$array_return = array();
		$array = $this->find_tweets_dateid( $date_id );

		// Obtenemos primero los terminos únicos
		if(count($array) > 1 ){
			foreach ($array as $key => $value) {

				$array_terms[] = $value["twitter_name"]."<br/>";
				
			}

			$unique = array_unique($array_terms);


			foreach ($unique as $key => $value) {

				$array_return[] = $array[ $key ];
				# code...
			}
		}

		return $array_return;

	}





}

/*
$insert = new TrendsPlaceBD();
$insert->place = "Queretaro";

//$insert->get_json();
//print_r( json_decode( $insert->json_buffer ) );

//echo "<hr/>";
//$insert->insert_db();
//print_r($insert->find_tweet_today( '#MujeresPoderosas' ));

print_r( $insert->get_tweets_today() );
*/
?>