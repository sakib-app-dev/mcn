<?php

?>
<?php
session_start();
if($_SESSION['id']==NULL){
        header('Location:../index.php');
           
        }

if(isset($_GET['logout'])){
        require_once '../adminLogIn.php';
        $admin=new AdminLogIn;
        $admin->admin_logout();
    }

include '../../config/configr.php'; 
$msg='';

    if(isset($_POST['btn'])){
      $adminId=$_SESSION['id'];
      $admin_name=$_SESSION['admin_name'];
      $title=$_POST['title'];
      $details=$_POST['notice_details'];
      $showUntil=$_POST['lasting_date'];
      $date = date("Y-m-d H:i:s");

      $sql="INSERT INTO notice VALUES ('','$adminId','$admin_name','$title','$details','$date','$showUntil')";
      if(mysqli_query($con,$sql)){
          $msg="Notice Published";
      }else{
        die('Wrong Query'.mysqli_error($con));
      }
      
    }
    

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MCN Admin</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <style>
      
      .box{
          background-color: mediumaquamarine;
          border: 1px solid black;
          border-radius: 20px;
          padding: 40px;
          margin: 35px 85px;
      }
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading bg-success text-white"><b style="font-family: cursive;">MCN </b>Admin Panel</div>
      <div class="list-group list-group-flush">
          <a href="index.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="post_notice.php" class="list-group-item list-group-item-action bg-light">Publish Notice</a>
        <a href="notices.php" class="list-group-item list-group-item-action bg-light">Published Notice</a>
        <a href="users.php" class="list-group-item list-group-item-action bg-light">All Users</a>
        <a href="settings.php" class="list-group-item list-group-item-action bg-light">Settings</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-success" id="menu-toggle">Panel Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a href="?logout=logout" class="btn-danger nav-link" style="color:white;" >LOG OUT <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container">
          <div class="row">
                <div class="col-md-offset-1 col-md-12">
                    <div class="box">
                      
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <h4 class="text" style="font-family: cursive;color: #fff;text-align: center;"><b><u>Publish Notice:</u></b></h4>
                                <input type="text" name="title" class="form-control" placeholder="Notice Title (Optional)">
                                <textarea name="notice_details" class="form-control" rows="4" placeholder="Details About notice" required=""></textarea>
                                <input type="date" name="lasting_date" class="form-control">
                                This notice will be show until (select Date):
                                <button  name="btn" class="btn btn-success  btn-block">Publish Notice</button>
                            </div>
                        </form>
                        <div class="text text-danger" align="center" style="font-size: 28px;border: 2px solid black;border-radius: 25px;"><b><?php echo $msg;?></b></div>
                    </div>
                </div>

            </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>







<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>