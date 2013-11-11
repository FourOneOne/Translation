<?php
namespace FourOneOne\Translation;

class Translation
{
    static private $instance;

    static public function getInstance(){
        if(!self::$instance instanceof Translation){
            self::$instance = new Translation();
        }
        return self::$instance;
    }

    public function translate($string){
        return $string;
    }
}

function t($string){
    return Translation::getInstance()->translate($string);
}