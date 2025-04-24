<?php
"DROP TABLE IF EXISTS `purinvretstk`;";
"CREATE TABLE `purinvretstk` ( 
    
    id int NOT NULL AUTO_INCREMENT,
    trans_date DATE NOT NULL,
    inv_no int,
    customer_acc_id int NOT NULL,
    customer_city_id int NOT NULL,
    header_id int NOT NULL, 
    sub_header_id int NOT NULL,
    random_no int,
    builty_no VARCHAR(10),
    vehicle_no VARCHAR(10),
    item_id int NOT NULL, 
    item_details TEXT,
    pur_qty int,
    pur_ret_qty int,
    sl_qty int,
    sl_ret_qty int,
    price int, 
    doc_type ENUM('sell','sell_ret','purchase','purchase_ret'),
    reg_by int,
    invoiced ENUM('0','1') DEFAULT '0',

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    
    CONSTRAINT fk_customer_acc_id_purinvretstk FOREIGN KEY (customer_acc_id) REFERENCES accounts(id) ON DELETE CASCADE, 
    CONSTRAINT fk_item_id_purinvretstk FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
    CONSTRAINT fk_customer_city_id_purinvretstk FOREIGN KEY (customer_city_id) REFERENCES cities(id) ON DELETE CASCADE,
    CONSTRAINT fk_header_id_purinvretstk FOREIGN KEY (header_id) REFERENCES headers(id) ON DELETE CASCADE,
    CONSTRAINT fk_sub_header_id_purinvretstk FOREIGN KEY (sub_header_id) REFERENCES sub_headers(id) ON DELETE CASCADE,
    CONSTRAINT fk_reg_by_purinvretstk FOREIGN KEY (reg_by) REFERENCES accounts(id) ON DELETE CASCADE

) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";
