<?php
include_once 'accountUtils.php';
include_once 'SQLConnect.php';
include_once 'src/Account.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: /login.php');
    return;
}

if (isset($_GET['id'])) {
    try {
        Account::deleteAccount($_GET['id']);
        header('Location: /');
    } catch (Exception $e) {
        echo $e;
    }

}

?>
