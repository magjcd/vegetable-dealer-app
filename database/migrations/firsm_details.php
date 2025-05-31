<?php
"DROP TABLE IF EXISTS `firsm_details`;";
"CREATE TABLE `firsm_details` (
    id int NOT NULL AUTO_INCREMENT,
    firm_name VARCHAR(100) NOT NULL,
    business_type varchar(100) NULL,
    address TEXT NULL,
    contact_no VARCHAR(15) NULL
    
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
