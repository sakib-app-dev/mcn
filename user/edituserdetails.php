<?php 
include '../layout/top.php';

if(isset($_POST['btn'])){
    
    $userInfo=new User_info();
    $userInfo->updateProfile($_POST);
}

if(isset($_POST['btnCloseAccount'])){
    $user=new User_info();
    $user->deactiveAccount();
}
$id=$_GET['u'];
$user_info=new User_info();
$query_user=$user_info->all_info_users($id);
$info= mysqli_fetch_assoc($query_user);
$name=$info['name'];
$email=$info['email'];
$phn=$info['phone_no'];
$address=$info['address'];
$profession=$info['profession'];
$id_mist=$info['id_no'];
$bday=$info['birthday'];
$gender=$info['gender'];
$currentlyWork=$info['currently_work'];
$startedJobDate=$info['started_job'];
$jobPosition=$info['job_position'];
$skill=$info['professional_skill'];
$fieldOfStudy=$info['field_of_study'];
$batch=$info['batch'];
$collage=$info['collage'];
$school=$info['school'];
$religion=$info['religious_view'];
$politics=$info['political_view'];




if($info['username']==$_SESSION['username']){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit User Details</title>
        <link rel="icon" href="../images/MIST_logo.png" type="image/gif">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
        <script src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </head>
    <body>
         <?php include '../layout/menu.php';?> 
        <div class="container" style="margin-top: 60px;">
            <div class="well col-md-3">
            <a href="all_profile.php?id=<?php echo $info['username'];?>">
                <img src="<?php echo $info['profile_pic'];?>" alt="" class="img-responsive"><hr>
            </a>
            <div class="custom-file">
                <input type="file" class=" form-control custom-file-input" id="customFile">
                <input type="submit" class="form-control btn btn-success" name="btn" value="Update Profile Picture">
            </div>
           
            <a href="userdetails.php?u=<?php echo $info['username'];?>" name="userdetails" class="btn btn-primary btn-block" style="margin-top: 5px;">View Details</a>
                
        </div>
        <div class=" well col-md-offset-1 col-md-7">
            <h3 align="center"> <b><u>Update Information</u></b></h3><hr>
            <form class="form-horizontal" action="" method="POST">
                       <div class="form-group">
                           <label class="control-label col-md-2">Name:</label>
                           <div class="col-md-9">
                               <input type="text" name="name" required="" value="<?php echo $name;?>"  placeholder="Enter Your Name..." class="form-control">
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-2">E-mail:</label>
                           <div class="col-md-9">
                               <input type="email" name="email" required="" value="<?php echo $email ;?>" placeholder="Enter Your E-mail address..." class="form-control" readonly="">
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-2">Phone No:</label>
                           <div class="col-md-9">
                               <input type="number" name="phn_no" value="<?php echo $phn ;?>" placeholder="Enter Your Phone No..." class="form-control">
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-2">Address:</label>
                           <div class="col-md-9">
                               <textarea name="address" class="form-control"><?php echo $address;?></textarea>
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-2">Birthday:</label>
                           <div class="col-md-9">
                               <input type="date" name="dob"  value="<?php echo $bday ;?>" class="form-control">
                           </div>
                       </div>
                       
                       <div class="form-group">
                           <label class="control-label col-md-2">Gender:</label>
                           <div class="col-md-9 form-check form-check-inline">
                               <label class="radio-inline">
                                   <input type="radio" name="gender" value="Male" checked>Male
                               </label>
                               <label class="radio-inline">
                                   <input type="radio" name="gender" value="Female">Female
                               </label>
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="control-label col-md-2">Institute:</label>
                           <div class="col-md-9">
                               <input class="form-control" type="text" name="Institute" placeholder="Model Institute of Science And Technology (MIST)..." readonly>
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Position:</label>
                           <div class="col-md-9">
                               <select name="position" class="custom-select form-control">
                                   <option selected="" disabled="">select</option>
                                <option value="Student"
                                        <?php if($profession=='Student'){
                                            echo "selected";
                                        }
                                            ?>
                                        >Student</option>
                                <option value="Teacher"
                                        <?php if($profession=='Teacher'){
                                            echo "selected";
                                        }
                                            ?>
                                        >Teacher</option>
                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">MIST ID NO:</label>
                           <div class="col-md-9">
                               <input type="text" name="mistid"  value="<?php echo $id_mist ;?>"  placeholder="MIST ID" class="form-control" readonly="">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Field of Study:</label>
                           <div class="col-md-9">
                               <select name="fos" class="custom-select form-control">
                                   <option selected disabled="">select</option>
                                <option value="CSE" <?php if($fieldOfStudy=='CSE'){echo "selected";}?> >CSE</option>
                                <option value="BBA" <?php if($fieldOfStudy=='BBA'){echo "selected";}?>>BBA</option>
                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Batch No:</label>
                           <div class="col-md-9">
                               <select name="batch" value="<?php echo $batch ;?>"  class="custom-select form-control">
                                   <option selected disabled="">select</option>
                                <option value="2011-12" <?php if($batch=='2011-12<'){echo "selected";}?>>2011-12</option>
                                <option value="2012-13" <?php if($batch=='2012-13'){echo "selected";}?>>2012-13</option>
                                <option value="2013-14" <?php if($batch=='2013-14'){echo "selected";}?>>2013-14</option>
                                <option value="2014-15" <?php if($batch=='2014-15'){echo "selected";}?>>2014-15</option>
                                <option value="2015-16" <?php if($batch=='2015-16'){echo "selected";}?>>2015-16</option>
                                <option value="2016-17" <?php if($batch=='2016-17'){echo "selected";}?>>2016-17</option>
                                <option value="2017-18" <?php if($batch=='2017-18'){echo "selected";}?>>2017-18</option>
                                <option value="2018-19" <?php if($batch=='2018-19'){echo "selected";}?>>2018-19</option>
                                <option value="2019-20" <?php if($batch=='2019-20'){echo "selected";}?>>2019-20</option>
                                <option value="2020-21" <?php if($batch=='2020-21'){echo "selected";}?>>2020-21</option>
                               </select>
                           </div>
                       </div>
                        
                        <div class="form-group">
                           <label class="control-label col-md-2">Currently Work:</label>
                           <div class="col-md-9">
                               <input type="text" name="currently_work"  value="<?php echo $currentlyWork ;?>"  placeholder="Where do you currently work now..." class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Job Position:</label>
                           <div class="col-md-9">
                               <input type="text" name="job_position" value="<?php echo $jobPosition ;?>"   placeholder="What is your Job Position.." class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Stated Job at:</label>
                           <div class="col-md-9">
                               <input type="date" name="startJobDate" value="<?php echo $startedJobDate ;?>"   class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Professional Skill:</label>
                           <div class="col-md-9">
                               <input type="text" name="skill" value="<?php echo $skill ;?>"   placeholder="Write your Skills..." class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Collage:</label>
                           <div class="col-md-9">
                               <input type="text" name="collage" value="<?php echo $collage ;?>"  placeholder="Enter Your Collage Name..." class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">School:</label>
                           <div class="col-md-9">
                               <input type="text" name="school" value="<?php echo $school ;?>"  placeholder="Enter Your School Name..." class="form-control">
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Religious View:</label>
                           <div class="col-md-9">
                               <select name="religion" value="<?php echo $religion ;?>" class="custom-select form-control">
                                   <option selected disabled="">select</option>
                                    <option value="Islam" <?php if($religion=='Islam'){echo "selected";}?> >Islam</option>
                                    <option value="Hindu" <?php if($religion=='Hindu'){echo "selected";}?>>Hindu</option>
                                    <option value="Christian" <?php if($religion=='Christian'){echo "selected";}?>>Christian</option>
                                    <option value="Buddhist" <?php if($religion=='Buddhist'){echo "selected";}?>>Buddhist</option>
                               </select>
                           </div>
                       </div>
                        <div class="form-group">
                           <label class="control-label col-md-2">Political View:</label>
                           <div class="col-md-9">
                               <input type="text" name="political_view" value="<?php echo $politics ;?>"  placeholder="Political View..." class="form-control">
                           </div>
                       </div>
                        
                
                       <div class="form-group">

                           <div class="col-md-offset-2 col-md-9">
                               <input type="submit" name="btn" value="Update Detiails" class="btn btn-success btn-block">
                           </div>
                       </div>   
                   </form>
            <p align="center">
                <a class="btn btn-primary btn-lg" href="changepswd.php?u=<?php echo $info['username'];?>">To Change Password <br> click here</a>
            </p>
            <form action="" method="POST">
                <button type="" name="btnCloseAccount" class="btn btn-danger center-block"><b>Deactivate Your Account</b></button>
            </form>
            

        </div>

        
        
    </body>
</html>
<?php } ?>