<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>



<?php
require 'models\Track.php';
Config::getConfig();

$tracks = Track::find('all', array('conditions' => 'server_path NOT LIKE "%.mp3"'));

echo "#######" . count($tracks) . "} <br>";

foreach ($tracks as $track) {
    $full_path = Track::$search_tracks_in . $track->server_path;
    $track_name_stripped = str_replace(' ', '_', $track->name);
    $composer_name_stripped = str_replace(' ', '_', $track->composer->name);

    $track->server_path = "$composer_name_stripped / $track_name_stripped.mp3";
    $track->save();

//    echo "#$track->id $full_path <br>";
    echo "#$track->id $composer_name_stripped / $track_name_stripped.mp3<br>";

//    $stripped_name =

    flush();
}

?>



</body>
</html>