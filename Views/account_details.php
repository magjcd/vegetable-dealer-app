<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$list_accs = $obj_account->listAccountsForGJ();
?>
<div>
    <h3 style="text-align: center;"> کھاتے کی تفصیل / اکائونٹ سمری</h3>
</div>


<div class="container">

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <?php
                    if ($obj_account->user_array->role == 'munshi') {
                        echo '<h4 class="modal-title"> وصولی بک</h4>';
                    } else {
                        echo '<h4 class="modal-title">جنرل جرنل</h4>';
                    } ?>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">


                </div>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div> -->

            </div>
        </div>

    </div>
    <?php
    if ($obj_account->user_array->role == 'munshi') {
    ?>
        <div id="collection_balance" style="text-align: center;"></div>
    <?php } ?>
    <form id="account_details" class="form-group">
        <div class="form-group">
            <span class="text-success"></span>
            <span class="text-danger"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <!-- <label for="from_date">
                <h5>
                    تاریخ
                </h5>
            </label> -->
            <input type="date" id="from_date" name="from_date" class="form-control" value="<?php echo date('Y-m-01'); ?>" />
            </select>
            <span class="text-danger" id="error_from_date"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <!-- <label for="to_date">
                <h5>
                    تاریخ
                </h5>
            </label> -->
            <input type="date" id="to_date" name="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </select>
            <span class="text-danger" id="error_to_date"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <div style="text-align: left;" id="account_balance"></div>
            <!-- <label for="account_info">
                <h5>کھاتا</h5>
            </label> -->
            <select id="account_info" name="account_info" class="form-control" style="text-align: right;">
                <option value="">کھاتے کا انتخاب</option>
                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($list_accs as $list_acc) {
                ?>
                    <option value="<?php echo $list_acc->id . '|' . $list_acc->acc_name . '|' . $list_acc->ct_name; ?>"><?php echo $list_acc->acc_name . ' ' . $list_acc->ct_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_account_info"></span>
        </div>

        <button type="submit" id="get_account_details" class="btn btn-primary">Get Data</button>
    </form>

    <div style="overflow: auto;" id="view_account_details"></div>
</div>



<script>
    $(document).ready(function() {
        $('#get_account_details').on('click', function(e) {
            e.preventDefault();


            let payload1 = {}

            let payload = {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                account_info: $('#account_info').val()
            }

            $.ajax({
                url: 'Views/reports/account_details.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    $('#get_account_details').html('wait....');
                },

                success: function(data) {
                    $('#error_from_date').html('');
                    $('#error_to_date').html('');
                    $('#error_account_info').html('');

                    let response = JSON.parse(data);
                    // if (response.success == false) {
                    //     response.errors.from_date ? $('#error_from_date').html(response.errors.from_date) : '';
                    //     response.errors.to_date ? $('#error_to_date').html(response.errors.to_date) : '';
                    //     response.errors.account_info ? $('#error_account_info').html(response.errors.account_info) : '';
                    //     $('#get_account_details').html('Get Data');
                    //     return;
                    // }
                    $('#get_account_details').html('Get Data');
                    $('#view_account_details').html(data);
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