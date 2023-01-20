<?php 
session_start();
// check if logged in
if(isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active' && isset($_SESSION['id'])){
    // view post, if the session id == post_user_id  then you can edit. 
// get post id, session id.
$post_id = $_GET['id'];
$user_id = $_SESSION['id'];
if(isset($_GET['index'])){
    $index = $_GET['index'];
}else{
    $index = 0;
}
$index =
// note that post
include_once("../mysqlconfig_connection.php");
// get target types
$result = mysqli_query($dbc, "SELECT target_type_details FROM target_type;");
$res_type = mysqli_fetch_all($result);
echo '<br>';
print_r($res_type);
echo '<br>';

// get the post 
$result = mysqli_query($dbc, "SELECT post_id,post_status_details,post_user_id,user_firstname,user_lastname,user_profile_picture,target_type_details,post_uuid,post_date_posted FROM posts 
LEFT OUTER JOIN users ON posts.post_user_id=users.user_id
LEFT OUTER JOIN target_type ON posts.post_target_type=target_type.target_type_id
LEFT OUTER JOIN post_status ON posts.post_status_id=post_status.post_status_id
WHERE post_id = '$post_id';");
$res_post = mysqli_fetch_array($result);

// check post 

// public
if($res_post['target_type_details'] == 'public'){
    // just show it
    echo 'public :<br>';
    print_r($res_post);
}else if($res_post['target_type_details'] == 'followers'){
    // followers
    echo 'followers :<br>';
    print_r($res_post);
    // query from followers  (post user id and session id )
}else if ($res_post['target_type_details'] == 'followers-except'){
    // followers-except
    echo 'followers-except :<br>';
    print_r($res_post);
    // from inserted queries (refer from add archive)
}else if($res_post['target_type_details'] == 'specific-followers'){
    // specific-followers
    echo 'followers-except :<br>';
    print_r($res_post);
    // from inserted queries (refer from add archive)
}else if($res_post['target_type_details'] == 'only-me'){
    // only me
    
    // dont show, only if (post user id  == session id)
    if($_SESSION['id'] == $res_post['post_user_id']){
        echo 'only me :<br>';
        print_r($res_post);
    }else{
        // page 404
        header("location:not found");
        die(0);
    }
}

// check for index. 
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
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
<?php 
require_once '../includes/navigation.php';
require_once '../includes/sidebar.php';
?>





<?php





    
?>
</body>
</html>
