<?php

class ImageHelper
{
    public static function file2base64($src)
    {
        $img_contents = file_get_contents($src);
        $img_base64 = base64_encode($img_contents);
        return $img_base64;
    }
}
