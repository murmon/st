<?php
require "SClient.php";
require "ImageHelper.php";

class SProduct
{
    private $shopifyClientInstance = null;

    private $params = array();

    private $images = array();

    const COLLECTION_DEFAULT = 14221745;

    function __construct()
    {
        $this->shopifyClientInstance = SClient::getInstance();
    }

    public function create($params)
    {
        if(isset($this->images)){
            $params['images'] = $this->images;
        }

        $this->params = $this->shopifyClientInstance->call('POST', '/admin/products.json', array(
                'product' => $params
            )
        );

        $this->bindCategory();
    }


    /*
     * Add image to product. It will be used during product creation
     */
    public function prepareImage($path)
    {
        $base64 = ImageHelper::file2base64($path);
        $this->images[] = array(
            'attachment' => $base64
        );
        return $this;
    }

    public function bindCategory($collection_id = self::COLLECTION_DEFAULT)
    {
        if(!isset($this->params['id'])){
            throw new Exception('Binding empty product to category');
        }

        $category_binding = $this->shopifyClientInstance->call('POST', '/admin/collects.json', array(
                'collect' => array(
                    'product_id' => $this->params['id'],
                    'collection_id' => $collection_id,
                )
            )
        );
        return $category_binding;
    }


    public function getParams()
    {
        return $this->params;
    }
}
