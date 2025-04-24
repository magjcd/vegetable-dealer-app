<?php

include_once('../../autoload.php');
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Controllers\UserController;

$obj_user = new UserController;

if ($_POST['flag'] == 'add_user') {
    $obj_user->addUser($_POST);
}
