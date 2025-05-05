<?php
"DROP TABLE IF EXISTS `pur_inv`;";
"CREATE TABLE `pur_inv` ( 
    id int NOT NULL AUTO_INCREMENT,
    purchase_date DATE NOT NULL,
    pur_inv_no int,
    vendor_id int NOT NULL, 
    -- random_no int NOT NULL,
    -- item_id int NOT NULL,
    builty_no VARCHAR(10) NOT NULL,
    vehicle_no VARCHAR(10) NOT NULL,
    commission int NULL,
    labour int NULL,
    tax int NULL,
    expences int NULL,
    reg_by int,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    
    -- CONSTRAINT fk_pur_inv_no_pur_inv FOREIGN KEY (pur_inv_no) REFERENCES pur_inv_no(id) ON DELETE CASCADE, 
    CONSTRAINT fk_vendor_id_pur_inv FOREIGN KEY (vendor_id) REFERENCES accounts(id) ON DELETE CASCADE,
    CONSTRAINT fk_reg_by_pur_inv FOREIGN KEY (reg_by) REFERENCES users(id) ON DELETE CASCADE

    
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";
