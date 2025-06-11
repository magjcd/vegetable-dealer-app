<?php

use Controllers\SellController;

include_once('../../autoload.php');
$obj_sell = new SellController;
if (isset($_POST['trans_date'])) {
    $list_kachi_sells = $obj_sell->listKachiSellInvoiced($_POST['trans_date']);
    // echo '<pre>';
    // print_r($list_kachi_sells);
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
                <th>ٹوٹل</th>
                <!-- <th>قیمت</th>
                <th>تعداد</th>
                <th style="text-align: right;">جنس</th> -->
                <th style="text-align: right;">شہر</th>
                <th style="text-align: right;">گاہک کا نام</th>
                <th style="text-align: right;">بل نمبر</th>
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

                            <?php
                            // echo $_POST['trans_date'] == date('Y-m-d');
                            if (($_POST['trans_date'] == date('Y-m-d')) == 1) {
                            ?>
                                <button class="btn btn-warning">
                                    <i class="fa fa-pencil">&nbsp;</i>
                                </button>

                                <button class="btn btn-danger delete-invoice" data-id="<?php echo $list_kachi_sell->inv_no; ?>">
                                    <i class="fa fa-trash">&nbsp;</i>
                                </button>

                            <?php
                            }
                            ?>

                        </td>
                        <td><?php //echo $list_kachi_sell['inv_amt'];
                            ?></td>
                        <!-- <td><?php // echo $list_kachi_sell->price; 
                                    ?></td>
                        <td><?php // echo $list_kachi_sell->sl_qty; 
                            ?></td>
                        <td style="text-align: right;"><?php // echo $list_kachi_sell->item_name; 
                                                        ?></td> -->
                        <td style="text-align: right;"><?php echo $list_kachi_sell->city_name; ?></td>
                        <td style="text-align: right;"><?php echo $list_kachi_sell->account_holder_name; ?></td>
                        <td style="text-align: right;"><?php echo $list_kachi_sell->inv_no; ?></td>

                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>