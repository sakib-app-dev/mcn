<?php
session_start();
$msg='';
if(isset($_SESSION['user_id'])){
    if ($_SESSION['user_id']!=NULL){
        header('Location:user/index.php');
    }
}
    
include_once './class/user.php';
    $user=new User();
    if(isset($_POST['btn'])){
        $msg=$user->log_in($_POST);
    }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Log_In</title>
      <link rel="icon" href="images/MIST_logo.png" type="image/gif">
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <style>
          .bg-img {
              background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/background/4.jpg");
              height: 630px;
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
              position: relative;
            }
      </style>
   </head>
   <body>
       <h1 class="container-fluid well" style="font-size: 55px; color: white; background-color: #44cc00; margin-top: 0;" align="center">
           MIST Community & Network
       </h1>
       <div class="container-fluid bg-img" style="margin-top:-22px;padding: 15px">
           
           <div class="row" style="padding: 65px;">
               <div class="col-md-4 w3-content w3-section" style="max-width:450px; padding-left: 20px;">
                   <img class="mySlides" src="images/MIST_logo.png" style="width:100%">
                   <img class="mySlides" src="images/0.jpg" style="width:100%;height: 380px;">
                   <img class="mySlides" src="images/2.jpg" style="width:100%;height: 380px;">
                   <img class="mySlides" src="images/1.jpg" style="width:100%;height: 380px;">
                   <img class="mySlides" src="images/mlogo.jpg" style="width:100%;height: 380px">
               </div>

               <div class=" col-md-7 pull-right">
                   <div class="well" style="margin-right:12px;margin-top:12px; padding-bottom: 60px;">
                       <h3 class="text-center text-success"><b>MCN Log In</b></h3>
                       <h4 class="text text-center text-alert"><?php echo $msg;?></h4>
                       <br/>
                       <form class="form-horizontal" action="" method="POST">
                           <div class="form-group">
                               <label class="control-label col-md-3">Email</label>
                               <div class="col-md-8">
                                   <input type="email" name="email" required="" placeholder="Enter Your E-mail Address..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-3">Password</label>
                               <div class="col-md-8">
                                   <input type="password" name="password" required="" placeholder="Enter Your Password..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">

                               <div class="col-md-offset-3 col-md-8">
                                   <input type="submit" name="btn" value="Log In" class="btn btn-success btn-block">
                               </div>
                           </div>   
                       </form>
                       <span style="margin-left:168px;"><a href="recoverAccount.php">Forgotten Password</a></span>
                       <hr/>
                       <div class="form-group">
                           <div class="col-md-offset-3 col-md-8">
                               <i>If you are not registered..Please Click On..</i><br>
                               <a href="sign_up.php"><input type="submit" name="signup" value="Sign Up" class="btn btn-info btn-block"></a>
                           </div><hr>
                       </div>
                   </div>
               </div>
           </div>
       </div>


            <script>
            var myIndex = 0;
            carousel();

            function carousel() {
                var i;
                var x = document.getElementsByClassName("mySlides");
                for (i = 0; i < x.length; i++) {
                   x[i].style.display = "none";  
                }
                myIndex++;
                if (myIndex > x.length) {myIndex = 1}    
                x[myIndex-1].style.display = "block";  
                setTimeout(carousel, 3000); // Change image every 2 seconds
            }
            </script>
      
      
      
      
      <?php include 'layout/footer.php'?>
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>