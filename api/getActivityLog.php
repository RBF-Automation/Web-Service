<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/ActivityLog.php';
include_once '../accountUtils.php';
include_once '../formatTime.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {

    if (isset($_POST['count']) && is_numeric($_POST['count']) && $_POST['count'] > 0 && $_POST['count'] < 100) {

        $log = ActivityLog::getLog($_POST['count']);

        $data = array();

        foreach ($log as $event) {
            $data[] = array(
                "user" => $event->user(),
                "message" => $event->message(),
                "time" => formatTime($event->time()),
            );
        }

        $out = array('result' => true, 'data' => $data);


    } else {
        $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'count not set or invalid');
    }

} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}

echo json_encode($out);
?>
