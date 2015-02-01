<?php
include_once 'SQLConnect.php';
include_once 'src/Account.php';

$account = Account::createNew('test', 'blah');

echo $account->username();


?>
