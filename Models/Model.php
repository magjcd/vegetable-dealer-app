<?php

namespace Models;

ini_set('display_error', 1);

use config\database;

class Model extends database
{

    protected function fetchAll($tbl)
    {
        $this->sql = "SELECT * FROM $tbl";
        return $this->conn->query($this->sql);
    }

    protected function fetchSingle($tbl, $where)
    {
        $this->sql = "SELECT * FROM $tbl WHERE $where";
        return $this->conn->query($this->sql);
    }

    protected function insert($tbl, $fields)
    {
        $this->keys = implode(', ', array_keys($fields));
        $this->values =  implode("', '", array_values($fields));
        $this->sql = "INSERT INTO `$tbl`($this->keys) VALUES('$this->values')";
        return $this->conn->query($this->sql);
    }

    protected function update($table, $varArr = array(), $where)
    {
        foreach ($varArr as $this->key => $this->value) {
            $args[] = "$this->key='$this->value'";
        }
        $this->sql = ("UPDATE `$table` SET " . implode(",", $args) . " WHERE $where");
        return $this->conn->query($this->sql);
    }

    protected function delete($table, $where)
    {
        $this->sql = "DELETE FROM $table WHERE $where";
        return $this->conn->query($this->sql);
    }


    protected function rawCmd($cmd)
    {
        $this->sql = $this->conn->query($cmd);
        return $this->sql;
    }
}
