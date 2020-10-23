<?php
   $host='localhost';
   $user='root';
   $password='';
   $dbname='mcn';
   $this->connection=mysqli_connect($host, $user, $password);
   $this->config=mysqli_select_db($this->connection, $dbname);
   if(!$this->connection){
      die('Connection Failed'.mysqli_error($this->connection));
      }
?>