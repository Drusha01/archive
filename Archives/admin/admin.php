<?php 
    // check session
session_start();
if(isset($_SESSION['id'])){
    // get check user if admin else go back to files.php
    include_once("../mysqlconfig_connection.php");
    $result = mysqli_query($dbc, "SELECT user_id FROM users
    WHERE user_type_id = (SELECT user_type_id FROM user_types WHERE user_type_details = 'admin');");
    $result = mysqli_fetch_array($result);
    if($result && $result['user_id'] != $_SESSION['id']){
        header('location:../files/files.php');
    }
}else{
    header('location:../files/files.php');
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>

<?php 
require_once '../includes/navigation.php';
?>

    <table>
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>User Status</th>
        <th>User Type</th>
        <th>Action</th>
    </tr>
    
    
    <?php
        $result = mysqli_query($dbc, "SELECT user_id,user_status_details,user_type_details,user_name,user_firstname,user_lastname from users
        LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
        LEFT OUTER JOIN user_types ON users.user_type_id=user_types.user_type_id
        WHERE user_name != BINARY 'Hanrickson';");
    if ($result) {
        $counter =1;
        while($res =mysqli_fetch_array($result)){
            echo '<tr>';
            echo '<td>' . $counter . '</td>';
            echo '<td>'.$res["user_name"].'</td>';
            echo '<td>'.$res["user_firstname"].'</td>';
            echo '<td>'.$res["user_lastname"].'</td>';
            echo '<td>'.$res["user_status_details"].'</td>';
            echo '<td>'.$res["user_type_details"].'</td>';
            if($res["user_status_details"] == 'active'){
                echo '<td><a href="../admin/modifystatus.php?id='.$res['user_id'].'&action=Deactivate">Deactivate</a></td>';
            }else{
                echo '<td><a href="../admin/modifystatus.php?id='.$res['user_id'].'&action=activate">Activate</a></td>';
            }
            
            
            echo '</tr>';
            $counter++;
        }
    }
    print_r($result);
    ?>
    </table>
</body>
</html>
