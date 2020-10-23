
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
  $query=mysqli_query($con,"SELECT * FROM user_info");  


if(isset($_GET['block'])){
$uid=$_GET['block'];
  mysqli_query($con,"UPDATE user_info SET status='block' WHERE username='$uid'");
}


if(isset($_GET['activate'])){
$uid=$_GET['activate'];
  mysqli_query($con,"UPDATE user_info SET status='activated' WHERE username='$uid'");
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
        
          
          <div class="col-md-10">
          
          <table class="table table-border">
              <tr>
                  <td>Image</td>
                  <td>Name</td>
                  <td>Position At MIST</td>
                  <td>Number Of Friend</td>
                  <td>User Status</td>
                  <td>Activate/block</td>
                  <td>Send Msg/Notification</td>
              </tr>
              <?php while($res=mysqli_fetch_assoc($query)){ 
                $user=$res['username'];

                $num_friend=(substr_count($res['friend_array'],","))-1;

                ?>
              <tr>
                  <td><img src="../<?php echo $res['profile_pic'];?>" class="img-responsive" style="height:40px;border-radius: 45px;"></td>
                  <td><a href="../../user/all_profile.php?id=<?php echo $user;?>"><?php echo $res['name'];?></a></td>
                  <td><?php echo $res['profession'];?></td>
                  <td align="center"><?php echo $num_friend;?></td>
                  <td><?php echo $res['Status'];?></td>
                  <?php if($res['Status']=='block'){ ?>
                    <td><a href="?activate=<?php echo $user;?>" onclick="return confirm('Are you want to Active the Account... ?')" class="btn btn-warning btn-block">Activate</a></td>

                 <?php }else{ ?>
                  <td><a href="?block=<?php echo $user;?>" onclick="return confirm('Are you want to block the Account ?')" class="btn btn-danger btn-block">Block Account</a></td>

                  <?php } ?>
                  <td>
                    <a href="../../user/message.php?msg_to=<?php echo $user;?>" class="btn btn-primary">Send Message</a>
                  </td>
              </tr>
              <?php } ?>
          </table>
          
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
