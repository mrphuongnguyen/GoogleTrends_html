<?php

include_once('TwitterUserTimeline.php');
include_once('class.db.php');

class TwitterUserTimelineBD extends TwitterUserTimeline{


	public function insert_db(){


		if( count($this->json_decode) > 1 ){

			$now	= time();
			foreach ($this->json_decode as $key => $value) {
				
				$tweet_id 		= $value->id;
				
				if (! $this->get_by_tweet_id( $tweet_id  ) ){

				
					$text			= $value->text;
					$twitter_user	= $this->query_user;
					$date_id		= $this->get_dateid();
					$fecha_ingreso	= $now;

					$_db 	= new myDBC();
					$_query	= "INSERT INTO twitterTimeline (tweet_id,text,twitter_user,date_id,fecha_ingreso) 
								VALUES ('$tweet_id','$text','$twitter_user','$date_id' , '$fecha_ingreso');";
					$_db->runQuery($_query);
				
				}

				

			}

		}


	}


	public function get_by_tweet_id( $tweet_id ){

		$array_return 	= array();
		$_db 			= new myDBC();
		$_query			= "Select * FROM twitterTimeline WHERE tweet_id = '$tweet_id';";
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



}


$bd = new TwitterUserTimelineBD();
$bd->get_json();
$bd->insert_db();




?>