<?php

require_once(dirname(__FILE__)."/config/config.php");
require_once(dirname(__FILE__)."/io/ImapReader.php");
require_once(dirname(__FILE__)."/io/FileCountDao.php");
require_once(dirname(__FILE__)."/io/StdoutTweetWriter.php");
require_once(dirname(__FILE__)."/io/BitlyUrlShortener.php");
require_once(dirname(__FILE__)."/io/FileTweetWriter.php");
require_once(dirname(__FILE__)."/io/TwitterTweetWriter.php");
require_once(dirname(__FILE__)."/dataProcessors/SimpleRegexLinkExtractor.php");
require_once(dirname(__FILE__)."/dataProcessors/FromFieldToAuthorConverter.php");
require_once(dirname(__FILE__)."/dataProcessors/UrlListDocumentTweetBuilder.php");

#setup
$emailReader = new ImapReader($imapServer, $imapUser, $imapPsswd);
$emailReader->connect();
$countDao = new FileCountDao($countFile);
$tweetWriters = Array();
$tweetWriters[] = new StdoutTweetWriter();
$tweetWriters[] = new FileTweetWriter($tweetFileName,true);
$tweetWriters[] = new TwitterTweetWriter($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);
$urlShortener = new BitlyUrlShortener($bitlyUser,$bitlyKey);
$linkExtractor = new SimpleRegexLinkExtractor($linkExclusionList);
$authorConverter = new FromFieldToAuthorConverter($knownAddresses,$knownDomains);
$tweetBuilder = new UrlListDocumentTweetBuilder();

#core loop
$current = $countDao->getCount();
$max = $emailReader->getCount();
for(; $current <= $max; $current++)
{
	$subject = $emailReader->getSubject($current);
	$links = $urlShortener->shortenAll
		(
			$linkExtractor->extractLinks($emailReader->getBody($current))
		);
	$author = $authorConverter->convert($emailReader->getFrom($current));
	$tweet = $tweetBuilder->buildTweet(
			Array("author"=>$author,"subject"=>$subject,"links"=>$links)
		);
	foreach($tweetWriters as $tweetWriter)
		$tweetWriter->writeTweet($tweet);
}
	
$countDao->setCount($current);