<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>



<?php
require 'models\Track.php';
require 'Utf8.php';

Config::getConfig();

$tracks = Track::find('all'/*, array('conditions' => 'id = 1')*/);

foreach ($tracks as $track) {

}


?>



</body>
</html>