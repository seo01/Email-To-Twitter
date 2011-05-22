<?php

class FromFieldToAuthorConverter
{
	
	private $knownAddresses;
	private $knownDomains;
	
	private $emailRegex = '/([^\s<>]+@)([^\s<>]+)/';
	
	
	public function __construct($knownAddresses = Array(), $knownDomains = Array())
	{
		$this->knownAddresses = $knownAddresses;
		$this->knownDomains = $knownDomains;
	}
	
	public function convert($fromField)
	{
		$matches = Array();
    	if(!preg_match($this->emailRegex, $fromField, $matches))
			return $fromField;
		$email = $matches[0];
		$user = $matches[1];
		$domain = $matches[2];
		if(array_key_exists($email,$this->knownAddresses))
			return $this->knownAddresses[$email];
		elseif(in_array($domain,$this->knownDomains))
			return $user;
		else
			return $email;
	}
	
}