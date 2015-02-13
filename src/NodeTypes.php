<?php

class NodeTypes {

    const SWITCH_NODE = 0;
    const ACTIVITY_LOG = 1;
    const IP_TRACKER = 2;

    static $map = array(
        self::SWITCH_NODE => "Switch",
        self::ACTIVITY_LOG => "Activity log",
        self::IP_TRACKER => "IP Tracker",
    );


}

?>
