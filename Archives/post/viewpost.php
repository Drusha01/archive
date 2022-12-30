<?php 
session_start();
// check if logged in
if(isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active' && isset($_SESSION['id'])){
    echo $_SESSION['id'];
    echo '<br>';
    echo $_SESSION['username'];
    echo '<br>';
    echo $_SESSION['firstname'];
    echo '<br>';
    echo $_SESSION['lastname'];
    echo '<br>';
    
    echo ' files';
    
    echo 'add files';
}else if(!isset($_SESSION['id'])){
    header('location:../login/login.php ');
}else if(isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'inactive'){
    header('location:../login/requestadmin.php ');
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View post</title>
</head>
<body>
<?php 
require_once '../includes/navigation.php';
?>

<h4>View post</h4>

<div class="container">
    <div class="header">
        <h4>DATE</h4>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="nice">
        <h5>Shared with</h5>
        <div class="box" width="200px" heigth="200px">
            <div class="item">Hanrickson</div>
            <div class="item">Hanrickson</div>
            <div class="item">Hanrickson</div>
        </div>
    </div>
    <h4>Content</h4>
    <div class="content-container">
        <img src="../Archive/Hanrickson9/2023-12-22/nice/1_2_IMG20210106154013.jpg" alt="" width="200" height="200" style="object-fit: cover;">
        <img src="../Archive/Hanrickson9/2023-12-22/nice/1_2_IMG20210106154013.jpg" alt="" width="200" height="200" style="object-fit: cover;">
        <img src="../Archive/Hanrickson9/2023-12-22/nice/1_2_IMG20210106154013.jpg" alt="" width="200" height="200" style="object-fit: cover;">
        <img src="../Archive/Hanrickson9/2023-12-22/nice/1_2_IMG20210106154013.jpg" alt="" width="200" height="200" style="object-fit: cover;">
    </div>
</div>

<?php
if(isset($_GET['id'])){
    $post_id = $_GET['id'];
    $user_id = $_SESSION['id'];
    include_once("../mysqlconfig_connection.php");
    $result = mysqli_query($dbc, "SELECT post_id,post_title,CAST(post_date_posted AS DATE) AS post_date_posted,post_date_updated FROM posts
    WHERE post_id = '$post_id' AND post_user_id = '$user_id';");
    if(mysqli_num_rows($result)>0){
        $res = mysqli_fetch_array($result);
        $dir = $_SESSION['username'] . '/' . $res['post_date_posted'] . '/'.$res['post_title'].'/';
        echo ' <h3>' . $res['post_date_posted'] . ' <a href="../post/viewpost.php?id='.$res['post_id'].'">' . $res['post_title'] . '</a></h3>';
        echo '<h4>Content</h4>';

        $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id';");
        if($result_content){
            echo '<ul>';
            while ($res_content = mysqli_fetch_array($result_content)){
                //echo '<li>' .$res_content['content_id'].' '.$res_content['content_name']. '</li>';
                echo '<img src="../Archive/'.$dir.$res_content["content_name"].'" alt="" width="200" height="200" style="object-fit: cover;">';
            }
            echo '</ul>';
        }


        echo '<h4>Shared to</h4>';
        $result_targetusers = mysqli_query($dbc, "SELECT user_id,user_name,user_firstname,user_lastname,access_type_details FROM targets
        LEFT OUTER JOIN access_types ON targets.target_access_type_id=access_types.access_type_id
        LEFT OUTER JOIN users ON targets.target_user_id = users.user_id
        WHERE target_post_id ='$post_id';");
        if($result){
            echo '<ul>';
            while($res_target = mysqli_fetch_array($result_targetusers)){
                echo '<li>'.$res_target['user_name'].'</li>';
            }
            echo '</ul>';
        }
    }
} 


    
?>
</body>
</html>

post id, title, target