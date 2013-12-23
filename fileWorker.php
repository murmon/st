<?php

class fileWorker
{
    public $ROOT_DIRECTORY = 'd:\result\\';
    public $FIRST_COUNT = 50;

    public $root_di = null;

    function __construct()
    {
        $this->root_di = new RecursiveDirectoryIterator($this->ROOT_DIRECTORY, RecursiveDirectoryIterator::SKIP_DOTS);
    }


    public function echoFiles()
    {
        $this->tst();
        return;

        $categories_dir = $this->getDirectories($this->ROOT_DIRECTORY);

        $arr = array();

        foreach ($categories_dir as $categorie_dir) {
            $categorie_subdirs = $this->getDirectories($categorie_dir . DIRECTORY_SEPARATOR);

            $product_images = array();
            foreach ($categorie_subdirs as $product_dir) {
                $images = $this->getFiles($product_dir);

                $product_dir_base = $this->getBaseName($product_dir);
                $product_dir_base_no_thumb = $this->delThumb($product_dir_base);

                $product_images[$product_dir_base_no_thumb] = $images;
            }

            $categorie_dir_base = $this->getBaseName($categorie_dir);

            $arr[$categorie_dir_base] = $product_images;
            break;
            self::vardump($arr);
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
            $file_contents = file_get_contents($dir . DIRECTORY_SEPARATOR.$filename);
            $b64_encoded = base64_encode($file_contents);
            echo $b64_encoded;
            $array[] = $b64_encoded;
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
        $res = substr($name, $stringpos+1);

        return $res;
    }

    private function delThumb($name)
    {
        $stringpos = strrpos($name, "_thumb");
        $res = substr($name, 0, $stringpos);

        $res = ucwords(strtolower($res));

        return $res;
    }

    public function tst(){
        $a = 'd:\result\application\AGREEMENT BETWEEN CARRIERS_thumbs\(2).jpg';
        $a_contents = file_get_contents($a);
        $bd = base64_encode($a_contents);

        echo $bd;
    }
}




