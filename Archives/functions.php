<?php
function validate_password($password){
    if(strlen($password) < '12') {
        return false;
    }
    elseif(!preg_match("#[0-9]+#",$password)) {
        return false;
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
        return false;
    }
    elseif(!preg_match("#[a-z]+#",$password)) {
        return false;
    }
    return true; 
}

?> 