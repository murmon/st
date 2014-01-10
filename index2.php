<?php
require 'SShopify\SProduct.php';

require 'models\Form.php';

ActiveRecord\Config::initialize(function ($cfg) {
    $cfg->set_model_directory('models');
    $cfg->set_connections(array('development' =>
        'mysql://root@localhost/shopify'));
});

$forms = Form::find('all', array('conditions' => array('shopify_product_id IS NULL')));

$count = 0;
foreach ($forms as $form) {
    $images = json_decode($form->images_path);

    $p1 = new SProduct();
    foreach ($images as $image) {
        $p1->prepareImage($image);
    }

    $p1->create(array(
            'title' => $form->form_name,
//            'body_html' => 'test pr 1 descr',
            "product_type" => "Legal form",
            "tags" => $form->category,
            "variants" => array(
                array(
                    'option1' => 'Buy on CD',
                    'price' => 4.99
                ),
                array(
                    'option1' => 'Buy on DVD',
                    'price' => 4.99
                ),
                array(
                    'option1' => 'Buy on Blu-Ray',
                    'price' => 4.99
                ),
                array(
                    'option1' => 'Digital download',
                    'price' => 4.99
                )
            ),
        ));

    $form->shopify_product_id = $p1->getId();
    $form->save();

    $count++;
    echo "#$form->id saved with s_id #$form->shopify_product_id in category [$form->category] @ " . date("d.m.Y H:i", time()) ." COUNT $count<br>";

    flush();
}
echo "================ done @ " . date("d.m.Y H:i", time()) . " ======================";


//$p1 = new SProduct();
//$p1->prepareImage("img1.png")
//    ->prepareImage("img2.jpg")
//    ->create(array(
//    'title' => 'test pr 1',
//    'body_html' => 'test pr 1 descr',
//    "product_type" => "Form",
//    "tags" => "RealEstate",
//));
//
//var_dump($p1->getParams());
//
//echo "======================";
//var_dump(SClient::getInstance()->callsMade());
//var_dump(SClient::getInstance()->callsLeft());
//var_dump(SClient::getInstance()->callLimit());
//echo "======================";