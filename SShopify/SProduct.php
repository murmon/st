<?php
require_once "SClient.php";
require_once "ImageHelper.php";

class SProduct
{
    private $shopifyClientInstance = null;

    private $params = array();

    private $images = array();

    const COLLECTION_DEFAULT = 14221745;

    const STATUS_UNSENT = 0;
    const STATUS_SENT = 1;

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

    public static function s_getAll($params)
    {

        $arr = SClient::getInstance()->call('GET', '/admin/products.json', $params);

        return $arr;
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

    public function getId()
    {
        return $this->params['id'];
    }

}
