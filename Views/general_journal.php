<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$list_accs = $obj_account->listAccountsForGJ(); // Accounts Receivable -> Sub Header is 1

// echo '<pre>';
// print_r($list_accs);
?>
<div>
    <h3 style="text-align: center;"> جنرل جرنل</h3>
</div>


<div class="container">

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">جنرل جرنل</h4>
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
            <label for="account_info">
                <h5>گاہک</h5>
            </label>
            <select id="account_info" name="account_info" class="form-control" style="text-align: right;">
                <option value="">گاہک کا انتخاب</option>
                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($list_accs as $list_acc) {
                ?>
                    <option value="<?php echo $list_acc->id . '|' . $list_acc->hid . '|' . $list_acc->subid; ?>"><?php echo $list_acc->acc_name . ' ' . $list_acc->ct_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_account_info"></span>
        </div>

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
            <input type="number" class="form-control" id="dr" placeholder="جمع" name="dr">
            <span class="text-danger" id="error_dr"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="cr">
                <h5>نام</h5>
            </label>
            <input type="number" class="form-control" id="cr" placeholder="نام" name="cr">
            <span class="text-danger" id="error_cr"></span>
        </div>


        <button type="submit" id="add_gj_entry" class="btn btn-primary">Add</button>
    </form>

</div>


<div style="overflow: auto;" id="view_gj_entries"></div>

<script>
    $(document).ready(function() {
        $('#add_gj_entry').on('click', function(e) {
            e.preventDefault();


            let payload1 = {
                flag: 'add_gj_entry',
                trans_date: null,
                account_info: null,
                details: null,
                dr: null,
                cr: null,
            }

            let payload = {
                flag: 'add_gj_entry',
                trans_date: $('#gj_date').val(),
                account_info: $('#account_info').val(),
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
                        response.errors.account_info ? $('#error_account_info').html(response.errors.account_info) : '';
                        response.errors.details ? $('#error_details').html(response.errors.details) : '';
                        response.errors.dr ? $('#error_dr').html(response.errors.dr) : '';
                        $('#add_gj_entry').html('Add');
                        return;
                    }
                    // kachi_book_report_unsaved(); // Calling Kachi listing Report on addition of a single item

                    $('#add_gj_entry').html('Add');
                    $('.text-success').html(response.message).show();
                    console.log(data);

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        // On page load this report
        // function kachi_book_report() {
        //     let payload = {
        //         trans_date: $('#sell_date').val()
        //     }

        //     $.ajax({
        //         url: 'Views/reports/gj_entries.php',
        //         type: 'POST',
        //         data: payload,

        //         success: function(data) {
        //             $('#view_gj_entries').html(data)
        //             console.log(data);
        //         },
        //         error: function(request, status, error) {
        //             console.log(request.responseText);

        //         }
        //     })
        // }

        // On date change this report
        // $('#sell_date').on('change', function(e) {
        //     e.preventDefault();
        //     let payload = {
        //         trans_date: $('#sell_date').val()
        //     }

        //     $.ajax({
        //         url: 'Views/reports/gj_entries.php',
        //         type: 'POST',
        //         data: payload,

        //         success: function(data) {
        //             $('#view_gj_entries').html(data)
        //             console.log(data);
        //         },
        //         error: function(request, status, error) {
        //             console.log(request.responseText);

        //         }
        //     })
        // })

        // kachi_book_report();

        // jQuery Data Table
        $('#myTable').DataTable();
    });
</script>
<style>
    .text-success {
        display: none;
    }
</style>