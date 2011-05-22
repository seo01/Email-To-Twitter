<?php

require_once(dirname(__FILE__)."/iTweetWriter.php");

class FileTweetWriter implements iTweetWriter
{
	
	private $fileName;
	private $dateFlag;
	
	public function __construct($fileName,$dateFlag)
	{
		$this->fileName = $fileName;
		$this->dateFlag = $dateFlag;
		if($this->dateFlag)
			date_default_timezone_set('UTC');
	}
	
	public function writeTweet($tweet)
	{
		$fh = fopen($this->fileName, "a");
    	if($fh==false) throw new Exception("unable to open/create file");
		$line = $tweet;
		if($this->dateFlag)
			$line .= "\t".date(DATE_ISO8601);
    	fputs ($fh, "$line\n");
		fclose($fh);
	}
}