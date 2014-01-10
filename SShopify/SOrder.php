<?php
require_once "SClient.php";
require "SProduct.php";
require '\..\models\Form.php';
require '\..\models\Counter.php';

class SOrder
{
    private $shopifyClientInstance = null;

    private $params = array();

    function __construct($params = array())
    {
        $this->params = $params;
        $this->shopifyClientInstance = SClient::getInstance();

        ActiveRecord\Config::initialize(function ($cfg) {
            $cfg->set_model_directory('models');
            $cfg->set_connections(array('development' =>
                'mysql://root@localhost/shopify'));
        });
    }

    public function create($params)
    {
    }

    /**
     * @param array $params
     * @return SOrder[]
     */
    public static function listAll($params = array())
    {
        $order_list = SClient::getInstance()->call('GET', '/admin/orders.json', $params);

        $orders = array();

        foreach ($order_list as $order_item) {
            $orders[] = new SOrder($order_item);
        }

        return $orders;
    }

    public function getEmail(){
        return $this->params['email'];
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getProductIds(){
        $products_param ='line_items';

        $products = $this->params[$products_param];

        $ids = array();

        foreach ($products as $product) {
            $ids[] = 199828769;
//            $ids[] = $product['product_id'];
        }

        return $ids;
    }

//    public function confirmProductsSent(){
//        $product_ids = $this->getProductIds();
//
//        foreach ($product_ids as $product_id) {
//            $form = Form::find('first', array('conditions' => 'shopify_product_id = ' . $product_id));
//            if($form){
//                $form->status = SProduct::STATUS_SENT;
//                $form->save();
//            }
//        }
//    }

    public function close(){
        $order_id = $this->params['id'];
        $close_result = $this->shopifyClientInstance->call('POST', "/admin/orders/$order_id/close.json");
        $this->params = $close_result['order'];
    }

    public function getProductAttachments(){
        $product_ids = $this->getProductIds();

        $productAttachments = array();

        foreach ($product_ids as $product_id) {
            $form = Form::find('first', array('conditions' => 'shopify_product_id = ' . $product_id));
            if($form){
                $productAttachments[] = $form->form_file_path;
            }
        }
        return $productAttachments;
    }

    public function sendMail(){
        require '\..\PHPMailer\PHPMailerAutoload.php';

        $mail = new PHPMailer;
//        $mail->From = 'noreply@4Q-organidation.com';
        $mail->From = 'noreply@dev-test.ankors.ru';
        $mail->FromName = '4Q-organidation';
        $mail->addAddress($this->getEmail());

        foreach ($this->getProductAttachments() as $attachment_path) {
            $mail->addAttachment($attachment_path . '.pdf');
        }

        $mail->Subject = 'Product purchase';
        $mail->Body = 'Thank you for purchasing order!<br>Here is your attachment.';
        $mail->AltBody = 'Thank you for purchasing order!Here is your attachment.';

        if(!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }

        Counter::incEmailsCount();

        //$this->confirmProductsSent();
        $this->close();

        echo 'ok';
    }
}
