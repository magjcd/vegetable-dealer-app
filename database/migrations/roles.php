<?php
"DROP TABLE IF EXISTS `roles`;";
"CREATE TABLE `roles` (
    id int NOT NULL AUTO_INCREMENT,
    role_name VARCHAR(100),

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id)
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";

"INSERT INTO `roles`(role_name) VALUES('owner');";
"INSERT INTO `roles`(role_name) VALUES('admin');";
"INSERT INTO `roles`(role_name) VALUES('munshi');";
"INSERT INTO `roles`(role_name) VALUES('accountant');";
