<?php
include '../layout/top.php';
if(isset($_GET['id'])){
   $id= $_GET['id'];
   $query=mysqli_query($con,"SELECT * FROM video_tutorial WHERE id='$id'");
   $row=mysqli_fetch_assoc($query);
   $post_by=$row['posted_by'];
   $date=$row['posting_date'];
   $view=$row['total_viewed'];
   $info=new Get_User_Info($con, $post_by);
   $name=$info->getName();
   $pic=$info->getProfilePic();
   $n=$row['total_viewed'];
   mysqli_query($con,"UPDATE video_tutorial SET total_viewed=$n+1 WHERE id='$id'");
}
   $file=$row['vedio_file'];

?>
<html>
    <head>
        <title>Video Tutorial</title>
        <link rel="icon" href="../images/MIST_logo.png" type="image/gif">
        <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    </head>
    <?php include '../layout/menu.php';?>
    <body>
        <div class="container-fluid" style="margin-top: 50px">
            <div class="row">
                <div class="col-md-3">
                    <?php include ('left_buttons.php');?>
                </div>
                <div class="col-md-9">
                    <div class="well">
                    <video width="900" controls="">
                        <source src="video/<?php echo $file;?>" type="video/mp4">
                    </video><hr>
                    <p>
                        <img  src="<?php echo $pic;?>" style="height: 50px;border-radius: 40px;padding-top: 10px;">
                        <a href="all_profile.php?id=<?php echo $post_by;?>">
                            <b style="padding: 12px;"><?php echo $name;?></b><br> 
                        </a>
                    <div style="margin-left: 55px;margin-top: -27px;"<small><?php echo '<b>Published: </b>'.$date;?><br><?php echo $view." views";?></small></div>
                    </p>
                    </div>
                </div>
                
                
            </div>
        </div>
    </body>
</html>