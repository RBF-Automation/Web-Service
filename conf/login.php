<?php
include_once '../accountUtils.php';
include_once '../SQLConnect.php';
include_once '../src/Account.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    try {
        $account = Account::login($username, $password);

        if ($account != false) {
            session_start();
            $_SESSION['userid'] = $account->ID();
            $_SESSION['token'] = $account->authToken();
            header("Location: /conf");
            return;
        } else {
        }
    } catch (Exception $e) {
    }
    echo "Error logging in";
}

?>


<form action="login.php" method="post">
    username
    <input name="username"/><br/>
    password
    <input type="password" name="password"/><br/>
    <input type="submit"/>
</form>
