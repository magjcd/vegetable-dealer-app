    <?php
    ini_set('display_error', 1);
    $cities = $obj_general->listAllCities();
    $list_customers = $obj_account->listAccounts();
    $list_headers = $obj_general->listHeaders();
    ?>
    <u>
        <h3 style="text-align: center;">کھاتوں کی تفصیل</h3>
    </u>

    <div class="container">
        <!-- <h3 style="text-align: center;">گاہک کی تفصیل</h3> -->
        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            نئے کھاتے کا اندراج
        </button>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">نئے کھاتے کا اندراج</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="customer_form">
                            <div class="form-group">
                                <span class="text-success"></span>
                            </div>

                            <div class="form-group" style="text-align: right;">
                                <label for="account_holder_name">
                                    <!-- <h5>گاہک کا نام</h5> -->
                                    <h5>نام</h5>
                                </label>
                                <input type="text" class="form-control" id="account_holder_name" placeholder="گاہک کا نام" name="account_holder_name" dir="rtl">
                                <span class="text-danger" id="error_account_holder_name"></span>
                            </div>

                            <div class="form-group">
                                <label for="header">Header:</label>
                                <select id="header" name="header" class="form-control">
                                    <option value="">Select a Header</option>
                                    <option value="" disabled>--------------------------------</option>
                                    <?php
                                    foreach ($list_headers as $list_header) {
                                    ?>
                                        <option value="<?php echo $list_header->id; ?>"><?php echo $list_header->header_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger" id="error_header"></span>
                            </div>

                            <div class="form-group">
                                <label for="sub_header">Sub_Header:</label>
                                <select id="sub_header" name="sub_header" class="form-control">
                                </select>
                                <span class="text-danger" id="error_sub_header"></span>
                            </div>

                            <div class="form-group" style="text-align: right;">
                                <label for="address">
                                    <h5>پتہ</h5>
                                </label>
                                <textarea id="address" class="form-control" name="address" placeholder="پتہ" dir="rtl"></textarea>
                                <span class="text-danger" id="error_address"></span>

                            </div>

                            <div class="form-group" style="text-align: right;">
                                <label for="business_address">
                                    <h5>کاروبار کا پتہ</h5>
                                </label>
                                <textarea id="business_address" class="form-control" name="business_address" placeholder="کاروبار کا پتہ" dir="rtl"></textarea>
                                <span class="text-danger" id="error_business_address"></span>
                            </div>

                            <div class="form-group" style="text-align: right;">
                                <label for="city">
                                    <h5>شہر</h5>
                                </label>
                                <select id="city" name="city" class="form-control" style="text-align: right;">
                                    <option value="">شہر کا انتخاب</option>
                                    <option value="" disabled>--------------------------------</option>
                                    <?php
                                    foreach ($cities as $city) {
                                    ?>
                                        <option value="<?php echo $city->id; ?>"><?php echo $city->city_name; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger" id="error_city"></span>
                            </div>

                            <div class="form-group" style="text-align: right;">
                                <label for="contact_no">
                                    <h3>رابطہ نمبر</h3>
                                </label>
                                <input type="text" class="form-control" id="contact_no" placeholder="+92 333 123 4567" name="contact_no">
                                <span class="text-danger" id="error_contact_no"></span>
                            </div>

                            <button type="submit" id="add_customer" class="btn btn-primary">Save</button>
                            <button type="submit" id="add_customer" class="btn btn-primary">Save & Exit</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div> -->

                </div>
            </div>
        </div>


        <div style="overflow: auto;">
            <table class="display" id="myTable">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Added By</th>
                        <th>City</th>
                        <th>Contact No.</th>
                        <th>Business Address</th>
                        <th>Address</th>
                        <th>Customer Name</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($list_customers)) {
                        foreach ($list_customers as $list_customer) { ?>
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
                                <td><?php echo $list_customer->name; ?></td>
                                <td><?php echo $list_customer->city_name; ?></td>
                                <td><?php echo $list_customer->contact_no; ?></td>
                                <td style="text-align: right;"><?php echo $list_customer->business_address; ?></td>
                                <td style="text-align: right;"><?php echo $list_customer->address; ?></td>
                                <td style="text-align: right;"><?php echo $list_customer->account_holder_name; ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No record is available</td>
                        </tr>
                    <?php

                    } ?>
                </tbody>
            </table>
        </div>

    </div>
    <script>
        $(document).ready(function() {

            $('#header').on('change', function() {
                const header_info = $(this).val();
                let payload = {
                    flag: 'list_sub_headers',
                    header_id: header_info,
                }

                $.ajax({
                    url: 'Views/actions/general_actions.php',
                    type: 'POST',
                    data: payload,

                    beforeSend: function() {
                        $('.btn-primary').html('wait....');
                        console.log(`I am before send.....`);
                    },

                    success: function(data) {
                        $('#sub_header').html(data);
                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);

                    }
                })
            });


            $('#add_customer').on('click', function(e) {
                e.preventDefault();

                let payload = {
                    flag: 'add_customer',
                    account_holder_name: $('#account_holder_name').val(),
                    header_id: $('#header').val(),
                    sub_header_id: $('#sub_header').val(),
                    address: $('#address').val(),
                    business_address: $('#business_address').val(),
                    city_id: $('#city').val(),
                    contact_no: $('#contact_no').val()
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
                        $('#error_account_holder_name').html('');
                        $('#error_address').html('');
                        $('#error_business_address').html('');
                        $('#error_contact_no').html('');
                        $('#error_city').html('');

                        let response = JSON.parse(data);
                        if (response.success == false) {
                            response.errors.account_holder_name ? $('#error_account_holder_name').html(response.errors.account_holder_name) : '';
                            response.errors.header_id ? $('#error_header').html(response.errors.header_id) : '';
                            response.errors.sub_header_id ? $('#error_sub_header').html(response.errors.sub_header_id) : '';
                            response.errors.business_address ? $('#error_business_address').html(response.errors.business_address) : '';
                            response.errors.address ? $('#error_address').html(response.errors.address) : '';
                            response.errors.contact_no ? $('#error_contact_no').html(response.errors.contact_no) : '';
                            response.errors.city_id ? $('#error_city').html(response.errors.city_id) : '';
                            $('.btn-primary').html('Save');
                            return;
                        }

                        $('.btn-primary').html('Save');
                        $('.text-success').html(response.message).show();
                        $('#error_account_holder_name').html('');
                        $('#error_address').html('');
                        $('#error_business_address').html('');
                        $('#error_contact_no').html('');
                        $('#error_city').html('');


                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);

                    }
                })
            });
        });

        // jQuery Data Table
        $('#myTable').DataTable({
            response: true
        });
    </script>
    <style>
        .text-success {
            display: none;
        }
    </style>