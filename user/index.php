
<?php
    
    include '../layout/top.php';
    $postStatus=new Post_query();
    
    
    
    
    if (isset($_POST['btn'])) {
    $postStatus->save_post($_POST);   //To save data in database
    }
    
    $query_result=$postStatus->show_all_post();// show post in the index page
    
  if(isset($_GET['delete'])){
       $pid=$_GET['delete'];
       //echo '<pre>';
//print_r($postid);
//exit();
       $postStatus->delete_post($pid);
   }
  
//      LIKE & UNLIKE 
 
    
// Insert like.........
    if(isset($_POST['like'])){
       $postStatus->likePost($_POST);
   }
   
// Delete Like 
   if(isset($_POST['unlike'])){
       $postStatus->unlikePost($_POST);
   }
   
   
   if(isset($_POST['add'])) {
       $user=$_POST['user'];
        $userReq = new Friend_Request();
	$userReq->sendReq($user);
}
  
?>






<head>
    <title>Home Page</title>
    <link rel="icon" href="../images/MIST_logo.png" type="image/gif">

    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">

    <style type="text/css">
        ::-webkit-scrollbar { 
        display: none; 
    }
    </style>
</head>
<?php include_once '../layout/menu.php';?>

<!--Posting Box-->
<body>

 
  

