<?php
//THIS WHOLE THING IS TEMP
function sendSwitchMessage($pipe, $state) {

    $msg = array("nodeid" => $pipe, "action" => 0, "state" => intval($state));

    $fp = stream_socket_client("tcp://localhost:30000", $errno, $errstr);

    fwrite($fp, json_encode($msg, JSON_NUMERIC_CHECK));
    fclose($fp);
}

?>
