<?php
include_once '../SQLConnect.php';
include_once '../src/Account.php';
include_once '../src/Node.php';
include_once '../src/NodeTypes.php';
include_once '../src/SwitchNodeProperties.php';
include_once '../src/IpTrackerNodeProperties.php';
include_once '../accountUtils.php';
session_start();

if (!checkLogin()) {
    header('Location: /conf/login.php');
    return;
}

?>
<head>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <style>
    .card {
        box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.30);
        border-radius: 2px;
        background: #FFF;
    }
    .node {
        margin: 10px;
        padding: 8px;
        float: left;
    }
    .account {
        margin: 10px;
        padding: 8px;
        float: left;
    }
    .topBar {
        background: #8E24AA;
        box-shadow: 0px 1px 14px rgba(0, 0, 0, 0.40);
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
    }
    .title {
        color: #fff;
        font-size: 20pt;
        padding: 10px;
        float: left;
    }
    .logout {
        float: right;
        color: #fff;
        font-size: 20pt;
        padding: 10px;
    }
    .logout a {
        color: #fff;
        text-decoration: none;
    }
    
    .logout a:hover {
        text-decoration: underline;
    }
    
    .hightlight {
        background: rgba(247, 250, 80, 0.64);
    }
    .hover:hover {
        background: #F0F0F0;
    }
    .indentContent {
        margin: 20px;
        
    }
    .createNode {
        margin: 10px;
        padding-top: 15px;
        padding-left: 10px;
        padding-right: 10px;
        float: left;
    }
    tr, td {
        padding: 2px;
        padding-right: 5px;
        border: 0px;
    }
    body {
        font-family: 'Open Sans', sans-serif;
        background: #E4E4E4;
        margin-top: 70px;
    }
    table {
        border: none;
        margin: 0 auto;
    }
    </style>
</head>

<div class="topBar">
    <div class="title"> RBF Automation </div>
    <div class="logout"> <a href="logout.php">Logout</a></div>
</div>

<h2> Accounts </h2>
<div class="indentContent">
    <h3> Create Account </h3>
    <form action="createAccount.php" method="post">
        <div class="account card">
            <table>
                <tr>
                    <td>username</td>
                    <td><input name="username"/></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input style="float: right;" type="submit"/></td>
                </tr>
            </table>
        </div>
    </form>
    <br style="clear: both" />

    <h3> Manage Accounts </h3>
    <?php
    foreach (Account::getAccounts() as $account) {
        ?>
        <div class="account card">
            <table>
                <tr>
                    <td>username</td>
                    <td><span style='font-weight: bold;'><?= $account->username(); ?></span></td>
                </tr>
                <tr>
                    <td>Created on</td>
                    <td><span style='font-weight: bold;'><?= date('j/n/Y h:i:s A', $account->time()); ?></span></td>
                </tr>
                <tr>
                    <td><a href="deleteAccount.php?id=<?= $account->ID(); ?>"> delete Account</a></td>
                    <td><a href="deauth.php?id=<?= $account->ID(); ?>"> reset token</a></td>
                </tr>
            </table>
        </div>
        <?php
    }
    ?>
</div>

<br style="clear: both" />

<h2> Nodes </h2>
<div class="indentContent">
    <h3> Create Node </h3>
    <div class="createNode card">
        <form action="createNode.php" method="post">
        <select name="nodeType">
        <?php
        foreach (NodeTypes::$map as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        }
        ?>
        </select>
        <input type="submit"/>
        </form>
    </div>
    
    <br style="clear: both" />
    
    <h3> Manage Nodes </h3>
    <?php
    foreach (Node::getNodes() as $node) {
        $type = $node->type();
        ?>
        <div class="node card">
        <table>
            <tr>
                <td>Type</td>
                <td><span style='font-weight: bold;'><?= NodeTypes::$map[$type]; ?></span></td>
            </tr>
            <tr>
                <td>Created on</td>
                <td><span style='font-weight: bold;'><?= date('j/n/Y h:i:s A', $node->time()); ?></span></td>
            </tr>
            <tr>
                <td></td>
                <td><a style="float: right;" href="deleteNode.php?id=<?= $node->ID(); ?>"> delete Node</a></td>
            </tr>
        </table>
        <?php

        switch ($node->type()) {
            case NodeTypes::SWITCH_NODE:
                $props = new SwitchNodeProperties($node->ID());
                ?>
                <div style="display: block; padding-top: 10px">
                    <form action="editSwitchNode.php?ID=<?= $node->ID(); ?>" method="post">
                        <table>
                            <tr>
                                <td>nodeId</td>
                                <td><input name="nodeId" value="<?= $props->nodeId(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input name="name" value="<?= $props->name(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>On text</td>
                                <td><input name="on" value="<?= $props->btn_on(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>Off text</td>
                                <td><input name="off" value="<?= $props->btn_off(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>On log message</td>
                                <td><input name="logMessageOn" value="<?= $props->logMessageOn(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>Off log message</td>
                                <td><input name="logMessageOff" value="<?= $props->logMessageOff(); ?>"/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input style="float: right;" type="submit"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
                
                <?php
                break;
                
            case NodeTypes::IP_TRACKER:
                $props = new IpTrackerNodeProperties($node->ID());
                ?>
                <div style="display: block; padding-top: 10px">
                    <form action="editIpTrackerNode.php?ID=<?= $node->ID(); ?>" method="post">
                        <table>
                            <tr>
                                <td>server</td>
                                <td><input name="server" value="<?= $props->server(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><input name="name" value="<?= $props->name(); ?>"/></td>
                            </tr>
                            <tr>
                                <td>newIp</td>
                                <td>
                                    <input name="newIp"/>
                                </td>
                                <td>
                                    <select name="user">
                                    <?php
                                    foreach (Account::getAccounts() as $account) {
                                        echo '<option value="' . $account->ID() . '">' . $account->username() . '</option>';
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><input style="float: right;" type="submit"/></td>
                            </tr>
                        </table>
                    </form>
                    <table>
                        <tr>
                            <?php
                            foreach ($props->getUsers() as $data) {
                                $user = new Account($data['user']);
                                echo '<tr><td>' . $user->username() . '</td><td>' . $data['ip'] . '</td><td><a href="editIpTrackerNode.php?ID=' . $node->ID() . '&delete=' . $data['ip'] . '">delete</a></td></tr>';
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <?php
                break;

        }
        echo '</div>';


    }
    ?>
</div>