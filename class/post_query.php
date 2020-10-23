<?php 
class Post_query {
    
    
    protected $connection;
        public function __construct(){
                
        include '../config/config.php';
        
        


        }
        
        public function save_post($data){
           
            $title=$data['title'];
            $post=$data['post_details'];
            $post=strip_tags($post);//remove html tags
            $post = mysqli_real_escape_string($this->connection, $post);
            $check_empty=preg_replace('/\s+/','',$post);//deletes All spaces
            

            $date = date("Y-m-d H:i:s"); //Current date and time

            $postedBy = $_SESSION['username'];

            $postedTo=$data['post_to'];

           if ($postedTo == '' || $postedTo==$postedBy) {
               $postedTo = "none";
           }else{
              $postedTo=$data['post_to'];
           }
//            echo '<pre>';
//            print_r($data);
//            exit();
            // ........IMAGE PRocessing..........


            $image_name = $_FILES['img']['name']; //image er nam
            $directory = 'upload/';           //kon folder e jabe
            $image_url = $directory . $image_name; //kothay jabe
            $img_from = $_FILES['img']['tmp_name'];  // kotha theke astese
            $image_type = pathinfo($image_name, PATHINFO_EXTENSION);
            
            $image_size = $_FILES['img']['size'];
            /* @var $check type */
            $check=$_FILES['img']['tmp_name'];           
            if ($check) {
//                echo '<pre>';
//                print_r($post);
//                exit();
                if ($image_size > 500000) {
                    die('File is tooo large');
                } else {
                    if ($image_type != 'jpg' && $image_type != 'JPG' && $image_type != 'png' && $image_type != 'PNG') {
                        die('File type is not valid');
                    } else {
                            
                        move_uploaded_file($img_from, $image_url);
//                        $sql = "INSERT INTO user_post(username,user_to,post_title,post_details,img_name,user_activity,posting_date,likes,deleted) VALUES ('$postedBy','$postedTo','$title','$post','$image_url','active','$date','0','no')";
//                        if (mysqli_query($this->connection, $sql)) {
//                            $returned_id = mysqli_insert_id($this->connection);
//                                
//                                if($user_to != 'none') {
//				$notification = new Notification($this->connection,$postedBy);
//				$notification->insertNotification($returned_id, $postedTo, "profile_post");
//
//                        } else {
//                            die("Query Problem" . mysqli_error($this->connection));
//                        }
//                        
//                        
//			}
                    }
                }
            }
            
        $sql = "INSERT INTO user_post(username,user_to,post_title,post_details,img_name,user_activity,posting_date,likes,deleted) VALUES ('$postedBy','$postedTo','$title','$post','$image_url','active','$date','0','no')";
        if (mysqli_query($this->connection, $sql)) {
                            $returned_id = mysqli_insert_id($this->connection);
                                
                                if($user_to != 'none') {
				$notification = new Notification($this->connection,$postedBy);
				$notification->insertNotification($returned_id, $postedTo, "profile_post");

                        } else {
                            die("Query Problem" . mysqli_error($this->connection));
                        }
                        
                        
			}

        $numberOfPosts="SELECT COUNT(post_id) FROM user_post WHERE deleted='no' AND username='$_SESSION[username]'  ";
            $query = mysqli_query($this->connection, $numberOfPosts);
            $numPost = mysqli_fetch_assoc($query);
            $numPost=$numPost['COUNT(post_id)'];

            $updateNumPost="UPDATE user_info SET num_posts='$numPost' WHERE username='$_SESSION[username]'";
            $query = mysqli_query($this->connection, $updateNumPost);
    }
    

public function show_all_post(){
            
           $sql="SELECT * FROM user_post WHERE deleted='no' AND user_activity='act' ORDER BY post_id DESC ";
        
        
           if(mysqli_query($this->connection, $sql)){
           $query_result= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $query_result;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
            }
            
        
    }
    
    
        public function show_post_user_id($id){
        
        $sql="SELECT * FROM user_post WHERE ((username='$id' AND user_to='none') OR user_to='$id') AND deleted='no' AND user_activity='act' ORDER BY post_id DESC";
        if(mysqli_query($this->connection, $sql)){
           $query_result= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $query_result;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
        $user="SELECT * FROM user_info WHERE username='$id'";
        if(mysqli_query($this->connection, $user)){
           $user_query= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $user_query;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
        
    }
    
    public function timeInterval($date){
        $date_time=$date;
        $date_time_now = date("Y-m-d H:i:s");
        $start_date = new DateTime($date_time); //Time of post
        $end_date = new DateTime($date_time_now); //Current time
        $interval = $start_date->diff($end_date); //Difference between dates 
        if ($interval->y >= 1) {
            if ($interval->y == 1)
                $time_message = $interval->y . " year ago"; //1 year ago
            else
                $time_message = $interval->y . " years ago"; //1+ year ago
        }
        else if ($interval->m >= 1) {
            if ($interval->d == 0) {
                $days = " ago";
            } else if ($interval->d == 1) {
                $days = $interval->d . " day ago";
            } else {
                $days = $interval->d . " days ago";
            }


            if ($interval->m == 1) {
                $time_message = $interval->m . " month " . $days;
            } else {
                $time_message = $interval->m . " months " . $days;
            }
        } else if ($interval->d >= 1) {
            if ($interval->d == 1) {
                $time_message = "Yesterday";
            } else {
                $time_message = $interval->d . " days ago";
            }
        } else if ($interval->h >= 1) {
            if ($interval->h == 1) {
                $time_message = $interval->h . " hour ago";
            } else {
                $time_message = $interval->h . " hours ago";
            }
        } else if ($interval->i >= 1) {
            if ($interval->i == 1) {
                $time_message = $interval->i . " minute ago";
            } else {
                $time_message = $interval->i . " minutes ago";
            }
        } else {
            if ($interval->s < 30) {
                $time_message = "Just now";
            } else {
                $time_message = $interval->s . " seconds ago";
            }
        }
        return $time_message;
    }

        public function likePost($data){
       $postid=$data['post_id'];
       
       $result= mysqli_query($this->connection, "SELECT username,likes FROM user_post WHERE post_id=$postid;");
       $row= mysqli_fetch_assoc($result);
//        echo '<pre>';
//        print_r($postid);
//        exit();
       $n=$row['likes'];
       $user_liked=$row['username'];
       $userLoggedIn=$_SESSION['username'];
       mysqli_query($this->connection, "UPDATE user_post SET likes=$n+1 WHERE post_id=$postid");
       mysqli_query($this->connection, "INSERT INTO post_likes VALUES ('','$userLoggedIn','$postid');");
       
       if($user_liked != $userLoggedIn) {
                $notification = new Notification($this->connection, $userLoggedIn);
                $notification->insertNotification($postid, $user_liked, "like");
        }
    }
    public function unlikePost($data){
       $postid=$data['post_id'];
       $result=mysqli_query($this->connection,"SELECT * FROM user_post WHERE post_id=$postid;");
       $row=mysqli_fetch_array($result);
       
       $n=$row['likes'];
       
       mysqli_query($this->connection,"DELETE FROM post_likes WHERE post_id=$postid AND username='$_SESSION[username]';");
       mysqli_query($this->connection,"UPDATE user_post SET likes=$n-1 WHERE post_id=$postid");
    }

    
    public function postInfoById($pid){
        $sql="SELECT * FROM user_post where post_id='$pid'";
        if(mysqli_query($this->connection, $sql)){
           $query_result= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $query_result;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
    }
    
    public function update_post($data){

        $postid=$data['post_id'];
        

        $sql="UPDATE user_post SET post_title='$data[title]' , post_details='$data[post_details]' WHERE post_id='$postid'";
        if(mysqli_query($this->connection, $sql)){
            
           header('Location:post_details.php?pid='.$postid); //FIX the problem
           
           $query_result= mysqli_query($this->connection, $sql);
           return $query_result;
           
           
       }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
        
    }
    //delete post on index.php
    public function delete_post($pid){
        $sql="UPDATE user_post SET deleted='yes' WHERE post_id='$pid'";
        if(mysqli_query($this->connection, $sql)){
           header('Location:index.php');
           
       }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
       
       $numberOfPosts="SELECT COUNT(post_id) FROM user_post WHERE deleted='no' AND username='$_SESSION[username]'  ";
            $query = mysqli_query($this->connection, $numberOfPosts);
            $numPost = mysqli_fetch_assoc($query);
            $numPost=$numPost['COUNT(post_id)'];

            $updateNumPost="UPDATE user_info SET num_posts='$numPost' WHERE username='$_SESSION[username]'";
            $query = mysqli_query($this->connection, $updateNumPost);
    }
    
    //delete post all_profile.php
    public function delete_post_on_user_profile($pid){
        $sql="UPDATE user_post SET deleted='yes' WHERE post_id='$pid'";
        if(mysqli_query($this->connection, $sql)){
           header('Location:all_profile.php?id='.$_SESSION['username']);
           
       }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
       
       $numberOfPosts="SELECT COUNT(post_id) FROM user_post WHERE deleted='no' AND username='$_SESSION[username]'  ";
            $query = mysqli_query($this->connection, $numberOfPosts);
            $numPost = mysqli_fetch_assoc($query);
            $numPost=$numPost['COUNT(post_id)'];

            $updateNumPost="UPDATE user_info SET num_posts='$numPost' WHERE username='$_SESSION[username]'";
            $query = mysqli_query($this->connection, $updateNumPost);
    }


//    public function submit_comment($data){
//        $date_time_comment=date("Y-m-d H:i:s");
//        $comment=$data['comment'];
//        $post_id=$data['post_id'];
//        $sql="INSERT INTO post_comment VALUES ('','$_SESSION[username]','','','','')";
//        if (mysqli_query($this->connection, $sql)) {
//            
//        } else {
//            die("Query Problem" . mysqli_error($this->connection));
//        }
//    }

}