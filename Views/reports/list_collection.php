<?php

use Controllers\AccountController;
use Controllers\FinanacialController;
use Controllers\GeneralController;

include_once('../../autoload.php');
$obj_financial = new FinanacialController;
$obj_general = new GeneralController;
$obj_accounts = new AccountController;

$list_cities = $obj_general->listAllCities();
echo '<div style="text-align: center;"><h3>' . $_POST['collection_date'] . '</h3></div>';
$total_collection = $obj_financial->totalCollection($_POST);
echo '<div style="text-align: center;"><h5> ٹوٹل بقیہ رقم: ' . $total_collection . '</h5></div>';
foreach ($list_cities as $list_city) {
    $list_collection_accounts = $obj_accounts->listAccountsByCitySubHeader($list_city->id, 1);
    $city_wise_collection = $obj_financial->cityWiseRemainingCollectionTotal($_POST, $list_city->id);
    $prev_city_wise_total = $obj_financial->cityWisePreviousCollectionTotal($payload, $list_city->id);
    $prev_city_wise_dr_total = $obj_financial->cityWiseDrCollectionTotal($payload, $list_city->id);
    $prev_city_wise_cr_total = $obj_financial->cityWiseCrCollectionTotal($payload, $list_city->id);
?>
    <table class="" id="" style="border: 1px dotted #000; width:100%;height:auto;">
        <thead>
            <tr>
                <th colspan="5" style="text-align: center; background-color: #066666; color: #fff;">
                    <h3><?php echo $list_city->city_name; ?></h3>
                </th>
            </tr>
            <tr style="border: 1px dotted #000; width:100%;height:auto; color: #fff; background-color:#000;">
                <th style="border: 1px dotted #000;text-align: center; width:100px;">بقیہ رقم</th>
                <th style="border: 1px dotted #000;text-align: center; width:100px;">وصولی</th>
                <th style="border: 1px dotted #000;text-align: center; width:100px;">مال</th>
                <th style="border: 1px dotted #000;text-align: center; width:100px;">اگرائی</th>
                <th style="border: 1px dotted #000;text-align: center; width:300px;">نام</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (!empty($list_collection_accounts)) {
                $customer_id = null;
                foreach ($list_collection_accounts as $list_collection_account) {
                    $customer_id = $list_collection_account->id;
                    $customer_balances = $obj_financial->listFullCollection($_POST, $customer_id);
                    if (!empty($customer_balances['dr']) || !empty($customer_balances['cr']) || !empty($customer_balances['prev_bal'])) {
            ?>
                        <tr style="border: 1px dotted #000; width:100%;height:auto;">
                            <td style="border: 1px dotted #000; text-align: right;"><?php echo (($customer_balances['prev_bal'] + $customer_balances['cr']) - $customer_balances['dr']); ?></td>
                            <td style="border: 1px dotted #000; text-align: right;"><?php echo $customer_balances['dr']; ?></td>
                            <td style="border: 1px dotted #000; text-align: right;"><?php echo $customer_balances['cr']; ?></td>
                            <td style="border: 1px dotted #000; text-align: right;"><?php echo $customer_balances['prev_bal']; ?></td>
                            <td style="border: 1px dotted #000; text-align: right;"><a href="index?route=account_details&cid=<?php echo $customer_id; ?>" style="color: #000;"><?php echo $customer_balances['account_holder_name']; ?></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            <?php
            }
            ?>
            <tr>
                <th style="text-align: right; color: #fff; background-color:#000;"><?php echo $city_wise_collection; ?></th>
                <th style="text-align: right; color: #fff; background-color:#000;"><?php echo $prev_city_wise_dr_total ?></th>
                <th style="text-align: right; color: #fff; background-color:#000;"><?php echo $prev_city_wise_cr_total ?></th>
                <th style="text-align: right; color: #fff; background-color:#000;"><?php echo $prev_city_wise_total; ?></th>

                <th style="text-align: center; color: #fff; background-color:#000;"> بقیہ رقم ٹوٹل</th>
            </tr>
        </tbody>
    </table>

<?php
}
?>