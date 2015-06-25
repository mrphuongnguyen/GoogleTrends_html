<?php

require_once('TwitterAPIExchange.php');

class TwitterUserTimeline {


	var $consumer_key		= "ytmKDBxK6d5oKyI3t4wEtkjWO";
	var $consumer_secret	= "XQHELr3dT4M9eY0p3eCEwikTZiNTclNvo2DupwbSQ1qB8cUI0T";
	var $url_api			= "https://api.twitter.com/1.1/statuses/user_timeline.json";	
	var $twitter_user 		= array(
							"@AristeguiOnline",
							"@MundoNarco",
							"@SinEmbargoMX",
							"@Milenio",
							"@PedroFerriz"
							);

	var $total_results		= 10;
	var $query_user;
	var $json_buffer;
	var $json_decode;


	public function __construct(){

		$this->query_user = "@alarcon_00mx";

	}

	public function get_query_string(){

		$user = str_replace("@", "" , $this->query_user);
		return "?screen_name=".$user."&count=".$this->total_results;

	}


	public function get_json(){

		$settings = array(
		    'oauth_access_token' => "",
		    'oauth_access_token_secret' => "",
		    'consumer_key' => $this->consumer_key,
		    'consumer_secret' => $this->consumer_secret
		);


		$url 			= $this->url_api;
		$getfield 		= $this->get_query_string();
		$requestMethod 	= 'GET';
		$twitter = new TwitterAPIExchange($settings);
		
		$this->json_buffer = $twitter->setGetfield($getfield)
		             ->buildOauth($url, $requestMethod)
		             ->performRequest();

		$this->json_decode = $this->get_json_decode();


	}

	public function get_dateid(){

		return date('dmY',time());
	}

	public function get_users(){

		return $this->twitter_user;
	}


	public function get_json_decode(){

		return json_decode( $this->json_buffer );
	}


	public function get_error(){

		if( isset( $this->json_decode->error ) ){

			return true;
		}else{

			return false;
		}

	}


	public function get_profile_info(){

		
		if ( !$this->get_error() ){

			return $this->json_decode[0]->user;
		
		}

		

	}



}
/*
$userTimeline = new TwitterUserTimeline();
$userTimeline->get_json();
// Cabecera
$userTimeline->get_profile_info();

*/

?>