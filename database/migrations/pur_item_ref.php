<?php
"DROP TABLE IF EXISTS `pur_item_ref`;";
"CREATE TABLE `pur_item_ref` ( 
    id int NOT NULL AUTO_INCREMENT,
    purchase_date DATE NOT NULL,
    pur_inv_no int,
    vendor_id int NOT NULL, 
    vendor_nm int NOT NULL, 
    vendor_city int NOT NULL, 
    random_no int NOT NULL,
    item_id int NOT NULL,
    reg_by int

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    
    -- CONSTRAINT fk_pur_inv_no_pur_item_ref FOREIGN KEY (pur_inv_no) REFERENCES pur_inv_no(id) ON DELETE CASCADE, 
    CONSTRAINT fk_vendor_id_pur_item_ref FOREIGN KEY (vendor_id) REFERENCES accounts(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_id_pur_item_ref FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
    CONSTRAINT fk_reg_by_item_ref FOREIGN KEY (reg_by) REFERENCES accounts(id) ON DELETE CASCADE
    
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";
