<?php
include_once 'SQLConnect.php';
include_once 'src/Account.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: /login.php');
    return;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $account = Account::createNew($username, $password);
        header('Location: /');
    } catch (Exception $e) {
        echo $e;
    }
}

?>
