<?php

use Controllers\SellController;

include_once('../../autoload.php');
$obj_sell = new SellController;
$list_kachi_sells = $obj_sell->listKachiSellUnInvoiced();
// echo '<pre>';
// print_r($list_kachi_sells);
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
                        <button class="btn btn-danger delete_sng_unsaved_item" data-id=<?php echo $list_kachi_sell->pur_id; ?>>
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
<script>
    $(document).ready(function() {

        // function it_delete() {

        //     $(document).on('click', '.delete_sng_unsaved_item', function(e) {
        //         e.preventDefault();
        //         const item_id = $(this).data('id');

        //         let payload = {
        //             'flag': 'delete_unsaved_sng_item',
        //             item_id: item_id
        //         }

        //         $.ajax({
        //             url: 'Views/actions.php',
        //             type: 'POST',
        //             data: payload,

        //             success: function(data) {
        //                 // let response = JSON.parse(data);
        //                 // if (response.success == false) {
        //                 // }
        //                 kachi_book_report_unsaved(); // Calling Kachi listing Report on addition of a single item

        //                 console.log(data);

        //             },

        //             error: function(request, status, error) {
        //                 console.log(request.responseText);

        //             }
        //         })
        //     })
        // }

        // it_delete();

    })
</script>