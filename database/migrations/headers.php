<?php
"DROP TABLE IF EXISTS `headers`;";

"CREATE TABLE `headers` (
    id int NOT NULL AUTO_INCREMENT,
    header_name VARCHAR(100),
    
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";

"INSERT INTO `headers`(header_name) VALUES('Assets');";
"INSERT INTO `headers`(header_name) VALUES('Liabilities');";
"INSERT INTO `headers`(header_name) VALUES("Owner's Equity");";
"INSERT INTO `headers`(header_name) VALUES('Revenue');";
"INSERT INTO `headers`(header_name) VALUES('Expences');";
