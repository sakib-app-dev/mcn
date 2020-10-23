<?php

session_start();
$userLoggedIn=$_SESSION['username'];

include '../config/configr.php';
include '../class/user.php';
include '../class/user_info.php';
include '../class/get_user_info.php';
include '../class/msgCls.php';
include '../class/notification.php';
include '../class/group.php';
include '../class/friend_request.php';



