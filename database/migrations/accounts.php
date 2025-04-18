<?php
"DROP TABLE IF EXISTS `accounts`;";
"CREATE TABLE `accounts` (
    id int NOT NULL AUTO_INCREMENT,
    account_holder_name VARCHAR(100),
    address TEXT,
    business_address TEXT,
    contact_no VARCHAR(15),
    city_id int,
    header_id int,
    sub_header_id int,
    reg_by int,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE(contact_no),
    
    CONSTRAINT fk_city_id_accounts FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    CONSTRAINT fk_header_id_accounts FOREIGN KEY (header_id) REFERENCES headers(id) ON DELETE CASCADE,
    CONSTRAINT fk_sub_header_id_accounts FOREIGN KEY (sub_header_id) REFERENCES sub_headers(id) ON DELETE CASCADE,
    CONSTRAINT fk_reg_by_accounts FOREIGN KEY (reg_by) REFERENCES users(id) ON DELETE CASCADE
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
