<?php
use Thru\Translation\Translation;
class TranslationTest extends PHPUnit_Framework_TestCase {

	public function setUp(){
		Translation::configure_original_language('en-gb');
		Translation::configure_target_language('fr');
	}
	public function testTranslatePhrase(){
		$input = "Hello.";
		$output = Translation::getInstance()->translate("input");
		// Since there is no language pack, the expected response is "Hello." still.
		$this->assertEquals($input, $output);
	}
}
