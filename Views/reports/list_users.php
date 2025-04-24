<?php

use Controllers\UserController;

include_once('../../autoload.php');
$obj_users = new UserController;
$list_users = $obj_users->listUsers();
?>
<div style="text-align: center;">
    <h4>
        یوزرس کا ریکارڈ
    </h4>
</div>
<table class="display" id="myTable">
    <thead>
        <tr>
            <th>Actions</th>
            <th style="text-align: right;">رول</th>
            <th style="text-align: right;">یوزر مین</th>
            <th style="text-align: right;">نام</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (!empty($list_users)) {
            foreach ($list_users as $list_user) { ?>
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
                    <td style="text-align: left;"><?php echo $list_user->role; ?></td>
                    <td style="text-align: right;"><?php echo $list_user->email; ?></td>
                    <td style="text-align: right;"><?php echo $list_user->name; ?></td>
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