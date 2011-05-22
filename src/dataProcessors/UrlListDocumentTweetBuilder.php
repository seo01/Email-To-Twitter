<?php

require_once(dirname(__FILE__)."/iTweetBuilder.php");

class UrlListDocumentTweetBuilder implements iTweetBuilder
{
	
	public function buildTweet($fields)
	{
		$author = $fields['author'];
		$subject = $fields['subject'];
		$links = $fields['links'];
		
		$usedChars = 0;
		$totalChars = 140;
		
		$signiture = "via $author";
		$usedChars += strlen($signiture);
		$linkStr = $this->joinLinks($links,$totalChars-$usedChars);
		$usedChars += strlen($linkStr);
		$subjectTr = $this->truncateStr($subject,$totalChars-$usedChars);
		
		#sanity check
		$tweet = substr($subjectTr.$linkStr.$signiture,0,$totalChars);
		return $tweet;
	}
	
	private function joinLinks($links, $maxLength)
	{
		$linkStr = "";
		foreach($links as $link)
		{
			if((strlen($linkStr)+strlen("$link ")) < $maxLength)
				$linkStr .= "$link ";
			else
				break;
		}
		return $linkStr;
	}
	
	private function truncateStr($str, $maxLength)
	{
		if(strlen($str) < $maxLength-1)
			return "$str ";
		else
			return substr($str,0,$maxLength-4)."... ";
	}
	
}