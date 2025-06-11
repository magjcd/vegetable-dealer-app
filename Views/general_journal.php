<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$list_accs = $obj_account->listAccountsForGJ();
$list_collector_accs = $obj_account->listUserAccountsForGJ();
?>
<div>
    <?php if ($obj_account->user_array->role == 'munshi') { ?>
        <h3 style="text-align: center;">وصولی بک</h3>
    <?php } else { ?>
        <h3 style="text-align: center;"> جنرل جرنل</h3>

    <?php } ?>
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
        <h5 id="collection_balance" style="text-align: center;"></h5>
    <?php } ?>
    <form id="gj_form" action="" method="POST">
        <div class="form-group">
            <span class="text-success"></span>
            <span class="text-danger"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="gj_date">
                <h5>
                    تاریخ
                </h5>
            </label>
            <input type="date" id="gj_date" name="gj_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </select>
            <span class="text-danger" id="error_gj_date"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <div style="text-align: left;" id="account_balance"></div>
            <label for="account_info">
                <?php if ($obj_account->user_array->role == 'munshi') { ?>
                    <h5>گاہک</h5>
                <?php } else { ?>
                    <h5>کھاتا</h5>
                <?php } ?>
            </label>
            <select id="account_info" name="account_info" class="form-control" style="text-align: right;">
                <?php if ($obj_account->user_array->role == 'munshi') { ?>
                    <option value="">گاہک کا انتخاب</option>
                <?php } else { ?>
                    <option value="">کھاتے کا انتخاب</option>

                <?php } ?>

                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($list_accs as $list_acc) {
                ?>
                    <option value="<?php echo $list_acc->id . '|' . $list_acc->hid . '|' . $list_acc->subid . '|' . $list_acc->acc_name . '|' . $list_acc->ct_name . '|' . $list_acc->ct_id; ?>"><?php echo $list_acc->acc_name . ' ' . $list_acc->ct_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_account_info"></span>
        </div>

        <?php
        // if ($obj_account->user_array->role == 'accountant') {
        ?>
        <div class="form-group" <?php echo $obj_account->user_array->role == 'accountant' ? 'style="text-align: right; display: block;"' : 'style="text-align: right; display: none;"'; ?>>
            <label for="collector">
                <h5>وصول کنندہ</h5>
            </label>
            <select id="collector" name="collector" class="form-control" style="text-align: right;">
                <option value="">وصول کنندہ</option>
                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($list_collector_accs as $list_collector_acc) {
                ?>
                    <option <?php echo $list_collector_acc->accounts_id == $obj_account->user_account_id ? 'selected = "selected" readonly="true"' : ''; ?> value="<?php echo $list_collector_acc->accounts_id . '|' . $list_collector_acc->hid . '|' . $list_collector_acc->subid . '|' . $list_collector_acc->acc_name; ?>"><?php echo $list_collector_acc->acc_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_collector"></span>
        </div>

        <?php
        // }
        ?>

        <div class="form-group" style="text-align: right;">
            <label for="details">
                <h5>تفصیل</h5>
            </label>
            <input type="text" class="form-control" id="details" placeholder="تفصیل" name="details" dir="rtl">
            <span class="text-danger" id="error_details"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="dr">
                <h5>جمع</h5>
            </label>
            <input type="number" class="form-control" id="dr" placeholder="جمع" name="dr" dir="rtl">
            <span class="text-danger" id="error_dr"></span>
        </div>

        <?php
        // echo $obj_account->user_array->role != 'munshi';
        if ($obj_account->user_array->role != 'munshi') {
        ?>
            <div class="form-group" style="text-align: right;">
                <label for="cr">
                    <h5>نام</h5>
                </label>
                <input type="number" class="form-control" id="cr" placeholder="نام" name="cr" dir="rtl">
                <span class="text-danger" id="error_cr"></span>
            </div>

        <?php
        }
        ?>

        <button type="submit" id="add_gj_entry" class="btn btn-primary">Add</button>
    </form>

    <div style="overflow: auto;" id="view_gj_entries"></div>
</div>



<script>
    $(document).ready(function() {
        $('#add_gj_entry').on('click', function(e) {
            e.preventDefault();


            let payload1 = {
                flag: 'add_gj_entry',
                trans_date: null,
                account_info: null,
                collector: null,
                details: null,
                dr: null,
                cr: null,
            }

            let payload = {
                flag: 'add_gj_entry',
                trans_date: $('#gj_date').val(),
                account_info: $('#account_info').val(),
                collector: $('#collector').val(),
                details: $('#details').val(),
                dr: $('#dr').val(),
                cr: $('#cr').val(),
            }

            $.ajax({
                url: 'Views/actions/finance_actions.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    $('#add_gj_entry').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    $('#error_vendor').html('');
                    $('#error_customer').html('');

                    $('#error_qty').html('');
                    $('#error_price').html('');

                    let response = JSON.parse(data);
                    if (response.success == false) {
                        response?.errors?.account_info ? $('#error_account_info').html(response?.errors?.account_info) : '';
                        response?.errors?.collector ? $('#error_collector').html(response?.errors?.collector) : '';
                        response?.errors?.details ? $('#error_details').html(response?.errors?.details) : '';
                        response?.errors?.dr ? $('#error_dr').html(response?.errors?.dr) : '';
                        $('#add_gj_entry').html('Add');
                        return;
                    }

                    $('#add_gj_entry').html('Add');
                    $('.text-success').html(response.message).show();
                    $('#details').val('')
                    $('#dr').val('')
                    $('#cr').val('')
                    $('#account_info').focus();
                    gj_entries();
                    collection_balance();
                    console.log(data);

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        // On page load this report
        function gj_entries() {
            $.ajax({
                url: 'Views/reports/gj_entries.php',
                type: 'POST',
                // data: payload,

                success: function(data) {
                    $('#view_gj_entries').html(data)
                    console.log(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }
        gj_entries();

        function collection_balance() {
            let payload = {
                flag: 'collection_balance',
            }

            $.ajax({
                url: 'Views/actions/finance_actions.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#collection_balance').html(`${data} آپکی طرف بقایاجات`)
                    console.log(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }
        collection_balance();

        // On date change this report
        $('#gj_date').on('change', function(e) {
            e.preventDefault();
            let payload = {
                gj_date: $('#gj_date').val()
            }

            $.ajax({
                url: 'Views/reports/gj_entries.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#view_gj_entries').html(data)
                    console.log(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        })

        // function account_balance() {
        $('#account_info').on('change', function() {

            payload = {
                flag: 'gj_account_balance',
                account_info: $('#account_info').val()
            }

            $.ajax({
                url: 'Views/actions/finance_actions.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#account_balance').html(`${data}`)
                },

                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        $(document).on('click', '.delete_sng_collection_record', function(e) {
            // alert($(this).data('id'));
            e.preventDefault();

            if (confirm('کیا آپ یے انٹری ڈیلیٹ کرنا چاہتے ہیں؟')) {
                let payload = {
                    flag: 'delete_collection_record',
                    uniq_id: $(this).data('id')
                }

                $.ajax({
                    url: 'Views/actions/finance_actions.php',
                    type: 'POST',
                    data: payload,

                    success: function(data) {
                        console.log(data);
                        $('.text-success').html(data)
                        // gj_entries();
                    },

                    error: function(request, status, error) {
                        console.log(request.responseText);

                    }
                })
            }
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