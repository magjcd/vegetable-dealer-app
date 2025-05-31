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
            <th>نام</th>
            <th>جمع</th>
            <th>تفصیل</th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($get_account_details as $get_account_detail) { ?>
            <tr>
                <td><?php echo $get_account_detail->reg_name; ?></td>
                <td><?php echo $get_account_detail->cr; ?></td>
                <td><?php echo $get_account_detail->dr; ?></td>
                <td><?php echo $get_account_detail->details; ?></td>
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