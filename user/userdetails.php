<?php
include '../layout/top.php';
$id=$_GET['u'];


$user_info=new User_info();
$query_user=$user_info->all_info_users($id);
$info= mysqli_fetch_assoc($query_user);
$num_friend=(substr_count($info['friend_array'],","))-1;
?>
<head>
<title>Profile Page</title>
<link rel="icon" href="../images/MIST_logo.png" type="image/gif">
<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</head>

<?php include '../layout/menu.php'?>
<body>
<div class="container">

    <div class="row" style="padding-top: 60px;">
        
        <div class="well col-md-3">
            <a href="all_profile.php?id=<?php echo $info['username'];?>">
                <img src="<?php echo $info['profile_pic'];?>" alt="" class="img-responsive"><hr/>
                <p><b style="font-family:cursive; font-size: 20px; color: #17a2b8"><?php echo $info['name'];?></b></p>
            </a>
            <p style="font-style: italic; color: #20AAE5">Number Of Posts = <?php echo $info['num_posts'];?></p>
            <p style="font-style: italic; color: #20AAE5">Number Of Friends = <?php echo $num_friend;?></p>
            <?php
                if($info['username']!==$_SESSION['username']){
            ?>
            <a href="message.php?msg_to=<?php echo $info['username'];?>" name="msg" class="btn btn-success" style="margin-left: 25px;">MESSAGE</a>
            <?php } ?>
            <?php
                if($info['username']==$_SESSION['username']){
            ?>
            <a href="edituserdetails.php?u=<?php echo $info['username'];?>" name="userdetails" class="btn btn-default" style="margin: 5px 68px;">Edit Details</a>
            <?php } ?>
        </div>
        <div class="well col-md-offset-1 col-md-7 table-responsive">
            <table class="table table-striped">
                <h3 align="center"><b><u>Personal Information:</u></b></h3><br>
                <tr>
                    <td class="active">Name:</td>
                    <td class="success"><?php echo $info['name'];?></td>
                 </tr>
                <tr>
                    <td class="active">E-mail:</td>
                    <td class="success"><?php echo $info['email'];?></td>
                 </tr>
                <tr>
                    <td class="active">Phone No.:</td>
                    <td class="success"><?php echo $info['phone_no'];?></td>
                 </tr>
                <tr>
                    <td class="active">Address:</td>
                    <td class="success"><?php echo $info['address'];?></td>
                 </tr>
                <tr>
                    <td class="active">Date of Birth:</td>
                    <td class="success"><?php echo $info['birthday'];?></td>
                 </tr>
                <tr>
                    <td class="active">Gender:</td>
                    <td class="success"><?php echo $info['gender'];?></td>
                 </tr>
            </table>
            <table class="table">
                 <h3 align="center"><b><u>Academic Information:</u></b></h3><br>
                <tr>
                    <td class="active">Institute:</td>
                    <td class="success"><?php echo "MODEL INSTITUTE of SCIENCE & TECHNOLOGY(MIST)";?></td>
                 </tr>
                <tr>
                    <td class="success">Position:</td>
                    <td ><?php echo $info['profession'];?></td>
                 </tr>
                <tr>
                    <td >ID No. of MIST:</td>
                    <td class="success"><?php echo $info['id_no'];?></td>
                 </tr>
                <tr>
                    <td class="success">Field Of Study:</td>
                    <td ><?php echo $info['field_of_study'];?></td>
                 </tr>
                <tr>
                    <td >Batch No:</td>
                    <td class="success"><?php echo $info['batch'];?></td>
                </tr>
                <tr>
                    <td class="success">Collage:</td>
                    <td ><?php echo $info['collage'];?></td>
                </tr>
                <tr>
                    <td >School:</td>
                    <td class="success"><?php echo $info['school'];?></td>
                </tr>
            </table>
            <table class="table">
                
                <h3 align="center"><b><u>Professional Information:</u></b></h3><br>
                <tr class="success">
                    <td >Currently Work At: </td>
                    <td ><?php echo $info['currently_work'];?></td>
                </tr>
                <tr class="info">
                    <td >Job Position:</td>
                    <td ><?php echo $info['job_position'];?></td>
                </tr>
                <tr class="success">
                    <td>Started Job From:</td>
                    <td ><?php echo $info['started_job'];?></td>
                </tr>
                <tr class="info">
                    <td >Professional Skill:</td>
                    <td ><?php echo $info['professional_skill'];?></td>
                </tr>
            </table>
            <table class="table able-striped table-bordered">
                <h3 align="center"><b><u>Other Information:</u></b></h3><br>
                <tr class="success">
                    <td >Religious View:</td>
                    <td ><?php echo $info['religious_view'];?></td>
                </tr>
                <tr class="danger">
                    <td >Political View:</td>
                    <td ><?php echo $info['political_view'];?></td>
                </tr>
            </table>
        </div>
        
    </div>
</div>
</body>