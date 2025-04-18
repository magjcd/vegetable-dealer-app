<?php
"DROP TABLE IF EXISTS `sell_inv_no`;";
"CREATE TABLE `sell_inv_no` (
    id int NOT NULL AUTO_INCREMENT,
    trans_date DATE NOT NULL,
    customer_id int NOT NULL,
    reg_by int,
    
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    CONSTRAINT fk_reg_by_sell_inv_no FOREIGN KEY (reg_by) REFERENCES users(id),
    CONSTRAINT fk_customer_id_sell_inv_no FOREIGN KEY (customer_id) REFERENCES accounts(id)
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
