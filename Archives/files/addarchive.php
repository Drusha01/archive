<?php
session_start();
$directory = 'C:/Apache24/htdocs/test/archive/Archives/Archive/';
// print_r($_POST);
// echo '<br>';
// print_r($_FILES);
if (isset($_SESSION['user_status']) && $_SESSION['user_status'] == 'active' && isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['target'])) {
  $title =  $_POST['title'];
  $valid =  false;
  include_once("../mysqlconfig_connection.php");
    // validate target type
  $result = mysqli_query($dbc, "SELECT target_type_details FROM target_type;");
  while($res = mysqli_fetch_array($result)){
    if($res['target_type_details'] == $_POST['target']){
      $valid = true;
      break;
    }
  }  

  if(strlen($title)>0){
    // validate files, only accept image and videos
    
    foreach ($_FILES as $arr) {
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
          if (str_contains($type, 'png') || str_contains($type, 'bmp') ||str_contains($type, 'jpg') || str_contains($type, 'jpeg')|| str_contains($type, 'mp4')) {
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
        if ($filesize > (pow(1024, 3))) {
          echo $valid = false;
          echo 'invalid max filesize';
        }
      }
      if ($valid) {
        $user_id = $_SESSION['id'];
        $title = $_POST['title'];
        $target = $_POST['target'];
        $uuid = $user_id.'_'.md5(time());
        $result_insert = mysqli_query($dbc, "INSERT INTO posts VALUES
        (
            null,
            (SELECT post_status_id from post_status WHERE post_status_details ='active'),
            '$user_id',
            '$title',
            (SELECT target_type_id from target_type where target_type_details = '$target'),
            '$uuid',
            now(),
            now()
        );");

        $result = mysqli_query($dbc, "SELECT post_id FROM posts WHERE post_uuid = '$uuid';");
        $res = mysqli_fetch_array($result);
        $post_id = $res['post_id'];

        if($target == 'followers-except'){
          // implement this later

        }else if($target == 'specific-followers'){
          // implement this later
        }

        // create folder
        // check if folder exist
        if ( !file_exists( $directory.$_SESSION['user_email']) ) {
          mkdir( $directory.$_SESSION['user_email'] );       
        }
        if ( !file_exists( $directory.$_SESSION['user_email'].'/'.$uuid )) {
            mkdir( $directory.$_SESSION['user_email'].'/'.$uuid );     
        }
        if(!file_exists( $directory.$_SESSION['user_email'].'/'.$uuid.'/'.$post_id)){
            mkdir($directory.$_SESSION['user_email'].'/'.$uuid.'/'.$post_id );
        }

        //move files 
        $counter = 0;
        foreach($arr['tmp_name'] as $temp_name){
            
          // move uploaded files
          $content_post_id = $post_id;
          $content_extension = (explode('.',$_FILES['files']['name'][$counter],2))[1];
          $content_hash = md5($_FILES['files']['name'][$counter]).'.'.$content_extension;
          $content_name = $post_id.'_'.$content_hash;
          $content_size = $_FILES['files']['size'][$counter];
          $content_caption = $_POST[str_replace('.', '_',(str_replace(' ', '_',($_FILES['files']['name'][$counter]))))];
          move_uploaded_file($temp_name,$directory.$_SESSION['user_email'].'/'.$uuid.'/'.$post_id.'/'.$content_name);
        
          
          // insert image names in contents
          $result = mysqli_query($dbc, "INSERT INTO contents VALUES(
              null,
              '$post_id',
              '$content_name',
              '$content_size',
              '$content_extension',
              '$content_caption'
              );");

          // make it zip?

          // resize image as jpg
          $counter++;
        }
      header('location:../files/files.php');
      }

    }
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
    <title>Add archive</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/addarchive.css">
</head>
<body id ="body">
<?php
    $addarchive = '-active';
    require_once '../includes/navigation.php';
    require_once('../includes/sidebar.php');
?>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="title" class="title" placeholder="Enter title" required>
    <br>
    <input type="file" id="files" name="files[]" multiple accept="image/*,video/*"onchange="onFileSelected(event)" required>
    <input type="text" name="caption[]" style="visibility: hidden;">
    <input type="text" name="target[]" style="visibility: hidden;">
    <br>
    <label for="target">Target</label>
    <br>
    <input type="radio" name="target" id="public" value="public" checked onclick="myFunction('user')">
    <label for="user"> Public</label>
    <br>
    <input type="radio" name="target" id="followers" value="followers" onclick="myFunction('group')">
    <label for="group">Followers</label>
    <br>
    <input type="radio" name="target" id="followers except" value="followers-except" onclick="myFunction('group')">
    <label for="group">Followers except</label>
    <br>
    <input type="radio" name="target" id="specific followers" value="specific-followers" onclick="myFunction('group')">
    <label for="group">Specific Followers</label>
    <br>
    <input type="radio" name="target" id="only me" value="only-me" onclick="myFunction('group')" checked>
    <label for="group">Only me</label>
    <br>
    <input type="submit" value="submit" name="submit">
  
    <div class="file-container">
      <button type="button" class="deleteall" id="deleteall" onclick="myfunctiondeleteall('delete')">X</button>
      <div class="file-list" style="">

      </div>
    </div>
    <div class="target">

    </div>
      
  </form>
      
  
  
  

  

</body>
</html>
<script>
  function myfunctioneditall(){
    const global_file = e.target.files;
//     const output = document.querySelector("div.file-list");
//     output.innerHTML = "";
//     // check length / how many files are there.
//     // add div
//     let length = global_file.length;
    
//     // load image
//     for (let i = 0; i < length ; i++) {
//        if (!global_file[i].type.match("image")) continue;
//         const imgReader = new FileReader();
//         imgReader.addEventListener("load", function (event) {
//           const imgFile = event.target;
//           const img = document.createElement("img");
//           const div = document.createElement("div");
//           div.setAttribute('class','file-item-container');
//           div.setAttribute('id',global_file[i].name);
//           output.appendChild(div);
//           const div_delete = document.createElement('button');
//           div_delete.setAttribute('class','delete');
//           div_delete.setAttribute('id','delete-'+i);
//           div_delete.innerHTML ='X';
//           div_delete.setAttribute("onclick", 'myfunctiondeleteindex('+i+',"'+global_file[i].name+'")');
//           div.appendChild(div_delete);

          

//           //img
//           img.className = "thumbnail";
//           img.src = imgFile.result;
//           div.appendChild(img);
//           // text area
//           const textarea = document.createElement('textarea');
//           textarea.setAttribute('name',global_file[i].name);
//           textarea.setAttribute('id','text-'+i);
//           textarea.setAttribute('cols','30');
//           textarea.setAttribute('rows','10');
//           textarea.setAttribute('placeholder','caption');
//           div.appendChild(textarea);
//         });
//         imgReader.readAsDataURL(global_file[i]);
//       }
//   }
  }
    document.querySelector("#files").addEventListener("change", (e) => { 
  if (window.File && window.FileReader && window.FileList && window.Blob) {
    const global_file = e.target.files;
    const output = document.querySelector("div.file-list");
    output.innerHTML = "";
    
    // check length / how many files are there.
    // add div
    let length = global_file.length;
    
    // load image
    for (let i = 0; i < length ; i++) {
       if (!global_file[i].type.match("image")) continue;
        const imgReader = new FileReader();
        imgReader.addEventListener("load", async function (event) {
          const imgFile = event.target;
          const img = document.createElement("img");
          const div = document.createElement("div");
          div.setAttribute('class','file-item-container');
          div.setAttribute('id',global_file[i].name);
          output.appendChild(div);
          const div_delete = document.createElement('button');
          div_delete.setAttribute('class','delete');
          div_delete.setAttribute('type','button');
          div_delete.setAttribute('id','delete-'+i);
          div_delete.innerHTML ='X';
          div_delete.setAttribute("onclick", 'myfunctiondeleteindex('+i+',"'+global_file[i].name+'")');
          div.appendChild(div_delete);

          

          //img
          img.className = "thumbnail";
          img.src = imgFile.result;
          div.appendChild(img);
          // text area
          const textarea = document.createElement('textarea');
          textarea.setAttribute('name',global_file[i].name);
          textarea.setAttribute('id','text-'+i);
          textarea.setAttribute('cols','30');
          textarea.setAttribute('rows','10');
          textarea.setAttribute('placeholder','caption');
          div.appendChild(textarea);
        });
        imgReader.readAsDataURL(global_file[i]);
      }

  } else {
    alert("Your browser does not support File API");
  }
});


function myfunctiondeleteindex(index,imgname){
  // 
  // console.log(index);
  // console.log(imgname);
  const dt = new DataTransfer()
  const input = document.getElementById('files');
  const { files } = input;
  for (let i = 0; i < files.length; i++) {
    const file = files[i]
    if (!(imgname == file.name)){
      //console.log(imgname);
      dt.items.add(file) // here you exclude the file. thus removing it
    }
  }

  input.files = dt.files

  document.getElementById(imgname).remove();
}

function myfunctiondeleteall(){
  
  const dt = new DataTransfer();
  const input = document.getElementById('files');
  const { files } = input;
  console.log(files.length);
  for (let i = 0; i < files.length; i++) {
    myfunctiondeleteindex(i,files[i].name);
  }
  input.files = dt.files;

  
}
</script>