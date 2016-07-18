<?php

include_once 'DataAccessLayer/Fireball.php';

class mFiOutletProperties extends Fireball\ORM {

    const TABLE_NAME      = 'mFiOutlet';
    const PRIMARY_KEY     = 'ID';
    const address         = 'address';
    const username        = 'username';
    const password        = 'password';
    const relay           = 'relay';
    const NAME            = 'name';
    const ON              = 'btn_on';
    const OFF             = 'btn_off';
    const LOG_MESSAGE_ON  = 'logMessageOn';
    const LOG_MESSAGE_OFF = 'logMessageOff';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::address,
        self::username,
        self::password,
        self::relay,
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
            self::address => "http://<address>/",
            self::username => "",
            self::password => "",
            self::relay => 1,
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

    public function msg($state) {
        $escapedState = 0;
        if ($state == 1) {
            $escapedState = 1;
        }
        $connection = ssh2_connect($this->address(), 22);
        ssh2_auth_password($connection, $this->username(), $this->password());
        error_log('echo ' . $escapedState . ' > /proc/power/relay/' . $this->relay());
        $stream = ssh2_exec($connection, 'echo ' . $escapedState . ' > /proc/power/relay' . $this->relay());
        stream_set_blocking($stream, true); 
        fclose($stream);
    }


}

?>
