<?php

class User{
		
    protected $connection;
	public function __construct(){
            
        include './config/config.php';
        
        }
        
                
    public function sign_up($data) {
                    //session_start();
                    $nam=$data['name'];     
                    $e_mail=$data['email']; 
                    $birthday=$data['dob']; 
                    $gender=$data['gender'];
                    $profession=$data['i_am'];
                    $id=$data['id_no'];
                    $password=$data['password'];
                    $re_password=$data['re_password'];
                    $signup_date=date("y-m-d");
                    $token= bin2hex(openssl_random_pseudo_bytes(40));
                    
                    //name condition
                    if(strlen($nam)>50 || strlen($nam)<4){
                        $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Your name should be not less than 4 not more than 50 character..!!</div>";
                        return $msg;
                    }else{
                        $name=$nam;
                    }
                    //Making Automatic Username
                    $username=str_replace(' ','',$name);//remove space
                    $username=strtolower($username);//convrting lowercase
                    
                    $check_username=mysqli_query($this->connection,"SELECT username FROM user_info WHERE username='$username'");
                    $i=0;
                    while(mysqli_fetch_assoc($check_username)!=0){
                       $i++;
                       $username1=$username.$i;
                       $check_username=mysqli_query($this->connection,"SELECT username FROM user_info WHERE username='$username1'");
                       }if($i!=0){
                           $username=$username1;
                       }
                       
                     // Email checking
                     $email_chk=mysqli_query($this->connection,"SELECT email FROM user_info WHERE email='$e_mail'");
                     $email_verification=mysqli_fetch_assoc($email_chk);
                     if($email_verification>0){
                         $msg="<div class='alert alert-danger'><strong>ERROR-</strong>This email is already Exist..!!</div>";
                         return $msg;
                     }else{
                         $email=$e_mail;
                     }
                     
                     //profession
                     if($profession=='student'){
                        $CHK=mysqli_query($this->connection,"SELECT student_id FROM institutions_information.student_information WHERE student_id='$id'");
                        $id_verification=mysqli_fetch_assoc($CHK);
                        if($id_verification==0){
                            $msg="<div class='alert alert-danger'><strong>ERROR-</strong>you are not Student of Mist..!!</div>";
                            return $msg;
                        }else{
                            $id=$id;
                        }
                     } else {
                        $CHK=mysqli_query($this->connection,"SELECT teachers_id FROM institutions_information.teachers_information WHERE teachers_id='$id'");
                        $id_verification=mysqli_fetch_assoc($CHK);
                        if($id_verification==0){
                            $msg="<div class='alert alert-danger'><strong>ERROR-</strong>you are not Teacher of Mist..!!</div>";
                            return $msg;
                        }else{
                            $id=$id;
                        }
                     }
                     
                     // Id Varification
                     
                     
                    
                    //password condition
                    if(strlen($password)>30){
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
                        
                        
                        if($gender=='male'){
                            $profile_pic="../images/profile_pic/male.png";
                        }else{
                            $profile_pic="../images/profile_pic/female.png";
                        }
                        
                    // DB query
                        //E-mail confirmation
                        $subject="Email Confirmation";
                        $body="Hi ". $name ." Here is the Confirmation Code to activate your account http://localhost/MCN/activate.php?token=".$token;
                        $sendBy="From:saapurbo09@gmail.com";
                        $mail=mail($email,$subject,$body,$sendBy);
                        if($mail){
                    $sql="INSERT INTO user_info(name,username,email,profession,id_no,birthday,gender,password,signup_date,profile_pic,num_posts,token,Status,user_activity,friend_array) VALUES ('$name','$username','$email','$profession','$id','$birthday','$gender','$password','$signup_date','$profile_pic','0','$token','block','active',',')";

                    if(mysqli_query($this->connection, $sql)){   //like Go button of DB
                        $msg = "Registered Successfully...Please Check your Email...";
                        return $msg;
                    } else {
                        $msg="Something gonig wrong ..Please try again";
                        return $msg;
                        die("Query Problem".mysqli_error($this->connection));
                        }
                        
                    }

                }
                
                
                
                //Log in  query sector
                
            public function log_in($data){
                    $email=$data['email'];
                    $password=md5($data['password']);
//                    $time= time();

                    $sql="SELECT user_id,name,username FROM user_info WHERE email='$email' AND password='$password' AND Status='activated'";
                    $query=mysqli_query($this->connection,$sql);
                    $user= mysqli_fetch_assoc($query);

                    if($user){
//                        session_start();
                        $_SESSION['user_id']=$user['user_id'];
                        $_SESSION['name']=$user['name'];
                        $_SESSION['username']=$user['username'];
                        
                        
//                    echo '<pre>';
//                    print_r($count_user);
//                    exit();
                        header('Location:user/index.php');
                    }else{
                        $msg='<div class="alert alert-danger">Sorry..Email or Password are not valid</div>';
                        return $msg;
                    }
                }
                
                
            public function user_logout(){
                    session_start();
//                    mysqli_query($this->connection, "DELETE FROM login_info WHERE time<$time -10");
                    unset($_SESSION['user_id']);
                    unset($_SESSION['name']);
                    unset($_SESSION['username']);
                    header('Location:../index.php');
                }
                
            
                 
        }
        
        

	
?>