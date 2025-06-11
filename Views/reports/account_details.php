<?php

use Controllers\FinanacialController;

include_once('../../autoload.php');
$obj_financial = new FinanacialController;
$get_account_details = $obj_financial->getAccountDetails($_POST);
?>
<table class="display" id="myTable" style="text-align: right;">
    <thead>
        <tr>
            <th>وصول کنندہ</th>
            <th>بیلینس</th>
            <th>نام</th>
            <th>جمع</th>
            <th>تفصیل</th>
            <th>تاریخ</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $tot = 0;
        foreach ($get_account_details as $get_account_detail) {
            $tot += $get_account_detail->cr - $get_account_detail->dr;
        ?>
            <tr>
                <td><?php echo $get_account_detail->reg_name; ?></td>
                <td><?php echo $tot; ?></td>
                <td><?php echo $get_account_detail->cr; ?></td>
                <td><?php echo $get_account_detail->dr; ?></td>
                <td><?php echo $get_account_detail->details; ?></td>
                <td><?php echo $get_account_detail->gj_date; ?></td>

            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>