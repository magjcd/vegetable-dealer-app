<?php

include_once('../../autoload.php');
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Controllers\FinanacialController;

$obj_finanace = new FinanacialController;

if ($_POST['flag'] == 'add_gj_entry') {
    $obj_finanace->addGjEntry($_POST);
}
