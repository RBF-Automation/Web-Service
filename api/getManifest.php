<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
session_start();
if (checkLogin()) {
    error_log('loggedin! ID:' . $_SESSION['userid']);
    $testManifest = array(
        "id" => 1,
        "name" => "Front Door",
        "btn_on" => "Unlock",
        "btn_off" => "Lock",
    );
    $out = array();
    $out[] = $testManifest;
    echo json_encode($out);
} else {
    error_log('not logged in');
}


?>
