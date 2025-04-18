<?php
ini_set('display_error', 1);
// session_start();

include_once(realpath(__DIR__) . '/config/variables.php');
include_once(realpath(__DIR__) . '/config/database.php');
include_once(realpath(__DIR__) . '/Models/Model.php');

include_once(realpath(__DIR__) . '/Controllers/UserController.php');
include_once(realpath(__DIR__) . '/Controllers/AuthController.php');
include_once(realpath(__DIR__) . '/Controllers/GeneralController.php');
include_once(realpath(__DIR__) . '/Controllers/AccountController.php');
include_once(realpath(__DIR__) . '/Controllers/ItemController.php');
include_once(realpath(__DIR__) . '/Controllers/SellController.php');
include_once(realpath(__DIR__) . '/Controllers/PurchaseController.php');
include_once(realpath(__DIR__) . '/Controllers/FinanacialController.php');



spl_autoload_register(function ($class) {
    // include_once('Controllers/' . $class . '.php');
    include_once(realpath(__DIR__) . '/' . $class . '.php');
});
