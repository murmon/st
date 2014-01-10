<?php
require 'SShopify\SProduct.php';

require 'models\Form.php';

ActiveRecord\Config::initialize(function ($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array('development' =>
        'mysql://root@localhost/shopify'));
});

$last_id = -1;


$form = Form::find('first', array('conditions' => array('id = ?', 346)));

$images = json_decode($form->images_path);

$i = 0;;

foreach ($images as $ii) {
    $i++;
}


var_dump($images);
var_dump($i);
$t = 0;
