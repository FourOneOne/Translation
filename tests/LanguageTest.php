<?php
use Thru\Translation\Translation;
use Thru\Translation\Models\Language;

class LanguageTest extends PHPUnit_Framework_TestCase {

  /** @var $tr Translation */
  private $tr;

  public function setUp(){
    $this->tr = Translation::getInstance();
    $this->tr->configure_original_language('en');
    $this->tr->configure_target_language('fr');
    return;
  }

  public function testTranslateEnToFr(){
    $this->assertEquals("bonjour", strtolower($this->tr->translate("Hello")));
  }
}
