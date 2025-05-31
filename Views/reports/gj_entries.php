<?php

use Controllers\FinanacialController;

include_once('../../autoload.php');
$obj_financial = new FinanacialController;
$list_collectoions = $obj_financial->listCollection($_POST['gj_date']);
?>

<table class="display" id="myTable">
    <thead>
        <tr>
            <th>Actions</th>
            <?php if ($obj_financial->user_array->role != 'munshi') { ?>
                <th>وصول کنندہ</th>
            <?php } ?>
            <th>نام</th>
            <th>جمع</th>
            <th>تفصیل</th>
            <th style="text-align: right;">گاہک کا نام</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($list_collectoions)) {
            foreach ($list_collectoions as $list_collectoion) { ?>
                <tr>
                    <td>
                        <button class="btn btn-danger delete_sng_collection_record" data-id=<?php echo $list_collectoion->uniq_id; ?>>
                            <i class="fa fa-trash">&nbsp;</i>
                        </button>

                    </td>
                    <?php if ($obj_financial->user_array->role != 'munshi') { ?>
                        <td><?php echo $list_collectoion->reg_name; ?></td>
                    <?php } ?>

                    <td><?php echo $list_collectoion->cr; ?></td>
                    <td><?php echo $list_collectoion->dr; ?></td>
                    <td><?php echo $list_collectoion->details; ?></td>
                    <td style="text-align: right;"><?php echo $list_collectoion->account_holder_name; ?></td>
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
        $('#myTable').DataTable();
    });
</script>