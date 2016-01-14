<?php
namespace Thru\Translation\Models;

use \Thru\ActiveRecord\ActiveRecord;

/**
 * Class translation_original_model
 * @package Thru\Translation\Models
 * @var $original_id INTEGER
 * @var $language_id INTEGER
 * @var $value TEXT
 * @var $created_at DATETIME
 */
class PhraseOriginal extends ActiveRecord
{
    protected $_table = "translation_originals";
    public $original_id;
    public $language_id;
    public $value;
    public $created_at;
}
