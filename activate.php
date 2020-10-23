<?php
	include_once './config/configr.php';


        if(isset($_GET['token'])){
        	$token=$_GET['token'];
        	$Query="UPDATE user_info SET Status='activated' WHERE token='$token'";
        	$execute=mysqli_query($con,$Query);
//                echo '<pre>';
//                print_r($execute);
//                exit();
        	if($execute){
        		header('Location:index.php');
        		$msg="Account Activated";
                        return $msg;
        	}else{
        		header('Location:sign.php');
        		$msg = "Sorry Something is wrong..Try again";
                return $msg;
        	}
        }
?>