<div class="container pro-bg-img">
    
  
    <div class="row" style="padding-top: 40px;margin-left: -80px">
        
        <div class="col-md-3" style="padding-top:2px;">
            <?php include ('left_buttons.php');?>
        </div>
        
        <div class="col-md-6" style="overflow-y: overlay; height: 662px;width:50%;">
            <div class="well">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4 class="text" style="font-family: cursive;color: #2ecc71"><b><u>Make Post:</u></b></h4>
                        <input type="text" name="title" class="form-control" placeholder="Title (Optional)">
                        <textarea name="post_details" class="form-control" rows="4" placeholder="What's on Your Mind"></textarea>
                        <input type="file" name="img" accept="image/*">
                        <button  name="btn" class="btn btn-sm btn-success btn-block">POST</button>
                    </div>
                </form>
            </div>
            

            
            <!--Post in profile-->
            
            <?php 
            include_once '../config/configr.php';
            
            while ($post = mysqli_fetch_assoc($query_result)) { 
                $userInfo = "SELECT friend_array FROM user_info WHERE username='$_SESSION[username]'";
                $infoQuery = mysqli_query($con, $userInfo);
                $userdata = mysqli_fetch_array($infoQuery);
                $friendList = $userdata['friend_array'];
                
                if(strstr($friendList, $post['username']) || $post['username']==$_SESSION['username'] || $post['user_to']==$userLoggedIn){
                $sql="SELECT * FROM user_info WHERE username='$post[username]'";
                $query= mysqli_query($con, $sql);
                $row= mysqli_fetch_assoc($query);
                $user_name=$row['name'];
                $user_pic=$row['profile_pic'];
                
                $post_to=$post['user_to'];
                $userTo=new Get_User_Info($con, $post_to);
                $username=$userTo->getUsername();
                $post_to=$userTo->getname();
                
                
                ?>
            <div class="well">
                <div class="col-md-12">
                        <div class="col-md-11">
                            <?php 
                            if($post['user_to']!='none'){
                            ?>
                            <h4>
                                <a href="all_profile.php?id=<?php echo $post['username']; ?>" style="font-family: cursive; color:"><img src="<?php echo $user_pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $user_name.'</a><i style="color:red">&nbsp; To &nbsp;</i><a href="all_profile.php?id=<?php echo $username;?>">'.$post_to.'</a>'; ?>
                            </h4>
                            <?php }else{ ?>
                            <h4>
                                <a href="all_profile.php?id=<?php echo $post['username']; ?>" style="font-family: cursive; color: "><img src="<?php echo $user_pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $user_name; ?></a>
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
                                <div class="dropdown" >
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">...</button>
                                    <ul class="dropdown-menu" >
                                        <li><a href="edit_post.php?pid=<?php echo $post['post_id']; ?>">Edit</a></li>
                                        <li><a href="?delete=<?php echo $post['post_id'] ?>" onclick="return confirm('Are you want to delete the post ?')">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <hr>
                <h4 class="text-center"><u><b><?php echo $post['post_title']; ?></b></u></h4>
                
                    <?php if(strlen($post['post_details'])>=300){?><p style="padding:0px 25px 0px 25px"><?php echo substr($post['post_details'],0,300)?>&nbsp;<a class="btn btn-sm btn-default" href="post_details.php?pid=<?php echo $post['post_id'];?>" role="button">See More &raquo;</a></p>
                    <?php }else{?>
                    <p style="padding:0px 25px 0px 25px""><?php echo $post['post_details'];?></p><?php }?>
                    <div class="" style="padding:0px 10px 0px 10px">
                        <img src="<?php echo $post['img_name'];?>" alt="" class="img-responsive" style="padding:0px 0px 10px 0px">
                    </div>
                    <div class="row" style="padding:0px 25px 0px 25px">
                        <div class="post">
                        <?php 
                      //determine if user all ready like the post
                      $res=mysqli_query($con,"SELECT * FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]';");
                      if(mysqli_num_rows($res)==1){ ?>
                          <!--user already like post-->
                          <span><a href="" class="unlike col-md-6 btn btn-success" id="<?php echo $post['post_id']; ?>">Liked</a></span>
                      <?php } else { ?>
                          <span><a href="" class="like col-md-6 btn btn-default" id="<?php echo $post['post_id']; ?>">Like</a></span>
                      <?php }?>
                        <a class="col-md-6 btn btn-default" href="post_details.php?pid=<?php echo $post['post_id'];?>">Comment</a>
                        </div>
                    </div>
                    
            </div>
            
                <?php } }?>




        </div>
        <div class="col-md-3" style="padding:10px;">
            <div class="well" style="max-height:255px;overflow-y: scroll; width: 122%">
                <?php
                 $query=mysqli_query($con, "SELECT * FROM notice ORDER BY id DESC LIMIT 1");
                 while($row=mysqli_fetch_assoc($query)){
                 $title=$row['title'];
                 $details=$row['details'];
                 $postindDate=$row['posting_date'];
                 $dateUntil=$row['post_until'];
                 
                 $currentDate=date("Y-m-d");
                 $date_now=new DateTime($currentDate);
                 $end_date=new DateTime($dateUntil);
                 if($date_now<$end_date){
                 
                ?>
                <b style="font-size: 25px;color: green;">Notice</b>
                <h4 style="font-size: 15px;font-weight: bold;"><?php echo $title;?></h4>
                <p style="font-size: 15px"><?php echo $details;?></p>
                 <?php } }?>
            </div>
            <div class="well" style="max-height:255px;overflow-y: scroll; width: 122%">
                <b style="font-size: 15px;color: green;">Add Friends</b>
                <div style="">
                    <table class="table table-hover">
                    <?php
                        $query=mysqli_query($con,"SELECT * FROM user_info ORDER BY user_id DESC");
                        while($res= mysqli_fetch_assoc($query)){
                        $user=$res['username'];
                        //are frnd or not
                        $ifFrnd=new Get_User_Info($con, $userLoggedIn);
                        $frnd=$ifFrnd->isFriend($user);
                        //are send req from or to user
                        $recReq=$ifFrnd->didReceiveRequest($user);
                        $sendReq=$ifFrnd->didSendRequest($user);
                        $mutualFriends = $ifFrnd->getMutualFriends($user);
                        
                        if($user!=$userLoggedIn && $user!=$frnd && $user!=$recReq && $user!=$sendReq ){
                        $activeuser=new Get_User_Info($con, $user);
                        $name=$activeuser->getName();
                        $pic=$activeuser->getProfilePic();
                    ?>
                   
                    <tr>
                        <td><img src="<?php echo $pic;?>" style="height:25px;border-radius: 13px;"></td>
                        <td> <a href="all_profile.php?id=<?php echo $user;?>" style="font-size:14px;color: #5cb85c;">
                                    <?php echo $name.'<br>'.$mutualFriends.' mutual friends';?>
                                </a>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="user" value="<?php echo $user;?>">
                                <button class="btn btn-default btn-sm" name="add">+Add Friend</button>
                            </form>
                        </td>
                    </tr>
                            
                        
                        <?php } }?>
                        
                    </table> 
                </div>
            </div>
            
            
            <!--Online Actives-->
            <div>

                <?php include './onlineActives.php';?>
            </div>
            
         </div>
        

    </div>
    
    

  <!-- Button to Open the Modal -->

            
 

     
</div>


</body>
      
<?php include '../layout/footer.php'?>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery-3.3.1.min.js"></script>


<!--JS for Like & Unlike-->
<script type="text/javascript" src="../assets/js/likeUnlike.js"></script>
<script type="text/javascript" src="../assets/js/search.js"></script>