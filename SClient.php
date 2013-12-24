<?php
require 'shopify.php';

class SClient
{
    public static $SHOP_DOMAIN = "4q-organization.myshopify.com";
    public static $PASSWORD = "858679f915c32742cd191ad5e844bf9e";
    public static $API_KEY = "a18a05c75a3548474230d7a456f35cc7";
    public static $SHARED_SECRET = "dc261751d907e4e985dfa510b17c4c41";

    public static $DEFAULT_COLLECTION_ID = 14221745;

    private static $shopifyClientInstance = null;


    public static function getInstance(){
        if(self::$shopifyClientInstance == null){
            self::$shopifyClientInstance = new ShopifyClient(self::$SHOP_DOMAIN, self::$PASSWORD, self::$API_KEY, self::$SHARED_SECRET);
        }

        return self::$shopifyClientInstance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}

