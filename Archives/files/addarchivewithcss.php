<?php
session_start();
// directory of upload
//$directory = 'D:/Archive/';
$directory = 'C:/Apache24/htdocs/test/Archives/Archive/';
// check session
// check if user is valid (can post)
// print_r($_POST);
// echo '<br>';
if( isset($_SESSION['user_status'])&& $_SESSION['user_status'] == 'active' && isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['targetuser'])){
    
    //check title if >0
    if(strlen($_POST['title'])>0){
        // validate files, only accept image and videos
        $valid = true;
        foreach ($_FILES as $arr){
            // check for invalid file upload
            if ($valid) {
                foreach ($arr['error'] as $error) {
                    if ($error == 1) {
                        $valid = false;
                        echo 'invalid \"error\"';
                    }
                }
            }

            // check file extension type
            if ($valid) {
                foreach ($arr['type'] as $type) {
                    if (str_contains($type, 'image') || str_contains($type, 'video')) {
                    } else {
                        $valid = false;
                        echo 'invalid file extension';
                    }
                }
            }

            // calculate the file size should not over 1gb
            if ($valid) {
                $filesize = 0;
                foreach ($arr['size'] as $size) {
                    $filesize += $size;
                }
                if ($filesize > (pow(1024,3) )) {
                    echo $valid = false;
                    echo 'invalid max filesize';
                }
            }

            // move files
            if($valid){
                include_once("../mysqlconfig_connection.php");
                // insert title database
                $user_id = $_SESSION['id'];
                $title = $_POST['title'];
                $date = date('d-m-y');
                // check if table exist for date 
                $result = mysqli_query($dbc, "SELECT post_id,post_title  FROM posts 
                WHERE CAST(post_date_posted AS DATE)  = '$date' AND post_user_id = '$user_id' AND post_title = BINARY '$title';");
                
                //print_r($result);
                $rows = mysqli_num_rows($result);
                if($rows ==0){
                    $result = mysqli_query($dbc, "INSERT INTO posts VALUES
                    (
                        null,
                        null,
                        '$user_id',
                        '$title',
                        CAST('$date' AS DATETIME),
                        now()
                    );");
                    $result = mysqli_query($dbc, "SELECT post_id FROM posts WHERE CAST(post_date_posted AS DATE)  = '$date' AND post_user_id = '$user_id' AND post_title = '$title';");
                    if($result){
                        $result = mysqli_fetch_array($result);
                        $post_id = $result['post_id'];
                    }
                }else if($rows ==1){
                    $result = mysqli_query($dbc, "SELECT post_id FROM posts WHERE CAST(post_date_posted AS DATE)  = '$date' AND post_user_id = '$user_id' AND post_title = '$title';");
                    if($result){
                        $result = mysqli_fetch_array($result);
                        $post_id = $result['post_id'];
                    }
                }

                // check target user/s
                $targetusers = $_POST['targetuser'];
                $targetusers = explode (",", $targetusers); 

                foreach ($targetusers as $value) {
                    $result = mysqli_query($dbc, "INSERT INTO targets VALUES
                    (
                        null,
                        '$post_id',
                        (SELECT user_id FROM users WHERE user_email= BINARY '$value'),
                        CONCAT('$post_id','_',(SELECT user_id FROM users WHERE user_email= BINARY '$value')),
                        (SELECT access_type_id FROM access_types WHERE access_type_details = 'normal')
                    );");
                    
                    echo $value;
                    echo '<br>';
                }
                echo '<br>';


                print_r($targetusers);
                echo '<br>';
                // insert target access

                // get post_id

                // get DATE
                $result = mysqli_query($dbc, "SELECT CAST(post_date_posted AS DATE) AS post_date_posted FROM posts WHERE post_id = $post_id;");
                if($result){
                    $result = mysqli_fetch_array($result);
                    $date = $result['post_date_posted'];
                }


                $counter = 0;
                foreach($arr['tmp_name'] as $temp_name){
                    // check if folder exist
                    if ( !file_exists( $directory.$_SESSION['user_email']) ) {
                        mkdir( $directory.$_SESSION['user_email'] );       
                    }
                    if ( !file_exists( $directory.$_SESSION['user_email'].'/'.$date )) {
                        mkdir( $directory.$_SESSION['user_email'].'/'.$date );     
                    }
                    if(!file_exists( $directory.$_SESSION['user_email'].'/'.$date.'/'.$title)){
                        mkdir($directory.$_SESSION['user_email'].'/'.$date.'/'.$title );
                    }

                    // move uploaded files
                    $content_name = $_SESSION['id'].'_'.$post_id.'_'.$_FILES['files']['name'][$counter];
                    move_uploaded_file($temp_name,$directory.$_SESSION['user_email'].'/'.$date.'/'.$title.'/'.$content_name); 
                    
                    // insert image names in
                    $result = mysqli_query($dbc, "INSERT INTO contents VALUES(
                        null,
                        '$post_id',
                        '$content_name'
                        );");

                    // make it zip?

                    // resize image as jpg
                    $counter++;
                }
                //header('location:../files/files.php ');
            }
            print_r($arr['tmp_name']);
            echo '<br>';
            
            echo '<br>';
            
            
            echo '<br>';
        }
        echo '<br>';
        print_r($_FILES);
        // validated size (25mb per image, 1 gb videos)


    }
}else if(!isset($_SESSION['id'])) {
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
    <title>Add Archive</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
 
    <style>

    </style>
</head>
<body>
<?php
$addarchive = '-active';
require_once '../includes/navigation.php';
?>
<h4>Add Archive</h4>
<?php
if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'active') {
?>



<label for="target">Target</label>
<input type="radio" name="target" id="user" value="user" checked onclick="myFunction('user')">
<label for="user"> Users</label>
<input type="radio" name="target" id="group" value="group" onclick="myFunction('group')">
<label for="group">Group</label>

<br>
<br>
<br>
<br>
<div id="target-user">
    <label for="search-user" >Search</label>
    <input type="search" name="search-user" id="search-user" onkeyup="searchUser()">
    <ul id="search-list">
    </ul>
    <h5>Target List</h5>
    <ul id="list-of-users">
    </ul>
</div>
<br>
<br>
<br>

<div class="add-archive-container">
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data"> 
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
        <br>
        <label for="files">Files</label>
        <input type="hidden" id="target-user-hidden" name="targetuser" value="" >
        <input type="file" name="files[]" multiple accept="image/*,video/*">
        <br>
        <input type="submit" value="submit" name="submit">
    </form>
    </div>
    <div class="target-user-content">
        <label for="target">Target</label>
        <input type="radio" name="target" id="user" value="user" checked onclick="myFunction('user')">
        <label for="user"> Users</label>
        <input type="radio" name="target" id="group" value="group" onclick="myFunction('group')">
        <label for="group">Group</label>
    </div>
    <div id="target-user">
        <label for="search-user" >Search</label>
        <input type="search" name="search-user" id="search-user" onkeyup="searchUser()">
        <ul id="search-list">
        </ul>
        <h5>Target List</h5>
        <ul id="list-of-users">
        </ul>
    </div>
    </div>
</div>

    

<?php
}else{
    echo 'contact the admin';
}
    ?>
<br>
</body>
</html>

<script>
    function myFunction(string){
        // change div target user
        // check if user or groups
        const target = document.getElementById('target-user');
        // clear
        target.textContent ='';
        if(string == 'user'){
            // label
            const label = document.createElement('label');
            label.setAttribute('for', 'search-user');
            label.textContent = 'Search';
            target.appendChild(label);
            // search bar
            const search = document.createElement('input');
            search.setAttribute('type','search');
            search.setAttribute('name','search-user');
            search.setAttribute('id','search-user');
            search.setAttribute('onkeyup','searchUser()');
            target.appendChild(search);
            // search-list
            const search_list = document.createElement('ul');
            search_list.setAttribute('id','search-list');
            target.appendChild(search_list);
        }else{

        }
        // 

        //console.log(document.getElementById('target-user').textContent)

    }

    function searchUser(){
        // get content of search bar
        // ajax call to retrive user
        const search = document.getElementById('search-user');
        let length = search.value.length;
        if(length >0){
            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "../search/searchUser.php?s="+search.value, true);
            xhttp.send();
        }

        // append the list of retrieved users (limit 5/10/15)
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // parse json
                //console.log(this.responseText);
                const search_list =  document.getElementById("search-list");
                search_list.textContent = '';
                const Arr = JSON.parse(this.responseText);
                const length = Arr.length;
                let i =0;
                while (i < length) {
                    //console.log(Arr[i]);
                    el = document.createElement('li');
                    el.innerHTML = "<button onclick=addFunction('"+(Arr[i][1])+"') >ADD</button>"+Arr[i][1]+": "+Arr[i][2]+" "+Arr[i][3];
                    search_list.appendChild(el);
                    if(i>100){
                        break;
                    }
                    i++;
                }
            }
        }; 
    }


    function addFunction(val){
        //console.log(val);
        // search, if found do nothing else append
        const hidden_list = document.getElementById("target-user-hidden");
        var arr = hidden_list.value.split(",");
        var length = arr.length;
        var found = false;
        // loop through an array if found dont append else,
        for (var i = 0; i<length; i++){
            //console.log(arr[i]);
            if(arr[i] === val){
                found = arr[i] === val;
                break;
            }
        }
        if(!found){
            arr.push(val);
            // add to the list-of-users
            const list = document.getElementById("list-of-users");
            el = document.createElement('li');
            el.setAttribute('id',val);
            el.innerHTML = "<button onclick=deletefunction('"+val+"') >Delete</button> "+val;
            list.appendChild(el);
            // create list element and button
        }

        hidden_list.setAttribute('value',arr);
        
        // append to the list of target user


    }

    function deletefunction(val){
        // delete from the list of users
        // update the array list in hidden element
        const hidden_list = document.getElementById("target-user-hidden");
        var arr = hidden_list.value.split(",");
        var length = arr.length;
        var found = false;
        for (var i = 0; i<length; i++){
            //console.log(arr[i]);
            if(arr[i] === val){
                found = arr[i] === val;
                arr.splice(i,i);
                //console.log(arr);
                break;
            }
        }
        hidden_list.setAttribute('value',arr);

        const item = document.getElementById(val);
        item.remove();
        ///console.log(val);
    }
</script>

