<?php
require "SProduct.php";

$p1 = new SProduct();
$p1->prepareImage("img1.png")
    ->prepareImage("img2.jpg")
    ->create(array(
    'title' => 'test pr 1',
    'body_html' => 'test pr 1 descr',
    "product_type" => "Form",
));

var_dump($p1->getParams());

echo "======================";
var_dump(SClient::getInstance()->callsMade());
var_dump(SClient::getInstance()->callsLeft());
var_dump(SClient::getInstance()->callLimit());
echo "======================";