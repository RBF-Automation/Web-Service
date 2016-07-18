<?php
include_once '../accountUtils.php';
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

if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        
        $node = new Node($id);
        $type = $node->type();
        
        switch ($type) {
            case NodeTypes::SWITCH_NODE:
                SwitchNodeProperties::delete($id);
                break;
            case NodeTypes::IP_TRACKER:
                IpTrackerNodeProperties::delete($id);
                break;
            case NodeTypes::MFI_SWITCH:
                mFiOutletProperties::delete($id);
                break;
        }
        
        
        Node::deleteNode($_GET['id']);
        header('Location: /conf/');
    } catch (Exception $e) {
        echo  $e->getMessage();
    }

}

?>
