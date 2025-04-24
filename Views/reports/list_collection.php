<?php

use Controllers\AccountController;
use Controllers\FinanacialController;
use Controllers\GeneralController;

include_once('../../autoload.php');
$obj_financial = new FinanacialController;
$obj_general = new GeneralController;
$obj_accounts = new AccountController;

// echo '<pre>';
// print_r($list_collection_accounts[0]);
$list_cities = $obj_general->listAllCities();

foreach ($list_cities as $list_city) {
    echo '<div style="text-align: center;"><h3>' . $list_city->city_name . '</h3></div>';
    $list_collection_accounts = $obj_accounts->listAccountsByCitySubHeader($list_city->id, 1);
    // foreach ($list_collection_accounts as $list_collection_account) {
?>
    <table class="" id="">
        <thead>
            <tr>
                <th style="text-align: right;">اگرائی</th>
                <th style="text-align: right;">مال</th>
                <th style="text-align: right;">وصولی</th>
                <th style="text-align: right;">نام</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (!empty($list_collection_accounts)) {
                foreach ($list_collection_accounts as $list_collection_account) {
                    $customer_id = $list_collection_account->id;
                    $customer_balances = $obj_financial->listFullCollection($_POST, $customer_id);
                    // echo '<pre>';
                    // print_r($customer_balances);
            ?>
                    <tr>
                        <?php
                        foreach ($customer_balances as $customer_balance) {
                            // $customer_balance;
                        ?>
                            <td style="text-align: left;"><?php echo $customer_balance->tot_bal; ?></td>
                            <td style="text-align: left;"><?php echo $customer_balance->dr; ?></td>
                            <td style="text-align: left;"><?php echo $customer_balance->cr; ?></td>
                        <?php } ?>
                        <td style="text-align: right;"><?php echo $list_collection_account->account_holder_name; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

<?php
    // }
}
?>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    })
</script>