<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {
    $account = new Account ($_SESSION['userid']);
    $out = array('result' => true, "username" => $account->username());


} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}

echo json_encode($out);


?>
