<?php

include_once 'DataAccessLayer/Fireball.php';

class IpTrackerNodeProperties extends Fireball\ORM {

    const TABLE_NAME      = 'IpTrackerNodeProperties';
    const PRIMARY_KEY     = 'ID';
    const SERVER          = 'server';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::SERVER,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function createNew($ID) {

        if (Fireball\ORM::newRecord(self::TABLE_NAME, self::$fields, array($ID, ''))) {
            return new self($ID);
        } else {
            throw new Exception("Node creation failed");
        }

    }

    public static function delete($id) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }
    
    public function getIps() {
        $data = self::webRequest($this->server() . '/api/getUsers.php', array());
        $parsed = json_decode($data);
        return $parsed;
    }
    
    public function newUser($ip) {
        self::webRequest($this->server() . '/api/newUser.php?ip=' . $ip, array());
    }
    
    private static function webRequest($url, $args) {
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($args),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }


}

?>
