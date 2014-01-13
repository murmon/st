<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>



<?php
//foreach (glob("e:\\projects\\shopify\\classical music\\*") as $filename) {
//    echo "$filename размер " . filesize($filename) . "<br>";
//}
//die();

require 'models\Track.php';
require 'Utf8.php';

Config::getConfig();

$tracks = Track::find('all'/*, array('conditions' => 'id = 1')*/);




$missing_tracks = array();

foreach ($tracks as $track) {
    $full_path = Track::$search_tracks_in . $track->server_path;

    echo $full_path . "<br>";
    $var = \Patchwork\Utf8::toAscii($full_path);
    echo  $var. "<br>";
//    echo "#$track->id " . $full_path;
//
    if(file_exists($full_path)){
        echo " [OK]<br>";
    } else {
        echo " [MISSING]<br>";
        $missing_tracks[] = $track;
    }
    echo "=============================================" . "<br>";
    flush();

}


?>



</body>
</html>