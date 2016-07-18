<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../accountUtils.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../src/mFiOutletProperties.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

if (isset($_POST['nodeType'])) {
    try {
        $node = Node::createNew($_POST['nodeType']);
        switch ($node->type()) {
            case NodeTypes::SWITCH_NODE:
                SwitchNodeProperties::createNew($node->ID());
                break;

            case NodeTypes::ACTIVITY_LOG:
                break;
                
            case NodeTypes::IP_TRACKER:
                IpTrackerNodeProperties::createNew($node->ID());
                break;
            case NodeTypes::MFI_SWITCH:
                mFiOutletProperties::createNew($node->ID());
                break;
        }

        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }
}

?>
