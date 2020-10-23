<?php
//session_start();
include_once 'post_query.php';
class Group extends Post_query{
    
    public function __construct() {
        include '../config/config.php';
    }
    
    public function createGroup($data){
        $groupName=$data['grpName'];
        $groupType=$data['grpType'];
        $creatingDate=date("y-m-d");
        $admin=$_SESSION['username'];
        
        
        //Group name condition
        if(strlen($groupName)>255 || strlen($groupName)<3){
            $msg="<div class='alert alert-danger'><strong>ERROR-</strong>Your Group name should be not less than 3 not more than 255 character..!!</div>";
            return $msg;
        }else{
            $groupName=$groupName;
        }
        
        //Making Automatic Uniqe grplink
        $groupLink=str_replace(' ','',$groupName);//remove space
        $groupLink=strtolower($groupLink);//convrting lowercase

        $check_groupLink=mysqli_query($this->connection,"SELECT grp_link FROM groups WHERE grp_link='$groupLink'");
        $i=0;
        while(mysqli_fetch_assoc($check_groupLink)!=0){
           $i++;
           $groupLink1=$groupLink.$i;
           $check_groupLink=mysqli_query($this->connection,"SELECT username FROM user_info WHERE username='$groupLink1'");
           }if($i!=0){
               $groupLink=$groupLink1;
           }
         
           
        $sql="INSERT INTO groups VALUES ('','$groupName','$groupType','$groupLink','$creatingDate','0','$admin','1');";
        mysqli_query($this->connection, $sql);
        $membersql="INSERT INTO group_members VALUES ('','$admin','$groupLink','$groupName');";
        if(mysqli_query($this->connection, $membersql)){
            header('Location:../user/index.php');
        }else {
            die("Query Problem".mysqli_error($this->connection));
        }
                       
    }
    public function saveGrpPost($data){
//            echo '<pre>';
//            print_r($grp_link);
//            exit();
            $grp_link=$data['grp_name'];            
            $title=$data['title'];
            $post=$data['post_details'];

            $post=strip_tags($post);//remove html tags
            $post = mysqli_real_escape_string($this->connection, $post);
            $check_empty=preg_replace('/\s+/','',$post);//deletes All spaces
            $date = date("Y-m-d H:i:s"); //Current date and time
            $name = $_SESSION['name'];
          
            // ........IMAGE PRocessing..........


            $image_name = $_FILES['img']['name']; //image er nam
            $directory = 'upload/';           //kon folder e jabe
            $image_url = $directory . $image_name; //kothay jabe
            $img_from = $_FILES['img']['tmp_name'];  // kotha theke astese
            $image_type = pathinfo($image_name, PATHINFO_EXTENSION);
            
            $image_size = $_FILES['img']['size'];
            $check=$_FILES['img']['tmp_name'];
//            echo '<pre>';
//            print_r($date);
//            exit();
            if ($check) {
//                echo '<pre>';
//                print_r($date);
//                exit();
            if ($image_size > 500000) {
                    die('File is tooo large');
                } else {
                    if ($image_type != 'jpg' && $image_type != 'JPG' && $image_type != 'png' && $image_type != 'PNG') {
                        die('File type is not valid');
                    } else {
                            
                        move_uploaded_file($img_from, $image_url);
                        
                        $sql = "INSERT INTO group_posts(grp_link,user_id,username,post_title,post_details,img_name,user_activity,posting_date,likes,deleted) VALUES ('$grp_link','$_SESSION[user_id]','$_SESSION[username]','$title','$post','$image_url','active','$date','0','no')";
                        if (mysqli_query($this->connection, $sql)) {

                        } else {
                            die("Query Problem" . mysqli_error($this->connection));
                        }
                    }
                }
            }
        
//            echo '<pre>';
//            print_r($data);
//            exit();
        $numberOfPosts="SELECT COUNT(grp_post_id) FROM group_posts WHERE grp_link='$grp_link'";
            $query = mysqli_query($this->connection, $numberOfPosts);
            $numPost = mysqli_fetch_assoc($query);
            $numPost=$numPost['COUNT(grp_post_id)'];

            $updateNumPost="UPDATE groups SET num_posts='$numPost' WHERE grp_link='$grp_link'";
            $query = mysqli_query($this->connection, $updateNumPost);
    } 

    public function show_post_group_id($gid){
        
        $sql="SELECT * FROM group_posts WHERE grp_link='$gid' ORDER BY grp_post_id DESC";
        if(mysqli_query($this->connection, $sql)){
           $query_result= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $query_result;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
           }
    
    }
    public function timeIntervalGrp($date){
    
        return $this->timeInterval($date);
            
    }

    public function postInfoById($gpid){
        $sql="SELECT * FROM group_posts where grp_post_id='$gpid'";
        if(mysqli_query($this->connection, $sql)){
           $query_result= mysqli_query($this->connection, $sql);//Checking are query ok or not
           return $query_result;
           }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
    }
    public function update_post($data){

        $postid=$data['grp_post_id'];
        
//echo '<pre>';
//print_r($postid);
//exit();
        $sql="UPDATE group_posts SET post_title='$data[title]' , post_details='$data[post_details]' WHERE grp_post_id='$postid'";
        if(mysqli_query($this->connection, $sql)){
            
           header('Location:post_details.php?gpid=0'); //FIX the problem
           
           $query_result= mysqli_query($this->connection, $sql);
           return $query_result;
           
           
       }else{
           die('Query Problem'.mysqli_error($this->connection));
       }
        
    }
}
