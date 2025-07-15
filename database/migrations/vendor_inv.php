<?php
"DROP TABLE IF EXISTS `vendor_inv`;";
"CREATE TABLE `vendor_inv` (
    id int NOT NULL AUTO_INCREMENT,
    purchase_date DATE NOT NULL,
    pur_inv_no int,
    vendor_id int NOT NULL, 
    builty_no VARCHAR(10) NOT NULL,
    vehicle_no VARCHAR(10) NOT NULL,
    commission int NULL,
    labour int NULL,
    tax int NULL,
    packing int NULL,
    expences int NULL,
    invoiced ENUM('0','1') DEFAULT '0',
    reg_by int,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    
    -- CONSTRAINT fk_pur_inv_no_pur_inv FOREIGN KEY (pur_inv_no) REFERENCES pur_inv_no(id) ON DELETE CASCADE, 
    CONSTRAINT fk_vendor_id_pur_inv FOREIGN KEY (vendor_id) REFERENCES accounts(id) ON DELETE CASCADE,
    CONSTRAINT fk_reg_by_pur_inv FOREIGN KEY (reg_by) REFERENCES users(id) ON DELETE CASCADE
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
