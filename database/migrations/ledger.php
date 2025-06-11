<?php

namespace database\migrations;

ini_set('display_error', 1);
include_once(realpath(__DIR__) . '/../../config/database.php');

use config\database;

class ledger extends database
{
    public function __construct()
    {
        echo $this->conn->query("DROP TABLE IF EXISTS `ledger`;");
        echo $this->conn->query("CREATE TABLE `ledger` ( 
                            id int NOT NULL AUTO_INCREMENT,
                            gj_date DATE NOT NULL,
                            inv_no int,

                            details TEXT,
                            customer_acc_id int NOT NULL,
                            city_id int NULL,
                            customer_header_id int NOT NULL,
                            customer_sub_header_id int NOT NULL,
                            dr int DEFAULT (0),
                            cr int DEFAULT (0),
                            doc_type ENUM('sell','sell_ret','purchase','purchase_ret','gj'),
                            uniq_id varchar(50),
                            reg_by int,
                            on_behalf_of int,
                            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            
                            PRIMARY KEY (id),
                            
                            -- CONSTRAINT fk_inv_no_ledger FOREIGN KEY (inv_no) REFERENCES sell_inv_no(id) ON DELETE CASCADE, 
                            CONSTRAINT fk_customer_acc_id_ledger FOREIGN KEY (customer_acc_id) REFERENCES accounts(id) ON DELETE CASCADE ON UPDATE CASCADE, 
                            CONSTRAINT fk_city_id_ledger FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT fk_customer_header_id_ledger FOREIGN KEY (customer_header_id) REFERENCES headers(id) ON DELETE CASCADE ON UPDATE CASCADE, 
                            CONSTRAINT fk_customer_sub_header_id_ledger FOREIGN KEY (customer_sub_header_id) REFERENCES sub_headers(id) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT fk_reg_by_ledger FOREIGN KEY (reg_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT fk_on_behalf_of_ledger FOREIGN KEY (on_behalf_of) REFERENCES users(id)

                        ) ENGINE=INNODB AUTo_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;");
    }
}
new ledger;

                            // ALTER TABLE `ledger` ADD COLUMN on_behalf_of int; ALTER TABLE `ledger` ADD CONSTRAINT FOREIGN KEY (on_behalf_of) REFERENCES users(id)

                            // ALTER TABLE `ledger` ADD COLUMN city_id int AFTER customer_acc_id;
                            // ALTER TABLE `ledger` ADD CONSTRAINT fk_city_id_ledger FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE ON UPDATE CASCADE;