<?php


class Get_User_Info {

	private $user;
	private $connection;

	public function __construct($connection, $user){
		$this->connection = $connection;
		$user_details_query = mysqli_query($this->connection, "SELECT * FROM user_info WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query);
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getNumberOfFriendRequests() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT * FROM friend_requests WHERE user_to='$username'");
		return mysqli_num_rows($query);
	}

	public function getNumPosts() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT num_posts FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
	}

	public function getName() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT name FROM user_info WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['name'] ;
	}
        
        public function grtPosition(){
            $username = $this->user['username'];
            $query = mysqli_query($this->connection, "SELECT profession FROM user_info WHERE username='$username'");
            $row = mysqli_fetch_array($query);
            return $row['profession'] ;
        }

	public function getProfilePic() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT profile_pic FROM user_info WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['profile_pic'];
	}

	public function getFriendArray() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT friend_array FROM user_info WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['friend_array'];
	}

	public function isClosed() {
		$username = $this->user['username'];
		$query = mysqli_query($this->connection, "SELECT user_activity FROM user_info WHERE username='$username'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'deact')
			return true;
		else 
			return false;
	}

	public function isFriend($username_to_check) {
		$usernameComma = "," . $username_to_check . ",";

		if((strstr($this->user['friend_array'], $usernameComma ) || $username_to_check == $this->user['username'])) {
			return true;
		}
		else {
			return false;
		}
	}
        

	public function didReceiveRequest($user_from) {
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->connection, "SELECT * FROM friend_request WHERE req_from='$user_from' AND req_to='$_SESSION[username]'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->connection, "SELECT * FROM friend_request WHERE req_to='$user_to' AND req_from='$_SESSION[username]'");
		if(mysqli_num_rows($check_request_query) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	

	public function getMutualFriends($user_to_check) {
		$mutualFriends = 0;
		$user_array = $this->user['friend_array'];
		$user_array_explode = explode(",", $user_array);

		$query = mysqli_query($this->connection, "SELECT friend_array FROM user_info WHERE username='$user_to_check'");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friend_array'];
		$user_to_check_array_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i) {

			foreach($user_to_check_array_explode as $j) {

				if($i == $j && $i != "") {
					$mutualFriends++;
				}
			}
		}
		return $mutualFriends;

	}







}
