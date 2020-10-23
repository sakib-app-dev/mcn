<?php
$msg='';
include '../layout/top.php';
// Uploads files
if(isset($_POST['btn'])) { // if save button on the form is clicked

    $posted_by=$userLoggedIn;
    $video_title=$_POST['title'];
    $details=$_POST['details'];
    $posting_date= date("Y-m-d H:i:s");
    
    $imgname = $_FILES['img']['name'];
    $destination = 'video/img/'.$imgname;
    $image_type = pathinfo($imgname, PATHINFO_EXTENSION);
    $img_from = $_FILES['img']['tmp_name'];
    $imgsize = $_FILES['img']['size'];
   
        move_uploaded_file($img_from, $destination);
    
    
    
    
    // name of the uploaded Video
    $filename = $_FILES['video']['name'];

    // destination of the file on the server
    $destination = 'video/'.$filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['video']['tmp_name'];
    $size = $_FILES['video']['size'];

//    if (!in_array($extension, ['mp4', '3gp', 'mkv'])) {
//        $msg= "You file extension must be .mp4, .3gp or .mkv";
//    } elseif ($_FILES['video']['size'] > 20000000) { // file shouldn't be larger than 20Megabyte
//        $msg= "File too large!";
//    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO video_tutorial VALUES ('','$posted_by','$video_title','$details','$imgname','$filename','$posting_date','no','0')";  
            if (mysqli_query($con, $sql)) {
                header('Location:video_tutorial.php');
            } else {
                die('Query Error'.mysqli_error($con));
            }
            
            
        } else {
            $msg= "Failed to upload file.";
        }
        
        
    }
    
    

?>
<html>
    <head>
        <title>Video Tutorial</title>
        <link rel="icon" href="../images/MIST_logo.png" type="image/gif">
        <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    </head>
    <body>
        <?php include '../layout/menu.php';?>
        <div class="container pro-bg-img" style="margin-top: 37px">
            <div class="row">
                <div class="col-md-3" style="padding-top:2px;">
                            <?php include ('left_buttons.php');?>
                    <?php 
                    $pro=new Get_User_Info($con, $userLoggedIn);
                    $position=$pro->grtPosition();
                    if($position=='Teacher'){?>
                            <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Post Video Tutorial</button>

                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                  <div class="modal-dialog">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Post Video Tutorial</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        
                                        
                                        <div class="well">
                                            <h4 class="text text-center text-success"><?php echo $msg;?></h4>
                                            <br/>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    
                                                    <input type="text" name="title" class="form-control" required="" placeholder="Enter Heading of your tutorial">
                                                    <textarea name="details" class="form-control" rows="4" placeholder="Details about your notes..."></textarea>
                                                    Here upload a related Image
                                                    <input type="file" name="img" accept="image/*"><br>
                                                    Here upload a your Video
                                                    <input type="file" name="video" accept="video/*">
                                                    <button  name="btn" class="btn btn-sm btn-success pull-right">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        
                                      </div>

                                     

                                    </div>
                                  </div>
                                </div>
                    <?php }?>
                        </div>
                
                
                <div class="col-md-9">
                    <?php $sql=mysqli_query($con,"SELECT * FROM video_tutorial");
                            while($res= mysqli_fetch_assoc($sql)){
                                $post_by=$res['posted_by'];
                                $n=$res['total_viewed'];
                                $info=new Get_User_Info($con, $post_by);
                                $name=$info->getName();
                                if(isset($_POST['click'])){
                                
                                 }
    
                                    ?>
                        <div class="col-md-3">
                            <div class="well">
                                
                               <a href="watch.php?id=<?php echo $res['id'];?>"><p><img src="<?php echo 'video/img/'.$res['image'];?>" style="height: 90px;width: 143px"></p>
                                <h4><?php echo $res['vedio_title'];?></h4>
                                <small><?php echo 'Posted By: '.$name;?><br><?php echo 'Viewed : '.$res['total_viewed'];?></small>
                                
                               </a>
                                

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>