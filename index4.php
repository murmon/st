<?php
require 'SShopify\SOrder.php';

$paid_orders = SOrder::listAll(array(
    'status' => 'opened',
    'financial_status' => 'paid',
));

foreach ($paid_orders as $paid_order) {
    $paid_order->sendMail();
}

var_dump($paid_orders);
