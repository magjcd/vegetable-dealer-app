<?php
"DROP TABLE IF EXISTS `sell_inv`;";
"CREATE TABLE `sell_inv` (
    id int NOT NULL AUTO_INCREMENT,
    sl_date DATE NOT NULL,
    sell_inv_no int,

    vendor_id int,
    item_id int,
    random_no int,
    builty_no VARCHAR(10),
    sl_qty int,
    price int,
    current_sl_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    
    PRIMARY KEY (id),
    
    CONSTRAINT fk_sell_inv_no_sell_inv FOREIGN KEY (sell_inv_no) REFERENCES sell_inv_no(id) ON DELETE CASCADE, 
    CONSTRAINT fk_vendor_id_sell_inv FOREIGN KEY (vendor_id) REFERENCES accounts(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_id_sell_inv FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
    
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";
