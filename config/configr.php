
<?php
   $host='localhost';
   $user='root';
   $password='';
   $dbname='mcn';
   $con=mysqli_connect($host, $user, $password, $dbname);
   if(!$con){
      die('Connection Failed'.mysqli_error($con));
      }
?>
