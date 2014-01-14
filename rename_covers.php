<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>



<?php
require 'models'.DIRECTORY_SEPARATOR.'Track.php';
require 'Utf8.php';

$covers = array_filter(glob('e:\projects\shopify\covers\\' . '*.jpg'), 'is_file');
$failed = array();

foreach ($covers as $cover) {
    $cover_ascii = \Patchwork\Utf8::toAscii($cover);

    if(rename($cover, $cover_ascii)){
        echo $cover . " => $cover_ascii <br>";
    } else {
        echo $cover . " RENAME FAILED <br>";
        $failed[] = $cover;
    }
}

echo "=========================<br>";
echo "FAILED" . count($failed) ." <br>";

function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
}
die();

function humanFileSize($size, $unit = "")
{
    if ((!$unit && $size >= 1 << 30) || $unit == "GB")
        return number_format($size / (1 << 30), 2) . "GB";
    if ((!$unit && $size >= 1 << 20) || $unit == "MB")
        return number_format($size / (1 << 20), 2) . "MB";
    if ((!$unit && $size >= 1 << 10) || $unit == "KB")
        return number_format($size / (1 << 10), 2) . "KB";
    return number_format($size) . " bytes";
}

function stripSpaces($str)
{
    return str_replace(' ', '_', $str);
}


?>



</body>
</html>