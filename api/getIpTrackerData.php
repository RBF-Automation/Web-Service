<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../accountUtils.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {
    
    if (isset($_POST['id'])) {
        $node = new Node($_POST['id']);
        $props = new IpTrackerNodeProperties($node->ID());
        
        $data = array();
        
        foreach ($log as $event) {
            $data[] = array(
                //finish
            );
        }
        
        $out = array('result' => true, 'data' => $data);
        
        
    } else {
        $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'id not set');
    }
    

} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}


echo json_encode($out);
?>
