<?php
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'php-activerecord' . DIRECTORY_SEPARATOR . 'ActiveRecord.php');
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php');

/**
 *
 * @property int $id
 * @property int $id_composer
 * @property string $name
 * @property string $server_path
 */
class Track extends ActiveRecord\Model
{
    static $table_name = 'track';

    static $belongs_to = array(
        array('composer', 'class_name' => 'Composer', 'foreign_key' => 'id_composer')
    );

    public static $search_tracks_in = '/home/freespace/classicalmusic/';
}