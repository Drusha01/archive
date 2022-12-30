<?php 
// check if user is logged in 
session_start();

if(isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active'){
    // get the search parameter from get global
    if(isset($_GET['s'])){
        $s = $_GET['s'];
        include_once("../mysqlconfig_connection.php");
        // select from database (limit, 5/10/15/20)
        $result = mysqli_query($dbc, "SELECT user_id, user_name,user_firstname,user_lastname FROM users
        WHERE user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = 'active') AND user_name LIKE '$s%'
        LIMIT 10;");
        if($result){
            // return json format
            print_r(json_encode(mysqli_fetch_All($result)));
        }
    }
}
?>