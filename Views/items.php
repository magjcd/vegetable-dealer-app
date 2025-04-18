<?php
ini_set('display_error', 1);
$list_items = $obj_item->listItems();
?>
<h3 style="text-align: center;">اجناس / Items</h3>


<div class="container">
    <!-- <h3 style="text-align: center;">گاہک کی تفصیل</h3> -->
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        اجناس / Items
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">اجناس / Items</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">


                    <form id="customer_form">

                        <div class="form-group">
                            <span class="text-success"></span>
                        </div>
                        <div class="form-group" style="text-align: right;">
                            <label for="item_name">
                                <h5>جنس کا نام</h5>
                            </label>
                            <input type="text" class="form-control" id="item_name" placeholder="جنس کا نام" name="item_name" dir="rtl">
                            <span class="text-danger" id="error_item_name"></span>
                        </div>

                        <button type="submit" id="add_item" class="btn btn-primary">Add</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<div style="overflow: auto;">
    <table class="table table-striped display" id="myTable">
        <thead>
            <tr>
                <th>Actions</th>
                <th>Item Name</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($list_items as $list_item) { ?>
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
                    <td style="text-align: right;"><?php echo $list_item->item_name; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#add_item').on('click', function(e) {
            e.preventDefault();

            let payload = {
                flag: 'add_item',
                item_name: $('#item_name').val()
            }

            $.ajax({
                url: 'Views/actions.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    $('.btn-primary').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    $('#error_item_name').html('');


                    let response = JSON.parse(data);
                    if (response.success == false) {
                        response.errors.item_name ? $('#error_item_name').html(response.errors.item_name) : '';
                        $('.btn-primary').html('Add');
                        return;
                    }

                    $('.btn-primary').html('Add');
                    $('.text-success').html(response.message).show();
                    console.log(data);

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        // jQuery Data Table
        $('#myTable').DataTable();

    });
</script>
<style>
    .text-success {
        display: none;
    }
</style>