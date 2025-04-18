<?php

use Controllers\SellController;

include_once('../../autoload.php');
$obj_sell = new SellController;
// if (isset($_POST['trans_date'])) {
$list_kachi_sells = $obj_sell->listKachiSellUnInvoiced();
?>

<table class="" id="unsaved_kachi_book_table">
    <thead>
        <tr>
            <th>Actions</th>
            <th>ٹوٹل</th>
            <th>قیمت</th>
            <th>تعداد</th>
            <th style="text-align: right;">جنس</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($list_kachi_sells)) {
            foreach ($list_kachi_sells as $list_kachi_sell) { ?>
                <tr>
                    <td>
                        <button class="btn btn-danger">
                            <i class="fa fa-trash">&nbsp;</i>
                        </button>

                    </td>
                    <td><?php echo ($list_kachi_sell->sl_qty * $list_kachi_sell->price); ?></td>
                    <td><?php echo $list_kachi_sell->price; ?></td>
                    <td><?php echo $list_kachi_sell->sl_qty; ?></td>
                    <td style="text-align: right;"><?php echo $list_kachi_sell->item_name; ?></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">No items are available</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php //} 
?>