<?php
include ('../layout/top.php');
include '../config/configr.php';


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
	        </div>
			<div class="col-md-6">
                            <?php 
                            $query= mysqli_query($con, "SELECT * FROM notice ORDER BY id DESC");
                            while ($row= mysqli_fetch_assoc($query)){
                                
//                                $row=mysqli_fetch_assoc($query);
//                                echo '<pre>';
//                                print_r($row);
//                                exit();
                            ?>
                            <div class="well">
                                <h5>Published Date: <?php echo $row['posting_date'];?></h5><hr>
                                <h4><?php echo $row['title'];?></h4>
                                <p><?php echo $row['details'];?></p>
                                
                            </div>
                            <?php } ?>
                            <div class="well"><hr><p align="center">No more Notice</p></div>
			</div>
		</div>
	</div>
</body>
</html>