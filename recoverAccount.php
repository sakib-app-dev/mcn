<?php
include_once './config/configr.php';
$msg='';

if(isset($_POST['btn'])){
    
    $email=$_POST['email'];
    $sql=mysqli_query($con,"SELECT name,email,token from user_info where email='$email'");
    $exe= mysqli_fetch_assoc($sql);
    $name=$exe['name'];
    $email=$exe['email'];
    $token=$exe['token'];
//    echo "<pre>";
//    print_r($email);
//    exit();
//    
    $subject="Recove Account";
    $body="Hi ". $name ." Here is the  Code for recover your account http://localhost/MCN/resetPassword.php?token=".$token;
    $sendBy="From:saapurbo09@gmail.com";
//    $mail=mail($email,$subject,$body,$sendBy);
    if(mail($email,$subject,$body,$sendBy)){
    header('Location:index.php');
    } else {
    $msg="Something goning wrong ..Please try again";
    return $msg;
    }
    
}



 
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Recover Password</title>
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
            <div class="col-md-offset-2 col-md-8">
                <div class="well" style="margin-right:12px;margin-top:12px; padding-bottom: 60px;">
                    <h3 class="text-center text-success"><b>Recover Account</b></h3>
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

                            <div class="col-md-offset-3 col-md-8">
                                <input type="submit" name="btn" value="Recover Account" class="btn btn-success btn-block">
                            </div>
                        </div>   
                    </form>
                    
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
   </body>
</html>