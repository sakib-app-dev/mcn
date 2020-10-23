<?php
include ('../layout/top.php');


$msg='';




// Uploads files
if(isset($_POST['btn'])) { // if save button on the form is clicked


    
    $posted_by=$userLoggedIn;
    $catagory=$_POST['catagory'];
    $company=$_POST['company'];
    $position=$_POST['position'];
    $details=$_POST['details'];
    $last_date=$_POST['date'];
    
    $posting_date= date("Y-m-d H:i:s");
    
                
    
    
    
    
    
    // name of the uploaded file
    $filename = $_FILES['jobs']['name'];

    // destination of the file on the server
    $destination = 'jobs/'.$filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                
           

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['jobs']['tmp_name'];
    $size = $_FILES['jobs']['size'];
    

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        $msg= "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['jobs']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        $msg= "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
//            $sql = "INSERT INTO jobs VALUES ('','$posted_by','$catagory','$company','$position','$details','$filename', '$size', '$posting_date','$last_date')";
//
//
//            if (mysqli_query($con, $sql)) {
//                header('Location:search_job.php');
//            }
        } else {
            $msg= "Failed to upload file.";
        }
    }
    $sql = "INSERT INTO jobs VALUES ('','$posted_by','$catagory','$company','$position','$details','$filename', '$size', '$posting_date','$last_date')";


            if (mysqli_query($con, $sql)) {
                header('Location:search_job.php');
            } else {
                die('Query Error'.mysqli_error($con));
            }
}






// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM notes WHERE id=$id";
    $result = mysqli_query($con, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'notes/' . $file['file'];
//    echo '<pre>';
//    print_r($filepath);
//    exit();

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('notes/' . $file['name']));
        readfile('notes/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE notes SET downloads=$newCount WHERE id=$id";
        mysqli_query($con, $updateQuery);
        
    }

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Notice</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">

<style type="text/css">
    ::-webkit-scrollbar { 
    display: none; 
}</style>
</head>
<body>
<?php include_once '../layout/menu.php';?>
    <div class="container" style="padding-top:40px;">
		<div class="row">
			<div class="col-md-3" style="padding-top:2px;">
                            <?php include ('left_buttons.php');?>
                            <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
                                  Post JOB
                                </button>

                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                  <div class="modal-dialog">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">POST Job Vacancy</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        
                                        
                                        <div class="well">
                                            <h4 class="text text-center text-success"><?php echo $msg;?></h4>
                                            <br/>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    
                                                        <select name="catagory" class="custom-select form-control">
                                                            <option selected disabled="">select catagory for job</option>
                                                            <option value="cse">CSE</option>
                                                            <option value="bba">BBA</option>
                                                            <option value="for_all">For All</option>
                                                        </select>
                                                    <input type="text" name="company" class="form-control" required="" placeholder="Enter The Company Name">
                                                    <input type="text" name="position" class="form-control" required="" placeholder="Enter The Position">
                                                    <textarea name="details" class="form-control" rows="4" placeholder="Details about your notes..."></textarea>
                                                    <input type="date" name="date" required="" class="form-control" >
                                                    <input type="file" name="jobs" >
                                                    <button  name="btn" class="btn btn-sm btn-success pull-right">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        
                                      </div>

                                     

                                    </div>
                                  </div>
                                </div>
                        </div>
			<div class="col-md-7">

            
                            
                            
                            <?php 
                            $query= mysqli_query($con, "SELECT * FROM jobs ORDER BY id DESC");
                            while ($row= mysqli_fetch_assoc($query)){
                             $user=$row['posted_by'];
                             $info=new Get_User_Info($con,$user);
                             $name=$info->getName();
                             
                             
                             $currentDate=$row['posting_date'];
                             $count_time=new Post_query();
                             $date=$count_time->timeInterval($currentDate);
                             
                            ?>
                            <div class="well">
                                
                                <h4><?php echo $row['position'];?></h4>
                                <h5><?php echo $row['company'];?></h5>
                                <h6>Published Date: <?php echo $currentDate;?></h6>
                                <h6>Deadline: <?php echo $row['last_date'];?></h6>
                                <p><a href="all_profile.php?id=<?php echo $row['posted_by'];?>">Published By :<em> <?php echo $name;?></em></a></p><hr>
                                
                                <p><?php echo $row['details'];?></p>
                                <?php if($row['file']!=''){?>
                                <p><a href="notes.php?file_id=<?php echo $row['id'] ?>">Download</a></p>
                                <p><?php echo floor($row['size']/1000).'KB';?></p>
                                <?php }?>
                                
                            </div>
                            <?php } ?>
                            <div class="well"><hr><p align="center">No more Notes</p></div>
			</div>
                   
		</div>
	</div>
</body>
</html>