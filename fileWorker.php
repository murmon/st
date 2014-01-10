<?php

require_once 'php-activerecord/ActiveRecord.php';

class fileWorker
{
    public $ROOT_DIRECTORY = 'd:\result\\';

    public $FIRST_COUNT = 40;

    public $root_di = null;

    function __construct()
    {
        $this->root_di = new RecursiveDirectoryIterator($this->ROOT_DIRECTORY, RecursiveDirectoryIterator::SKIP_DOTS);

        ActiveRecord\Config::initialize(function ($cfg) {
            $cfg->set_model_directory('models');
            $cfg->set_connections(array('development' =>
                'mysql://root@localhost/shopify'));
        });
    }


    public function echoFiles()
    {
        $categories_dir = $this->getDirectories($this->ROOT_DIRECTORY);

        $arr = array();

        foreach ($categories_dir as $category_dir) {
            $category_subdirs = $this->getDirectories($category_dir . DIRECTORY_SEPARATOR);
            $category_name = $this->getBaseName($category_dir);

            $product_images = array();
            foreach ($category_subdirs as $product_dir) {
                if (!$this->FIRST_COUNT) {
                    //break;
                }

                $images_path = $this->getFiles($product_dir);

                $product_dir_base = $this->getBaseName($product_dir);
                $product_dir_base_no_thumb = $this->delThumb($product_dir_base);

                $product_images[$product_dir_base_no_thumb] = $images_path;

                $form = new Form();
                $form->category = $category_name;
                $form->form_name = $product_dir_base_no_thumb;
                $form->form_file_path = $category_dir . DIRECTORY_SEPARATOR . $product_dir_base;
                $form->images_path = json_encode($images_path);
                $form->save(false);

                $this->FIRST_COUNT--;
            }

            $arr[$category_name] = $product_images;
        }

        self::vardump($arr);
    }

    private function getDirectories($dir)
    {
        $directories = glob($dir . '*', GLOB_ONLYDIR);
        return $directories;
    }

    private function getFiles($dir)
    {
        $iterator = new \GlobIterator($dir . '/*.jpg', FilesystemIterator::KEY_AS_FILENAME);

        $array = array();
        foreach ($iterator as $filename => $val) {
            $array[] = $dir . DIRECTORY_SEPARATOR . $filename;
        }

        return $array;
    }

    public static function vardump($obj)
    {
        echo "<pre>";
        var_dump($obj);
        echo "</pre>";
    }

    private function getBaseName($name)
    {
        $stringpos = strrpos($name, DIRECTORY_SEPARATOR);
        $res = substr($name, $stringpos + 1);

        return $res;
    }

    private function delThumb($name)
    {
        $stringpos = strrpos($name, "_thumb");
        $res = substr($name, 0, $stringpos);

        $res = ucwords(strtolower($res));

        return $res;
    }
}




