<?php

$total_likes = $post['likes'];

if (isset($_POST['like'])) {
    $total_likes++;
    $likeUpdate = mysqli_query($con, "UPDATE user_post SET likes='$total_likes' WHERE post_id='$post[post_id]'");
    $insertLike = mysqli_query($con, "INSERT INTO post_likes VALUES ('','$_SESSION[username]','$post[post_id]')");
}
if (isset($_POST['unlike'])) {
    $total_likes--;
    $likeUpdate = mysqli_query($con, "UPDATE user_post SET likes='$total_likes' WHERE post_id='$post[post_id]'");
    $deleteLike = mysqli_query($con, "DELETE FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]'");
}
$likeSqlQuery = mysqli_query($con, "SELECT * FROM post_likes WHERE username='$_SESSION[username]' AND post_id='$post[post_id]'");
$numUserLike = mysqli_fetch_assoc($likeSqlQuery);
//echo $post['post_id'];
?>
<?php if ($numUserLike > 0) { ?>
    <form action="" method="POST">
        <button class="col-md-5 btn btn-success" name="unlike">Unike &nbsp;<?php echo $total_likes;?> Likes</button>

    </form>';
<?php } else { ?>
    <form action="" method="POST">
        <button class="col-md-5 btn btn-default" name="like">Like &nbsp;<?php echo $total_likes;?> Likes</button>
    </form>';
<?php } ?>