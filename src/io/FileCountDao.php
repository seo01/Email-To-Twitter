<?php

require_once(dirname(__FILE__)."/iCount.php");

class FileCountDao implements iCount
{

	private $fileName;
	
	public function __construct($fileName)
	{
		$this->fileName = $fileName; 
	}
	
	public function getCount()
	{
		if (!file_exists($this->fileName))
		{
			return 0;
    	}
		else
		{
			$lines = file($this->fileName);
			return $lines[0];
		}
	}
	
	public function setCount($count)
	{
		$fh = fopen($this->fileName, "w");
    	if($fh==false) throw new Exception("unable to create file");
    	fputs ($fh, $count);
		fclose($fh);
	}
	
}