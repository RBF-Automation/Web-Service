<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once 'ErrorCodes.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $account = Account::login($username, $password, true);
        if ($account != false) {
            $out = array('result' => true, "message" => 'login successful', 'token' => $account->authToken());
        } else {
            $out = array('result' => false, "errorCode" => ErrorCodes::LOGIN_FAILED, "message" => 'failed to login');
        }
    } catch (Exception $e) {
        $out = array('result' => false, "errorCode" => ErrorCodes::UNKNOWN_LOGIN_ERROR, "message" => 'failed to login');
    }


} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::INVALID_PARAMETERS, "message" => 'username or password not set');
}

echo json_encode($out);

?>
