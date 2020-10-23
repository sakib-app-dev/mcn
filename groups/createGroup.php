<?php
include '../layout/top.php';

if(isset($_POST['btn'])){
    $grp=new Group();
    $msg=$grp->createGroup($_POST);
}

?>
<html>
    <head>
      <title>Create Group</title>
      <link rel="icon" href="images/MIST_logo.png" type="image/gif">
      <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
   </head>
   
   <body>
       <?php include_once '../layout/menu_1.php';?>
       <form action="" method="post">
           <div class="container" style="padding-top: 160px">
               <div class="well">
                   <div class="form-group">
                       <label>Group Name:</label>
                       <input type="text" name="grpName" class="form-control" placeholder="Choose a group name...">
                   </div>
                   <div class="form-group">
                       <label>Group Type:</label>
                       <div class="form-check form-check-inline">
                           <label class="radio-inline">
                               <input type="radio" name="grpType" value="public" checked>Public
                           </label><br>
                           <label class="radio-inline">
                               <input type="radio" name="grpType" value="private">Private
                           </label>
                       </div>
                   </div>
                   <div class="form-group">
                       <input type="submit" name="btn" value="Create Group" class="btn btn-success btn-block">
                   </div> 
               </div>
           </div>
       </form>
       
       <?php include '../layout/footer.php'?>
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
   </body>
</html>