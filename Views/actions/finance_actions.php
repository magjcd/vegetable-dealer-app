<?php

include_once('../../autoload.php');
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Controllers\FinanacialController;

$obj_finanace = new FinanacialController;

if ($_POST['flag'] == 'add_gj_entry') {
    $obj_finanace->addGjEntry($_POST);
} elseif ($_POST['flag'] == 'gj_account_balance') {
    $obj_finanace->gjAccountBalance($_POST);
} elseif ($_POST['flag'] == 'collection_balance') {
    $obj_finanace->munshiCollectionBalance();
} elseif ($_POST['flag'] == 'delete_collection_record') {
    $obj_finanace->deleteCollectionRecord($_POST);
}
