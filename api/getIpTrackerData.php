<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../accountUtils.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {
    
    if (isset($_GET['id'])) {
        $node = new Node($_GET['id']);
        $props = new IpTrackerNodeProperties($node->ID());
        
        $outData = array();
        $results = $props->getUsers();
        foreach ($results as $data) {
            $user = new Account($data['user']);
            if ($data['isHome']) {
                $outData[] = array(
                    'username' => $user->username(),
                    'status' => $data['status']
                );
            }
            
        }
        
        $out = array('result' => true, 'data' => $outData);
        
        
    } else {
        $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'id not set');
    }
    

} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}


echo json_encode($out);
?>
