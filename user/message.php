<?php
include '../layout/top.php';

$id=$_GET['msg_to'];
$userInfo=new User_info($id);
$query_user=$userInfo->all_info_users($id);
$info= mysqli_fetch_assoc($query_user);
$name=$info['name'];
$username=$_SESSION['username'];




$msg=new MsgCls($con,$username);
if(isset($_GET['msg_to'])){
    $msg_to=$_GET['msg_to'];
    if(isset($_POST['btn'])){
    $msg->sendMsg($_POST,$msg_to);
    
    }
    
}
elseif(isset($_POST['btn'])){
     $msg->sendMsg($_POST);
}

$result=$msg->getMsg($_GET['msg_to']);
?>
<html>
    <head>
        <title>Message</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
        <style>
/*            .msgDesign{
                height: 56%;
                min-height: 300px;
                max-height: 400px;
                overflow-y: scroll;
                margin-bottom: 10px;
            }
            .otherMsg{
                font-family: cursive;
                margin-bottom: 2px;
                background-color: #2ecc71;
                border: 1px solid #000;
                border-radius: 5px;
                border-color: #298069;
                padding: 5px 10px;
                display: inline-block;
                color: #ffffff;
            }
            .ownerMsg{
                font-family: cursive;
                float: right;
                margin-bottom: 2px;
                background-color: #3498db;
                border: 1px solid #000;
                border-radius: 5px;
                border-color: #006633;
                padding: 5px 10px;
                display: inline-block;
                color: #ffffff;
            }
            .btnStyle{
                height: 50px;
                width: 78px;
                font-family: cursive;
                margin-top: 3px;
                float: right;
            }
            .loaded_conversations {
                max-height: 450px;
                overflow-y: scroll;
            }

            .user_found_messages {
                    border-bottom: 1px solid #D3D3D3;
                    padding: 8px 8px 10px 8px;
            }

            .user_found_messages:hover {
                    background-color: #D3D3D3;
            }

            .user_found_messages img {
                    height: 35px;
                    float: left;
            }*/
            #grey {
                    color: #8C8C8C;
            }

        </style>
    </head>

        <?php include '../layout/menu.php' ?>
    <body>
        <div class="well">
            <div class="container" style="padding-top: 60px;">
                <div class="col-md-4">
                    <div class="user_details column" id="conversations">
			<h4>Conversations</h4>

			<div class="loaded_conversations">
				<?php echo $msg->getConvos(); ?>
			</div>
			<br>
<!--			<a href="messages.php?msg_to=new">New Message</a>-->

		</div>
                </div>

                
                    <div class="col-md-6" style="background-color: #ffffff">
                        <h4 style="color: #3399ff"><?php echo 'You And ' . $name; ?></h4><hr>
                        <div class="msgDesign" id="scroll_msg">
                            
                            <?php while ($msgAll = mysqli_fetch_array($result)) {
                                $username = $msgAll['sender'];
                                if ($username != $_SESSION['username']) { ?>
                                    <h6 class="nameStyle"><?php echo $name; ?></h6>
                                    <p class="otherMsg"><?php echo $msgAll['message']; ?></p><br>
                                <?php } else { ?>
                                    <p class="ownerMsg"><?php echo $msgAll['message']; ?></p><br><br>

                                <?php }
                                }
                                ?>
                        </div>




                        <hr style="margin-top:12px">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>
                                    <textarea name="msg" class="form-control" rows="2" cols="50" placeholder="write messages..."></textarea></label>
                                

                                <button  name="btn" class="btn btn-success btnStyle">Send</button>

                            </div>
                        </form>
                    </div>
                
            </div>
        </div>
<?php include '../layout/footer.php' ?>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var div=document.getElementById("scroll_msg");
            div.scrollTop=div.scrollHeight;
        </script>
    </body>
</html>


