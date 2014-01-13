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
//                    'mysql://root@localhost/classic'));
                    'mysql://boom:QAred2vuTON1W5X6N1vIkI4O6O74mE@10.10.10.10/classic?charset=utf8'));
            });
        }
    }


}




