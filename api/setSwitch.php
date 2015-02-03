<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/NodeTypes.php';
include_once '../accountUtils.php';
include_once '../hwController.php';
session_start();


if (checkLogin()) {

    if (isset($_POST['id']) && isset($_POST['state']) && ($_POST['state'] == 1 || $_POST['state'] == 0 )) {

        $node = new Node($_POST['id']);

        sendSwitchMessage($node->nodeId(), $_POST['state']);
        $out = array('result' => true, "message" => 'setData');

    } else {
        $out = array('result' => false, "message" => 'Invalid args');
    }


} else {
    $out = array('result' => false, "message" => 'Not Logged in');
}

echo json_encode($out);
?>
