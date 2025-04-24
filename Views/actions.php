<?php
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once('../autoload.php');

use Controllers\AuthController;
use Controllers\AccountController;
use Controllers\ItemController;
use Controllers\PurchaseController;
use Controllers\SellController;

$auth_obj = new AuthController;
$obj_cutomer = new AccountController;
$obj_item = new ItemController;
$obj_purchase = new PurchaseController;
$obj_sell = new SellController;

// try {
if ($_POST['flag'] == 'login') {
    $payload = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    $auth_obj->login($payload);
} elseif ($_POST['flag'] == 'add_customer') {
    $payload = [
        'account_holder_name' => $_POST['account_holder_name'],
        'header_id' => $_POST['header_id'],
        'sub_header_id' => $_POST['sub_header_id'],
        'address' => $_POST['address'],
        'business_address' => $_POST['business_address'],
        'city_id' => $_POST['city_id'],
        'contact_no' => $_POST['contact_no']
    ];

    $obj_cutomer->addAccount($payload);
} elseif ($_POST['flag'] == 'add_item') {
    $payload = [
        'item_name' => $_POST['item_name']
    ];

    $obj_item->addItem($payload);
} elseif ($_POST['flag'] == 'add_purchase') {
    $payload = [
        'pur_inv_no' => $_POST['pur_inv_no'],
        'purchase_date' => $_POST['purchase_date'],
        'vendor' => $_POST['vendor'],
        'builty_no' => $_POST['builty_no'],
        'vehicle_no' => $_POST['vehicle_no'],
        'items' => $_POST['items'],
        'item_details' => $_POST['item_details'],
        'qty' => $_POST['qty'],
        'price' => $_POST['price']
    ];

    $obj_purchase->purchaseItem($payload);
} elseif ($_POST['flag'] == 'sell_stock') {
    $obj_sell->kachiItemEntry($_POST);
    // echo json_encode($_POST);
} elseif ($_POST['flag'] == 'save_pur_inv') {
    $obj_purchase->savePurchaseInvoce($_POST);
} elseif ($_POST['flag'] == 'save_sell_inv') {
    $obj_sell->saveKachiInvoce($_POST);
} elseif ($_POST['flag'] == 'delete_unsaved_sng_item') {
    $obj_sell->deleteUnsavedSngItem($_POST);
}


// } catch (\Throwable $th) {
//     return $th->getMessage();
// }
