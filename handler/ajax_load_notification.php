<?php
include("../config/configr.php");
include("../class/notification.php");

$limit = 7; //Number of notification to load

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>