
<?php
include '../layout/top.php';
$id=$_GET['id'];




$postStatus=new Post_query();
if(isset($_POST['btn'])){
    $postStatus->save_post($_POST);
}
$query_result=$postStatus->show_post_user_id($id);
 
if(isset($_GET['delete'])){
       $pid=$_GET['delete'];
       $postStatus->delete_post_on_user_profile($pid);
   }
   
   
  


// Insert like.........
    if(isset($_POST['like'])){
        
       $postStatus->likePost($_POST);
   }
   
// Delete Like 
   if(isset($_POST['unlike'])){
       $postStatus->unlikePost($_POST);
   }
$user_info=new User_info();
$query_user=$user_info->all_info_users($id);
$info= mysqli_fetch_assoc($query_user);
$num_friend=(substr_count($info['friend_array'],","))-1;

//mutual friend
$user_of=$_SESSION['username'];
$user_to=$info['username'];
$userfrnd=new Get_User_Info($con, $user_of);
$mutualFriends=$userfrnd->getMutualFriends($user_to);

//Friend Request Buttons
$user=$info['username'];
if(isset($_POST['remove_friend'])) {
	$userReq = new Friend_Request();
	$userReq->removeFriend($user);
}

if(isset($_POST['add'])) {
        $userReq = new Friend_Request();
	$userReq->sendRequest($user);
}
if(isset($_POST['confirm_request'])) {
    // echo "<pre>";
    // print_r($_POST);
    // exit();
	$userReq = new Friend_Request();
	$userReq->ConfirmRequest($user);
} 
if(isset($_POST['ignore_request'])) {
        $userReq = new Friend_Request();
	$userReq->IgnoreRequest($user);
}
if(isset($_POST['cancel_req'])) {
        $userReq = new Friend_Request();
	$userReq->cancelRequest($user);
}
?>
<head>
<title>Profile Page</title>
<link rel="icon" href="../images/MIST_logo.png" type="image/gif">
<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<style>
    .frnd-img{
        border-radius: 45px; 
        margin-right: 5px;
        height: 35px; 
        float: left;
         
        }
        ::-webkit-scrollbar { 
        display: none;
        }
