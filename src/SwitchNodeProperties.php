<?php

include_once 'DataAccessLayer/Fireball.php';

class SwitchNodeProperties extends Fireball\ORM {

    const TABLE_NAME      = 'SwitchNodeProperties';
    const PRIMARY_KEY     = 'ID';
    const NODE_ID         = 'nodeId';
    const NAME            = 'name';
    const ON              = 'btn_on';
    const OFF             = 'btn_off';
    const LOG_MESSAGE_ON  = 'logMessageOn';
    const LOG_MESSAGE_OFF = 'logMessageOff';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::NODE_ID,
        self::NAME,
        self::ON,
        self::OFF,
        self::LOG_MESSAGE_ON,
        self::LOG_MESSAGE_OFF,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function createNew($ID) {
        
        $data =  array (
            self::PRIMARY_KEY => $ID,
            self::NODE_ID => 0,
            self::NAME => "SWITCH",
            self::ON => "ON",
            self::OFF => "OFF",
            self::LOG_MESSAGE_ON => "turned on",
            self::LOG_MESSAGE_OFF => "turned off",
        );
        
        $ID = Fireball\ORM::newRecord(self::TABLE_NAME, $data);
        
        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            throw new Exception("switch node props creation failed");
        }

    }

    public static function delete($id) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }


}

?>
