<?php
require_once(dirname(__FILE__)."/iEmailReader.php");

class ImapReader implements iEmailReader
{
	private $imapServer;
	private $user;
	private $passwd;
	
	private $mailbox;
	
	public function __construct($imapServer, $user, $psswd)
	{
		$this->imapServer = $imapServer;
		$this->user = $user;
		$this->psswd = $psswd;
	}
	
	public function connect()
	{
		$this->mailbox = imap_open($this->imapServer, $this->user, $this->psswd);
		if(!$this->mailbox)
			throw new Exception('Cannot connect to Mail: '.imap_last_error());
	}
	
	public function getCount()
	{
		return imap_num_msg($this->mailbox);
	}
	
	public function getFrom($index)
	{
		$headers = imap_headerinfo($this->mailbox, $index);
		return $headers->fromaddress;
	}
	
	public function getSubject($index)
	{
		$headers = imap_headerinfo($this->mailbox, $index);
		//probably should imap_qprint the subject!
		return imap_qprint($headers->subject);
	}
	
	public function getBody($index)
	{
		return imap_qprint(imap_body($this->mailbox, $index));
	}
}