<?php

    $total_likes = $post['likes'];

    if (isset($_POST['like'])) {
        $get_likes = mysqli_query($con, "SELECT likes, username FROM user_post WHERE post_id='$post[post_id]'");
	$row = mysqli_fetch_array($get_likes);
	$total_likes = $row['likes'];
        $user_liked=$row['username'];
        $total_likes++;
//        $likeUpdate = mysqli_query($con, "UPDATE user_post SET likes='$total_likes' WHERE post_id='$post[post_id]'");
//        $insertLike = mysqli_query($con, "INSERT INTO post_likes VALUES ('','$_SESSION[username]','$post[post_id]')");
        
        //Insert Notification
        if($user_liked != $userLoggedIn) {
            $post_id=$post['post_id'];
            
                $notification = new Notification($con,$userLoggedIn);
                $notification->insertNotification($post_id, $user_liked, "like");
        }
}
    if (isset($_POST['unlike'])) {
        $total_likes--;
        $likeUpdate = mysqli_query($con, "UPDATE user_post SET likes='$total_likes' WHERE post_id='$post[post_id]'");
        $deleteLike = mysqli_query($con, "DELETE FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]'");
    }
    $likeSqlQuery = mysqli_query($con, "SELECT * FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]'");
    $numUserLike = mysqli_fetch_assoc($likeSqlQuery);
    //echo $post['post_id'];
//    if ($numUserLike > 0) {
//        echo '<form action="" method="POST">
//                <input type="submit" name="unlike" value="Unlike">
//                <div>
//                    ' . $total_likes . 'Likes
//                </div>
//              </form>';
//    } else {
//        echo '<form action="" method="POST">
//                <input type="submit" name="like" value="Like">
//                <div>
//                    ' . $total_likes . 'Likes
//                </div>
//              </form>';
//    }
?>