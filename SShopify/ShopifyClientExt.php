<?php
require_once '/../shopify.php';

class ShopifyClientExt extends ShopifyClient{

    public function call($method, $path, $params=array())
    {
        //prevent to overflow call limit
        if(!$this->callsLeft()){
            sleep(2);
        }
        parent::call($method, $path, $params);
    }
}