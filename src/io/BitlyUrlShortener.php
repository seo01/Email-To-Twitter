<?php

require_once(dirname(__FILE__)."/iUrlShortener.php");
require_once(dirname(__FILE__)."/../thirdParty/bitly.php");

class BitlyUrlShortener implements iUrlShortener
{
	
	private $login;
	private $appKey;
	
	public function __construct($login, $appKey)
	{
		$this->login = $login;
		$this->appKey = $appKey;
	}
	
	public function shorten($url)
	{
		return make_bitly_url($url,$this->login,$this->appKey,'json'); 
	}
	
	public function shortenAll($urls)
	{
		$shorts = Array();
		foreach($urls as $url)
			$shorts[] = $this->shorten($url);
		return $shorts;
	}
	
}
