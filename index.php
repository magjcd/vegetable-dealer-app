<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <title> محمد علی، فرحان علی قادری اینڈ برادرز - سبزی مندی</title> -->
    <title> محمد علی اینڈ سنز - سبزی منڈی</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="./public/style.css" />
    <link rel="stylesheet" href="./public/top_navigation.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link href='https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/affa3c5e5a.js"></script>

    <!-- Sweet Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <!-- CounterJS -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js" integrity="sha512-ZKNVEa7gi0Dz4Rq9jXcySgcPiK+5f01CqW+ZoKLLKr9VMXuCsw3RjWiv8ZpIOa0hxO79np7Ec8DDWALM0bDOaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js" integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>

<body class="container-fluid">
    <?php

    // KEEP THEM COMMENTED IN PRODUCTION ENVIRONMENT
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);

    include_once('./autoload.php');

    use Controllers\AuthController;
    use Controllers\AccountController;
    use Controllers\FinanacialController;
    use Controllers\GeneralController;
    use Controllers\ItemController;
    use Controllers\PurchaseController;
    use Controllers\RoleController;
    use Controllers\SellController;
    use Controllers\UserController;

    $obj_user = new UserController;
    $obj_auth = new AuthController;
    $obj_general = new GeneralController;
    $obj_account = new AccountController;
    $obj_item = new ItemController;
    $obj_sell = new SellController;
    $obj_purchase = new PurchaseController;
    $obj_financial = new FinanacialController;
    $obj_role = new RoleController;


    date_default_timezone_set("Asia/Karachi");
    echo date_default_timezone_get();

    if (count($_SESSION) == 0) {
        header('location: login');
    }


    include_once('./Views/layout/top_navigation.php');
    echo '<div style="margin-top: 100px;"></div>';
    // echo '<pre>';
    // print_r($_SESSION['accountant']->role);
    if (isset($_GET['route'])) {
        $route = $_GET['route'];
        $path = 'Views/' . $route . '.php';
        if (file_exists($path)) {
            include($path);
        } else {
            echo 'no route found with this name';
        }
    } elseif (isset($_GET['migration_route'])) {
        $migration_route = $_GET['migration_route'];
        $migration_path = 'database/migrations/' . $migration_route . '.php';
        if (file_exists($migration_path)) {
            include($migration_path);
        } else {
            echo 'no migration_route found with this name';
        }
    } else {
        include_once(__DIR__ . '/Views/layout/dashboard.php');
    }
    echo '<div style="margin-bottom: 50px;"></div>';
    include_once('./Views/layout/footer.php');
    ?>

</body>

</html>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>