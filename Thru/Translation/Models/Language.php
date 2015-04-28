<?php
namespace Thru\Translation\Models;
use \Thru\ActiveRecord\ActiveRecord;

/**
 * Class translation_language_model
 * @package Thru\Translation\Models
 * @var $language_id INTEGER
 * @var $name string(64)
 * @var $code string(8)
 * @var $completeness INTEGER
 */
class Language extends ActiveRecord{
    protected $_table = "translation_languages";

    public $language_id;
    public $name;
    public $code;
    public $completeness = 0;
}