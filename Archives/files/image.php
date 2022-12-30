<?php

header("Content-type: image/png");
$file = $_GET['img'];
$size= filesize($file);
header("Content-Length: $size bytes");
imagecreatefromjpeg($file);
?>