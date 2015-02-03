<?php
include_once '../accountUtils.php';
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_GET['id'])) {
    try {
        Node::deleteNode($_GET['id']);
        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }

}

?>
