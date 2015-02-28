<?php

include_once 'DataAccessLayer/Fireball.php';
include_once 'SwitchNodeProperties.php';
include_once 'NodeTypes.php';

class ActivityLog extends Fireball\ORM {

    const TABLE_NAME  = 'ActivityLog';
    const PRIMARY_KEY = 'ID';
    const USER        = 'user';
    const MESSAGE     = 'message';
    const TIME        = 'time';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::USER,
        self::MESSAGE,
        self::TIME,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function log($username, $message) {
        if (strlen($message) < 0 && strlen($username) < 0) {
            throw new Exception("Invalid input");
        }

        $data = array (
            self::USER    => $username,
            self::MESSAGE => $message,
            self::TIME => time(),
        );

        $ID = Fireball\ORM::newRecord(self::TABLE_NAME, $data);

        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            throw new Exception("Log entry failed");
        }

    }

    public static function getLog($lim) {
        $result = self::mapQuery(self::rawQuery('select * from ' . self::TABLE_NAME . ' ORDER BY time DESC limit :lim', array(":lim" => $lim), true));
        return $result;
    }

}

?>
