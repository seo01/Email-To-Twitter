<?php

require_once(dirname(__FILE__)."/iTweetWriter.php");

class StdoutTweetWriter implements iTweetWriter
{
	public function writeTweet($tweet)
	{
		echo "$tweet\n";
	}
}