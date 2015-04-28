<?php
use \Thru\Translation\Models\Language;
use \Faker\Generator;

class LanguageTest extends PHPUnit_Framework_TestCase {

	/** @var $_faker Generator */
	private $_faker;

	public function setUp(){
		$this->_faker = Faker\Factory::create();
	}

	public function testCreateLanguage(){
		$newLanguage = new Language();
		$newLanguage->name = "Test " . $this->_faker->languageCode;
		$newLanguage->code = $this->_faker->languageCode;
		$newLanguage->save();

		$this->assertNotNull($newLanguage->language_id);
		$this->assertGreaterThan(0, $newLanguage->language_id);

		return $newLanguage;
	}

	/**
	 * @depends testCreateLanguage
	 */
	public function testLoadLanguge(Language $savedLanguage){
		$loadLanguage = Language::search()->where('language_id', $savedLanguage->language_id)->execOne();
		$this->assertEquals($savedLanguage, $loadLanguage);
	}
}
