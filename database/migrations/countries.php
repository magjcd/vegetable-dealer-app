<?php

namespace database\migrations;

ini_set('display_error', 1);

use config\database;

class cities extends database
{
    public function __construct()
    {
        echo 'migrations.';

        $this->conn->query(
            "CREATE TABLE `countries` (
                id int NOT NULL AUTO_INCREMENT,
                country_name VARCHAR(100),
                
                PRIMARY KEY (id),
                UNIQUE(country_name)

            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;"
        );
    }
}
