<?php 

session_start();
$directory = 'C:/Apache24/htdocs/test/archive/Archives/Archive/';
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
    <title>Files</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/content.css">
</head>
<body>

<?php
$files = '-active';
require_once '../includes/navigation.php';
require_once '../includes/sidebar.php';
?>
<?php
include_once("../mysqlconfig_connection.php");
echo '<div class="content-container">';
echo '<div class="content-container-padding"></div>';
$user_id = $_SESSION['id'];
$result = mysqli_query($dbc,"SELECT post_id,post_title,post_uuid,CAST(post_date_posted AS DATE) AS post_date_posted_date,post_date_updated FROM posts
    WHERE post_user_id = '$user_id' 
    ORDER BY post_date_posted DESC
    LIMIT 20;");
if (mysqli_num_rows($result)>0) {
    while ($res = (mysqli_fetch_array($result))) {
        $post_id = $res['post_id'];
        $dir = $_SESSION['user_email'] . '/' . $res['post_uuid'] . '/'.$res['post_id'].'/';
        echo '  <div class="content-item">
                    <div class="owner">
                        <a href="../login/viewprofile.php?id='.$_SESSION['id'].'"><img src="../img/profileresize/'.$_SESSION['profile_picture'].'" alt="" class="profilepicture">
                        <span>'.$_SESSION['firstname'].' '.$_SESSION['lastname'].'</span><p>'.$res['post_date_posted_date'] .'</p></a>
                        <img src="/../../6zfm6y.jpg" alt="" class="sharedto">
                        <div class="option">
                            <img src="../assets/option.png" alt="" class="option">
                        </div> 
                    </div>
                    <div class="content-item-title">
                        <a href="../post/viewpost.php?id='.$res['post_id'].'"><p>'.$res['post_title'].'</p></a>
                    </div>
                    <div class="content-item-padding"></div>';
        
        $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id';");
        if($result_content){
            //echo '<ul>';
            echo '  <div class="content-file-container">';
            $counter=0;
            while ($res_content = mysqli_fetch_array($result_content)){
                $counter++;
                //echo '<li>' .$res_content['content_id'].' '.$res_content['content_name']. '</li>';
                echo '<img src="../Archive/'.$dir.$res_content["content_name"].'" alt="" width="200" height="200" style="object-fit: cover;">';
                if($counter==1){
                    break;
                }
            }
            echo '  </div>';
            //echo '</ul>';
        }

        echo '
            </div>';


        //echo '<h4>Shared to</h4>';
        $result_targetusers = mysqli_query($dbc, "SELECT user_id,user_email,user_firstname,user_lastname,access_type_details FROM targets
        LEFT OUTER JOIN access_types ON targets.target_access_type_id=access_types.access_type_id
        LEFT OUTER JOIN users ON targets.target_user_id = users.user_id
        WHERE target_post_id ='$post_id';");
        if($result){
            //echo '<ul>';
            // while($res_target = mysqli_fetch_array($result_targetusers)){
            //     //echo '<li>'.$res_target['user_email'].'</li>';
            // }
            //echo '</ul>';
        }
    }
}else{
    echo '<h3>No Archives found</h3>';
}

        

echo '</div>';



//print_r($result);
?>

</body>
</html>