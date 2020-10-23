<?php
include ('../layout/top.php');
include '../config/configr.php';

$msg='';




// Uploads files
if(isset($_POST['btn'])) { // if save button on the form is clicked


    
    $published_by=$userLoggedIn;
    $title=$_POST['title'];
    $details=$_POST['details'];
    $posting_date= date("Y-m-d H:i:s");
    
    
    
    
    
    
    // name of the uploaded file
    $filename = $_FILES['notes']['name'];

    // destination of the file on the server
    $destination = 'notes/'.$filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['notes']['tmp_name'];
    $size = $_FILES['notes']['size'];
    

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        $msg= "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['notes']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        $msg= "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO notes VALUES ('','$published_by','$title','$details','$filename', '$size', '$posting_date','0')";
//            $q=mysqli_query($con, $sql);
//            echo"<pre>";
//    print_r($q);
//    exit();
            if (mysqli_query($con, $sql)) {
                header('Location:notes.php');
            }
        } else {
            $msg= "Failed to upload file.";
        }
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
	<title>Notes</title>
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
	        </div>
			<div class="col-md-6">
                            <div class="well">
                                <h4 class="text text-center text-success"><?php echo $msg;?></h4>
                                <br/>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <h4 class="text" style="font-family: cursive;color: #2ecc71"><b><u>Publish Your Notes as File:</u></b></h4>
                                        <input type="text" name="title" class="form-control" required="" placeholder="Notes Title">
                                        <textarea name="details" class="form-control" rows="4" placeholder="Details about your notes..."></textarea>
                                        <input type="file" name="notes" >
                                        <button  name="btn" class="btn btn-sm btn-success btn-block">Submit</button>
                                    </div>
                                </form>
                            </div>
            
                            
                            
                            <?php 
                            $query= mysqli_query($con, "SELECT * FROM notes ORDER BY id DESC");
                            while ($row= mysqli_fetch_assoc($query)){
                             $user=$row['published_by'];
                             $info=new Get_User_Info($con,$user);
                             $name=$info->getName();
                             $profession=$info->grtPosition();
                             
                             $currentDate=$row['posting_date'];
                             $count_time=new Post_query();
                             $date=$count_time->timeInterval($currentDate);
                             
//                                $row=mysqli_fetch_assoc($query);
//                                echo '<pre>';
//                                print_r($row);
//                                exit();
                            ?>
                            <div class="well">
                                <h4>Published By :<em><a href="all_profile.php?id=<?php echo $row['published_by'];?>"> <?php echo $name;?></a></em></h4>
                                <p><i><?php echo $profession.' Of MIST';?></i></p>
                                <h5>Published Date: <?php echo $date;?></h5><hr>
                                <h4><?php echo $row['title'];?></h4>
                                <p><?php echo $row['details'];?></p>
                                <p><a href="notes.php?file_id=<?php echo $row['id'] ?>">Download</a></p>
                                <p><?php echo floor($row['size']/1000).'KB';?></p>
                                <p><?php echo 'Downloads : '.$row['downloads'];?></p>
                                
                            </div>
                            <?php } ?>
                            <div class="well"><hr><p align="center">No more Notes</p></div>
			</div>
		</div>
	</div>
</body>
</html>