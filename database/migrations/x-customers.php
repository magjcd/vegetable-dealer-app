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
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON DELETE CASCADE ,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CASCADE  ON DELETE CASCADE ,

    PRIMARY KEY (id),
    UNIQUE(contact_no),
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (added_by) REFERENCES users(id),
    FOREIGN KEY (account_type_id) REFERENCES account_types(id),
    FOREIGN KEY (header_id) REFERENCES headers(id),
    FOREIGN KEY (sub_header_id) REFERENCES sub_headers(id)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
