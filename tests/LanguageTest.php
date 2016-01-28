<?php
namespace Thru\Translation\Test;

use Thru\Translation\Translation;
use Thru\Translation\Models\Language;

class LanguageTest extends BaseTest
{

    /**
 * @var $tr Translation
*/
    private $tr;

    public function setUp()
    {
        parent::setUp();
        $this->tr = Translation::getInstance();
        $this->tr->setOriginalLanguage('en');
        $this->tr->setTargetLanguage('fr');
    }

    public function testTranslateEnToFr()
    {
        $this->assertEquals("Bonjour", $this->tr->translate("Hello"));
    }

    public function testTranslateEnToFrParameters()
    {
        $name = $this->faker->firstName();
        $this->assertEquals("Bonjour {$name}", $this->tr->translate("Hello :name", [':name' => $name]));
    }
}
