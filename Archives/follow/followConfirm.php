<?php
session_start();
 // check if logged in through session
 // check if status is still active
if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'active' && isset($_SESSION['id']) && isset($_POST['follower_id']) && isset($_POST['follow_detail'])) {
    include_once("../mysqlconfig_connection.php");
    $follower_user_id = $_SESSION['id'];
    $follower_follow_to_id = $_POST['follow_user_id'];
    
    
}
    


?>