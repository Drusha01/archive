
<?php
session_start();
if(isset($_POST['save']) && isset($_POST['currentpassword'])&& isset($_POST['password']) && isset($_POST['confirmpassword'])){
    // check if the password is valid
    include_once("../mysqlconfig_connection.php");
    $user_id = $_SESSION['id'];
    $result = mysqli_query($dbc, "SELECT user_password_hashed FROM users
    WHERE user_id = BINARY '$user_id';");
    $result = mysqli_fetch_array($result);
    // verify
    if (password_verify($_POST['currentpassword'], $result['user_password_hashed'])) {
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        if($password == $confirmpassword){
            // validate password
            include_once("../functions.php");
            if (validate_password($password)) {
                // hash password
                $password = password_hash($password, PASSWORD_ARGON2I);
                 // update password
                $result = mysqli_query($dbc, "UPDATE users
                SET user_password_hashed = '$password'
                WHERE user_id = BINARY '$user_id';");
                if($result){
                    $saved= 'saved';
                }else{
                    $errorcurrentppassword = "Failed";
                    $errorpassword = "Failed";
                    $errorconfirmpassword = "Failed";
                }
            }
        }else{
            $errorpassword = "Invalid";
            $errorconfirmpassword    = "Invalid";
        }
    }else{
        $errorcurrentppassword = "Invalid current password";
    }
    
}else if(!isset($_SESSION['id'])) {
    header('location:../login/login.php ');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/password.css">
</head>
<body>
    
<?php
$password = '-active';
require_once '../includes/navigation.php';
?>
    <div class="change-password-padding"></div>
    <div class="change-password-container">
        <div class="change-password-form">
            <form action="" method="post">
                <div class="current-password">
                    <label for="password">Current Password</label>
                    <span><input type="password" name="currentpassword" id="currentpassword" placeholder="<?php if(isset($errorcurrentppassword)){ echo $errorcurrentppassword;} ?>"  required min-length="12" ></span>
                </div>
                <div class="current-password">
                    <label for="password">New  Password</label>
                    <span><input type="password" name="password" id="password"  placeholder="<?php if(isset($errorpassword)){ echo $errorpassword;} ?>" required min-length="12" ></span>
                </div>
                <div class="current-password">
                    <label for="password">Confirm Password</label>
                    <span><input type="password" name="confirmpassword" id="confirmpassword" placeholder="<?php if(isset($errorconfirmpassword)){ echo $errorconfirmpassword;} ?>"  required min-length="12" ></span>
                </div>
                <input class="save" type="submit" value="save" name="save" id ="save">
                <div class="saved"><p><?php if(isset($saved)){ echo $saved;} ?></p></div>
            </form>
        </div>
    </div>
    
</body>
</html>