</style>
</head>
<?php include '../layout/menu.php'?>
<body>
<div class="container">

    <div class="row" style="padding-top: 0px;">
        
        <div class="well col-md-3">
            <center>
            <a href="upload.php"><img src="<?php echo $info['profile_pic'];?>" alt="" class="img-responsive"></a><hr/>

            <a href="all_profile.php?id=<?php echo $info['username'];?>">
                <p><b style="font-family:cursive; font-size: 20px; color: #17a2b8"><?php echo $info['name'];?></b></p>
            </a>
            <p style="font-style: italic; color: #20AAE5">Number Of Posts = <?php echo $info['num_posts'];?></p>
            <p style="font-style: italic; color: #20AAE5">Number Of Friends = <?php echo $num_friend;?></p>
            <?php if($user_of!==$user_to){ ?>
            <p style="font-style: italic; color: #20AAE5"><?php echo $mutualFriends." mutual Friend";?></p>
            <?php } ?>
            </center>
            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModal"><?php echo $num_friend;?> Friends</button>
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Friend List</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body"  style="overflow-y:scroll;">
                            
                            <?php
                            
                            $profileUsername=$info['username'];
                            $sql="SELECT friend_array FROM user_info WHERE username='$profileUsername'";
                            $frndQuery= mysqli_query($con, $sql);
                            $row= mysqli_fetch_assoc($frndQuery);
                            
                            $getArray=$row['friend_array'];
                            $arrayExplode= explode(",", $getArray);
                            
                            for($a=1;$a<=$num_friend;$a++){
                                $user= $arrayExplode[$a];
                                $sql="SELECT * FROM user_info WHERE username='$user'";
                                $query=mysqli_query($con, $sql);
                                $row=mysqli_fetch_assoc($query);
                                $pic=$row['profile_pic'];
                                $name=$row['name'];
                                $user_of = $_SESSION['username'];
                                $userfrnd = new Get_User_Info($con, $user_of);
                                $mutualFriends = $userfrnd->getMutualFriends($user);
                                ?>
                            <div>
                                <a href="all_profile.php?id=<?php echo $user;?>" >
                                    <img src="<?php echo $pic?>" class="img-responsive frnd-img">
                                    <?php echo $name.'<br>'.$mutualFriends.' mutual friends';?>
                                </a>
                            </div><hr>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            $user=$info['username'];
            if($userLoggedIn != $user) {
                $user=$info['username'];
                    $logged_in_user_obj=new Get_User_Info($con, $userLoggedIn);?>
            <form action="" method="post">
                   <?php if ($logged_in_user_obj->isFriend($user)) {
                        ?>
                <button class="btn btn-danger btn-block" name="remove_friend">Remove Friend</button>
                <!--<input type="submit" name="remove_friend" class="btn btn-danger" value="Remove Friend"><br>-->
                    <?php } else if ($logged_in_user_obj->didReceiveRequest($user)) {?>
                        <button class="btn btn-warning btn-block" name="confirm_request">Confirm Request</button>
                        <button class="btn btn-danger btn-block" name="ignore_request">Ignore Request</button>
                        <!--<input type="submit" name="respond_request" class="btn btn-warning" value="Respond to Request"><br>-->
                    <?php } else if ($logged_in_user_obj->didSendRequest($user)) {?>
                        <button  name="cancel_req" class="btn btn-warning btn-block" style=""><small style="color:green;"><b><em>Request Sent</em></b></small><br>Cancel Request</button><br>
                    <?php } else{?>
                        <button class="btn btn-primary btn-block" name="add">Add Friend</button>
<!--                        <input type="submit" name="add_friend" class="btn btn-success" value="Add Friend"><br>-->
                    <?php } ?>
            </form>
               <?php }
                ?>
            
            <?php
                if($info['username']!==$_SESSION['username']){
            ?>
            <a href="message.php?msg_to=<?php echo $info['username'];?>" name="msg" class="btn btn-success btn-block">MESSAGE</a>
            <?php } ?>
            <a href="userdetails.php?u=<?php echo $info['username'];?>" name="userdetails" class="btn btn-default btn-block">View Details</a>
            
        </div>
        
        <div class="col-md-offset-0 col-md-6" style="overflow-y: overlay; height: 800px;width:50%;">
            
            <div class="well">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4 class="text" style="font-family: cursive;color: #2ecc71"><b><u>Make Post:</u></b></h4>
                        <input type="text" name="title" class="form-control" placeholder="Title (Optional)">
                        <textarea name="post_details" class="form-control" rows="4" placeholder="What's on Your Mind"></textarea>
                        <input type="file" name="img" accept="image/*">
                        <input type="hidden" name="post_to" value="<?php echo $info['username'];?>">
                        <button name="btn" class="btn btn-sm btn-success btn-block">POST</button>
                    </div>
                </form>
            </div>
            
            <!--    Post in profile-->
            
            <?php while ($post=mysqli_fetch_assoc($query_result)){ 
                $userInfo=new Get_User_Info($con, $post['username']);
                $posterName=$userInfo->getName();
                $pic=$userInfo->getProfilePic();
                $user_to=new Get_User_Info($con, $post['user_to']);
                $post_to=$user_to->getName();
                
                ?>
            <div class="well">
                <div class="col-md-12">
                        <div class="col-md-11">
                            <?php 
                            if($post['user_to']!='none'){
                            ?>
                            <h4>
                                <a href="all_profile.php?id=<?php echo $post['username']; ?>" style="font-family: cursive; color: #2ecc71"><img src="<?php echo $pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $posterName.'</a><i style="color:red">&nbsp; To &nbsp;</i>'.$post_to; ?>
                            </h4>
                            <?php }else{ ?>
                            <h4>
                                <a href="all_profile.php?id=<?php echo $post['username']; ?>" style="font-family: cursive; color: #2ecc71"><img src="<?php echo $pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $posterName; ?></a>
                            </h4>
                            <?php }?>
                            <h6>
                                <?php 
                                // Time interval
                                $date_time=$post['posting_date'];
                                $time_message=$postStatus->timeInterval($date_time);
                                echo $time_message;

                                ?>
                            </h6>
                        </div>
                        <!--  rightside button-->
                        <?php if (($post['username'] == $_SESSION['username']) || ($post['user_to'])==$userLoggedIn) { ?>
                            <div class="col-md-1">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">...</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="edit_post.php?pid=<?php echo $post['post_id'];?>">Edit</a></li>
                                        <li><a href="?delete=<?php echo $post['post_id']?>" onclick="return confirm('Are you want to delete the post ?')">delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <hr>
                <h4 class="text-center"><u><b><?php echo $post['post_title']; ?></b></u></h4>
                    <?php if(strlen($post['post_details'])>=300){?><p style="padding:0px 25px 0px 25px"><?php echo substr($post['post_details'],0,300)?></p>
                    <p style="padding:0px 25px 0px 25px"><a class="btn btn-sm btn-default" href="post_details.php?pid=<?php echo $post['post_id'];?>" role="button">See More &raquo;</a></p>
                    <?php }else{?>
                    <p style="padding:0px 25px 0px 25px"><?php echo $post['post_details'];?></p><?php }?>
                    <div class="" style="padding:0px 10px 0px 10px">
                        <img src="<?php echo $post['img_name'];?>" alt="" class="img-responsive">
                    </div>
                    
                    <div class="row" style="padding:0px 25px 0px 25px">
                        <div class="post">
                        <?php 
                      //determine if user all ready like the post
                      $res=mysqli_query($con,"SELECT * FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]';");
                      if(mysqli_num_rows($res)==1){ ?>
                          <!--user already like post-->
                          <span><a href="" class="unlike col-md-6 btn btn-success" id="<?php echo $post['post_id'];?>">Liked</a></span>
                      <?php } else { ?>
                          <span><a href="" class="like col-md-6 btn btn-default" id="<?php echo $post['post_id'];?>">Like</a></span>
                      <?php }?>
                        <a class="col-md-6 btn btn-default" href="post_details.php?pid=<?php echo $post['post_id'];?>">Comment</a>
                        </div>          
                    </div>
                
            </div>
            <?php } ?>
        </div>
    </div>

    
</div>

</body>

<?php include '../layout/footer.php'?>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/search.js"></script>
<script type="text/javascript" src="../assets/js/likeUnlike.js"></script>
