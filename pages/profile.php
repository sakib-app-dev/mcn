<?php

include_once '../class/post_query.php';

$post=new Post_query();
if(isset($_POST['btn'])){
    $post->save_post($_POST);
}


?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<?php include '../layout/menu.php'?>
<div class="container">

    <div class="row">
        <div class="col-md-offset-2 col-md-6">
            <div class="well">
                <form action="" method="post">
                    <div class="form-group">
                        <h4 class="text text-primary"><b><u>Make Post:</u></b></h4>
                        <textarea name="post_details" class="form-control" rows="4"></textarea>
                        <input type="file" name="img" accept="image/*">
                        <button name="btn" class="btn btn-sm btn-primary btn-block">POST</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--    Post in profile-->
     
</div>

<?php include '../layout/footer.php'?>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>