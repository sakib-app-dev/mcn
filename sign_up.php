<?php 
session_start();
$msg='';
if(isset($_SESSION['user_id'])){
    if ($_SESSION['user_id']!=NULL){
        header('Location:user/index.php');
    }
}
    include_once './class/user.php';
    $user=new User;
    if(isset($_POST['btn'])){
    $msg=$user->sign_up($_POST);
    
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Sign Up</title>
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
      <style>
          .bg-img {
              background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/background/27250817-modern-social-network-connection-background-.jpg");
              height: 50%;
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
       <div class="container-fluid bg-img"  style="margin-top:-22px;padding: 15px;">
           <h2 class="text-capitalize text-success">Images:</h2>
           <div class="row">
               <div class="col-md-offset-1 col-md-4 w3-content w3-section" style="max-width:450px; padding-left: 20px;margin-top: 8px;">
                   <img class="mySlides" src="images/MIST_logo.png" style="width:100%">
                   <img class="mySlides" src="images/0.jpg" style="width:100%;height: 419px;">
              </div>

               <div class=" col-md-6 pull-right">
                   <div class="well" style="margin-right: 60px; padding: 40px; margin-bottom: 60px">
                       <h3 class="text-center text-success"><b>MCN Sign Up</b></h3><hr/>
                       <h4 class="text text-center text-success"><?php echo $msg;?></h4>
                       <br/>
                       <form class="form-horizontal" action="" method="POST">
                           <div class="form-group">
                               <label class="control-label col-md-2">Name:</label>
                               <div class="col-md-9">
                                   <input type="text" name="name" required=""  placeholder="Enter Your Name..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">E-mail:</label>
                               <div class="col-md-9">
                                   <input type="email" name="email" required="" placeholder="Enter Your E-mail address..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">Birthday:</label>
                               <div class="col-md-9">
                                   <input type="date" name="dob" required=""  class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">I Am:</label>
                               <div class="form-check form-check-inline">
                                   <label class="radio-inline">
                                       <input type="radio" name="i_am" value="student" checked>Student
                                   </label>
                                   <label class="radio-inline">
                                       <input type="radio" name="i_am" value="teacher">Teacher
                                   </label>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">MIST ID No.:</label>
                               <div class="col-md-9">
                                   <input type="number" name="id_no" required="" placeholder="Enter Your Id of institution..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">Gender:</label>
                               <div class="form-check form-check-inline">
                                   <label class="radio-inline">
                                       <input type="radio" name="gender" value="male" checked>Male
                                   </label>
                                   <label class="radio-inline">
                                       <input type="radio" name="gender" value="female">Female
                                   </label>
                               </div>
                           </div>
                           
                           <div class="form-group">
                               <label class="control-label col-md-2">Password:</label>
                               <div class="col-md-9">
                                   <input type="password" name="password" required="" placeholder="Set a password..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-2">Re-Password:</label>
                               <div class="col-md-9">
                                   <input type="password" name="re_password" required="" placeholder="Enter your password again for check..." class="form-control">
                               </div>
                           </div>
                           <div class="form-group">

                               <div class="col-md-offset-2 col-md-9">
                                   <input type="submit" name="btn" value="Sign UP" class="btn btn-success btn-block">
                               </div>
                           </div>   
                       </form>
                       <hr/>
                       <div class="form-group">
                           <div class="col-md-offset-3 col-md-8">
                               <i>Do You Want to</i>
                               <a href="index.php"><input type="submit" name="login" value="Log In" class="btn btn-success"></a>
                           </div>
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