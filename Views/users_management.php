<?php
ini_set('display_error', 1);
$list_roles = $obj_role->listRoles();
?>
<u>
    <h3 style="text-align: center;">یوزرس مینیجمینٹ</h3>
</u>


<div class="container">
    <!-- <h3 style="text-align: center;">گاہک کی تفصیل</h3> -->
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        نئے یوزر کا اندراج
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">نئے یوزر کا اندراج</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="user_form">
                        <div class="form-group text-center">
                            <span class="text-success"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="name">
                                <h5>نام</h5>
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="نام" name="name" dir="rtl">
                            <span class="text-danger" id="error_name"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="user_name">
                                <h5>یوزر کا نام</h5>
                            </label>
                            <input type="text" class="form-control" id="user_name" placeholder="یوزر کا نام" name="user_name">
                            <span class="text-danger" id="error_user_name"></span>
                        </div>

                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">Select a Role</option>
                                <option value="" disabled>--------------------------------</option>
                                <?php
                                foreach ($list_roles as $list_role) {
                                ?>
                                    <option value="<?php echo $list_role->id . '|' . $list_role->role_name; ?>"><?php echo $list_role->role_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger" id="error_role"></span>
                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="address">
                                <h5>پتہ</h5>
                            </label>
                            <textarea id="address" class="form-control" name="address" placeholder="پتہ" dir="rtl"></textarea>
                            <span class="text-danger" id="error_address"></span>

                        </div>

                        <div class="form-group" style="text-align: right;">
                            <label for="contact_no">
                                <h3>رابطہ نمبر</h3>
                            </label>
                            <input type="text" class="form-control" id="contact_no" placeholder="+92 333 123 4567" name="contact_no">
                            <span class="text-danger" id="error_contact_no"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="add_user" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div> -->

            </div>
        </div>
    </div>

    <div id="list_users"></div>

</div>
<script>
    $(document).ready(function() {
        $('#add_user').on('click', function(e) {
            e.preventDefault();

            let payload = {
                flag: 'add_user',
                name: $('#name').val(),
                user_name: $('#user_name').val(),
                role: $('#role').val(),
                address: $('#address').val(),
                contact_no: $('#contact_no').val()
            }

            $.ajax({
                url: 'Views/actions/user_actions.php',
                type: 'POST',
                data: payload,

                beforeSend: function() {
                    $('.btn-primary').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    $('#error_name').html('');
                    $('#error_address').html('');
                    $('#error_user_name').html('');
                    $('#error_contact_no').html('');
                    $('#error_role').html('');

                    let response = JSON.parse(data);
                    if (response.success == false) {
                        response.errors.name ? $('#error_name').html(response.errors.name) : '';
                        response.errors.user_name ? $('#error_user_name').html(response.errors.user_name) : '';
                        response.errors.address ? $('#error_address').html(response.errors.address) : '';
                        response.errors.contact_no ? $('#error_contact_no').html(response.errors.contact_no) : '';
                        response.errors.role ? $('#error_role').html(response.errors.role) : '';
                        $('.btn-primary').html('Add');
                        return;
                    }

                    $('.btn-primary').html('Add');
                    $('.text-success').html(response.message).show();
                    console.log(data);
                    listUsers();
                    $('#user_form').trigger("reset");

                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        });
    });

    // On page load this report
    function listUsers() {
        $.ajax({
            url: 'Views/reports/list_users.php',
            type: 'POST',

            success: function(data) {
                $('#list_users').html(data);
            },
            error: function(request, status, error) {
                console.log(request.responseText);

            }
        })
    }
    listUsers();

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