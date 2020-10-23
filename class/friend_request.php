<?php


class Friend_Request {
    
    protected $connection;
        public function __construct(){
                
        include '../config/config.php';
        
       }
    public function removeFriend($user_to_remove) {
		$logged_in_user = $_SESSION['username'];

		$query = mysqli_query($this->connection, "SELECT friend_array FROM user_info WHERE username='$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$friend_array_username = $row['friend_array'];

		$new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
		$remove_friend = mysqli_query($this->connection, "UPDATE user_info SET friend_array='$new_friend_array' WHERE username='$logged_in_user'");

		$new_friend_array = str_replace($this->user['username'] . ",", "", $friend_array_username);
		$remove_friend = mysqli_query($this->connection, "UPDATE user_info SET friend_array='$new_friend_array' WHERE username='$user_to_remove'");
	}

	public function sendRequest($user_to) {
//            echo '<pre>';
//            print_r($user_to);
//            exit();
            $sql="INSERT INTO friend_request VALUES('', '$_SESSION[username]', '$user_to')";
		if (mysqli_query($this->connection, $sql)) {

                }else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
                header('Location:all_profile.php?id='.$user_to);
	}
	public function sendReq($user_to) {
//            echo '<pre>';
//            print_r($user_to);
//            exit();
            $sql="INSERT INTO friend_request VALUES('', '$_SESSION[username]', '$user_to')";
		if (mysqli_query($this->connection, $sql)) {
                    $msg="Request Send";
                    return $msg;
                }else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
                header('Location:index.php');
	}
        public function ConfirmRequest($user_from){
            $userLoggedIn=$_SESSION['username'];
            $sql="UPDATE user_info SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLoggedIn'";
            
            
            $add_friend_query = mysqli_query($this->connection, $sql);
            
            $sql_1="UPDATE user_info SET friend_array=CONCAT(friend_array, '$userLoggedIn,') WHERE username='$user_from'";
            $add_friend_query = mysqli_query($this->connection, $sql_1);

            $delete_query = mysqli_query($this->connection, "DELETE FROM friend_request WHERE req_to='$userLoggedIn' AND req_from='$user_from'");

            header('Location:all_profile.php?id='.$user_from);

        }

        public function cancelRequest($user_to){
            $sql="DELETE FROM friend_request WHERE req_from='$_SESSION[username]' AND req_to='$user_to'";
            if (mysqli_query($this->connection, $sql)) {

                }else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
                header('Location:all_profile.php?id='.$user_to);
        }

        public function IgnoreRequest($user_from){
            $sql="DELETE FROM friend_request WHERE req_from='$user_from' AND req_to='$_SESSION[username]'";
            if (mysqli_query($this->connection, $sql)) {

                }else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
                header('Location:all_profile.php?id='.$user_from);
        }
}
