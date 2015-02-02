<?php

include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/NodeTypes.php';
include_once '../accountUtils.php';
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
        }
    }
} else {
    $out = array('result' => false, "message" => 'Not Logged in');
}

echo json_encode($out);
?>
