<?php

session_start();


// check if logged in
if(isset($_SESSION['id'])){
    if(isset($_POST['firstname']) && isset($_POST['lastname'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $imageName = 0;

        if(strlen($firstname) > 0 && strlen($lastname)>0){
            include_once("../mysqlconfig_connection.php");
            $user_id  = $_SESSION['id'];
            // update profile
            if($_FILES['file']['size'] > 500 && $_FILES['file']['size'] < 26214400){
                $length=(strlen($_FILES['file']['name']));
                $length2 = $length;
                $ext;
                while($length--){
                    if ($_FILES['file']['name'][$length] == '.'){
                        $ext = substr($_FILES['file']['name'],$length-$length2+1);
                        break;
                    }
                }
                $type= array('png','bmp','jpg');
                foreach($type as $value){
                    if($ext== $value){
                        $dir = dirname(__DIR__, 1).'/img/profile';
                        $resizedir = dirname(__DIR__, 1).'/img/profileresize';
                        if ( !$dir) {
                            mkdir($dir);       
                        }
                        if ( !$resizedir) {
                            mkdir($resizedir);       
                        }
                        
                        
                        // select old photo and delete.
                        $result = mysqli_query($dbc,"SELECT user_profile_picture FROM users
                        WHERE user_id = '$user_id';");
                        $result = mysqli_fetch_array($result);
                        if($result['user_profile_picture']){
                            // delete
                            try {
                                unlink($dir.'/'.$result['user_profile_picture']);
                            } catch (Exception $e) {        // do something for this
                            }
                            try {
                                unlink($resizedir.'/'.$result['user_profile_picture']);
                            } catch (Exception $e) {        // do something for this
                            }                   
                        }
                        // check if null 
                        $imageName = $_SESSION['id'].'_'.md5($_FILES['file']['name']).'.jpg';
                        $newFileName = $dir.'/'.$imageName;
                        $newFileNameResize = $resizedir.'/'.$imageName;
                        //move_uploaded_file($_FILES['file']['tmp_name'], $newFileName);
                        switch($value){
                            case 'png':
                                $img = imagecreatefrompng($_FILES['file']['tmp_name']);
                                // convert jpeg
                                imagejpeg($img,$newFileName,100);
                                 break;
                            case 'bmp':
                                $img = imagecreatefrompng($_FILES['file']['tmp_name']);
                                // convert jpeg
                                imagejpeg($img,$newFileName,100);
                                break;
                            case 'jpg':
                                move_uploaded_file($_FILES['file']['tmp_name'], $newFileName);
                                break;
                        }
    
                        $percent = 1;
                        list($width, $height) = getimagesize($newFileName);
                        if($width/$height > 1){
                            $x = ($width - $height) / 2;
                            $y = 0;
                            $width= $width - ($x*2);
                            $height;
                        }else{
                            $y = ($height - $width) / 2;
                            $x = 0;
                            $width;
                            $height = $height - ($y*2);
                        }
                        $img = imagecreatefromjpeg($newFileName);
                        $img =imagecrop($img, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
                        $newwidth = 500;
                        $newheight = 500;
                        $thumb = imagecreatetruecolor($newwidth, $newheight);

                        imagecopyresized($thumb, $img, 0, 0, 0, 0,$newwidth, $newheight, $width, $height);
                        imagejpeg($thumb,$newFileNameResize,80);
                        //

                        break;
                    }
                }
                
            }
            

            if($imageName ==0){
                // update profile firstname and lastname
                $result = mysqli_query($dbc, "UPDATE users
                SET user_firstname = '$firstname', user_lastname = '$lastname'
                WHERE user_id = '$user_id';");
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }else{
                // update profile firstname, lastname ,and profile picture name
                $result = mysqli_query($dbc, "UPDATE users
                SET user_firstname = 'nice', user_lastname = 'nice' ,user_profile_picture = '$imageName'
                WHERE user_id = '$user_id';");
                // update session
                $_SESSION['profile_picture'] = $imageName;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }
            
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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <style>
        div.profile-container{
            padding-top: 100px;
            width: 800px;
            margin-left: calc((100vw / 2) - (800px/2));
        }
        div.profile-padding{
            width: inherit;
            opacity: 0;
        }
        div.profile-content-container{
            padding-top: 20px;
            padding-bottom: 20px;
            width: inherit;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        div.profile-content{
        }
        div.profile-content img{
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-left: 50px;
            margin-top: 30px;
        }
        div.profile-content span{
            position: relative;
            left: 20px; 
            top: -70px;
            font-size: .5cm;
        }
        input.firstname{
            position: relative;
            top: -100px;
            left: 230px;
            width: 250px;
            height: 40px;
            border-radius: 5px;
            padding-left: 5px;
        }
        input.lastname{
            position: relative;
            top: -100px;
            left: 230px;
            margin-top: 10px;
            width: 250px;
            height: 40px;
            border-radius: 5px;
            padding-left: 5px;
        }
        
    </style>
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
            <form action="" method="post" enctype="multipart/form-data">
                <input class="firstname" type="text" name="firstname" id="firstname" value="<?php echo $_SESSION['firstname'];?>"placeholder="Hanrickson" required>
                <br>
                <input class="lastname"type="text"  name="lastname" id="lastname" value="<?php echo $_SESSION['lastname'];?>"placeholder="Dumapit" required>
                <input class="file" type="file" accept="image/*" name="file" >
                <input type="submit" value="save" name="save">
            </form>
            
        </div>
    </div>
    <div class="profile-padding"></div>
</div>



</body>
</html>