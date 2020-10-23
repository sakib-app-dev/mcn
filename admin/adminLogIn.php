<?php

class AdminLogIn {
    protected $connection;
	public function __construct(){
            
        include '../config/config.php';
        
        }
        
        public function adminLogIn($data){
            
                $name=$data['adminName'];
                $password=md5($data['password']);

                $sql="SELECT * FROM admin WHERE admin_name='$name' AND password='$password'";
                $query=mysqli_query($this->connection,$sql);
                $user= mysqli_fetch_assoc($query);
//                    echo '<pre>';
//                    print_r($user);
//                    exit();
                if($user){
                    session_start();
                    $_SESSION['id']=$user['id'];
                    $_SESSION['admin_name']=$user['admin_name'];
                    header('Location:admin_panel/index.php');
                }else{
                    $msg='<div class="alert alert-danger">Sorry..Email or Password are not valid</div>';
                    return $msg;
                }
                
        }
        
        public function admin_logout(){
                    session_start();
                    unset($_SESSION['id']);
                    unset($_SESSION['admin_name']);
                    header('Location:../index.php');
                }
}
