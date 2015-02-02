<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
session_start();


if (checkLogin()) {
    $account = new Account ($_SESSION['userid']);
    $out = array('result' => true, "username" => $account->username());


} else {
    $out = array('result' => false, "message" => 'Not Logged in');
}

echo json_encode($out);


?>
