<?php
include_once 'SQLConnect.php';
include_once 'src/Account.php';
include_once 'src/Node.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: /login.php');
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
    <input name="password"/><br/>
    <input type="submit"/>
</form>

<h3> Manage Accounts </h3>
<?php
foreach (Account::getAccounts() as $account) {
    echo "username: <span style='font-weight: bold;'>" . $account->username() . "</span>";
    echo "<br/>Account created on: <span style='font-weight: bold;'>" . date('j/n/Y h:i:s A', $account->time()) . "</span><br/>";
    echo '<a href="deleteAccount.php?id=' . $account->ID() . '"> delete Account</a><br/><br/>';
}
?>

<br/>
<h2> Nodes </h2>
<hr/>
<h3> Create Node </h3>
<form action="createNode.php" method="post">
NodeId
<input name="nodeId"/><br/>
<input type="submit"/>
</form>

<h3> Manage Nodes </h3>
<?php
foreach (Node::getNodes() as $node) {
    echo "nodeId: <span style='font-weight: bold;'>" . $node->nodeId() . "</span>";
    echo "<br/>Node created on: <span style='font-weight: bold;'>" . date('j/n/Y h:i:s A', $node->time()) . "</span><br/>";
    echo '<a href="deleteNode.php?id=' . $node->ID() . '"> delete Node</a><br/><br/>';
}
?>
