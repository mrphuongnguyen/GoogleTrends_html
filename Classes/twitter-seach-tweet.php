<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "ytmKDBxK6d5oKyI3t4wEtkjWO",
    'consumer_secret' => "XQHELr3dT4M9eY0p3eCEwikTZiNTclNvo2DupwbSQ1qB8cUI0T"
);

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=AristeguiOnline&count=10';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$twitter_result = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();


print_r( json_decode($twitter_result) );