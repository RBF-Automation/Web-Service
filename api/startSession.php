<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once 'ErrorCodes.php';

if (isset($_POST['token'])) {
    try {
        $account = Account::fromToken($_POST['token']);
        if ($account->getID() != null) {
            session_start();
            $_SESSION['userid'] = $account->ID();
            $_SESSION['token'] = $account->authToken();
            $out = array('result' => true, "message" => 'session stared');
        } else {
            $out = array('result' => false, "errorCode" => ErrorCodes::SESSION_START_FAILED, "message" => 'failed to start session');
        }
     } catch (Exception $e) {
        $out = array('result' => false, "errorCode" => ErrorCodes::UNKNOWN_LOGIN_ERROR, "message" => 'failed to login');
    }

} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'Token not set');
}

echo json_encode($out);

?>
