<?php
include '../layout/top.php';
$gp_id=$_GET['gpid'];

require_once '../class/group.php';

$post_data=new Group();

//data collecting post query
$query_result=$post_data->postInfoById($gp_id);
$post= mysqli_fetch_assoc($query_result);


//updating post query
if(isset($_POST['btn'])){
$post_data->update_post($_POST);
//echo '<pre>';
//print_r($_POST);
//exit();

}

?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<?php include '../layout/menu_1.php'?>
<div class="row" style="padding-top: 60px">
<div class="col-md-offset-2 col-md-8">
    <div class="well">
        <form action="" method="post">
            <div class="form-group">
                <h4 class="text" style="font-family: cursive;color: #2ecc71"><b><u>Edit Post:</u></b></h4>
                <input type="hidden" name="post_id" value="<?php echo $post['post_id'];?>" >
                <label>Post Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo $post['post_title'];?>">
                <label>What's on your mind:</label>
                <textarea name="post_details" class="form-control" rows="4" ><?php echo $post['post_details'];?></textarea>
                <input type="file" name="img" accept="image/*">
                <button name="btn" class="btn btn-sm btn-success btn-block">UPDATE</button>
            </div>
        </form>
    </div>
</div>
</div>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<?php include '../layout/footer.php'?>