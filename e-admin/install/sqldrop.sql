USE `oleville`;

CREATE TABLE `options` (
`optionname` VARCHAR( 80 ) NOT NULL ,
`value` VARCHAR( 160 ) NULL ,
PRIMARY KEY ( `optionname` )
) ENGINE = innodb;

INSERT INTO `oleville`.`options` (
`optionname` ,
`value`
)
VALUES (
'username', 'admin'
), (
'userpword', 'password'
), (
'starttime', '0'
), (
'endtime', '0'
), (
'electitle', 'An Election'
), (
'elecdesc', 'A Description of the Election'
), (
'nocon', 'yes'
), (
'canorder', 'lastname'
), (
'presentation', 'firstnamefirst'
), (
'affliation', 'yes'
), (
'blurbs', 'yes'
), (
'useroll', 'no'
), (
'allowspecial', 'yes'
);

CREATE TABLE `positions` (
`position` VARCHAR( 80 ) NOT NULL ,
`rank` INT NOT NULL ,
PRIMARY KEY ( `rank` )
) ENGINE = innodb;

CREATE TABLE `candidates` (
`rowid` INT NOT NULL AUTO_INCREMENT, 
`lastname` VARCHAR( 80 ) NOT NULL ,
`firstname` VARCHAR( 80 ) NOT NULL ,
`position` VARCHAR( 80 ) NOT NULL ,
`affliation` VARCHAR( 80 ) NOT NULL,
`blurb` TEXT NULL ,
PRIMARY KEY ( `rowid` )
) ENGINE = innodb;

INSERT INTO `oleville`.`candidates` (
`rowid` ,
`lastname` ,
`firstname` ,
`position` ,
`blurb`
)
VALUES (
NULL , 'No Confidence', '', 'No Confidence', ''
);

CREATE TABLE `voters` (
`id` VARCHAR( 80 ) NOT NULL ,
`lastname` VARCHAR( 80 ) NOT NULL ,
`firstname` VARCHAR( 80 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb;

CREATE TABLE `votes` (
`id` VARCHAR( 80 ) NOT NULL ,
`can` VARCHAR( 80 ) NOT NULL ,
`pos` VARCHAR( 80 ) NOT NULL
) ENGINE = innodb;

CREATE TABLE `specialvoters` (
`id` VARCHAR( 80 ) NOT NULL ,
`lastname` VARCHAR( 80 ) NOT NULL ,
`firstname` VARCHAR( 80 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb;

CREATE TABLE `specialvotes` (
`id` VARCHAR( 80 ) NOT NULL ,
`can` VARCHAR( 80 ) NOT NULL ,
`pos` VARCHAR( 80 ) NOT NULL
) ENGINE = innodb;