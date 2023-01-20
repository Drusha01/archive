
<?php
session_start();
// check if logged in
// 
if(isset($_SESSION['id']) && isset($_GET['id'])  && $_GET['id'] != $_SESSION['id']){
    include_once("../mysqlconfig_connection.php");
    $user_id = $_GET['id'];
    $result = mysqli_query($dbc, "SELECT user_status_details,user_firstname,user_lastname,user_profile_picture FROM users 
    LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
    WHERE user_id = '$user_id';");
    if($result){
        $res = mysqli_fetch_array($result);
        if (!isset($res['user_status_details']) && $res['user_status_details'] != 'active'){
            header("location:not found");
            die(0);
        }
    }else{
        die(0);
    }
    $storage_used = mysqli_query($dbc, "SELECT SUM(content_size) FROM contents 
    LEFT OUTER JOIN posts ON contents.content_post_id=posts.post_id
    LEFT OUTER JOIN users ON posts.post_user_id=users.user_id
    WHERE user_id =$user_id;");
    $storage_used = mysqli_fetch_array($storage_used);
    
}else if(!isset($_SESSION['id'])){
    header('location:../login/login.php ');
}else if(isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'inactive'){
    header('location:../login/requestadmin.php ');
}else{
    header('location:../login/profile.php ');
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
    <style>
        div.follow{
            padding: 10px;
            background-color: gray;
            width: fit-content;
            position: relative;
            font-size: .5cm;
            left: 690px;
            top: -180px;
            border-radius: 5px;
            color: white;
        }
        a.follow{
            text-decoration: none;
            color: white;
        }
        
    </style>
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
            <a href="#"><img src="../img/profileresize/<?php echo htmlentities($res['user_profile_picture']);?>" alt="" class="profile" width="200px" height="200px"></a>
            <span><?php echo htmlentities($res['user_firstname']) . ' ' . ($res['user_lastname']);?></span>
            
            <a href="#" class="follow">
                
                <?php
                $follower_user_id = $_SESSION['id'];
                $follower_follow_to_id = $_GET['id'];
                $result = mysqli_query($dbc, "SELECT follower_status_details FROM followers
                    LEFT OUTER JOIN follower_status ON followers.follower_follower_status_id = follower_status.follower_status_id
                    WHERE follower_user_id = '$follower_user_id' AND follower_follow_to_id ='$follower_follow_to_id';");

                $res = mysqli_fetch_array($result);
                if(isset($res['follower_status_details']) && $res['follower_status_details'] == 'requested'){
                    echo '<div class="follow" onclick="myfunctionfollow('.$_GET["id"].',\'Cancel\')">';
                    echo htmlentities('Cancel');
                }else if(isset($res['follower_status_details'])&& $res['follower_status_details'] == 'active' ){
                    echo '<div class="follow" onclick="myfunctionconfirm('.$_GET["id"].',\'Unfollow\')">';
                    echo htmlentities('Unfollow');
                }else if(isset($res['follower_status_details'])&& $res['follower_status_details'] == 'deleted')
                {
                    // nothing
                }else{
                    echo '<div class="follow" onclick="myfunctionfollow('.$_GET["id"].',\'Follow\')">';
                    echo htmlentities('Follow');
                }
                ?>
                </div>
            </a>
            
            
        </div>
    </div>
    <div class="profile-padding"></div>
    <div class="followers">
        <img src="../assets/files.png" alt="" width="30px" height="30px">
        <span>Followers:
        <?php 
        $follower_user_id = $_GET['id'];
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
        $follower_user_id = $_GET['id'];
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

<script>
function myfunctionfollow(id,detail){
    console.log(id+':'+detail);
    var http = new XMLHttpRequest();
    http.open("POST", "../follow/follow.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("follow_user_id="+id+"&follow_detail="+detail);
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // change the div
            const follow =  document.querySelector("div.follow");
            if(this.responseText =='Follow'){
                follow.setAttribute('onclick','myfunctionfollow('+id+',\''+this.responseText+'\')');
                follow.innerHTML = this.responseText;
            }else{
                follow.setAttribute('onclick','myfunctionconfirm('+id+',\''+this.responseText+'\')');
                follow.innerHTML = this.responseText;
            }
            
            
        }
    };
}

function myfunctionconfirm(id,detail){
    let text = "Are you sure you want to unfollow?!\n";
  if (confirm(text) == true) {
    myfunctionfollow(id,detail);
  } 
}

</script>