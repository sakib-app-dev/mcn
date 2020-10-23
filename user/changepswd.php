<?php
include '../layout/top.php';
$id=$_GET['u'];

$msg='';
$user_info=new User_info();
$query_user=$user_info->all_info_users($id);
$info= mysqli_fetch_assoc($query_user);
$num_friend=(substr_count($info['friend_array'],","))-1;

if(isset($_POST['btn'])){
    $user=new User_info;
    $msg=$user->changePSWD($_POST);
}
if($info['username']==$_SESSION['username']){
?>
<head>
<title>Change password</title>
<link rel="icon" href="../images/MIST_logo.png" type="image/gif">

<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</head>

<?php include '../layout/menu.php'?>
<body>
<div class="container" style="margin-top: 120px;">

    <div class="row" >
        
        <div class="well col-md-3">
            <a href="all_profile.php?id=<?php echo $info['username'];?>">
                <img src="<?php echo $info['profile_pic'];?>" alt="" class="img-responsive"><hr/>
                <p><b style="font-family:cursive; font-size: 20px; color: #17a2b8"><?php echo $info['name'];?></b></p>
            </a>
            <p style="font-style: italic; color: #20AAE5">Number Of Posts = <?php echo $info['num_posts'];?></p>
            <p style="font-style: italic; color: #20AAE5">Number Of Friends = <?php echo $num_friend;?></p>
            
            <?php
                
            ?>
            <a href="edituserdetails.php?u=<?php echo $info['username'];?>" name="userdetails" class="btn btn-default" style="margin: 5px 21px;">Edit Details</a>
            
        </div>
        <div class=" well col-md-offset-1 col-md-7" style=" margin-top: 30px;padding: 50px;">
            <h3 align="center"> <b><u>Update Password</u></b></h3><hr>
            <h4 class="text text-center text-success"><?php echo $msg;?></h4>
            <form class="form-horizontal" action="" method="POST">
                           
                           <div class="form-group">
                               <label class="control-label col-md-3">Old Password</label>
                               <div class="col-md-8">
                                   <input type="password" name="old_password" required="" placeholder="Enter Your Password..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-3">NEW Password</label>
                               <div class="col-md-8">
                                   <input type="password" name="new_password" required="" placeholder="Enter Your Password..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-3">Re-Password</label>
                               <div class="col-md-8">
                                   <input type="password" name="re_password" required="" placeholder="Enter Your Password..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">

                               <div class="col-md-offset-3 col-md-8">
                                   <input type="submit" name="btn" value="Log In" class="btn btn-success btn-block">
                               </div>
                           </div>   
                       </form>
        
    </div>
</div>
</body>
<?php } ?>