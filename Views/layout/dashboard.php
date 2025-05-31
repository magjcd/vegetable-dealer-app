<?php
if (isset($_SESSION['owner'])) {
    include_once((realpath(__DIR__) . '/owner_dashboard.php'));
} elseif (isset($_SESSION['admin'])) {
    include_once((realpath(__DIR__) . '/admin_dashboard.php'));
} elseif (isset($_SESSION['accountant'])) {
    include_once((realpath(__DIR__) . '/accountant_dashboard.php'));
} elseif (isset($_SESSION['munshi'])) {
    include_once((realpath(__DIR__) . '/user_dashboard.php'));
}
