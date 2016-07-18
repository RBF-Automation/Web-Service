<?php

include_once 'DataAccessLayer/Fireball.php';
include_once 'IpMap.php';

class IpTrackerNodeProperties extends Fireball\ORM {

    const TABLE_NAME      = 'IpTrackerNodeProperties';
    const PRIMARY_KEY     = 'ID';
    const SERVER          = 'server';
    const NAME            = 'name';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::SERVER,
        self::NAME,
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
            self::SERVER => "",
            self::NAME => "",
        );
        
        $ID = Fireball\ORM::newRecord(self::TABLE_NAME, $data);
        
        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            throw new Exception("ip tracker node props creation failed");
        }
    }

    public static function delete($id) {
        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }
    
    public function getUsers() {
        $data = self::webRequest($this->server() . '/api/getUsers.php', array());
        error_log($data);
        $parsed = json_decode($data, true);
        
        for ($i = 0; $i < sizeof($parsed); $i++) {
            $map = IpMap::fromIp($parsed[$i]['ip']);
            $parsed[$i]['user'] = $map->user();
        }
        
        return $parsed;
    }
    
    public function newUser($ip, $user) {
        IpMap::createNew($ip, $user);
        self::webRequest($this->server() . '/api/newUser.php?ip=' . $ip, array());
    }
    
    public function deleteClientIp($ip) {
        IpMap::delete($ip);
        self::webRequest($this->server() . '/api/removeUser.php?ip=' . $ip, array());
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
