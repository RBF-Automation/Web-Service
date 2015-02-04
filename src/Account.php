<?php

include_once 'DataAccessLayer/Fireball.php';

class Account extends Fireball\ORM {

    const TABLE_NAME  = 'Account';
    const PRIMARY_KEY = 'ID';
    const USERNAME    = 'username';
    const HASH        = 'hash';
    const TIME        = 'time';
    const TOKEN       = 'authToken';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::USERNAME,
        self::HASH,
        self::TIME,
        self::TOKEN,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function createNew($username, $password) {
        if (strlen($username) <= 0 || strlen($password) <= 0) {
            throw new Exception("Invalid input");
        }

        if (self::accountExistsUsername($username)) {
            throw new Exception("Account already Exists");
        }

        $hash = self::hashPassword($password);

        $data = array (
            self::USERNAME => $username,
            self::HASH => $hash,
            self::TIME => time(),
            self::TOKEN => self::genToken(),
        );

        $ID = Fireball\ORM::newRecordAutoIncrement(self::TABLE_NAME, $data);

        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            throw new Exception("account creation failed");
        }

    }


    public static function login($username, $password, $resetToken = false) {
        if (!self::accountExistsUsername($username)) {
            throw new Exception("Account Does Not Exist");
        }
        $account = self::fromUsername($username);
        if ($resetToken) {
            resetToken($account);
        }

        if (self::checkPassword($password, $account->hash())) {
            return $account;
        } else if ($account->username() == $username) {
            return false;
        }
    }

    public static function resetToken($account) {
        $account->authToken(self::genToken());
    }

    private static function genToken() {
        return md5(openssl_random_pseudo_bytes(16));
    }

    public static function validateToken($token) {
        if (!self::accountExistsToken($token)) {
            throw new Exception("Token Not Found");
        }
        $account = self::fromToken($token);
        return $account;
    }

    public static function accountExistsUsername($username) {
        return Fireball\ORM::rowExistsFrom(self::TABLE_NAME, self::USERNAME, $username);
    }

    public static function accountExistsToken($token) {
        return Fireball\ORM::rowExistsFrom(self::TABLE_NAME, self::TOKEN, $token);
    }

    protected function hashPassword($password) {
        return crypt($password, '$6$rounds=5000$' . openssl_random_pseudo_bytes(16));
    }

    protected function checkPassword($password, $hash) {
        $hash1 = crypt($password, $hash);
        return $hash == crypt($password, $hash);
    }

    public static function fromUsername($username) {
        $result = Fireball\ORM::dbSelect(self::PRIMARY_KEY, self::TABLE_NAME, self::USERNAME, $username);
        return new Account($result);
    }

    public static function fromToken($token) {
        $result = Fireball\ORM::dbSelect(self::PRIMARY_KEY, self::TABLE_NAME, self::TOKEN, $token);
        return new Account($result);
    }

    public static function getAccounts() {
        $result = self::mapQuery(self::rawQuery('select * from ' . self::TABLE_NAME, null, true));
        return $result;
    }

    public static function deleteAccount($id) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }


}

?>
