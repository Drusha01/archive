<?php
session_start();
// check if logged in
if(isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active' && isset($_SESSION['id'])){
    // echo $_SESSION['id'];
    // echo '<br>';
    // echo $_SESSION['username'];
    // echo '<br>';
    // echo $_SESSION['firstname'];
    // echo '<br>';
    // echo $_SESSION['lastname'];
    // echo '<br>';
    
    // echo ' files';
    
    // echo 'add files';
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
    <title>Shared With Me</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/content.css">
</head>
<body>
<?php
$sharedwithme = '-active';
require_once '../includes/navigation.php';
require_once '../includes/sidebar.php';
?>
<?php 



include_once("../mysqlconfig_connection.php");
$target_user_id = $_SESSION['id'];
$result = mysqli_query($dbc, "SELECT target_id,target_post_id,post_status_id,user_email,post_title,CAST(post_date_posted AS DATE) AS post_date_posted_date,post_date_updated
FROM targets 
LEFT OUTER JOIN posts ON targets.target_post_id = posts.post_id
LEFT OUTER JOIN users ON posts.post_user_id = users.user_id
WHERE target_user_id ='$target_user_id'
ORDER BY post_date_posted DESC;");
echo '<div class="content-container">';
echo '  <div class="content-container-padding"></div>';
if(mysqli_num_rows($result)>0){
    while($res = mysqli_fetch_array($result)){
        echo '
            <div class="content-item">
                <div class="owner">
                    <a href="#profile"><img src="/../../6zfm6y.jpg" alt="" class="profilepicture">
                    <span>'.$_SESSION['firstname'].' '.$_SESSION['lastname'].'</span><p>'.$res['post_date_posted_date'] .'</p></a>
                    <img src="/../../6zfm6y.jpg" alt="" class="sharedto">
                    <div class="option">
                        <img src="/../../6zfm6y.jpg" alt="" class="option">
                    </div>
                </div>
                <div class="content-item-title">
                    <a href="#title"><p>'.$res['post_title'].'</p></a>
                </div>
                <div class="content-item-padding"></div>';
        $post_id = $res['target_post_id'];
        $dir = $res['user_email'] . '/' . $res['post_date_posted_date'] . '/'.$res['post_title'].'/';

        $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id';");
        if($result_content){
            echo '  
                <div class="content-file-container">';
            //echo '<ul>';
            while ($res_content = mysqli_fetch_array($result_content)){
                //echo '<li>' .$res_content['content_id'].' '.$res_content['content_name']. '</li>';
                echo '<img src="../Archive/'.$dir.$res_content["content_name"].'" alt="" width="200" height="200" style="object-fit: cover;">';
                break;
            }
            //echo '</ul>';
            echo ' 
                </div>';
        }
        echo '
            </div>';
    }
   
}else{
    echo '<h4>No files shared</h4>';
}

echo '</div>';
?>

</body>
</html>
