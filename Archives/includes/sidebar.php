<div class="side-bar-container">
    <div class="side-bar-padding">
        Follow people
    </div>
    <?php 
    // get request every 30 seconds.
    include_once("../mysqlconfig_connection.php");

    $follower_follow_to_id = $_SESSION['id'];
    $result = mysqli_query($dbc, "SELECT follower_id,user_firstname,user_lastname,user_profile_picture,follower_user_id,UNIX_TIMESTAMP(follow_date) AS follow_date  FROM followers
    LEFT OUTER JOIN users ON followers.follower_user_id = users.user_id
    WHERE follower_follow_to_id = '$follower_follow_to_id' AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'requested')
    ORDER BY follow_date DESC
    LIMIT 5;");

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="follow-request-title">Follow request</div>
                <a href="#see all" class="see-all"><div class="see-all-follow-request">See all</div></a>';
        while ($res_side_bar = mysqli_fetch_array($result)) {

            $time = time() - $res_side_bar['follow_date'];
            if($time < 60){
                $time = 1;
                $timex = 'm';
            }else if($time > 60 && $time < 3600){
                $time = intval($time/60);
                $timex = 'm';
            }elseif($time > 3600 && $time < (3600 * 24)){
                $time = intval($time / (3600));
                $timex = 'h';
            }elseif($time > (3600 * 24)){
                $time = intval($time / (3600*24));
                $timex = 'd';
            }
            echo '
                <div class="follow-request-item" id="'.htmlentities($res_side_bar['follower_id']).'">
                    <a href="../login/viewprofile.php?id='.htmlentities($res_side_bar['follower_user_id']).'" class="follow-request-item" >
                        <img class="follow-request-item" src="../img/profileresize/'.htmlentities($res_side_bar['user_profile_picture']).'" alt=""  width="45px" height="45px">
                        <div class="name">'.htmlentities(substr($res_side_bar['user_firstname'].' '.$res_side_bar['user_lastname'],0,23)).'</div>
                        <div class="date-time">'.htmlentities($time.$timex).' </div>
                        <div class="mutual-followers">50 mutual followers </div>
                    </a>
                    <a href="#confirm" class="confirm" onclick="myfunctionConfirmFollow('.htmlentities($res_side_bar['follower_user_id']).','.htmlentities($res_side_bar['follower_id']).',\'Confirm\')" >Confirm</a>
                    <a href="#delete" class="delete" onclick="myfunctionDeleteFollow('.htmlentities($res_side_bar['follower_user_id']).','.htmlentities($res_side_bar['follower_id']).',\'Delete\')">Delete</a>
                </div>
            ';
        }
        echo '</div>';
    }

    ?>    


</div>
<script>

function myfunctionConfirmFollow(id,follow_id,detail){
    // ajax here
    console.log('id:'+id+',f_id:'+follow_id+',d:'+detail);
    var http = new XMLHttpRequest();
    http.open("POST", "../follow/follow.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("follow_user_id="+id+"&follower_id="+follow_id+"&follow_detail="+detail);
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // change the div
            if(this.responseText == 'Following'){
                // remove the div
                const element = document.getElementById(follow_id);
                element.remove(); 
            }else{
                // erro
                console.log('error confirmation');
            }
            
            
        }
    };
}
function myfunctionDeleteFollow(id,follow_id,detail){
    // ajax here
    console.log('id:'+id+',f_id:'+follow_id+',d:'+detail);
    var http = new XMLHttpRequest();
    http.open("POST", "../follow/follow.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("follow_user_id="+id+"&follower_id="+follow_id+"&follow_detail="+detail);
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // change the div
            if(this.responseText == 'Deleted'){
                // remove the div
                const element = document.getElementById(follow_id);
                element.remove(); 
            }else{
                // erro
                console.log('error confirmation');
            }
            
            
        }
    };
}

</script>