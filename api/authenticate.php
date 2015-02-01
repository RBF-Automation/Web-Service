<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $account = Account::login($username, $password, true);
        if ($account != false) {
            $out = array('result' => true, "message" => 'login successful', 'token' => $account->authToken());
        } else {
            $out = array('result' => false, "message" => 'failed to login');
        }
    } catch (Exception $e) {
        $out = array('result' => false, "message" => 'failed to login');
    }


} else {
    $out = array('result' => false, "message" => 'username or password not set');
}

echo json_encode($out);

?>
