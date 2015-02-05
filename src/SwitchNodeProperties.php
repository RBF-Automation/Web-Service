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

        error_log($ID);

        if (Fireball\ORM::newRecord(self::TABLE_NAME, self::$fields, array($ID, 0, "SWITCH", "ON", "OFF", "turned on", "turned off"))) {
            return new self($ID);
        } else {
            throw new Exception("Node creation failed");
        }

    }

    public static function delete($id) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }


}

?>
