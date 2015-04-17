<?php
namespace Thru\Translation\Models;
use \Thru\ActiveRecord\ActiveRecord;

/**
 * Class translation_original_model
 * @package Thru\Translation\Models
 * @var $translation_id INTEGER
 * @var $original_id INTEGER
 * @var $language_id INTEGER
 * @var $value TEXT
 * @var $created_at DATETIME
 * @var $is_translated ENUM("Yes","No");
 */
class PhraseReplacement extends ActiveRecord{
    protected $_table = "translation_replacements";
    public $translation_id;
    public $original_id;
    public $language_id;
    public $value;
    public $created_at;
    public $is_translated = "No";
}