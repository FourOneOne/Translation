Translation Library
=====================

Support multi-lingual in YOUR application! :D

Install like so:
````
composer require "thru.io/translation": "dev-master"
````

Setup like so:
````
use \Thru\Translation\Translation;
Translation::configure_original_language('en-gb');
Translation::configure_target_language('fr'); 
````
    
You will note you are responsible for deciding what the target language will be! Be that browser-detection or user-agent sniffing or giving the user a language selection or whatever.

The helper function ````t()```` is provided.

Then translate with tokens like so:
````
<?=t("Hello, :name, how are you?", [":name" => "Bob"]); ?>
````
