<?php

require_once('TwitterAPIExchange.php');


Class TrendsPlace{


	var $consumer_key		= "ytmKDBxK6d5oKyI3t4wEtkjWO";
	var $consumer_secret	= "XQHELr3dT4M9eY0p3eCEwikTZiNTclNvo2DupwbSQ1qB8cUI0T";	
	var $woeid = array(
							"Mexico-DF" 	=> 116545,
							"Guadalajara"	=> 124162,
							"Monterrey"		=> 134047,
							"Puebla" 		=> 137612,
							"Queretaro" 	=> 138045,
							"Merida"		=> 133327,
							"Morelia"		=> 134091,
							"San-Luis"		=> 144265,
							"Toluca"		=> 149769,
							"Tijuana" 		=>149361);
	var $place;
	var $json_buffer;


	public function __construct(){

		$this->place = "Mexico-DF";

	}


	public function get_json(){

		$settings = array(
		    'oauth_access_token' => "",
		    'oauth_access_token_secret' => "",
		    'consumer_key' => $this->consumer_key,
		    'consumer_secret' => $this->consumer_secret
		);


		$url = 'https://api.twitter.com/1.1/trends/place.json';
		$getfield = '?id='.$this->woeid[$this->place];
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$this->json_buffer = $twitter->setGetfield($getfield)
		             ->buildOauth($url, $requestMethod)
		             ->performRequest();

		

	}


	public function get_woeid(){

		return $this->woeid[$this->place];
	}


	public function get_dateid(){

		return date('dmY',time());
	}

	public function get_places(){

		return $this->woeid;
	}






}

/*
$myTrends = new TrendsPlace();
$myTrends->place = "Monterrey";
$myTrends->get_json();
print_r( json_decode( $myTrends->json_buffer ) );
echo $myTrends->get_woeid();
*/

?>