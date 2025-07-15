<?php

use Controllers\PurchaseController;

include_once('../../autoload.php');
$obj_purchase = new PurchaseController;
$list_uninvoiced_vendor_bills = $obj_purchase->unInvoicedVendorBill();
// echo '<pre>';
// print_r($list_uninvoiced_vendor_bills);
// die();
?>
<div style="text-align: center;">
    <h4>
        کے ریکارڈ c<?php echo $_POST['trans_date']; ?>
    </h4>
</div>
<table class="display" id="myTable">
    <thead>
        <tr>
            <th>Actions</th>
            <!-- <th>ٹوٹل رقم</th> -->
            <th>گاڑی نمبر</th>
            <th style="text-align: right;">بلٹی نمبر</th>
            <th style="text-align: right;">بیوپاری کا نام</th>
            <th style="text-align: right;">تاریخ</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($list_uninvoiced_vendor_bills)) {
            foreach ($list_uninvoiced_vendor_bills as $list_uninvoiced_vendor_bill) { ?>
                <tr>
                    <td>

                        <button class="btn btn-success">
                            <i class="fa fa-eye">&nbsp;</i>
                        </button>

                        <button class="btn btn-primary">
                            <i class="fa fa-pencil" data-id="<?php echo $list_uninvoiced_vendor_bill->vendor_id . '|' . $list_uninvoiced_vendor_bill->builty_no . '|' . $list_uninvoiced_vendor_bill->vehicle_no; ?>">&nbsp;</i>
                        </button>

                        <!-- <button class="btn btn-danger">
                            <i class="fa fa-trash">&nbsp;</i>
                        </button> -->

                    </td>
                    <td><?php echo $list_uninvoiced_vendor_bill->vehicle_no; ?></td>
                    <td style="text-align: right;"><?php echo $list_uninvoiced_vendor_bill->builty_no; ?></td>
                    <td style="text-align: right;"><?php echo $list_uninvoiced_vendor_bill->account_holder_name; ?></td>
                    <td style="text-align: right;"><?php echo $list_uninvoiced_vendor_bill->purchase_date; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    })
</script>