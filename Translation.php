<?php
namespace Thru\Translation;

class Translation
{
    static private $instance;

    static public function getInstance(){
        if(!self::$instance instanceof Translation){
            self::$instance = new Translation();
        }
        return self::$instance;
    }

    public function translate($string, $replacements = array()){

        // Swap in the variables
        foreach($replacements as $key => $value){
            $string = str_replace($key, $value, $string);
        }

        // Return translated contents.
        return $string;
    }
}

function t($string, $replacements = array()){
    return Translation::getInstance()->translate($string, $replacements);
}