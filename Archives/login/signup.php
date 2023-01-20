
<?php
session_start();
//print_r($_POST);
if(isset($_SESSION['id'])){
    header('location:../files/files.php ');
}else if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword'])){
    
    // validation
    $error = false;
    if(strlen($_POST['firstname'])<= 0 || strlen($_POST['firstname']) >= 255){
        $errorfname = "Enter firstname";
        $error = true;
    }else{
        $fname = $_POST['firstname'];
    }
    if(strlen($_POST['lastname'])<= 0 || strlen($_POST['lastname']) >= 255){
        $errorlname = "Enter lastname";
        $error = true;
    }else{
        $lname = $_POST['lastname'];
    }

    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = "Invalid email format";
        $error = true;
    }
    if($password == $confirmpassword ){
        include_once("../functions.php");
        // check if password is valid
        if (validate_password($password)) {
            // hash password
            $password = password_hash($password, PASSWORD_ARGON2I);

            include_once("../mysqlconfig_connection.php");
            $result = mysqli_query($dbc, "SELECT user_id FROM users
            WHERE user_email = BINARY '$email';");
            if ($result) {
                $result = mysqli_fetch_array($result);
            }
            if (!isset($result['user_id'])) {
                // insert to the table
                $result = mysqli_query($dbc, "INSERT INTO users VALUES(
                null,
                (SELECT user_status_id FROM user_status WHERE user_status_details = 'active'),
                (SELECT user_type_id FROM user_types WHERE user_type_details = 'normal'),
                '$email',
                '$password',
                '$fname',
                '$lname',
                0,
                'default.png',
                now(),
                now()
                );");

                if ($result) {
                    // successful
                    // get user_id
                    $result = mysqli_query($dbc, "SELECT user_id,user_status_details FROM users
                    LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
                    WHERE user_email = BINARY '$email';");
                    if($result){
                        $result = mysqli_fetch_array($result);
                        // set session
                        //print_r($result);
                        $_SESSION['id'] = $result['user_id'];
                        $_SESSION['user_status'] = $result['user_status_details'];
                        $_SESSION['user_email'] = $email;
                        $_SESSION['firstname'] = $fname;
                        $_SESSION['lastname'] = $lname;
                        $_SESSION['profile_picture'] = "default.png";
            
                        // go to files
                        header('location:../login/editprofile.php');
                    }else{
                        echo 'error';
                    }
                    echo 'error sign up';
                }
            } else {
                $errorEmail ='email exist';
                $email = null;
            }
        }else{
            $errorPassword ="weak password";
            $errorconfirmpassword = "weak password";
        }
    }else{
        $errorPassword ="password don't match";
        $errorconfirmpassword = "password don't match";
    }





    
    // check if the username is valid then insert
    // insert to database


}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>

    <div class="signup-container">
        <div class="signup-form">
            <div class="signup-form-padding"></div>
            <div class="signup-form-name">Sign up</div>
            <form action="" method = "POST">
                <div class="input">
                <label for="firstname">Firstname</label>
                    <br>
                    <input type="text" name="firstname" id="firstname" onkeyup="myfunctionvalidate()"value="<?php if(isset($fname)){echo $fname;}?>" placeholder="<?php if(isset($errorfname)){echo $errorfname;}else echo 'Enter Firstname'?>" required>
                </div>
                <div class="input">
                <label for="lastname">Lastname</label>
                    <br>
                    <input type="text" name="lastname" id="lastname" onkeyup="myfunctionvalidate()" value="<?php if(isset($lname)){echo $lname;}?>" placeholder="<?php if(isset($errorlname)){echo $errorlname;}else echo 'Enter Lastname'?>" required>
                </div>

                <div class="input">
                    <label for="username">Email</label>
                    <br>
                    <input type="email" name="email" id="email" onkeyup="myfunctionvalidate()" value="<?php if(isset($email)){echo $email;}?>" placeholder="<?php if(isset($errorEmail)){echo $errorEmail;}else echo 'Enter Email'?>" required>
                    
                </div>
                <div class="input">
                    <label for="password">Password</label>
                    <br>
                    <input type="password" name="password" id="password"  onkeyup="myfunctionvalidate()" placeholder="<?php if(isset($errorPassword)){echo $errorPassword;}else echo 'Enter Password'?>" minlength="12" required >
                </div>
                <div class="input">
                    <label for="confirmpassword">Confirm Password</label>
                    <br>
                    <input type="password" name="confirmpassword" id="confirmpassword"  onkeyup="myfunctionvalidate()" placeholder="<?php if(isset($errorconfirmpassword)){echo $errorconfirmpassword;}else echo 'Confirm Password'?>" minlength="12" required >
                </div>
                <div class="submit">
                    <input type="submit" id="submit" value="SIGN UP" name="SIGN UP" disabled>
                </div>
                <div class="login">
                    <a href="login.php">Login?</a>
                </div>
            </form>
        </div>
    </div>
    
    
</body>
</html>
<script>
    function myfunctionvalidate(){
        console.log('nice');
        let firstname = document.getElementById("firstname").value.length;
        let lastname = document.getElementById("lastname").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let confirmpassword = document.getElementById("confirmpassword").value;
        let submit = document.getElementById("submit");
        console.log(firstname);
        if((firstname) == 0 || lastname == 0 || !ValidateEmail(email) || !ValidatePasswordLength(password) || !ValidatePasswordUppercase(password) || !ValidatePasswordLowercase(password)
        || !ValidatePasswordIsnum(password) || !validatedPassowrdConfirmPassword(password,confirmpassword)){
            submit.disabled = true;
            if((firstname) == 0){
                submit.setAttribute('value','Invalid firstname');
            }
            if(lastname == 0){
                submit.setAttribute('value','Invalid lastname');
            }
            if(!ValidateEmail(email)){
                submit.setAttribute('value','Invalid email');
            }
            if(!ValidatePasswordLength(password)){
                submit.setAttribute('value','Password length must be >=12');
            }
            if(!ValidatePasswordUppercase(password)){
                submit.setAttribute('value','Password must have uppercase letter');
            }
            if(!ValidatePasswordLowercase(password)){
                submit.setAttribute('value','Password must have lowercase letter');
            }
            if(!ValidatePasswordIsnum(password)){
                submit.setAttribute('value','Password must have number letter');
            }
            if(!validatedPassowrdConfirmPassword(password,confirmpassword)){
                submit.setAttribute('value','Password don\'t match');
            }
        }else{
            submit.disabled = false;
            submit.setAttribute('value','SIGN UP');
        }
        // }else{
            
        //     if (firstname == 0){
        //         submit.setAttribute('value','Invalid firstname');
        //     } 
        //     if (lastname == 0){
        //         console.log(parseInt(lastname));
        //     }
        //     if (!ValidateEmail(email)){
        //         submit.setAttribute('value','Invalid email');
        //     }
        //     if (!ValidatePasswordLength(password)){
        //         submit.setAttribute('value','Password length more than or equal to 12');
        //     }
        //     document.getElementById("submit").disabled = true;
            
        // }
       
    }
    function ValidateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)){
        // ajax email??
        return (true)
    }
        return (false)
    }
    function ValidatePasswordLength(password){
        if(password.length <12){
            return false;
        }
        return true;
    }
    function ValidatePasswordUppercase(password){
        for (let i = 0; i < password.length; i++) {
            if(password[i] == password[i].toUpperCase()){
                return true;
            }
        }
        return false;
    }
    function ValidatePasswordLowercase(password){
        for (let i = 0; i < password.length; i++) {
            if(password[i] == password[i].toLowerCase()){
                return true;
            }
        }
        return false;
    }
    function ValidatePasswordIsnum(password){
        for (let i = 0; i < password.length; i++) {
            if(isNumber(password[i])){
                return true;
            }
        }
        return false;
    }
    function isNumber(char) {
        return /^\d$/.test(char);
    }
    function validatedPassowrdConfirmPassword(password,confirmpassword){
        return password  === confirmpassword;
    }
    function ValidatePassword(password){
        if(password.length <12){
            return false;
        }else if(0){
            return false;
        }
    }


</script>