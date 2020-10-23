<?php
class User_info {
    protected $connection;
        public function __construct(){
                
         include '../config/config.php';
        

        }
        
        
        public function all_info_users($id){
            $sql="SELECT * FROM user_info WHERE username='$id'";
            if(mysqli_query($this->connection, $sql)){
           $query_user= mysqli_query($this->connection, $sql);//Checking are query ok or not
           
           return $query_user;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
        }
        
        public function updateProfile($info){
            
            $name=$info['name'];
            $phn=$info['phn_no'];
            $address=$info['address'];
            $profession=$info['position'];
            $bday=$info['dob'];
            $gender=$info['gender'];
            $currentlyWork=$info['currently_work'];
            $startedJobDate=$info['startJobDate'];
            $jobPosition=$info['job_position'];
            $skill=$info['skill'];
            $fieldOfStudy=$info['fos'];
            $batch=$info['batch'];
            $collage=$info['collage'];
            $school=$info['school'];
            $religion=$info['religion'];
            $politics=$info['political_view'];
            
            $sql="UPDATE user_info SET name='$name', phone_no='$phn',profession='$profession',address='$address',"
                    . "birthday='$bday',gender='$gender',currently_work='$currentlyWork',started_job='$startedJobDate',"
                    . "job_position='$jobPosition',professional_skill='$skill',field_of_study='$fieldOfStudy',"
                    . "batch='$batch',collage='$collage',school='$school',"
                    . "religious_view='$religion',political_view='$politics' WHERE username='$_SESSION[username]'";
            if(mysqli_query($this->connection, $sql)){
                $query= mysqli_query($this->connection, $sql);//Checking are query ok or not
                header("Location:userdetails.php?u=".$_SESSION['username']);
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
            
//            echo '<pre>';
//            print_r($info);
//            exit();
            
        }
        public function changePSWD($data){
            $old_password=$data['old_password'];
            $oldPassword= md5($old_password);
            $password=$data['new_password'];
            $re_password=$data['re_password'];
            
                    $pswd="SELECT password from user_info WHERE username='$_SESSION[username]'";
                    $psQuery= mysqli_query($this->connection, $pswd);
                    $row= mysqli_fetch_assoc($psQuery);
                    $prev_password=$row['password'];
                    
            //password condition
                    if($prev_password !== $oldPassword){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Old Password is not correct..!!</div>";
                        return $msg;
                    }elseif($old_password==$password){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>New password should be different than old password..!!</div>";
                        return $msg;
                    }elseif(strlen($password)>30){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be not more than 30 character..!!</div>";
                        return $msg;
                    }elseif(strlen($password)<6){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be at least 6 character..!!</div>";
                        return $msg;
                    }elseif(preg_match('/[^A-Za-z0-9]/',$password)){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password should be contain English character & Number..!!</div>";
                        return $msg;
                    }
                    elseif($password!=$re_password){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Password doesn't matched. Try again..!!</div>";
                        return $msg;
                        }else{
                            $password=md5($password);
                        }
            
            $sql="UPDATE user_info SET password='$password' WHERE username='$_SESSION[username]'";
            if(mysqli_query($this->connection, $sql)){
                $query= mysqli_query($this->connection, $sql);//Checking are query ok or not
                header("Location:userdetails.php?u=".$_SESSION['username']);
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
        }

        

        public function info_users($username){
            $sql="SELECT * FROM user_info WHERE username='$username'";
            if(mysqli_query($this->connection, $sql)){
           $query_user= mysqli_query($this->connection, $sql);//Checking are query ok or not
           $this->user= mysqli_fetch_assoc($query_user);
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
        }
        
        public function deactiveAccount(){
                
                $sql="UPDATE user_post AND user_info SET user_activity='dac' WHERE username='$_SESSION[username]'";
                $query= mysqli_query($this->connection, $sql);
                session_start();
                    unset($_SESSION['user_id']);
                    unset($_SESSION['name']);
                    unset($_SESSION['username']);
                    header('Location:../index.php');
        }
        
        
        
        

        
        
    }
?>