<?php
include '../layout/top.php';
$gid=$_GET['gid'];


$group=new Group();
if (isset($_POST['btn'])) {
    $group->saveGrpPost($_POST);
    }
$query_result=$group->show_post_group_id($gid);

$grp_info= mysqli_query($con, "SELECT * FROM groups WHERE grp_link='$gid'");
$grpRes=mysqli_fetch_assoc($grp_info);
$admin=$grpRes['admin'];
$grp_type=$grpRes['type'];
if(isset($_POST['joined'])){
    $dlt= mysqli_query($con, "DELETE FROM group_members WHERE grp_member_username='$userLoggedIn' AND grp_link='$gid'");
    
}
if(isset($_POST['join'])){
    
    $join=mysqli_query($con,"INSERT INTO grp_req VALUES ('','$userLoggedIn','$admin','$gid')");
}
if(isset($_POST['cancelreq'])){
    $dlt= mysqli_query($con, "DELETE FROM grp_req WHERE user_from='$userLoggedIn' AND grp_link='$gid'");
}


?>
<html>
    <head>
      <title>Create Group</title>
      <link rel="icon" href="images/MIST_logo.png" type="image/gif">
      <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
   </head>
   
   <body>
       <?php include_once '../layout/menu_1.php';?>
       <div style="height: 320px;padding-top: 40px;background-color: #ffb31a">
               <?php 
               
               $sql="SELECT * FROM groups where grp_link='$gid'";
               $qry=mysqli_query($con, $sql);
               $qryRes=mysqli_fetch_assoc($qry);
               
               $reqSql=mysqli_query($con,"SELECT * FROM grp_req WHERE user_from='$userLoggedIn' AND grp_link='$gid' ");
               $res=mysqli_fetch_assoc($reqSql);
               $reqsender=$res['user_from'];
               $member=mysqli_query($con,"SELECT * FROM group_members WHERE grp_member_username='$userLoggedIn' AND grp_link='$gid'");
               $r=mysqli_num_rows($member);
               
//            echo '<pre>';
//            print_r($r);
//            exit();
//               
               ?>
               <h1 align="center" style="font-size: 70px;"><b><?php echo $qryRes['group_name'];?></b></h1><br>
               <h4 align="center" style="font-size: 25px;">Total members: <?php echo $qryRes['members']?></h4>
               <h4 align="center" style="font-size: 25px;">Number of Posts: <?php echo $qryRes['num_posts']?></h4>
               <center>
               <?php if($r>0){ ?>
                   <button name="joined" class="btn btn-primary btn-lg join-button">Joined Here</button>
               <?php }elseif($reqsender==$userLoggedIn){ ?>
                   <button name="cancelreq" class="btn btn-warning btn-lg join-button">Request Sent</button>
               <?php }else{?>
                   <button name="join" class="btn btn-default btn-lg join-button">Join</button>
               <?php } ?>
               </center>
               
           </div>
       <div class="container" style="padding-top: 6px;">
           <div class="col-md-3">
               <?php include 'left_buttons.php';?>
           </div>
           <div class=" col-md-6">
               <div class="well">
                   <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4 class="text" style="font-family: cursive;color: #2ecc71"><b><u>Make Post:</u></b></h4>
                        <input type="hidden" name="grp_name" value="<?php echo $gid;?>">
                        <input type="text" name="title" class="form-control" placeholder="Title (Optional)">
                        <textarea name="post_details" class="form-control" rows="4" placeholder="What's on Your Mind"></textarea>
                        <input type="file" name="img" accept="image/*">
                        <button name="btn" class="btn btn-sm btn-success btn-block">POST</button>
                    </div>
                </form>
            </div>
               
               <?php while($grp_post=mysqli_fetch_assoc($query_result)){
                  
                   include_once '../config/configr.php';
                   $user_Query= mysqli_query($con, "SELECT * FROM user_info WHERE username='$grp_post[username]'");
                   $user_info=mysqli_fetch_assoc($user_Query);
                   
                   $user_pic=$user_info['profile_pic'];
                   $user_name=$user_info['name'];
                   ?>
               <div class="well">
                   <div class="col-md-12">
                        <div class="col-md-11">
                            <h4>
                                <a href="all_profile.php?id=<?php echo $grp_post['username']; ?>" style="font-family: cursive;color: #2ecc71"><img src="<?php echo $user_pic; ?>" style="width: 40px; float: left; margin-right: 8px;" alt="" class="img-responsive"><?php echo $user_name; ?></a>
                            </h4>
                            <h6>
                                <?php 
                                // Time interval
                                $date_time=$grp_post['posting_date'];
                                $time_message=$group->timeIntervalGrp($date_time);
                                echo $time_message;

                                ?>
                                
                            </h6>
                        </div>
                        <!--  rightside button-->
                        <?php if ($grp_post['username'] == $_SESSION['username']) { ?>
                            <div class="col-md-1">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">...</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="editGroup_post.php?gpid=<?php echo $grp_post['grp_post_id']; ?>">Edit</a></li>
                                        <li><a href="?delete=<?php echo $grp_post['grp_post_id'] ?>" onclick="return confirm('Are you want to delete the post ?')">delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                   <?php echo $grp_post['post_details'];?>
                    <div class="" style="padding:0px 10px 0px 10px">
                        <img src="<?php echo $grp_post['img_name'];?>" alt="" class="img-responsive" style="padding:0px 0px 10px 0px">
                    </div>
               </div>
               <?php }?>
           </div>
           <div class="col-md-3">
               <div class="well">
                   <h4>Members of This Group</h4>
               <?php 
                                           $query=mysqli_query($con, "SELECT * FROM group_members WHERE grp_link='$gid'");
                                           while($row=mysqli_fetch_assoc($query)){
                                               $user=$row['grp_member_username'];
                                               $mem=new Get_User_Info($con, $user);
                                               $name=$mem->getName();
                                               $pic=$mem->getProfilePic();
                                               
                                               $sql= mysqli_query($con, "SELECT * FROM groups WHERE grp_link='$gid'");
                                               while($res=mysqli_fetch_assoc($sql)){
                                                   $admin=$res['admin'];
                                                   
                                               ?>
                   <table class="table table-responsive">
                     <?php if($userLoggedIn==$admin){?>  
                   <tr>
                       <td><img src="<?php echo $pic;?>" style="height: 35px;border-radius: 20px;"></td>
                       <td><a href="../user/all_profile.php?id=<?php echo $user;?>"><?php echo $name;?></a></td>
                       <td><button class="btn btn-danger btn-sm">Remove</button></td>
                   </tr>
                     <?php }else { ?>
                   <tr>
                       <td><img src="<?php echo $pic;?>" style="height: 35px;border-radius: 20px;"></td>
                       <td><a href="../user/all_profile.php?id=<?php echo $user;?>"><?php echo $name;?></a></td>
                       <td><button class="btn btn-default btn-sm">+Add Friend</button></td>
                   </tr>
                     <?php } ?>
               </table>
                                               
                                               <?php   }   } ?>
               </div>
               
               <!--//Online List-->
               <div>
                   <?php include '../user/onlineActives.php';?>
               </div>
               
           </div>
           
       </div>
       
       
       
       
       <?php include '../layout/footer.php'?>
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
   </body>
</html>
