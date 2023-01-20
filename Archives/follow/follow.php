<?php
session_start();
 // check if logged in through session
 // check if status is still active

if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'active' && isset($_SESSION['id']) && isset($_POST['follow_user_id']) && isset($_POST['follow_detail'])) {
    include_once("../mysqlconfig_connection.php");
    $follower_user_id = $_SESSION['id'];
    $follower_follow_to_id = $_POST['follow_user_id'];
    $follow_detail = $_POST['follow_detail'];
    
    if($follow_detail == 'Confirm' || $follow_detail == 'Delete' ){
        $follower_user_id = $_POST['follow_user_id'];
        $follower_follow_to_id = $_SESSION['id'];
    }
    // check if we have inserted a stuff in a table, if so dont insert
    $result = mysqli_query($dbc, "SELECT follower_status_details FROM followers
    LEFT OUTER JOIN follower_status ON followers.follower_follower_status_id = follower_status.follower_status_id
    WHERE follower_user_id = '$follower_user_id' AND follower_follow_to_id ='$follower_follow_to_id';");

    $res = mysqli_fetch_array($result);
    if(!isset($res['follower_status_details']) &&  $follow_detail == 'Follow'){
        // insert to follow table
        $result = mysqli_query($dbc, "INSERT INTO followers VALUES
        (
            null,
            $follower_user_id,
            $follower_follow_to_id,
            (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active'),
            now()
        );");
        if($result){
            echo htmlentities("Unfollow");
        }
    }else if(isset($res['follower_status_details']) && $res['follower_status_details'] == 'requested' && $follow_detail == 'Confirm' && isset($_POST['follower_id'])){
        
        $follower_id = $_POST['follower_id'];
        $result = mysqli_query($dbc, "UPDATE followers 
        SET follower_follower_status_id= (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active')
        WHERE follower_id = $follower_id;");
        if($result){
            echo htmlentities('Following');
        }
    }else if(isset($res['follower_status_details']) && $res['follower_status_details'] == 'requested' && $follow_detail == 'Delete' && isset($_POST['follower_id'])){
        
        $follower_id = $_POST['follower_id'];
        $result = mysqli_query($dbc, "UPDATE followers 
        SET follower_follower_status_id= (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'deleted')
        WHERE follower_id = $follower_id;");
        if($result){
            echo htmlentities('Deleted');
        }
    }else{
        // check if it is cancel
        $follow_detail = $_POST['follow_detail'];
        if($follow_detail == 'Cancel' || $follow_detail == 'Unfollow'){
            $result = mysqli_query($dbc, "DELETE FROM followers WHERE follower_user_id = '$follower_user_id' AND follower_follow_to_id = '$follower_follow_to_id';");
            if($result){
                echo htmlentities("Follow");
            }
        }
    }


    

    // create notification 
}
    


?>