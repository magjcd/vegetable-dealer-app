<?php

namespace config;

ini_set('display_error', 1);

trait variables
{

    protected $host = 'localhost';
    protected $db_user_name = 'root';
    protected $db_password = '';
    protected $db_name = 'oop_project';

    // protected $host = '118.139.178.102';
    // protected $db_user_name = 'mf';
    // protected $db_password = 'MF@2025Soft';
    // protected $db_name = 'mf';

    protected $conn_ok = null;
    protected $conn = null;
    protected $model;
    protected $sql;
    protected $key;
    protected $keys;
    protected $value;
    protected $values;
    protected $rows;
    protected $query;
    public $data;
    public $errors = [];
    public $error;
    public $user_array = null;
    public $user_id = null;
    public $user_account_id = null;
    protected $user_role = null;
}
