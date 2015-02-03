<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['nodeId']) && isset($_POST['nodeType'])) {
    try {
        $account = Node::createNew($_POST['nodeId'], $_POST['nodeType']);
        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }
}

?>
