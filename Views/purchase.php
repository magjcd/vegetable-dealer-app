<?php
ini_set('display_error', 1);
$inv_no = $obj_purchase->purchaseInvNo();
$verndors_info = $obj_account->listAccountByType(2);
$items_info = $obj_item->listItems();
$list_purchases = $obj_purchase->listPurchases();
$list_sales_inventory = $obj_financial->listSalesInventory("Inventory");
// echo '<pre>';
// print_r($verndors_info);

?>

<u>
    <h3 style="text-align: center;">خریداری کا اندراج</h3>
</u>

<div class="container">
    <!-- <h3 style="text-align: center;">گاہک کی تفصیل</h3> -->
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        خریداری کا اندراج
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">خریداری کا اندراج</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">


                    <form id="purchase_form">

                        <div class="form-group">
                            <span class="text-success"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="vendor">
                                <h5>
                                    تاریخ
                                </h5>
                            </label>
                            <input type="date" id="purchase_date" name="purchase_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                            </select>
                            <span class="text-danger" id="error_purchase_date"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="pur_inv_no">
                                <h5>بل نمبر</h5>
                            </label>
                            <input type="number" class="form-control" id="pur_inv_no" placeholder="Invoice No." name="pur_inv_no" value="<?php echo $inv_no->pur_inv_no + 1; ?>" disabled>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="vendor">
                                <h5>
                                    بیوپاری
                                </h5>
                            </label>
                            <select id="vendor" name="vendor" class="form-control" style="text-align: right;">
                                <option value="">بیوپاری منتخب کریں</option>
                                <option value="" disabled>--------------------------------</option>
                                <?php
                                foreach ($verndors_info as $verndor_info) {
                                ?>
                                    <option value="<?php echo $verndor_info->id . '|' . $verndor_info->header_id . '|' . $verndor_info->sub_header_id . '|' . $verndor_info->city_id . '|' . $verndor_info->account_holder_name . '|' . $verndor_info->city_name; ?>"><?php echo $verndor_info->account_holder_name . ' ' . $verndor_info->city_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger" id="error_vendor"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="builty_no">
                                <h5>
                                    بلٹی نمبر
                                </h5>
                            </label>
                            <input type="text" class="form-control" id="builty_no" placeholder="بلٹی نمبر" name="builty_no" dir="rtl">
                            <span class="text-danger" id="error_builty_no"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="vehicle_no">
                                <h5>
                                    گاڑی نمبر
                                </h5>
                            </label>
                            <input type="text" class="form-control" id="vehicle_no" placeholder="گاڑی نمبر" name="vehicle_no" dir="rtl">
                            <span class="text-danger" id="error_vehicle_no"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="items">
                                <h5>
                                    جنس کا نام
                                </h5>
                            </label>
                            <select id="items" name="items" class="form-control">
                                <option value="" style="text-align: right;">
                                    <h5>جنس منتخب کریں</h5>
                                </option>
                                <option value="" disabled>--------------------------------</option>
                                <?php
                                foreach ($items_info as $item_info) {
                                ?>
                                    <option value="<?php echo $item_info->id; ?>"><?php echo $item_info->item_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger" id="error_items"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="item_details">
                                <h5>
                                    جنس کا تفصیل
                                </h5>
                            </label>
                            <input type="text" class="form-control" id="item_details" placeholder="جنس کا تفصیل" name="item_details" dir="rtl">
                            <span class="text-danger" id="error_item_details"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="price">
                                <h5>
                                    تعداد
                                </h5>
                            </label>
                            <input type="number" id="qty" class="form-control" name="qty" placeholder="تعداد" dir="rtl" />
                            <span class="text-danger" id="error_qty"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="price">
                                <h5>
                                    قیمت
                                </h5>
                            </label>
                            <input type="number" id="price" class="form-control" name="price" placeholder="قیمت" dir="rtl"></input>
                            <span class="text-danger" id="error_price"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="inventory">
                                <h5>Inventory</h5>
                            </label>
                            <select id="inventory" name="inventory" class="form-control" style="text-align: right;">
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

                        <button type="submit" id="add_purchase" class="btn btn-primary">Add</button>
                        <button type="submit" id="save_pur_inv" name="save_pur_inv" class="btn btn-success">Save Invoice</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div>
    <h3 style="text-align: center;">خریداری</h3>
</div> -->


<div style="overflow: auto;">
    <table class="display" id="myTable">
        <thead>
            <tr>
                <th>Actions</th>
                <th>Qunatity</th>
                <th>Builty No.</th>
                <th>Item</th>
                <th>City</th>
                <th>Contact No.</th>
                <th>Vendor Name</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (!empty($list_purchases)) {
                foreach ($list_purchases as $list_purchase) { ?>
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
                        <td style="text-align: right;"><?php echo $list_purchase->pur_qty; ?></td>
                        <td style="text-align: right;"><?php echo $list_purchase->builty_no; ?></td>
                        <td style="text-align: right;"><?php echo $list_purchase->item_name; ?></td>
                        <td><?php echo $list_purchase->city_name; ?></td>
                        <td style="text-align: right;"><a href="https://wa.me/<?php echo $list_purchase->contact_no; ?>?text= محترم <?php echo $list_purchase->account_holder_name; ?>  صاحب، آپ کی بلٹی نمبر <?php echo $list_purchase->builty_no; ?> کی تمام <?php echo $list_purchase->pur_qty; ?> بوریاں فروخت ہو گئی ہیں" class=" btn btn-success">
                                <i class="fa fa-whatsapp">&nbsp;</i>
                            </a> <?php echo $list_purchase->contact_no; ?></td>
                        <td style="text-align: right;"><?php echo $list_purchase->account_holder_name; ?></td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#add_purchase').on('click', function(e) {
            e.preventDefault();

            let payload = {
                flag: 'add_purchase',
                purchase_date: $('#purchase_date').val(),
                pur_inv_no: $('#pur_inv_no').val(),
                vendor: $('#vendor').val(),
                date: $('#date').val(),
                builty_no: $('#builty_no').val(),
                vehicle_no: $('#vehicle_no').val(),
                items: $('#items').val(),
                item_details: $('#item_details').val(),
                qty: $('#qty').val(),
                price: $('#price').val()
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
                    $('#error_date').html('');
                    $('#error_vendor').html('');
                    $('#error_builty_no').html('');
                    $('#error_vehicle_no').html('');
                    $('#error_items').html('');
                    $('#error_item_details').html('');
                    $('#error_qty').html('');
                    $('#error_price').html('');

                    let response = JSON.parse(data);
                    if (response.success == false) {
                        response.errors.date ? $('#error_date').html(response.errors.date) : '';
                        response.errors.vendor ? $('#error_vendor').html(response.errors.vendor) : '';
                        response.errors.builty_no ? $('#error_builty_no').html(response.errors.builty_no) : '';
                        response.errors.vehicle_no ? $('#error_vehicle_no').html(response.errors.vehicle_no) : '';
                        response.errors.items ? $('#error_items').html(response.errors.items) : '';
                        response.errors.item_details ? $('#error_item_details').html(response.errors.item_details) : '';
                        response.errors.qty ? $('#error_qty').html(response.errors.qty) : '';
                        response.errors.price ? $('#error_price').html(response.errors.price) : '';
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

        $('#save_pur_inv').on('click', function(e) {
            e.preventDefault();

            let payload = {
                flag: 'save_pur_inv',
                trans_date: $('#purchase_date').val(),
                pur_inv_no: $('#pur_inv_no').val(),
                // vendor: $('#vendor').val(),
                vendor: $('#vendor').val(),
                builty_no: $('#builty_no').val(),
                vehicle_no: $('#vehicle_no').val(),
                inventory: $('#inventory').val(),
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
                        $('.btn-primary').html('Add');
                        response.errors.vendor ? $('#error_vendor').html(response.errors.vendor) : '';
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

        // jQuery Data Table
        $('#myTable').DataTable();
    });
</script>
<style>
    .text-success {
        display: none;
    }
</style>