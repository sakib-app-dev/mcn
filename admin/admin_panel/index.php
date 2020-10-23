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
$query= mysqli_query($con, "SELECT * FROM user_info WHERE gender='Male'");
$male_num=mysqli_num_rows($query);
$query= mysqli_query($con, "SELECT * FROM user_info WHERE gender='Female'");
$female_num=mysqli_num_rows($query);
$query= mysqli_query($con, "SELECT * FROM user_info WHERE profession='Teacher'");
$teacher__num=mysqli_num_rows($query);
$query= mysqli_query($con, "SELECT * FROM user_info WHERE profession='Student'");
$student_num=mysqli_num_rows($query);
$query= mysqli_query($con, "SELECT * FROM groups");
$grp_num= mysqli_num_rows($query);
$query= mysqli_query($con, "SELECT * FROM notice");
$notice_num= mysqli_num_rows($query);

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
      .boxcolor1{
          background-color: #00ccff;
          margin: 20px 50px; 
      }
      .boxcolor2{
          background-color: #00ccff;
          margin: 20px 25px; 
      }
      .boxcolor3{
          background-color: #00ccff;
          margin: 20px 0px; 
      }
      .boxcolor4{
          background-color: #00ccff;
          margin: 20px 50px; 
      }
      .boxcolor5{
          background-color: #00ccff;
          margin: 20px 25px; 
      }
      .boxcolor6{
          background-color: #00ccff;
          margin: 20px 0px; 
      }
      .boxstyle{
          
          
          border: 2px solid #000000;
          height:200px;
          border-radius: 60px;
          height: 175px;
          width: 246px;
          color: white;
          font-size: 25px;
          text-align: center;
          font-family: sans-serif;
          
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
              <div class="col-md-4">
                  <div class="boxstyle boxcolor1">
                      <p><br>Male Users
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $male_num;?></b>
                      </p>
                  </p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="boxstyle boxcolor2">
                      <p><br>Female Users
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $female_num;?></b>
                      </p>
                  </p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="boxstyle boxcolor3">
                      <p><br> Teachers ID
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $teacher__num;?></b>
                      </p>
                  </p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="boxstyle boxcolor4">
                      <p><br>Groups
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $grp_num;?></b>
                      </p>
                  </p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="boxstyle boxcolor5">
                      <p><br>Notices
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $notice_num;?></b>
                      </p>
                  </p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="boxstyle boxcolor6">
                      <p><br>Students ID
                      <p style="font-size:50px;margin-top: -8px;">
                          <b><?php echo $student_num;?></b>
                      </p>
                  </p>
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
