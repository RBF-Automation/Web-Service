<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['server'])) {

    $nodeProps = new IpTrackerNodeProperties($_GET['ID']);
    $nodeProps->server($_POST['server']);
}


if (isset($_POST['newIp'])) {
    error_log('here');
    $nodeProps = new IpTrackerNodeProperties($_GET['ID']);
    $nodeProps->newUser($_POST['newIp']);
}

header('Location: /conf/');

?>
