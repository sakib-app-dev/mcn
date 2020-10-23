<?php

include '../config/configr.php';
if(isset($_POST["query"])){
    $output='';
    $query="SELECT * FROM   user_info WHERE name LIKE '%".$_POST['query']."%' ";
    $result= mysqli_query($con, $query);
    $output.='<ul class="listStyle">';
    if(mysqli_num_rows($result)>0){
        while($row= mysqli_fetch_assoc($result)){
            $name=$row['name'];
            $pic=$row['profile_pic'];
            $user= $row['username'];
            $output.='<li class="srcList"><a href="all_profile.php?id='.$user.'"><img class="img-responsive" style="height:40px;margin-right:0px;float:left;" src='.$pic.'>'.$name.'</a></li><hr/>';
            
        }
    }else{
        $output.='<li> Nothing Found</li>';
    }
    $output.='</ul>';
    echo $output;
}

