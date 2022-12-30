<?php 
session_start();

// check if we are logged in 
if(isset($_SESSION['id'])){
    header('location:../files/files.php ');
}else if (isset($_POST['email']) && isset($_POST['password'])){
    // query
    $email = $_POST['email'];
    $password = $_POST['password'];
    include_once("../mysqlconfig_connection.php");

    $result = mysqli_query($dbc, "SELECT user_id,user_password_hashed,user_firstname,user_lastname,user_status_details,user_profile_picture FROM users
        LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
        WHERE user_email = BINARY '$email';");

    $result = mysqli_fetch_array($result);
    if(!isset($result['user_id'])){
        $errorEmail = "Invalid Email";
        $error = true;
        $email = null;
    }else{
    }
  
    // verify
    if (isset($result['user_id']) && password_verify($password, $result['user_password_hashed'])) {
        // set session
        $_SESSION['id'] = $result['user_id'];
        $_SESSION['user_status'] = $result['user_status_details'];
        $_SESSION['user_email'] = $email;
        $_SESSION['firstname'] = $result['user_firstname'];
        $_SESSION['lastname'] = $result['user_lastname'];
        if(isset($result['user_profile_picture'])){
            $_SESSION['profile_picture'] = $result['user_profile_picture'];
        }else{
            $_SESSION['profile_picture'] = "default.jpg";
        }
       
        // go to files
        header('location:../files/files.php');
    }else{
        $errorPassword = "Invalid Password";
    }

}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="login-form-padding"></div>
            <div class="login-form-name">Login</div>
            <form action="" method = "POST">
                <div class="input">
                    <label for="username">Email</label>
                    <br>
                    <input type="email" name="email" id="email" value="<?php if(isset($email)){echo $email;}?>"placeholder="<?php if(isset($errorEmail)){echo $errorEmail;}else echo 'Enter Email'?>" required>
                    
                </div>
                <div class="input">
                    <label for="password">Password</label>
                    <br>
                    <input type="password" name="password" id="password" placeholder="<?php if(isset($errorPassword)){echo $errorPassword;}else echo 'Enter Password'?>" minlength="12" required >
                </div>
                <div class="submit">
                    <input type="submit" value="LOGIN" name="LOGIN">
                </div>
                <div class="forgot-password">
                    <a href="#">Forgot Password</a>
                </div>
                <div class="vertical-line"></div>
                <div class="signup">
                    <a href="signup.php">Signup?</a>
                </div>
            </form>
            
        </div>
    </div>


    
    
</body>
</html>