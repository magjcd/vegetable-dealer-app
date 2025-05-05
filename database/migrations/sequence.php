1 - accounts -> Sales / Supplier must be added automatically when table is created
2 - pur_inv_no
3 - pur_inv -> but without vendor foreign key -> need to check,
4 - purinvretstk
4 - sell_inv_no
5 - sell_inv
6 - ledgers












<tr>
    <?php
    if (!empty($list_collection_accounts)) {
        $customer_id = null;
        foreach ($list_collection_accounts as $list_collection_account) {
            $customer_id = $list_collection_account->id;
            $customer_balances = $obj_financial->listFullCollection($_POST, $customer_id);
            // echo '<pre>';
            // print_r($customer_balances);
    ?>
            <?php
            foreach ($customer_balances as $customer_balance) {
            ?>

                <!-- <td><?php // echo (($customer_balance->prev_bal - $customer_balance->dr) + $customer_balance->cr); 
                            ?></td> -->
                <td><?php echo $customer_balance->dr; ?></td>
                <td><?php echo $customer_balance->cr; ?></td>
                <td><?php echo $customer_balance->prev_bal; ?></td>
            <?php } ?>
            <td style="text-align: right;"><?php echo $list_collection_account->account_holder_name; ?></td>
    <?php
        }
    }
    ?>
</tr>