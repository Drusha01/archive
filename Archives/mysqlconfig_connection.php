<?php 
    DEFINE('DB_USER','root');
    DEFINE('DB_PASSWORD','Uwat09hanz');
    DEFINE('DB_HOST','localhost');
    DEFINE('DB_NAME','Archives');

    $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR dies('Could not coonect to MySQL: '. mysqli_connect_error());

?>