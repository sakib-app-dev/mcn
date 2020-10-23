
<?php


    if($_SESSION['user_id']==NULL){
        header('Location:../index.php');
           
        }
        
    $id=$_SESSION['username'];
    //online Activity
        $time= time();
        $sql="SELECT * FROM login_info WHERE username='$_SESSION[username]'";
        $query= mysqli_query($con, $sql);
        $count= mysqli_num_rows($query);
        if($count==NULL){
            mysqli_query($con, "INSERT INTO login_info (username,time) VALUES ('$_SESSION[username]','$time')");
        }else{
            mysqli_query($con, "UPDATE login_info SET time='$time' WHERE username='$_SESSION[username]'");
        }
        $count_user= mysqli_query($con, "SELECT *FROM login_info");
        $count_user= mysqli_num_rows($count_user);
        mysqli_query($con, "DELETE FROM login_info WHERE time<$time -10");
    //user Information
    include_once '../class/user_info.php';
    $user=new User_info();
    $query_user=$user->all_info_users($id);
    $usr= mysqli_fetch_assoc($query_user);
    
    //log Out
    if(isset($_GET['logout'])){
        mysqli_query($con, "DELETE  FROM login_info WHERE username='$id'");
        require_once '../class/user.php';
        $user=new User;
        $user->user_logout();
    }
        
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <!-- <script src="../assets/js/bootstrap.min.js"></script> -->
        <script src="../assets/js/dropdown_menu.js"></script>
        <script src="../assets/js/jquery.jcrop.js"></script>
	   <script src="../assets/js/jcrop_bits.js"></script>
        
        
        <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <!-- <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="../assets/css/jquery.Jcrop.css" type="text/css" />
        
        <style>
            
            .menu {
                
                right: 1px;
                position: absolute;
                
        }

            .menu a{
                
                position: relative;
                color: #fff;
                text-decoration: none;
                font-size: 22px;
        }

            .menu a:hover {
                background-color: #ff0033;
                border-bottom: 7px solid #e67e22;
                color: 3399ff;
                border-radius: 40px;
        }
            

            .srcList.ul{
                

                cursor: pointer;
                
            }
            .srcList.li{
                padding: 115px;
            }
            .listStyle{
                background-color: #eee;
                list-style-type: none;
                padding: 30px;
                width: 360px;
                cursor: pointer;
                height: 402px;
                overflow-y: overlay;
                margin-left: 112px;
            }

           

        </style>
        
        
            
<body>
        
    

<div class="navbar navbar-dafault" style="background:#44cc00; top:0; height: 55px; position: fixed; width: 100%; z-index:1;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand " style="color: whitesmoke;font-family:cursive" href="../user/index.php">MCN</a>
            
            <form class="nav navbar-nav navbar-form" action="./search.php">
                <div class="form-group" style="padding-left: 20px; ">
                    <input type="text" class="form-control" style="width:370px;height: 38px"placeholder="Search..." name="search" id="search">
                </div>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search" style="padding:4px 0px;"></span></button>
            </form>
        </div>
        
        
       
        <ul class="nav navbar-nav navbar-right menu">
            <?php
                //Unread notification
                include_once '../class/notification.php';
                $userLoggedIn=$_SESSION['username'];
                    $notification= new Notification($con,$userLoggedIn);
                    $num_notifications = $notification->get_unread_number();

                // Unread messages 
                    include_once  '../class/msgCls.php';
                    $messages = new MsgCls($con,$userLoggedIn);
                    $num_messages = $messages->getUnreadNumber();




            ?>
            <li>
                <a href="all_profile.php?id=<?php echo $usr['username']; ?>">
                    <table style="margin-top:-17px;">
                        <tr>
                            <td ><img style="width: 35px;margin-bottom: -14px;" class="img-circle"  src="<?php echo $usr['profile_pic'];?>">&nbsp;</td>
                            <td><p class="text text-uppercase" style=" font-size: 15px;font-family:monospace;margin-bottom: 2px"><br><?php echo $usr['name'];?></p></td>
                        </tr>
                    </table>   
                </a>
            </li>
            <li><a href="index.php" class="glyphicon glyphicon-home"></a></li>
            <li><a href="all_profile.php?id=<?php echo $_SESSION['username'];?>" class="glyphicon glyphicon-user"></a></li>

            <li><a href="javascript:void(0);" class="w3-button glyphicon glyphicon-envelope" onclick="test('<?php echo $userLoggedIn; ?>', 'message')">
                    <?php
                        if($num_messages > 0)
                         echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
                    ?>
                </a>
              
          </li>
          <li><a href="javascript:void(0);" class="w3-button glyphicon glyphicon-bell" onclick="test('<?php echo $userLoggedIn; ?>', 'notification')">
                  <?php
                  if ($num_notifications > 0)
                      echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
                  ?>
              </a>
              
          </li>
          <li><a href="edituserdetails.php?u=<?php echo $_SESSION['username'];?>" class="w3-button glyphicon glyphicon-cog"></a>
              
          </li>
          
         
            <li> &nbsp; &nbsp; &nbsp;</li>
            <li><a href="?logout=logout" class="glyphicon glyphicon-log-out" style="color: #ff0033; padding-right: 25px"></a></li>
        </ul>
    </div>
    
    <div id="searchResult" class="srcList" style="width:50px;"></div>

    <div class="dropdown_data_window" style="height:0px; border:none;"></div>
    <input type="hidden" id="dropdown_data_type" value="">
</div>


<script type="text/javascript" src="../assets/js/search.js"></script>
</body>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script src="../assets/js/search.js"></script>
 <script src="../assets/js/test.js"></script>
<script type="text/javascript" src="../assets/js/msg.js"></script> -->
</html>