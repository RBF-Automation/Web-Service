<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['name']) && isset($_POST['on']) && isset($_POST['off']) && isset($_GET['ID'])) {

    $nodeProps = new SwitchNodeProperties($_GET['ID']);
    $nodeProps->name($_POST['name']);
    $nodeProps->btn_on($_POST['on']);
    $nodeProps->btn_off($_POST['off']);
    header('Location: /conf/');
}

?>
