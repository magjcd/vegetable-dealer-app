<?php

namespace database\migrations;

ini_set('display_error', 1);

use config\database;

class cities extends database
{
    public function __construct()
    {

        $this->conn->query(
            "CREATE TABLE `items` (
                id int NOT NULL AUTO_INCREMENT,
                item_name VARCHAR(100),
                
                PRIMARY KEY (id),
                UNIQUE(item_name)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;"
        );
    }
}
