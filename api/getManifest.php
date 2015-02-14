<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../src/NodeTypes.php';
include_once '../accountUtils.php';
include_once 'ErrorCodes.php';
session_start();


if (checkLogin()) {

    $out = array();

    foreach (Node::getNodes() as $node) {
        switch ($node->type()) {
            case NodeTypes::SWITCH_NODE:
                $props = new SwitchNodeProperties($node->ID());
                $out[] = array(
                    "id" => intval($node->ID()),
                    "type" => intval($node->type()),
                    "name" => $props->name(),
                    "btn_on" => $props->btn_on(),
                    "btn_off" => $props->btn_off(),
                );
                break;

            case NodeTypes::ACTIVITY_LOG:
                $props = new SwitchNodeProperties($node->ID());
                $out[] = array(
                    "id" => intval($node->ID()),
                    "type" => intval($node->type()),
                    "name" => NodeTypes::$map[NodeTypes::ACTIVITY_LOG],
                );
                break;
                
            case NodeTypes::IP_TRACKER:
                $props = new IpTrackerNodeProperties($node->ID());
                $out[] = array(
                    "id" => intval($node->ID()),
                    "type" => intval($node->type()),
                    "name" => $props->name(),
                );
                break;
        }
    }
} else {
    $out = array('result' => false, "errorCode" => ErrorCodes::NOT_LOGGED_IN, "message" => 'Not Logged in');
}

echo json_encode($out);
?>
