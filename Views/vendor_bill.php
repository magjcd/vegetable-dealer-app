<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
ini_set('display_error', 1);
$inv_no = $obj_purchase->purchaseVendorInvNo();
$cities = $obj_general->listAllCities();
$list_acc_recs = $obj_account->listAccountByType(1); // Accounts Receivable -> Sub Header is 1
$bal_qtys = $obj_purchase->availableQtyVendor();
$list_sales_inventory = $obj_financial->listSalesInventory("Sells");
?>
<div>
    <h3 style="text-align: center;"> بیوپاری بل</h3>
</div>


<div class="container">

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">بیوپاری بل</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                </div>
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
            <label for="vendor_inv_no">
                <h5>بل نمبر</h5>
            </label>
            <input type="number" class="form-control" id="vendor_inv_no" placeholder="Invoice No." name="vendor_inv_no" value="<?php echo $inv_no->vendor_inv; ?>" disabled>
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
                    $tot_qty = ($bal_qty->tot_pur_qty - $bal_qty->tot_vend_sl_qty);
                    if ($tot_qty != 0) {
                ?>
                        <option value="<?php echo $bal_qty->random_no . '|' . $bal_qty->builty_no . '|' . $bal_qty->vehicle_no . '|' . $bal_qty->item_id . '|' . $bal_qty->item_name . '|' . $bal_qty->vendor_id . '|' . $bal_qty->header_id . '|' . $bal_qty->sub_header_id . '|' . $bal_qty->city_id; ?>"><?php echo $tot_qty . ' / ' . $bal_qty->tot_pur_qty . ' - ' . $bal_qty->vendor_nm . ' - ' . $bal_qty->vendor_city . ' - ' . $bal_qty->item_name; ?></option>
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

        <button type="submit" id="add_vendor_items" class="btn btn-primary">Add Item</button>
        <button type="submit" id="save_vendor_inv" name="save_vendor_inv" class="btn btn-success">Save Invoice</button>
    </form>
    <div style="overflow: auto;" id="list_uninvoiced_vendoor_bill"></div>
</div>

<script>
    $(document).ready(function() {
        $('#vendor').focus();
        $('#add_vendor_items').on('click', function(e) {
            e.preventDefault();


            let payload1 = {
                flag: 'vendor_bill',
                trans_date: null,
                vendor_inv_no: null,
                vendor: null,
                revenue: null,
                qty: null,
                price: null
            }

            let payload = {
                flag: 'vendor_bill',
                trans_date: $('#sell_date').val(),
                vendor_inv_no: $('#vendor_inv_no').val(),
                vendor: $('#vendor').val(),
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
                    $('#sell_stock').html('Add Item');
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

        // List Uninvoiced Bills
        function list_uninvoiced_vendoor_bill() {
            let payload = {
                flag: 'list_unsaved_vendor_inv',
            }
            $.ajax({
                url: 'Views/reports/list_unsaved_vendor_inv.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    // $('#sell_stock').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    $('#list_uninvoiced_vendoor_bill').html(data)
                    console.log(data);

                },

                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        }

        list_uninvoiced_vendoor_bill();

        // $('#save_vendor_inv').on('click', function(e) {
        //     e.preventDefault();

        //     let payload = {
        //         flag: 'save_vendor_inv',
        //         trans_date: $('#sell_date').val(),
        //         vendor_inv_no: $('#vendor_inv_no').val(),
        //         vendor: $('#vendor').val(),
        //         customer: $('#customer').val(),
        //         // revenue: $('#revenue').val(),
        //     }

        //     $.ajax({
        //         url: 'Views/actions.php',
        //         type: 'POST',
        //         data: payload,

        //         beforeSend: function() {
        //             $('.btn-primary').html('wait....');
        //             console.log(`I am before send.....`);
        //         },

        //         success: function(data) {

        //             let response = JSON.parse(data);
        //             if (response.success == false) {
        //                 if (response.message == 'please add item in invoice') {
        //                     const msg = Swal.fire({
        //                         title: "آئٹم ایڈ کریں۔",
        //                         text: "آئٹم ایڈ کریں، خالی بل سیو نہیں ہوگا۔",
        //                         icon: "info"
        //                     });
        //                     $('.text-success').html(response.message).show();
        //                 }
        //                 kachi_book_report_unsaved_count();
        //                 $('.btn-primary').html('Add');
        //                 response.errors.customer ? $('#error_customer').html(response.errors.customer) : '';
        //             }

        //             $('.text-success').html(response.message).show();
        //             Swal.fire({
        //                 title: "بل بن چکا ہے۔",
        //                 text: "نیا بل جینیریٹ ہو رہا ہے، انتظار کریں۔",
        //                 icon: "success"
        //             });
        //             setTimeout(function() {
        //                 window.location.replace('index?route=kachi_book')
        //             }, 3000);
        //             console.log(data);

        //         },
        //         error: function(request, status, error) {
        //             console.log(request.responseText);

        //         }
        //     })
        // });

        // On date change this report
        // $('#sell_date').on('change', function(e) {
        //     e.preventDefault();
        //     let payload = {
        //         trans_date: $('#sell_date').val()
        //     }

        //     $.ajax({
        //         url: 'Views/reports/kachi_book_report.php',
        //         type: 'POST',
        //         data: payload,

        //         success: function(data) {
        //             $('#view_kachi_report').html(data)
        //             console.log(data);
        //         },
        //         error: function(request, status, error) {
        //             console.log(request.responseText);

        //         }
        //     })
        // })




        // jQuery Data Table
        $('#myTable').DataTable();
    });
</script>
<style>
    .text-success {
        display: none;
    }
</style>