<?php
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'php-activerecord' . DIRECTORY_SEPARATOR . 'ActiveRecord.php');

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

    public static $search_tracks_in = 'e:\projects\shopify\classical music\\';
}