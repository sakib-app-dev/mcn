<?php
	
	class Notification{
		
	protected $connection;
        private $user_obj;
	
		
        public function __construct($con, $user){
		$this->connection = $con;
                include_once '../class/get_user_info.php';
		$this->user_obj = new Get_User_Info($con, $user);
	}

        public function userDetails(){
		$userLoggedIn = $this->user_obj->getUsername();
		$user_details_query = mysqli_query($this->connection, "SELECT * FROM user_info WHERE username='$username'");
		$user = mysqli_fetch_array($user_details_query);
		}


		public function get_unread_number(){
                    $userLoggedIn = $this->user_obj->getUsername();
                    $sql="SELECT * from notification WHERE viewed='no' AND user_to='$userLoggedIn'";
                    $query=mysqli_query($this->connection,$sql);
                    return mysqli_num_rows($query);
		}


		public function getNotifications($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();
		$return_string = "";

		if($page == 1)
			$start = 0;
		else 
			$start = ($page - 1) * $limit;

		$set_viewed_query = mysqli_query($this->connection, "UPDATE notification SET viewed='yes' WHERE user_to='$userLoggedIn'");

		$query = mysqli_query($this->connection, "SELECT * FROM notification WHERE user_to='$userLoggedIn' ORDER BY id DESC");

		if(mysqli_num_rows($query) == 0) {
			echo "You have no notifications!";
			return;
		}

		$num_iterations = 0; //Number of messages checked 
		$count = 1; //Number of messages posted

		while($row = mysqli_fetch_array($query)) {

			if($num_iterations++ < $start)
				continue;

			if($count > $limit)
				break;
			else 
				$count++;


			$user_from = $row['user_from'];

			$user_data_query = mysqli_query($this->connection, "SELECT * FROM user_info WHERE username='$user_from'");
			$user_data = mysqli_fetch_array($user_data_query);


			//Timeframe
                        $date = $row['date'];

                        include_once '../class/post_query.php';
                        $time = new Post_query();
                        $time_message = $time->timeInterval($date);


			$opened = $row['opened'];
			$style = ($opened == 'no') ? "background-color: #DDEDFF;" : "";

			$return_string .= "<a href='" . $row['link'] . "'> 
									<div class='resultDisplay resultDisplayNotification' style='" . $style . "'>
										<div class='notificationsProfilePic'>
											<img src='" . $user_data['profile_pic'] . "'>
										</div>
										<p class='timestamp_smaller' id='grey'>" . $time_message . "</p>" . $row['message'] . "
									</div>
								</a>";
		}


		//If posts were loaded
		if($count > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
		else 
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;'>No more notifications to load!</p>";

		return $return_string;
	}

	public function insertNotification($post_id, $user_to, $type) {

		$userLoggedIn = $this->user_obj->getUsername();
		$userLoggedInName = $this->user_obj->getName();

		$date_time = date("Y-m-d H:i:s");

		switch($type) {
			case 'comment':
				$message = $userLoggedInName . " commented on your post";
				break;
			case 'like':
				$message = $userLoggedInName . " liked your post";
				break;
			case 'profile_post':
				$message = $userLoggedInName . " posted on your profile";
				break;
			
		}

		$link = "post_details.php?pid=" . $post_id;

		$insert_query = mysqli_query($this->connection, "INSERT INTO notification VALUES('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')");
	}
	}

?>