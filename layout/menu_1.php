
<?php

    if($_SESSION['user_id']==NULL){
        header('Location:../index.php');
           
        }
        
    $id=$_SESSION['username'];
    
    include_once '../class/user_info.php';
    $user=new User_info();
    $query_user=$user->all_info_users($id);
    $usr= mysqli_fetch_assoc($query_user);
    
    
    if(isset($_GET['logout'])){
        require_once '../class/user.php';
        $user=new User;
        $user->user_logout();
    }

    
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
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

        </style>
        
        
            <script src="../assets/js/jquery.min.js"></script>
            <script src="../assets/js/bootstrap.min.js"></script>
            <script src="../assets/js/search.js"></script>
            <script src="../assets/js/msg.js"></script>
    </head>
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
            <li>
                <a href="../user/all_profile.php?id=<?php echo $usr['username']; ?>">
                    <table style="margin-top:-17px;">
                        <tr>
                            <td ><img style="width: 35px;margin-bottom: -14px;" class="img-circle"  src="<?php echo $usr['profile_pic'];?>">&nbsp;</td>
                            <td><p class="text text-uppercase" style=" font-size: 15px;font-family:monospace;margin-bottom: 2px"><br><?php echo 'Welcome->'.$_SESSION['name'];?></p></td>
                        </tr>
                    </table>   
                </a>
            </li>
            <li><a href="../user/index.php" class="glyphicon glyphicon-home"></a></li>
            <li><a href="../user/all_profile.php?id=<?php echo $_SESSION['username'];?>" class="glyphicon glyphicon-user"></a></li>
            <li><a href="../user/message.php" onclick=""  class="glyphicon glyphicon-envelope"></a></li>
            <li><a href="../user/notification.php" class="glyphicon glyphicon-bell"></a></li>
            <li> &nbsp; &nbsp; &nbsp;</li>
            <li><a href="?logout=logout" class="glyphicon glyphicon-log-out" style="color: #ff0033; padding-right: 25px"></a></li>
        </ul>
    </div>
    <div id="searchResult" class="srcList" style="color: #fff;width:40px; position:absolute"></div>

    <div class="dropdown_data_window" style="height:0px; border:none;"></div>
    <input type="hidden" id="dropdown_data_type" value="">
</div>
<script type="text/javascript" src="../assets/js/search.js"></script>
</body>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/search.js"></script>
<script type="text/javascript" src="../assets/js/msg.js"></script>
</html>