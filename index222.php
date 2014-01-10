<?php
require 'SShopify\SProduct.php';

require 'models\Form.php';

ActiveRecord\Config::initialize(function ($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array('development' =>
        'mysql://root@localhost/shopify'));
});

$last_id = -1;

do {
    $s_products = SProduct::s_getAll($last_id != -1 ? array(
        'since_id' => $last_id
    ) : array());

    echo 'Found s_#' . count($s_products) . '<br>';
    flush();

    foreach ($s_products as $s_product) {
        $last_id = $s_product['id'];
        SClient::getInstance()->call('GET', "/admin/products/$last_id.json");

        echo 's_#' . $last_id . ' DELETED <br>';
        flush();
    }
} while (!empty($s_products));
