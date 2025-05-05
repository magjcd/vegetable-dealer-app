<?php
include_once('../autoload.php');

use Controllers\AuthController;
use Controllers\AccountController;
use Controllers\FinanacialController;
use Controllers\GeneralController;
use Controllers\ItemController;
use Controllers\PurchaseController;
use Controllers\RoleController;
use Controllers\SellController;
use Controllers\UserController;

$obj_user = new UserController;
$obj_auth = new AuthController;
$obj_general = new GeneralController;
$obj_account = new AccountController;
$obj_item = new ItemController;
$obj_sell = new SellController;
$obj_purchase = new PurchaseController;
$obj_financial = new FinanacialController;
$obj_role = new RoleController;
