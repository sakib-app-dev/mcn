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
      .right-margin{
          margin: 25px;
          padding: 15px;
          background-color: #cccccc;
          
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

      <div class="container-fluid">
          
          
          
          
          
          
          
          
          <div class="well">
              <div class="row">
                  <div class="right-margin col-md-10">
                      
                    <?php
                    include '../../config/configr.php'; 
                    $query=mysqli_query($con,"SELECT * FROM notice ORDER BY id DESC");
                    while($row=mysqli_fetch_assoc($query)){
                      $name=$row['admin_name'];
                      $title=$row['title'];
                      $details=$row['details'];
                      $date=$row['posting_date'];
                    

                    
                    ?>

                    <div class="col-md-8" style="background-color: #eee;border: 1px solid red; border-radius: 15px; margin:3px 153px;padding: 20px; ">
                        
                        <h4 align="center"><?php echo $title;?></h4>
                        <p><u>Published By : <?php echo $name;?></u> <em style="float: right">Published Date:<?php echo $date;?></em></p><hr>
                        <p><?php echo $details;?></p>
                    </div>
                  <?php }?>

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
