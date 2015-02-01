<?php

include_once 'DataAccessLayer/Fireball.php';
include_once 'SwitchNodeProperties.php';
include_once 'NodeTypes.php';

class Node extends Fireball\ORM {

    const TABLE_NAME  = 'Node';
    const PRIMARY_KEY = 'ID';
    const NODE_ID    = 'nodeId';
    const NODE_TYPE    = 'type';
    const TIME        = 'time';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::NODE_ID,
        self::NODE_TYPE,
        self::TIME,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }

    public static function createNew($nodeId, $type) {
        if (strlen($nodeId) <= 0 && strlen($type) <= 0) {
            throw new Exception("Invalid input");
        }

        $data = array (
            self::NODE_ID => $nodeId,
            self::NODE_TYPE => $type,
            self::TIME => time(),
        );

        $ID = Fireball\ORM::newRecordAutoIncrement(self::TABLE_NAME, $data);

        if (is_numeric($ID)) {

            switch ($type) {
                case NodeTypes::SWITCH_NODE:
                    SwitchNodeProperties::createNew($ID);
                    break;
            }

            return new self($ID);
        } else {
            throw new Exception("Node creation failed");
        }

    }

    public static function getNodes() {
        $result = self::mapQuery(self::rawQuery('select * from ' . self::TABLE_NAME, null, true));
        return $result;
    }

    public static function deleteNode($id) {
        $node = new self($id);
        $type = $node->type();

        switch ($type) {
            case NodeTypes::SWITCH_NODE:
            SwitchNodeProperties::delete($id);
            break;
        }

        self::rawQuery('delete from ' . self::TABLE_NAME . ' where id = :ID', array(self::PRIMARY_KEY => $id), true);
    }


}

?>
