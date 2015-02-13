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
    header('Location: /conf/');
}

?>
