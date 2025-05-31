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
foreach ($list_cities as $list_city) {
    echo '<div style="text-align: center;"><h3>' . $list_city->city_name . '</h3></div>';
    $list_collection_accounts = $obj_accounts->listAccountsByCitySubHeader($list_city->id, 1);
?>
    <table class="" id="" style="border: 1px solid #000; width:100%;height:auto;">
        <thead>
            <tr style="border: 1px solid #000; width:100%;height:auto;">
                <th style="border: 1px solid #000;text-align: center; width:100px;">بقیہ رقم</th>
                <th style="border: 1px solid #000;text-align: center; width:100px;">وصولی</th>
                <th style="border: 1px solid #000;text-align: center; width:100px;">مال</th>
                <th style="border: 1px solid #000;text-align: center; width:100px;">اگرائی</th>
                <th style="border: 1px solid #000;text-align: center; width:300px;">نام</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (!empty($list_collection_accounts)) {
                $customer_id = null;
                foreach ($list_collection_accounts as $list_collection_account) {
                    $customer_id = $list_collection_account->id;
                    $customer_balances = $obj_financial->listFullCollection($_POST, $customer_id);
                    // echo '<pre>';
                    // print_r($customer_balances);
                    if (!empty($customer_balances['dr']) || !empty($customer_balances['cr']) || !empty($customer_balances['prev_bal'])) {
            ?>
                        <?php
                        // foreach ($customer_balances as $customer_balance) {
                        ?>
                        <tr style="border: 1px solid #000; width:100%;height:auto;">
                            <td style="border: 1px solid #000; text-align: right;"><?php echo (($customer_balances['prev_bal'] + $customer_balances['cr']) - $customer_balances['dr']); ?></td>
                            <td style="border: 1px solid #000; text-align: right;"><?php echo $customer_balances['dr']; ?></td>
                            <td style="border: 1px solid #000; text-align: right;"><?php echo $customer_balances['cr']; ?></td>
                            <td style="border: 1px solid #000; text-align: right;"><?php echo $customer_balances['prev_bal']; ?></td>
                            <td style="border: 1px solid #000; text-align: right;"><?php echo $customer_balances['account_holder_name']; ?></td>
                        </tr>
                    <?php // }
                    }
                    ?>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

<?php
}
?>