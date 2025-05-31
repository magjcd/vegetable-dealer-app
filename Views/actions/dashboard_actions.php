<?php

include_once('../../autoload.php');

use Controllers\DashboardController;

$obj_dashboard = new DashboardController;

if ($_POST['flag'] == 'dashboard_daily_sell') {
    // echo '<pre>';
    // print_r($_POST);
    $obj_dashboard->dailySell($_POST);
} elseif ($_POST['flag'] == 'dashboard_monthly_sell') {
    $obj_dashboard->monthlySell($_POST);
} elseif ($_POST['flag'] == 'dashboard_daily_collection') {
    $obj_dashboard->dailyCollection($_POST);
} elseif ($_POST['flag'] == 'dashboard_monthly_collection') {
    $obj_dashboard->monthlyCollection($_POST);
} elseif ($_POST['flag'] == 'dashboard_day_bank_position') {
    $obj_dashboard->dayBankPostion($_POST);
} elseif ($_POST['flag'] == 'dashboard_monthly_bank_position') {
    $obj_dashboard->monthlyBankPosition($_POST);
}
