<?php
session_start();
$msg='';
if(isset($_SESSION['id'])){
    if ($_SESSION['id']!=NULL){
        header('Location:admin_panel/index.php');
    }
}

include_once './adminLogIn.php';
$admin=new AdminLogIn();
    if(isset($_POST['btn'])){
        $admin->adminLogIn($_POST);
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Log_In</title>
      <link rel="icon" href="images/MIST_logo.png" type="image/gif">
      <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
   </head>
   <body>
       <h1 class="container-fluid well" style="font-size: 55px; color: white; background-color: #44cc00; margin-top: 0;" align="center">
           MIST Community & Network
       </h1>
       <div class="container-fluid">
           
           <div class="row">
              
               <div class="col-md-offset-2 col-md-8">
                   <div class="well" style="margin-right: 60px; padding: 60px;">
                       <h3 class="text-center text-success"><b>MCN Admin Log-In</b></h3>
                       <h4 class="text text-center text-alert"><?php echo $msg;?></h4>
                       <br/>
                       <form class="form-horizontal" action="" method="POST">
                           <div class="form-group">
                               <label class="control-label col-md-3">Admin Name:</label>
                               <div class="col-md-8">
                                   <input type="text" name="adminName" required="" placeholder="Enter Your Name..." class="form-control">
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
                       
                   </div>
               </div>
           </div>
       </div>