
<?php
session_start();
// check if logged in
if(isset($_SESSION['id'])){

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
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    
<?php
$profile = '-active';
require_once '../includes/navigation.php';
?>
<div class="profile-container">
    <div class="profile-padding"></div>
    <div class="profile-content-container">
        <div class="profile-content">
            <a href="../img/profile/<?php echo $_SESSION['profile_picture'];?>"><img src="../img/profileresize/<?php echo $_SESSION['profile_picture'];?>" alt="" width="200px" height="200px"></a>
            <span><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?></span>
            <div class="posted-number">
                <span>Posted:XXXXXX</span>
            </div>
            <div class="storage-used">
                <span>GB used : XXXXXX</span>
            </div>
            <div class="edit-profile">
                <a href="editprofile.php">Edit Profile</a>
            </div>
            
        </div>
    </div>
    <div class="profile-padding"></div>
</div>

</body>
</html>