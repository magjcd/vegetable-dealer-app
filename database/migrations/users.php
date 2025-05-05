<?php
$chek_if_tale_exists = "SELECT * FROM information_schema.tables WHERE table_schema = 'oop_project' AND table_name = 'users' LIMIT 1";

"DROP TABLE IF EXISTS `users`";
"CREATE TABLE `users` (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    role enum('munshi','accountant','admin','owner'),
    account_id int NULL,
    active enum('0','1') DEFAULT('1'),
    reg_by int,
    
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    CONSTRAINT fk_reg_by_users FOREIGN KEY (reg_by) REFERENCES accounts(id) ON DELETE CASCADE,
    CONSTRAINT fk_account_id_users FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE
    
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";

"INSERT INTO `users`(name,email,password,role,active) VALUES('Ali','admin@mf.com','9cc3e5abdfaee198a6b74b97ea91e306e1744ddf49876d3dcf6cb936dfd5c9d7','admin','1');";
