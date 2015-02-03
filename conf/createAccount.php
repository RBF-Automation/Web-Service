<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $account = Account::createNew($username, $password);
        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }
}

?>
