<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';

if (isset($_POST['token'])) {
    session_start();
    $account = Account::fromToken($_POST['token']);
    if ($account->getID() != null) {
        $_SESSION['userid'] = $account->ID();
        $out = array('result' => true, "message" => 'session stared');
    } else {
        session_destroy();
        $out = array('result' => false, "message" => 'failed to start session');
    }

} else {
    $out = array('result' => false, "message" => 'Token not set');
}

echo json_encode($out);

?>
