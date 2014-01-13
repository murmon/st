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

Config::getConfig();

$tracks = Track::find('all'/*, array('conditions' => 'id = 1')*/);

foreach ($tracks as $track) {
    if(strpos($track->file, '%') !== FALSE){

        $full_track_path = Track::$search_tracks_in . stripSpaces($track->composer->name) . DIRECTORY_SEPARATOR . stripSpaces($track->name_ascii) . '.mp3';

        $stream = file_get_contents($track->file);
        $bytes = file_put_contents($full_track_path, $stream);
        echo "Downloaded #$track->id " . humanFileSize($bytes, 'MB') . " @ " . date("d.m.Y H:i:s" , time()) . "<br>";
    }
//    $track->name_ascii = trim($track->name_ascii);
//    $track->save();
}

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