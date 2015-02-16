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

if (isset($_POST['server']) && isset($_POST['name'])) {

    $nodeProps = new IpTrackerNodeProperties($_GET['ID']);
    $nodeProps->server($_POST['server']);
    $nodeProps->name($_POST['name']);
}


if (isset($_POST['newIp']) && isset($_POST['user']) && $_POST['newIp'] != "" && $_POST['user'] != '') {
    $nodeProps = new IpTrackerNodeProperties($_GET['ID']);
    $nodeProps->newUser($_POST['newIp'], $_POST['user']);
}

if (isset($_GET['delete'])) {
    $nodeProps = new IpTrackerNodeProperties($_GET['ID']);
    $nodeProps->deleteClientIp($_GET['delete']);
}
header('Location: /conf/');

?>
