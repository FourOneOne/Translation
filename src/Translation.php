<?php
namespace Thru\Translation;

use Commando\Command;
use Stichoza\GoogleTranslate\TranslateClient;
use Thru\Translation\Models\Language as translation_language_model;
use Thru\Translation\Models\Language;
use Thru\Translation\Models\PhraseOriginal as translation_original_model;
use Thru\Translation\Models\PhraseOriginal;
use Thru\Translation\Models\PhraseReplacement as translation_replacement_model;
use Thru\Translation\Models\PhraseReplacement;

class Translation
{
    static private $original_language = "en-gb";
    static private $target_language = null;
    static private $instance;

    static public function getInstance()
    {
        if(!self::$instance instanceof Translation) {
            self::$instance = new Translation();
        }
        return self::$instance;
    }

    static public function configure_original_language($language_code)
    {
        self::$original_language = $language_code;
        return true;
    }

    static public function configure_target_language($language_code)
    {
        self::$target_language = $language_code;
        return true;
    }

    public function translate($string, $replacements = array())
    {

        if(self::$target_language !== null && self::$original_language != self::$target_language) {
            $originalLanguage = translation_language_model::search()->where('code', self::$original_language)->execOne();
            if(!$originalLanguage) {
                $originalLanguage = new translation_language_model();
                $originalLanguage->code = self::$original_language;
                $originalLanguage->completeness = 0;
                $originalLanguage->name = "Untitled Language " . self::$original_language;
                $originalLanguage->save();
            }
            $targetLanguage = translation_language_model::search()->where('code', self::$target_language)->execOne();
            if(!$targetLanguage) {
                $targetLanguage = new translation_language_model();
                $targetLanguage->code = self::$target_language;
                $targetLanguage->completeness = 0;
                $targetLanguage->name = "Untitled Language " . self::$target_language;
                $targetLanguage->save();
            }
            if($targetLanguage->language_id != $originalLanguage->language_id) {
                $originalPhrase = translation_original_model::search()->where('value', $string)->execOne();
                if (!$originalPhrase) {
                    $originalPhrase = new translation_original_model();
                    $originalPhrase->value = $string;
                    $originalPhrase->created_at = date("Y-m-d H:i:s");
                    $originalPhrase->language_id = $originalLanguage->language_id;
                    $originalPhrase->save();
                }
                $translatedPhrase = translation_replacement_model::search()->where('language_id', $targetLanguage->language_id)->where('original_id', $originalPhrase->original_id)->execOne();
                if (!$translatedPhrase) {
                    $translatedPhrase = new translation_replacement_model();
                    $translatedPhrase->original_id = $originalPhrase->original_id;
                    $translatedPhrase->value = $string;
                    $translatedPhrase->created_at = date("Y-m-d H:i:s");
                    $translatedPhrase->language_id = $targetLanguage->language_id;
                    $translatedPhrase->is_translated = "No";
                    $translatedPhrase->save();
                }
                $string = $translatedPhrase->value;
            }
        }

        // Swap in the variables
        foreach($replacements as $key => $value){
            $string = str_replace($key, $value, $string);
        }

        // Return translated contents.
        return $string;
    }

    static public function FetchFromGoogle()
    {
        $trans_command = new Command();
        $trans_command->option('i')
            ->aka('in')
            ->describedAs("Input Language")
            ->required()
            ->default("en");
        $trans_command->option('o')
            ->aka('out')
            ->describedAs("Output Language");

        echo "Translate from {$trans_command['in']} to " . (isset($trans_command['out'])?$trans_command['out'] : 'all') . "\n";

        $tr = new TranslateClient();
        $tr->setSource($trans_command['in']);
        $tr->setTarget($trans_command['out']);
        $langauges = Language::search()->exec();
        $untranslated_phrases = PhraseReplacement::search()->where('is_translated', 'No')->exec();
        foreach($untranslated_phrases as $i => $phrase){
            /* @var $phrase PhraseReplacement */
            /* @var $original PhraseOriginal */
            /* @var $langauge Language */
            $langauge = $langauges[$phrase->language_id];
            $translator = $tr->setTarget($langauge->code);
            $original = PhraseOriginal::search()->where('original_id', $phrase->original_id)->execOne();
            $output = $translator->translate($original->value);
            $phrase->value = $output;
            $phrase->is_translated = "Yes";
            $phrase->save();
        }
    }
}

function t($string, $replacements = array())
{
    return Translation::getInstance()->translate($string, $replacements);
}