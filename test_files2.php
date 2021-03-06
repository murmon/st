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

$dirs = array_filter(glob(Track::$search_tracks_in . '*'), 'is_dir');

foreach ($dirs as $dir) {
    $dir_basename = basename($dir);
    $dir_ascii = \Patchwork\Utf8::toAscii($dir_basename);

    echo $dir . " => $dir_ascii <br>";

    if(rename($dir, $dir_ascii)){
        echo $dir . " => $dir_ascii <br>";
    } else {
        echo $dir . " RENAME FAILED <br>";
    }

}

function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
}
die();

Config::getConfig();

$tracks = Track::find('all'/*, array('conditions' => 'id = 1')*/);

$not_found_files = 1;

foreach ($tracks as $track) {
    $full_track_path = Track::$search_tracks_in . stripSpaces($track->composer->name) . DIRECTORY_SEPARATOR . stripSpaces($track->name_ascii) . '.mp3';

    if(!is_file($full_track_path)){
        echo "$full_track_path<br>";
        $not_found_files++;
    }
//    $track->name_ascii = trim($track->name_ascii);
//    $track->save();
}

echo "Missing $not_found_files files";

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