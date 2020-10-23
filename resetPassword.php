<?php
include_once './config/configr.php';
if(isset($_GET['token'])){
    $token=$_GET['token'];
}
if(isset($_POST['btn'])){
            $password=$_POST['new_password'];
            $re_password=$_POST['re_password'];
            
                   
                    
            //password condition
                    if(strlen($password)>30){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be not more than 30 character..!!</div>";
                        return $msg;
                    }elseif(strlen($password)<6){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be at least 6 character..!!</div>";
                        return $msg;
                    }elseif(preg_match('/[^A-Za-z0-9]/',$password)){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be contain English character & Number..!!</div>";
                        return $msg;
                    }
                    elseif($password!=$re_password){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password doesn't matched. Try again..!!</div>";
                        return $msg;
                        }else{
                            $password=md5($password);
                        }
            
            $sql="UPDATE user_info SET password='$password' WHERE token='$token'";
            if(mysqli_query($con, $sql)){
                $query= mysqli_query($con, $sql);//Checking are query ok or not
                header('Location:index.php');
           }else{
           die('Query Problem'.mysqli_error($con));
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
                    <hr>
                     <form class="form-horizontal" action="" method="POST">
                           
                           
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
        </div>
    </div>
