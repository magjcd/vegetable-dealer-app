<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Updated</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <?php
    // ini_set('display_error', 1);
    // include_once('autoload.php');
    // session_start();

    // use Controllers\AuthController;

    // $auth_obj = new AuthController;

    // if (count($_SESSION) > 0) {
    //     header('location: index');
    // }

    // if (isset($_POST['login'])) {

    //     $response = $auth_obj->login($_POST);
    //     // echo '<pre>';
    //     // print_r($response);
    //     // echo '</pre>';

    //     $error_email = isset($response['email']) ? $response['email'] : '';
    //     $error_password = isset($response['password']) ? $response['password'] : '';
    //     $error_logged = isset($response['logged']) ? $response['logged'] : '';

    //     // if (in_array('email', $response)) {
    //     //     echo 'email';
    //     // }

    //     // $error_email = in_array('email', $response) ? $response['email'] : '';
    //     // $error_password = in_array('password', $response) ? $response['password'] : '';
    // }

    ?>

    <!-- <div class="container" style="margin-top: 200px; border: 1px solid #000; background-color: skyblue; border-radius: 5px; padding:50px; width: 550px;">
        <h2>Login</h2>
        <form id="login_form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                <span class="text-danger" id="error_email"><?php // echo $error_email; 
                                                            ?></span>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                <span class="text-danger" id="error_password"><?php // echo $error_password; 
                                                                ?></span>

            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary" name="login" id="login">Login</button>
        </form>
    </div> -->

    <div class="container mt-5" style="border: 1px solid #000; background-color: skyblue; border-radius: 5px; padding:50px;">
        <h2>Login</h2>
        <form id="login_form">

            <div class="mb-3 mt-3">
                <p class="text-danger text-center un-success"></p>
            </div>
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                <span class="text-danger" id="error_email"><?php echo $error_email; ?></span>

            </div>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                <span class="text-danger" id="error_password"><?php echo $error_password; ?></span>

            </div>
            <div class="form-check mb-3">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" id="login" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#login').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'Views/actions.php',
                type: 'POST',
                data: {
                    flag: 'login',
                    email: $('#email').val(),
                    password: $('#password').val()
                },

                beforeSend: function() {
                    $('.btn-primary').html('wait....');
                    console.log(`I am before send.....`);
                },

                success: function(data) {
                    let response = JSON.parse(data);
                    if (response.success == false) {
                        $('#error_email').InnerHTML = '';
                        $('#error_password').InnerHTML = '';
                        // console.log(response.invalid_credentials)
                        // return;
                        if (response.invalid_credentials) {
                            $('.un-success').html(response.invalid_credentials)
                            $('.btn-primary').html('Login');
                            return;
                        } else if (response.active_status) {
                            $('.un-success').html(response.active_status)
                            $('.btn-primary').html('Login');
                            return;
                        } else if (response.errors) {
                            response.errors.email ? $('#error_email').html(response.errors.email) : '';
                            response.errors.password ? $('#error_password').html(response.errors.password) : '';
                            $('.btn-primary').html('Login');
                            return;
                        }
                    }
                    $('.btn-primary').html('Login');

                    window.location.replace(`index`);

                },
                error: function() {

                }
            })
        });
    })
</script>