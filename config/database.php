<?php

namespace config;

ini_set('display_error', 1);

use config\variables;

class database
{

    use variables;
    public function __construct()
    {
        if (!$this->conn_ok) {
            $this->conn = new \mysqli($this->host, $this->db_user_name, $this->db_password, $this->db_name);
            if ($this->conn->connect_error) {
                return false;
            } else {
                $this->conn->query("SET NAMES 'utf8'");
                return true;
            }
        }
    }
}
