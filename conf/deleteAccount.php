<?php
include_once '../accountUtils.php';
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
include_once '../src/IpMap.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_GET['id'])) {
    try {
        IpMap::deleteByUser($_GET['id']);
        Account::deleteAccount($_GET['id']);
        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }

}

?>
