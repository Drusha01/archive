<?php 
require_once 'header.php';
?>

    <div class="navigation-container">
        <div class="navigation-container-padding">
        </div>
        <div class="navigation-content">
            <div class="navigation-item">
                <a href="../login/profile.php">
                    <div class="navigation-item-content<?php if(isset($profile))echo $profile;?>">
                        <img src="../img/thumb/<?php echo $_SESSION['profile_picture'];?>" alt="" >
                        <span><?php echo substr($_SESSION['firstname'] . ' ' . $_SESSION['lastname'],0,23);?></span> 
                        <div class="navigation-name">
                        </div>
                    </div>
                </a>
            </div>
            <div class="navigation-item">
                <a href="../files/publicArchives.php">
                    <div class="navigation-item-content<?php if(isset($publicArchive))echo $publicArchive;?>">
                        <img src="../assets/navigation/publicarchive.png" alt="" >
                        <span>Public archives</span> 
                        <div class="navigation-name">
                        </div>
                    </div>
                </a>
            </div>
            <div class="navigation-item">
                <a href="../files/files.php">
                    <div class="navigation-item-content<?php if(isset($files))echo $files;?>">
                        <img src="../assets/navigation/files.png" alt="" >
                        <span>My archives</span> 
                        <div class="navigation-name">
                        </div>
                    </div>
                </a>
            </div>
            <div class="navigation-item">
                <a href="../files/addarchive.php">
                    <div class="navigation-item-content<?php if(isset($addarchive))echo $addarchive;?>">
                        <img src="../assets/navigation/addfiles.png" alt="" >
                        <span>Add archive</span> 
                        <div class="navigation-name">   
                        </div>
                    </div>
                </a>
            </div>
            <div class="navigation-item">
                <a href="../files/sharedwithme.php">
                    <div class="navigation-item-content<?php if(isset($sharedwithme))echo $sharedwithme;?>">
                        <img src="../assets/navigation/sharedwithme.png" alt="" >
                        <span>Shared with me</span> 
                        <div class="navigation-name">  
                        </div>
                    </div>
                </a>
            </div>
            
            
            <?php
            if(isset($profile) || isset($password)){
                if(!isset($password)){
                    $password = '';
                }
            echo'
            <div class="navigation-item">
                <a href="../login/password.php">
                    <div class="navigation-item-content'.$password.'">
                        <img src="../assets/navigation/changepassword.png" alt="" >
                        <span>Change Password</span> 
                        <div class="navigation-name">   
                        </div>
                    </div>
                </a>
            </div>';
            }
            
            ?>
            <hr>
            <div class="navigation-item-logout">
                <a href="../login/logout.php">
                    <div class="navigation-item-content ">
                        <img src="../assets/navigation/logout.png" alt="" >
                        <span>Logout</span> 
                        <div class="navigation-name">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
