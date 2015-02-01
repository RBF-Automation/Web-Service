<?php

function logOut() {
    session_start();
    session_destroy();
}
function checkLogin() {
    (session_id() == '' ? session_start() : false);
    return isset($_SESSION['userid']);
}

?>
