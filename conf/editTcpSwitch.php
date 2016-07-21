<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/TcpSwitch.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['name']) && 
    isset($_POST['address']) && 
    isset($_POST['port']) && 
    isset($_POST['onCmd']) && 
    isset($_POST['offCmd']) && 
    isset($_POST['on']) && 
    isset($_POST['off']) && 
    isset($_GET['ID']) &&
    isset($_POST['logMessageOff'])) {

    $nodeProps = new TcpSwitch($_GET['ID']);
    $nodeProps->name($_POST['name']);
    $nodeProps->address($_POST['address']);
    $nodeProps->port($_POST['port']);
    $nodeProps->onCmd($_POST['onCmd']);
    $nodeProps->offCmd($_POST['offCmd']);
    $nodeProps->btn_on($_POST['on']);
    $nodeProps->btn_off($_POST['off']);
    $nodeProps->logMessageOn($_POST['logMessageOn']);
    $nodeProps->logMessageOff($_POST['logMessageOff']);
    header('Location: /conf/');
}

?>
