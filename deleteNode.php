<?php
include_once 'accountUtils.php';
include_once 'SQLConnect.php';
include_once 'src/Account.php';
include_once 'src/Node.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: /login.php');
    return;
}

if (isset($_GET['id'])) {
    try {
        Node::deleteNode($_GET['id']);
        header('Location: /');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }

}

?>