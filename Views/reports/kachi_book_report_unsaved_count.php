<?php

use Controllers\SellController;

include_once('../../autoload.php');
$obj_sell = new SellController;
// if (isset($_POST['trans_date'])) {
$list_kachi_sells_count = $obj_sell->listKachiSellUnInvoiced();
// echo count($list_kachi_sells_count);
