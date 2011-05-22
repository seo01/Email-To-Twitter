<?php

interface iUrlShortener
{
	public function shorten($url);
	public function shortenAll($urls);
}