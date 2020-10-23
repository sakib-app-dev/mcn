<?php
include '../../config/configr.php';
include '../../class/user_info.php';
include '../../class/msgCls.php';

$limit = 7; //Number of messages to load

$message = new Message($this->connection, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST, $limit);
?>
