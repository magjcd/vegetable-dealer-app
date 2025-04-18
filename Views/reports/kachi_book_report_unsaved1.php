<?php

use Controllers\SellController;

include_once('../../autoload.php');
$obj_sell = new SellController;
// if (isset($_POST['trans_date'])) {
$list_kachi_sells = $obj_sell->listKachiSellUnInvoiced();
?>

<table class="display" id="myTable">
    <thead>
        <tr>
            <th>Actions 2</th>
            <th>ٹوٹل</th>
            <th>قیمت</th>
            <th>تعداد</th>
            <th style="text-align: right;">جنس</th>
            <th style="text-align: right;">شہر</th>
            <th style="text-align: right;">گاہک کا نام</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($list_kachi_sells)) {
            foreach ($list_kachi_sells as $list_kachi_sell) { ?>
                <tr>
                    <td>

                        <button class="btn btn-success">
                            <i class="fa fa-eye">&nbsp;</i>
                        </button>

                        <button class="btn btn-warning">
                            <i class="fa fa-pencil">&nbsp;</i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="fa fa-trash">&nbsp;</i>
                        </button>

                    </td>
                    <td><?php echo ($list_kachi_sell->sl_qty * $list_kachi_sell->price); ?></td>
                    <td><?php echo $list_kachi_sell->price; ?></td>
                    <td><?php echo $list_kachi_sell->sl_qty; ?></td>
                    <td style="text-align: right;"><?php echo $list_kachi_sell->item_name; ?></td>
                    <td style="text-align: right;"><?php echo $list_kachi_sell->city_name; ?></td>
                    <td style="text-align: right;"><?php echo $list_kachi_sell->account_holder_name; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<?php //} 
?>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    })
</script>