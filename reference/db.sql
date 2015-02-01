create table Account (
    ID bigint unsigned NOT NULL AUTO_INCREMENT,
    username varchar(256) NOT NULL,
    hash varchar(104) NOT NULL,
    salt varchar(32) NOT NULL,
    time int unsigned NOT NULL,

    PRIMARY KEY (ID)
);
