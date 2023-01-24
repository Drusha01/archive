<?php 
    session_start();
    $directory = 'C:/Apache24/htdocs/test/archive/Archives/Archive/';
    // check if logged in
    if(isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active' && isset($_SESSION['id'])){
        // view post, if the session id == post_user_id  then you can edit. 
    // get post id, session id.
    $post_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    // check for index.
    if(isset($_GET['index'])){
        $index = $_GET['index'];
    }else{
        $index = -1;
    }
    
    // note that post
    include_once("../mysqlconfig_connection.php");

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
            if($index !=-1){
                // check if we have previous
                // check if we have next
                // check the index if it found something
                $index--;
                $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id' AND content_id = '$index';");
                // check num rows
                if($result_content){
                    echo 'wtf';
                    $res_content_prev = mysqli_fetch_array($result_content);
                }else{
                    echo 'wtf';
                }
                $index++;
                $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id' AND content_id = '$index';");
                if($result_content){
                    $res_content = mysqli_fetch_array($result_content);
                }
                $index++;
                $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id' AND content_id = '$index';");
                if($result_content){
                    $res_content_next = mysqli_fetch_array($result_content);
                }

            }else{
                $result_content = mysqli_query($dbc, "SELECT content_id,content_name FROM contents WHERE content_post_id = '$post_id' LIMIT 2;");
                // check num rows
                if ($result_content) {
                    $res_content = mysqli_fetch_array($result_content);
                }else{
                    // page 404
                    
                }
                if ($result_content) {
                    $res_content_next = mysqli_fetch_array($result_content);
                }
                

                
            }
        
            if($result_content){
                print_r(mysqli_fetch_all($result_content));
            }
        }else{
            // page 404
            header("location:not found");
            die(0);
        }
    }

    
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
    <style>
        :root{
    --content-container-width:800px;
    /* note that media will not take effect on this */
}
    .view-content-container{
        margin-left: calc((100vw / 2) - var(--content-container-width) / 2);
    }
    </style>
</head>
<body>
<?php 
require_once '../includes/navigation.php';
require_once '../includes/sidebar.php';
?>

<div class="view-content-container">
    <div class="previous-button">
        <?php 
        if(isset($res_content_prev)){
            echo '<a href="../post/viewpost.php?id='.$post_id.'&index='.$res_content_prev["content_id"].'">prev</a>';
        }
        
        ?>
    </div>
    <div class="next-button">
        <?php 
        if(isset($res_content_next)){
            echo '<a href="../post/viewpost.php?id='.$post_id.'&index='.$res_content_next['content_id'].'">next</a>';
        }
        
        ?>
    </div>
    <div class="content">
        <div class="img"> 
            <?php 
            $dir = $_SESSION['user_email'] . '/' . $res_post['post_uuid'] . '/'.$res_post['post_id'].'/';
            echo '<img src="../Archive/'.$dir.$res_content["content_name"].'" alt="" width="800" height="800" style="object-fit: cover;">'?>
        </div>
    </div>
</div>



<?php





    
?>
</body>
</html>
