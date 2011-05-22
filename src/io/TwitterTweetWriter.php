<?php

require_once(dirname(__FILE__)."/iTweetWriter.php");
require_once(dirname(__FILE__)."/../thirdParty/twitteroauth/twitteroauth.php");

class TwitterTweetWriter implements iTweetWriter
{
	
	private $twitter;
	
	public function __construct($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret)
	{
		$this->twitter = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
	}
	
	public function writeTweet($tweet)
	{
		$this->twitter->post('statuses/update', array('status' => "$tweet"));
	}
}