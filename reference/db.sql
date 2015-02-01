create table Account (
    ID bigint unsigned NOT NULL AUTO_INCREMENT,
    username varchar(256) NOT NULL,
    hash varchar(104) NOT NULL,
    salt varchar(32) NOT NULL,
    time int unsigned NOT NULL,
    authToken char(32) NOT NULL,

    PRIMARY KEY (ID)
);

create table Node (
    ID bigint unsigned NOT NULL AUTO_INCREMENT,
    nodeId bigint unsigned NOT NULL,
    type int unsigned NOT NULL,
    time int unsigned NOT NULL,

    PRIMARY KEY (ID)
);

create table SwitchNodeProperties (
    ID bigint unsigned NOT NULL,
    name varchar(100) NOT NULL,
    btn_on varchar(100) NOT NULL,
    btn_off varchar(100) NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (ID) REFERENCES Node(ID)
);


INSERT INTO Account VALUES (
    0,
    'admin',
    '70c40d7a05d4e677$IjAu0nY3YzMh0lXBl4/QdqvipYOHhhEfcvOTkOnuEmBbUwM84YtwwEUMY3M7EGMiUm37/SGZhF1Pi891PfzrD/',
    '70c40d7a05d4e677ac78709f54f76ba0',
    UNIX_TIMESTAMP(),
    '0'
);
