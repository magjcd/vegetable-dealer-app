<?php
"DROP TABLE IF EXISTS `profiles`;";
"CREATE TABLE `profiles` (
    id int NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(100),
    address TEXT,
    contact_no VARCHAR(15),
    user_id int,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
