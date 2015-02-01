<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
session_start();
if (checkLogin()) {
    error_log('loggedin! ID:' . $_SESSION['userid']);
} else {
    error_log('not logged in');
}


?>
