<?php

class MsgCls {

    protected $connection;
        public function __construct($con, $user){
		$this->connection = $con;
                include_once '../class/get_user_info.php';
		$this->user_obj = new Get_User_Info($con, $user);
        
        }
        
        public function sendMsg($data,$msgTo){
            $userLoggedIn = $this->user_obj->getUsername();
            $sender= $userLoggedIn;
            $receiver=$msgTo;
            $msg=$data['msg'];
            $time= date("Y-m-d H:i:s");
//            echo "<pre>";
//            print_r($sender);
//            exit();
            if($msg!=NULL){
            $sql="INSERT INTO messages VALUES ('','$sender','$receiver','$msg','$time','no','no','no')";
                if (mysqli_query($this->connection, $sql)) {

                } else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
            }
        }
        
        public function getMsg($msgTo){
            $userLoggedIn = $this->user_obj->getUsername();
            $sender=$userLoggedIn;
            $receiver=$msgTo;
            $sql="SELECT * FROM messages WHERE (sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender')";
                if (mysqli_query($this->connection, $sql)) {
                    $query=mysqli_query($this->connection, $sql);
                    return $query;

                } else {
                    die("Query Problem" . mysqli_error($this->connection));
                }
            
        }
        
        public function getMostRecentUser() {
		$userLoggedIn = $this->user_obj->getUsername();

		$query = mysqli_query($this->connection, "SELECT sender, receiver FROM messages WHERE sender='$userLoggedIn' OR receiver='$userLoggedIn' ORDER BY id DESC LIMIT 1");

		if(mysqli_num_rows($query) == 0){
			return false;
                }

		$row = mysqli_fetch_array($query);
		$user_to = $row['receiver'];
		$user_from = $row['sender'];

		if($user_to != $userLoggedIn){
			return $user_to;
                }
		else {
			return $user_from;
                }

	}
        
        public function  getLatestMessage ($userLoggedIn, $user2) {
		$details_array = array();

		$query = mysqli_query($this->connection, "SELECT message, sender, date FROM messages WHERE (sender='$userLoggedIn' AND receiver='$user2') OR (sender='$user2' AND receiver='$userLoggedIn') ORDER BY id DESC LIMIT 1");
		$row = mysqli_fetch_array($query);
		$sent_by = ($row['sender'] != $userLoggedIn) ? "They said: " : "You said: ";
                $date=$row['date'];

                include_once '../class/post_query.php';
                $time=new Post_query();
                $time_message=$time->timeInterval($date);
		array_push($details_array, $sent_by);
		array_push($details_array, $row['message']);
		array_push($details_array, $time_message);

		return $details_array;
	}

	public function getConvos() {
		$userLoggedIn = $this->user_obj->getUsername();
		$return_string = "";
		$convos = array();

		$query = mysqli_query($this->connection, "SELECT receiver, sender FROM messages WHERE sender='$userLoggedIn' OR receiver='$userLoggedIn' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query)) {
			$user_to_push = ($row['receiver'] != $userLoggedIn) ? $row['receiver'] : $row['sender'];

			if(!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}
		}

		foreach($convos as $username) {
                    
			$user_found_obj = new User_info($this->connection, $username);
                        $sql="SELECT * FROM user_info WHERE username='$username'";
                        $query=mysqli_query($this->connection, $sql);
                        $user= mysqli_fetch_assoc($query);
                        $name=$user['name'];
                        $pic=$user['profile_pic'];
                        
                        
			$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots; 

			$return_string .= "<a href='message.php?msg_to=$username'> <div class='user_found_messages'>
								<img src='" . $pic . "' style='border-radius: 5px; margin-right: 5px;'>
								" . $name . "
								<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
								<p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
								</div>
								</a>";
		}

		return $return_string;

	}

	public function getConvosDropdown($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();
		$return_string = "";
		$convos = array();

		if($page == 1){
			$start = 0;
                        
                }
		else {
			$start = ($page - 1) * $limit;
                }

		$set_viewed_query = mysqli_query($this->connection, "UPDATE messages SET viewed='yes' WHERE receiver='$userLoggedIn'");

		$query = mysqli_query($this->connection, "SELECT sender, receiver FROM messages WHERE sender='$userLoggedIn' OR receiver='$userLoggedIn' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query)) {
			$user_to_push = ($row['receiver'] != $userLoggedIn) ? $row['receiver'] : $row['sender'];

			if(!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}
		}

		$num_iterations = 0; //Number of messages checked 
		$count = 1; //Number of messages posted

		foreach($convos as $username) {

			if($num_iterations++ < $start)
				continue;

			if($count > $limit)
				break;
			else 
				$count++;


			$is_unread_query = mysqli_query($this->connection, "SELECT opened FROM messages WHERE receiver='$userLoggedIn' AND sender='$username' ORDER BY id DESC");
			$row = mysqli_fetch_array($is_unread_query);
			$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

			include_once("user_info.php");
			$user_found_obj = new User_info($this->connection, $username);
			$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots; 

                        $sql="SELECT * FROM user_info WHERE username='$username'";
                        $query=mysqli_query($this->connection, $sql);
                        $user= mysqli_fetch_assoc($query);
                        $name=$user['name'];
                        $pic=$user['profile_pic'];
                        
                        
			$return_string .= "<a href='message.php?msg_to=$username'> 
                            <div class='user_found_messages' style='" . $style . "'>
                            <img src='" . $pic . "' style='border-radius: 5px; margin-right: 5px;'>
                            " . $name . "
                            <span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
                            <p id='grey' style='margin: 0;'>" . $latest_message_details[0] . $split . " </p>
                            </div>
                            </a>";
		}


		//If posts were loaded
		if($count > $limit){
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
                }
		else {
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'> <p style='text-align: center;'>No more messages to load!</p>";
                }

		return $return_string;
	}

	public function getUnreadNumber() {
		$userLoggedIn = $this->user_obj->getUsername();
		$query = mysqli_query($this->connection, "SELECT * FROM messages WHERE viewed='no' AND receiver='$userLoggedIn'");
		return mysqli_num_rows($query);
	}

}
