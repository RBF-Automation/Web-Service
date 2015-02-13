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
Welcome!
<a href="logout.php">Logout</a>
<br/>

<h2> Accounts </h2>
<hr/>
<h3> Create Account </h3>
<form action="createAccount.php" method="post">
    username
    <input name="username"/><br/>
    password
    <input type="password" name="password"/><br/>
    <input type="submit"/>
</form>

<h3> Manage Accounts </h3>
<?php
foreach (Account::getAccounts() as $account) {
    echo "username: <span style='font-weight: bold;'>" . $account->username() . "</span>";
    echo "<br/>Account created on: <span style='font-weight: bold;'>" . date('j/n/Y h:i:s A', $account->time()) . "</span><br/>";
    echo '<a href="deleteAccount.php?id=' . $account->ID() . '"> delete Account</a><br/><br/>';
    echo '<a href="deauth.php?id=' . $account->ID() . '"> reset token</a> Current token: ' . $account->authToken() . '<br/><br/>';
}
?>

<br/>
<h2> Nodes </h2>
<hr/>
<h3> Create Node </h3>
<form action="createNode.php" method="post">
type
<input name="nodeType"/><br/>
<input type="submit"/>
</form>

<h3> Manage Nodes </h3>
<?php
foreach (Node::getNodes() as $node) {
    $type = $node->type();
    echo "<br/>nodeType: <span style='font-weight: bold;'>" . NodeTypes::$map[$type] . "</span>";
    echo "<br/>Node created on: <span style='font-weight: bold;'>" . date('j/n/Y h:i:s A', $node->time()) . "</span><br/>";
    echo '<a href="deleteNode.php?id=' . $node->ID() . '"> delete Node</a><br/>';

    switch ($node->type()) {
        case NodeTypes::SWITCH_NODE:
            $props = new SwitchNodeProperties($node->ID());
            echo '<div style="margin-left: 40px; display: block;">';
            echo '<form action="editSwitchNode.php?ID=' . $node->ID() . '" method="post">';
            echo 'nodeId<input name="nodeId" value="' . $props->nodeId() . '"/><br/>';
            echo 'Name<input name="name" value="' . $props->name() . '"/><br/>';
            echo 'On text<input name="on" value="' . $props->btn_on() . '"/><br/>';
            echo 'Off text<input name="off" value="' . $props->btn_off() . '"/><br/>';
            echo 'On log message<input name="logMessageOn" value="' . $props->logMessageOn() . '"/><br/>';
            echo 'Off log message<input name="logMessageOff" value="' . $props->logMessageOff() . '"/><br/>';
            echo '<input type="submit"/>';
            echo '</form>';
            echo '</div>';

            break;
            
        case NodeTypes::IP_TRACKER:
            $props = new IpTrackerNodeProperties($node->ID());
            echo '<div style="margin-left: 40px; display: block;">';
            echo '<form action="editIpTrackerNode.php?ID=' . $node->ID() . '" method="post">';
            echo 'server<input name="server" value="' . $props->server() . '"/><br/>';
            var_dump($props->getIps());
            echo '<input type="submit"/>';
            echo '</form>';
            echo '</div>';
            
            break;

    }


}
?>
