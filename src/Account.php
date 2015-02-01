<?php

include_once 'DataAccessLayer/Fireball.php';

class Account extends Fireball\ORM {

    const TABLE_NAME  = 'Account';
    const PRIMARY_KEY = 'ID';
    const USERNAME    = 'username';
    const HASH        = 'hash';
    const SALT        = 'salt';
    const TIME        = 'time';

    private static $fields = array (
        self::USERNAME,
        self::HASH,
        self::SALT,
        self::TIME
    );

//Override
protected function setUp(Fireball\TableDef $def) {
    $def->setName(self::TABLE_NAME);
    $def->addKey(self::PRIMARY_KEY);
    $def->setCols(self::$fields);
}

public static function createNew($username, $password) {
    if (strlen($username) <= 0 || strlen($password) <= 0) {
        throw new Exception("Invalid input");
    }

    if (self::accountExistsUsername($username)) {
        throw new Exception("Account already Exists");
    }

    $bytes = openssl_random_pseudo_bytes(16, $cstrong);
    $salt = md5(sha1($bytes));
    $hash = self::hashPassword($password, $salt);

    if (Fireball\ORM::newRecord(self::TABLE_NAME, self::$fields, array($username, $hash, $salt, time()))) {
        return new self($ID);
    } else {
        throw new Exception("account creation failed");
    }

}


public static function login($username, $password) {
    if (!self::accountExistsUsername($username)) {
        throw new Exception("Account Does Not Exist");
    }
    $account = self::fromUsername($username);
    $hash = self::hashPassword($password, $account->salt());

    if ($account->hash() == $hash) {
        return $account;
    } else if ($account->username() == $username) {
        return false;
    }
}

public static function accountExistsUsername($username) {
    return Fireball\ORM::rowExistsFrom(self::TABLE_NAME, self::USERNAME, $username);
}

protected function hashPassword($password, $salt) {
    return substr(crypt($password, '$6$rounds=5000$' . $salt . '$'), 15);
}

public static function fromUsername($username) {
    $result = Fireball\ORM::dbSelect(self::PRIMARY_KEY, self::TABLE_NAME, self::USERNAME, $username);
    return new Account($result);
}


}

?>
