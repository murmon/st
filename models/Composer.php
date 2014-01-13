<?php
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'php-activerecord' . DIRECTORY_SEPARATOR . 'ActiveRecord.php');
/**
 *
 * @property int $id
 * @property string $name
 */
class Composer extends ActiveRecord\Model {
    static $table_name = 'composer';
}