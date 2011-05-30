<?php

require_once(dirname(__FILE__)."/../../dataProcessors/FromFieldToAuthorConverter.php");

class FromFieldToAuthorConverterTest extends PHPUnit_Framework_TestCase
{
	
	/**
	* @dataProvider provider
	*/
	public function testConvertUnknownAddress($fftac)
	{
		$author = $fftac->convert("Unknown Person <unknown@other.com>");
		$this->assertEquals($author,"unknown@other.com");
	}
	
	public function provider()
	{
		$fftac = new FromFieldToAuthorConverter
			(
				array(
					"andrew@example.com"=>"@andrew",
					"ben@example.com"=>"@blahpro",
					"chris@example.com"=>"@chris"
				),
				array(
					"example.com"
				)
			);
		
		return array(
			array($fftac)
			);
	}
}