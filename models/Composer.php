<?php
require_once '\..\php-activerecord\ActiveRecord.php';
/**
 *
 * @property int $id
 * @property string $name
 */
class Composer extends ActiveRecord\Model {
    static $table_name = 'composer';
}