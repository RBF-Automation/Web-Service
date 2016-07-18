<?php

include_once 'DataAccessLayer/Fireball.php';

class IpMap extends Fireball\ORM {
    
    const TABLE_NAME  = 'IpMap';
    const PRIMARY_KEY = 'ID';
    const USER        = 'user';
    const IP          = 'ip';
    
    private static $fields = array (
        self::PRIMARY_KEY,
        self::USER,
        self::IP,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function createNew($ip, $user) {
        $data = array (
            self::USER => $user,
            self::IP   => $ip,
        );

    $ID = Fireball\ORM::newRecord(self::TABLE_NAME, $data);

    return self::fromId($ID);

    }

    private static function fromId($ID) {
        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            //throw new Exception("mapping not found");
            // Silently fail - IP exists remotely but not locally. Something was deleted improperly. 
            // Nothing to see here
        }
    }
    
    public static function delete($ip) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where ip = :IP', array('IP' => $ip), true);
    }

    public static function deleteByUser($ip) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where user = :IP', array('IP' => $ip), true);
    }

    public static function fromIp($ip) {
        $result = Fireball\ORM::dbSelect(self::PRIMARY_KEY, self::TABLE_NAME, self::IP, $ip);
        return self::fromId($result);
    }


}

?>
