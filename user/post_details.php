<?php
session_start();
include_once '../class/post_query.php';
include_once '../class/notification.php';
$post=new Post_query();

if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $post->delete_post($id);
}


$pid=$_GET['pid'];
//$id=$_GET['id'];



$query_result=$post->postInfoById($pid);
$post= mysqli_fetch_assoc($query_result);
//$post_id=$post['post_id'];
//if (isset($_POST['btn'.$post_id])) {
//    $post->submit_comment($_POST);
//    }

include_once '../config/configr.php';
if(isset($_POST['btn'])){
    $date_time_comment = date("Y-m-d H:i:s");
    $comment = $_POST['comment'];
    $comment_to= mysqli_query($con, "SELECT username FROM user_post WHERE post_id='$pid'");
    $cmntTo=mysqli_fetch_assoc($comment_to);
    $posted_to =$cmntTo['username'];
    $userLoggedIn=$_SESSION['username'];
//    echo '<pre>';
//    print_r($cmntTo);
//    exit();
    if($comment!=''){
    $sql = "INSERT INTO post_comments VALUES ('','$userLoggedIn','','$pid','$date_time_comment','$comment','no')";
    if (mysqli_query($con, $sql)) {
        if($posted_to  != $userLoggedIn) {
                $notification = new Notification($con, $userLoggedIn);
                $notification->insertNotification($pid, $posted_to , "comment");
        }
        
 } else {
        die("Query Problem" . mysqli_error($con));
    }
    
    }
//    include '../class/notification.php';
//    if($posted_to != $userLoggedIn) {
//			$notification = new Notification();
//			$notification->insertNotification($pid, $posted_to, "comment");
//		}
}


$sql="SELECT * FROM user_info WHERE username='$post[username]'";
$query= mysqli_query($con, $sql);
$row= mysqli_fetch_assoc($query);
$user_name=$row['name'];
$user_pic=$row['profile_pic'];

$commentUserSql=mysqli_query($con,"SELECT *FROM post_comments WHERE post_id='$pid'") ;


//      LIKE & UNLIKE 
 
    
// Insert like.........
    if(isset($_POST['like'])){
       $postStatus->likePost($_POST);
   }
   
// Delete Like 
   if(isset($_POST['unlike'])){
       $postStatus->unlikePost($_POST);
   }

?>
<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<?php include '../layout/menu.php'?>
<body>
<div class="container">

    <div class="row" style="padding-top: 60px;">

        <div class=" col-md-8">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="col-md-11">
                            <h4>
                                <a href="all_profile.php?id=<?php echo $post['username']; ?>" style="font-family: cursive;color: #2ecc71"><img src="<?php echo $user_pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $user_name; ?></a>
                            </h4>
                            <h6><?php echo $post['posting_date']; ?></h6>
                            </div>
                            
                            <!--  rightside button-->
                            <?php if($post['username']==$_SESSION['username']){?>
                            <div class="col-md-1">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">...</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="edit_post.php?pid=<?php echo $post['post_id'];?>">Edit</a></li>
                                        <li><a href="?delete=<?php echo $post['post_id']?>" onclick="return confirm('Are you want to delete the post ?')">delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php }?>
                            
                        </div>
                        <hr>
                        <h2 align="center"><u><?php echo $post['post_title']; ?></u></h2>
                        <p><?php echo $post['post_details']; ?></p>
                        <p><img src="<?php echo $post['img_name'];?>" alt="" class="img-responsive" style="padding:0px 0px 10px 0px"></p>
                    </div>
                </div>
                <div class="panel">
                    <?php 
                      //determine if user all ready like the post
                      $res=mysqli_query($con,"SELECT * FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]';");
                      if(mysqli_num_rows($res)==1){ ?>
                          <!--user already like post-->
                          <span><a href="" class="unlike col-md-12 btn btn-success" id="<?php echo $post['post_id']; ?>">Liked</a></span>
                      <?php } else { ?>
                          <span><a href="" class="like col-md-12 btn btn-default" id="<?php echo $post['post_id']; ?>">Like</a></span>
                      <?php }?>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label><textarea name="comment" class="form-control" style="width:104%;" rows="2" placeholder="Comment Your Opinion !!!"></textarea></label>
                                
                                <button name="btn" class="btn btn-sm btn-success pull-right" style="padding:15px;margin-right:-12px;margin-top: 2px;">Comment</button>
                            </div>
                        </form>
                        <hr>
                        <?php  while ($commentShow = mysqli_fetch_assoc($commentUserSql)) { 
                            $userSql="SELECT * FROM user_info WHERE username='$commentShow[comment_by]'";
                            $userQuery = mysqli_query($con, $userSql);
                            $row = mysqli_fetch_assoc($userQuery);
                            $user_name = $row['name'];
                            $user_pic = $row['profile_pic'];
                            $commentDate=$commentShow['comment_date'];
                            $timeQ=new Post_query();
                            $time_message=$timeQ->timeInterval($commentDate);
                        ?>
                        <div>
                            <h4>
                                <a href="all_profile.php?id=<?php echo $commentShow['comment_by']; ?>" style="font-family: cursive;color: #2ecc71"><img src="<?php echo $user_pic; ?>" style="width: 40px; float: left; margin-right: 6px;" alt="" class="img-responsive"><?php echo $user_name; ?></a>
                            </h4>
                            <h6><?php echo $time_message;?></h6>
                            <p><?php echo $commentShow['comment_details'];?></p>
                        </div><hr/>
                        <?php  } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/likeUnlike.js"></script>
<?php include '../layout/footer.php'?>


