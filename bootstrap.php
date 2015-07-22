<?php

require_once "vendor/autoload.php";

$database = new \Thru\ActiveRecord\DatabaseLayer(
    array(
    'db_type'     => 'Mysql',
    'db_hostname' => 'localhost',
    'db_port'     => '3306',
    'db_username' => 'travis',
    'db_password' => 'travis',
    'db_database' => 'translations_test'
    )
);

