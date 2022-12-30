<?php 
header('Content-Type: image/jpeg');
$file = $_GET['img'];
$imgname = $_GET['img'];
$img = imagecreatefromjpeg($imgname);;

imagejpeg($img);
imagedestroy($img);


?>