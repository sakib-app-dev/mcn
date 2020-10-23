<?php
include("../config/configr.php");
include("../class/msgCls.php");

$limit = 7; //Number of notification to load

$msg = new MsgCls($con, $_REQUEST['userLoggedIn']);
echo $msg->getConvosDropdown($_REQUEST, $limit);

?>

