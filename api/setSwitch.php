<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/ActivityLog.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/NodeTypes.php';
include_once '../accountUtils.php';
include_once '../hwController.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {

    if (isset($_POST['id']) && isset($_POST['state']) && ($_POST['state'] == 1 || $_POST['state'] == 0 )) {

        $node = new Node($_POST['id']);

        $acc = new Account($_SESSION['userid']);

        sendSwitchMessage($node->nodeId(), $_POST['state']);

        $props = new SwitchNodeProperties($node->ID());

        if ($_POST['state'] == 1) {
            ActivityLog::log($acc->username(), $props->logMessageOn() . ' ' . $props->name());
        } else {
            ActivityLog::log($acc->username(), $props->logMessageOff() . ' ' . $props->name());
        }

        $out = array('result' => true, "message" => 'setData');

    } else {
        $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'Invalid args');
    }


} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}

echo json_encode($out);
?>
