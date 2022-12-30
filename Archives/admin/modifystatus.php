<?php

// check session
session_start();
if(isset($_SESSION['id'])){
    // get check user if admin else go back to files.php
    include_once("../mysqlconfig_connection.php");
    $result = mysqli_query($dbc, "SELECT user_id FROM users
    WHERE user_type_id = (SELECT user_type_id FROM user_types WHERE user_type_details = 'admin');");
    $result = mysqli_fetch_array($result);
    if($result && $result['user_id'] != $_SESSION['id']){
        header('location:../files/files.php');
    }else if($result && $result['user_id'] == $_SESSION['id']){
        // get action
        $status = $_GET['action'];
        $user_id = $_GET['id'];
        if($status =='activate'){
            $status = 'active';
        }else{
            $status = 'inactive';
        }

        $result = mysqli_query($dbc, "UPDATE users 
        SET user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = '$status')
        WHERE user_id = $user_id;");
        header('location: ../admin/admin.php');
        print_r($_GET);
    }
}else{
    header('location:../login/login.php');
}

?>