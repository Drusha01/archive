
<?php
session_start();
// check if logged in
if(isset($_SESSION['id'])){
    include_once("../mysqlconfig_connection.php");
    $user_id = $_SESSION['id'];
    $storage_used = mysqli_query($dbc, "SELECT SUM(content_size) FROM contents 
    LEFT OUTER JOIN posts ON contents.content_post_id=posts.post_id
    LEFT OUTER JOIN users ON posts.post_user_id=users.user_id
    WHERE user_id = '$user_id';");
    $storage_used = mysqli_fetch_array($storage_used);
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
    <title>Profile</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    
<?php
$profile = '-active';
require_once '../includes/navigation.php';
require_once('../includes/sidebar.php');
?>
<div class="profile-container">
    <div class="profile-padding"></div>
    <div class="profile-content-container">
        <div class="profile-content">
            <a href="../img/profile/<?php echo $_SESSION['profile_picture'];?>"><img src="../img/profileresize/<?php echo $_SESSION['profile_picture'];?>" alt="" class="profile" width="200px" height="200px"></a>
            <span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?></span>
            <div class="posted-number">
                <span>Posted:XXXXXX</span>
            </div>
            <div class="storage-used">
                <span>Usage :<?php  echo round($storage_used['SUM(content_size)']/1024/1024/1000,3)?> GB</span>
            </div>
            <div class="edit-profile">
                <a href="editprofile.php">Edit Profile</a>
            </div>
            
        </div>
    </div>
    <div class="profile-padding"></div>
    <div class="followers">
        <img src="../assets/files.png" alt="" width="30px" height="30px">
        <span>Followers:
        <?php 
        $follower_user_id = $_SESSION['id'];
        $result = mysqli_query($dbc, "SELECT COUNT(follower_id) as num_of_followers FROM followers
            WHERE follower_follow_to_id = '$follower_user_id' AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active');");

        $res = mysqli_fetch_array($result);
        echo htmlentities($res['num_of_followers']);
        ?>

        </span>
    </div>
    <div class="following">
        <img src="../assets//files.png" class="asset" alt="" width="30px" height="30px">
        <span>Following:
        <?php 
        $follower_user_id = $_SESSION['id'];
        $result = mysqli_query($dbc, "SELECT COUNT(follower_id) as num_of_following FROM followers
            WHERE follower_user_id = '$follower_user_id' AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active');");

        $res = mysqli_fetch_array($result);
        echo htmlentities($res['num_of_following']);
        ?>
        </span>
    </div>
    <div class="joined">
    <img src="../assets/files.png" alt="" class="asset" width="30px" height="30px">
        <span>Joined:232 months</span>
    </div>
    <div class="usage">
        <img src="../assets/files.png" alt="" class="asset" width="30px" height="30px">
        <span>Usage:<?php  echo round($storage_used['SUM(content_size)']/1024/1024/1000,3)?>GB</span>
    </div>
</div>

</body>
</html>