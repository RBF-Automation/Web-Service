<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';

function logOut() {
    session_start();
    session_destroy();
}
function checkLogin() {
    (session_id() == '' ? session_start() : false);
    if (isset($_SESSION['userid'])) {
        try {
            $acc = new Account($_SESSION['userid']);
            return (($acc->ID() == $_SESSION['userid']) && $acc->authToken() == $_SESSION['token']);
        } catch (Exception $e) {
        }
    }
    return false;
}

?>
