<?php

require_once 'php-activerecord/ActiveRecord.php';

class Config
{
    private static $config = array();

    static function getConfig()
    {
        if(empty(self::$config)){
            ActiveRecord\Config::initialize(function ($cfg) {
                $cfg->set_model_directory('models');
                $cfg->set_connections(array('development' =>
                    'mysql://root@localhost/shopify'));
            });
        }
    }


}




