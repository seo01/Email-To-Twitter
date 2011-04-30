<?php

interface iEmailReader
{
	public function connect();
	public function getCount();
	
	#per e-mail functions
	public function getFrom($index);
	public function getSubject($index);
  	public function getBody($index);
}