<?php

require_once(dirname(__FILE__)."/iLinkExtractor.php");

class SimpleRegexLinkExtractor implements iLinkExtractor
{
	
	private $linkRegex = '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\-.]*(\?\S+)?)?)?)@';
	private $linkExclusionList;
	
	public function __construct($linkExclusionList = Array())
	{
		$this->linkExclusionList = $linkExclusionList; 
	}
	
	public function extractLinks($text)
	{
		$matches = Array();
    	preg_match_all($this->linkRegex, $text, $matches);
    	$links = Array();
		foreach($matches[0] as $link)
    	{
			if(!$this->isLinkInExclusionList($link))
        		$links[] = $link;
    	}
		$links = array_unique($links);
		return $links;
	}
	
	private function isLinkInExclusionList($link)
	{
		foreach($this->linkExclusionList as $excludeLink)
			if(strpos($link,$excludeLink) === 0)
				return true;
		return false;
	}
}