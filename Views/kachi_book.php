<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
ini_set('display_error', 1);
$inv_no = $obj_sell->sellInvNo();
$cities = $obj_general->listAllCities();
$list_acc_recs = $obj_account->listAccountByType(1); // Accounts Receivable -> Sub Header is 1
$bal_qtys = $obj_sell->availableQty();
$list_sales_inventory = $obj_financial->listSalesInventory("Sells");

if (isset($_POST['sell_inv_no'])) {
?>
    <script>
        alert('dsfdsfs');
    </script>
<?php
    echo 'saved';
    $obj_sell->saveKachiInvoce($_POST['sell_date'], $_POST['sell_inv_no'], $_POST['vendor'], $_POST['customer'], $_POST['revenue']);
}
?>
<div>
    <h3 style="text-align: center;"> کچی بک کی تفصیل</h3>
</div>


<div class="container">
    <!-- <h3 style="text-align: center;">گاہک کی تفصیل</h3> -->
    <!-- Button to Open the Modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        مال کا کچا اندراج
    </button> -->

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">مال کا کچا اندراج</h4>
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
    <form id="customer_form" action="index?route=kachi_book" method="POST">
        <div class="form-group">
            <span class="text-success"></span>
            <span class="text-danger"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="vendor">
                <h5>
                    تاریخ
                </h5>
            </label>
            <input type="date" id="sell_date" name="sell_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </select>
            <span class="text-danger" id="error_sell_date"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="sell_inv_no">
                <h5>بل نمبر</h5>
            </label>
            <input type="number" class="form-control" id="sell_inv_no" placeholder="Invoice No." name="sell_inv_no" value="<?php echo $inv_no->sell_inv_no + 1; ?>" disabled>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="customer">
                <h5>گاہک</h5>
            </label>
            <select id="customer" name="customer" class="form-control" style="text-align: right;">
                <option value="">گاہک کا انتخاب</option>
                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($list_acc_recs as $list_acc_rec) {
                ?>
                    <option value="<?php echo $list_acc_rec->id . '|' . $list_acc_rec->header_id . '|' . $list_acc_rec->sub_header_id . '|' . $list_acc_rec->city_id . '|' . $list_acc_rec->account_holder_name . '|' . $list_acc_rec->city_name; ?>"><?php echo $list_acc_rec->account_holder_name . ' ' . $list_acc_rec->city_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_customer"></span>
        </div>
        <div class="form-group" style="text-align: right;">
            <label for="vendor">
                <h5>بیوپاری</h5>
            </label>
            <select id="vendor" name="vendor" class="form-control" style="text-align: right;">
                <option value="">بیوپاری کا انتخاب</option>
                <option value="" disabled>--------------------------------</option>
                <?php
                foreach ($bal_qtys as $bal_qty) {
                    $tot_qty = ($bal_qty->tot_pur_qty - $bal_qty->tot_sl_qty);
                    if ($tot_qty != 0) {
                ?>
                        <option value="<?php echo $bal_qty->random_no . '|' . $bal_qty->builty_no . '|' . $bal_qty->vehicle_no . '|' . $bal_qty->item_id . '|' . $bal_qty->item_name . '|' . $bal_qty->vendor_id; ?>"><?php echo $tot_qty . ' / ' . $bal_qty->tot_pur_qty . ' - ' . $bal_qty->vendor_nm . ' - ' . $bal_qty->vendor_city . ' - ' . $bal_qty->item_name; ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <span class="text-danger" id="error_vendor"></span>
        </div>
        <div class="form-group" style="text-align: right;">
            <label for="qty">
                <h5>تعداد</h5>
            </label>
            <input type="number" class="form-control" id="qty" placeholder="تعداد" name="qty" dir="rtl">
            <span class="text-danger" id="error_qty"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="price">
                <h5>قیمت</h5>
            </label>
            <input type="number" class="form-control" id="price" placeholder="قیمت" name="price" dir="rtl">
            <span class="text-danger" id="error_price"></span>
        </div>

        <div class="form-group" style="text-align: right;" hidden>
            <label for="revenue">
                <h5>Revenue</h5>
            </label>
            <select id="revenue" name="revenue" class="form-control" style="text-align: right;">
                <?php
                foreach ($list_sales_inventory as $list_sale_inventory) {
                ?>
                    <option value="<?php echo $list_sale_inventory->id . '|' . $list_sale_inventory->header_id . '|' . $list_sale_inventory->sub_header_id; ?>">
                        <?php echo $list_sale_inventory->account_holder_name; ?>
                    </option>
                <?php
                }
                ?>
            </select>
            <span class="text-danger" id="error_customer"></span>
        </div>

        <button type="submit" id="sell_stock" class="btn btn-primary">Add Item</button>
        <button type="submit" id="save_sell_inv" name="save_sell_inv" class="btn btn-success">Save Invoice</button>
    </form>

    <div id="view_kachi_report_unsaved"></div>
    <div style="overflow: auto;" id="view_kachi_report"></div>
</div>

<script>
    $(document).ready(function() {
        $('#customer').focus();
        $('#sell_stock').on('click', function(e) {
            e.preventDefault();


            let payload1 = {
                flag: 'sell_stock',
                trans_date: null,
                sell_inv_no: null,
                vendor: null,
                customer: null,
                revenue: null,
                qty: null,
                price: null
            }

            let payload = {
                flag: 'sell_stock',
                trans_date: $('#sell_date').val(),
                sell_inv_no: $('#sell_inv_no').val(),
                vendor: $('#vendor').val(),
                customer: $('#customer').val(),
                revenue: $('#revenue').val(),
                qty: $('#qty').val(),
                price: $('#price').val()
            }

            $.ajax({
                url: 'Views/actions.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    $('#sell_stock').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    $('#error_vendor').html('');
                    $('#error_customer').html('');

                    $('#error_qty').html('');
                    $('#error_price').html('');

                    let response = JSON.parse(data);
                    if (response.success == false) {
                        response.errors.vendor ? $('#error_vendor').html(response.errors.vendor) : '';
                        response.errors.customer ? $('#error_customer').html(response.errors.customer) : '';
                        response.errors.qty ? $('#error_qty').html(response.errors.qty) : '';
                        response.errors.price ? $('#error_price').html(response.errors.price) : '';
                        $('#sell_stock').html('Add');
                        return;
                    }
                    kachi_book_report_unsaved(); // Calling Kachi listing Report on addition of a single item
                    $('#vendor').focus();
                    $('#sell_stock').html('Add');
                    $('.text-success').html(response.message).show();
                    $('#qty').val(0)
                    $('#price').val(0)
                    console.log(data);

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        $('#save_sell_inv').on('click', function(e) {
            e.preventDefault();

            let payload = {
                flag: 'save_sell_inv',
                trans_date: $('#sell_date').val(),
                sell_inv_no: $('#sell_inv_no').val(),
                // vendor: $('#vendor').val(),
                customer: $('#customer').val(),
                revenue: $('#revenue').val(),
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

                    let response = JSON.parse(data);
                    if (response.success == false) {
                        if (response.message == 'please add item in invoice') {
                            const msg = Swal.fire({
                                title: "آئٹم ایڈ کریں۔",
                                text: "آئٹم ایڈ کریں، خالی بل سیو نہیں ہوگا۔",
                                icon: "info"
                            });
                            $('.text-success').html(response.message).show();
                        }
                        kachi_book_report_unsaved_count();
                        $('.btn-primary').html('Add');
                        response.errors.customer ? $('#error_customer').html(response.errors.customer) : '';
                    }

                    $('.text-success').html(response.message).show();
                    Swal.fire({
                        title: "بل بن چکا ہے۔",
                        text: "نیا بل جینیریٹ ہو رہا ہے، انتظار کریں۔",
                        icon: "success"
                    });
                    setTimeout(function() {
                        window.location.replace('index?route=kachi_book')
                    }, 3000);
                    console.log(data);

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });

        // On page load this report
        function kachi_book_report() {
            let payload = {
                trans_date: $('#sell_date').val()
            }

            $.ajax({
                url: 'Views/reports/kachi_book_report.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#view_kachi_report').html(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }

        // On date change this report
        $('#sell_date').on('change', function(e) {
            e.preventDefault();
            let payload = {
                trans_date: $('#sell_date').val()
            }

            $.ajax({
                url: 'Views/reports/kachi_book_report.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#view_kachi_report').html(data)
                    console.log(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        })

        kachi_book_report();


        // On page load this report
        function kachi_book_report_unsaved() {
            $.ajax({
                url: 'Views/reports/kachi_book_report_unsaved.php',
                type: 'POST',

                success: function(data) {
                    $('#view_kachi_report_unsaved_top').html(data);
                    $('#view_kachi_report_unsaved').html(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }
        kachi_book_report_unsaved();

        function kachi_book_report_unsaved_count() {
            $.ajax({
                url: 'Views/reports/kachi_book_report_unsaved_count.php',
                type: 'POST',

                success: function(data) {
                    $('#cart_count').html(data);
                },

                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }
        kachi_book_report_unsaved_count();

        // Delete unsaved item fro kachi
        function it_delete() {
            $(document).on('click', '.delete_sng_unsaved_item', function(e) {
                e.preventDefault();
                const item_id = $(this).data('id');

                let payload = {
                    'flag': 'delete_unsaved_sng_item',
                    item_id: item_id
                }

                $.ajax({
                    url: 'Views/actions.php',
                    type: 'POST',
                    data: payload,

                    success: function(data) {
                        // let response = JSON.parse(data);
                        // if (response.success == false) {
                        // }
                        kachi_book_report_unsaved(); // Calling Kachi listing Report on addition of a single item
                        kachi_book_report_unsaved_count();
                        console.log(data);

                    },

                    error: function(request, status, error) {
                        console.log(request.responseText);

                    }
                })
            })
        }

        it_delete();

        // jQuery Data Table
        $('#myTable').DataTable();
    });
</script>
<style>
    .text-success {
        display: none;
    }
</style>