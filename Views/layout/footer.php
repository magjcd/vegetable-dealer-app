<?php
if (isset($_SESSION['admin'])) {
    $user_array = $_SESSION['admin'];
    $user_info = $_SESSION['admin']->name . ' (' . ucfirst($_SESSION['admin']->role) . ')';
} elseif (isset($_SESSION['munshi'])) {
    $user_array = $_SESSION['munshi'];
    $user_info = $_SESSION['munshi']->name . ' (' . ucfirst($_SESSION['munshi']->role) . ')';
} elseif (isset($_SESSION['accountant'])) {
    $user_array = $_SESSION['accountant'];
    $user_info = $_SESSION['accountant']->name . ' (' . ucfirst($_SESSION['accountant']->role) . ')';
} elseif (isset($_SESSION['owner'])) {
    $user_array = $_SESSION['owner'];
    $user_info = $_SESSION['owner']->name . ' (' . ucfirst($_SESSION['owner']->role) . ')';
}
?>
<div class="footer">

    <div>
        <a href="index?route=customer">
            <i class="fa fa-user-circle"></i>
        </a>
    </div>

    <div>
        <a href="index?route=collection">
            <i class="fa fa-dollar-sign"></i>
        </a>
    </div>

    <div>
        <a href="index.php?route=account_details">
            <i class="fa fa-file"></i>
        </a>
    </div>

    <div style="width: auto;" class="footer_user_info">
        <?php
        echo $user_info;
        ?>
    </div>

    <div class="footer_user_sign_out">
        <a href="">
            <a href="logout" accesskey="l"><i class="fa fa-sign-out"></i></a>
        </a>
    </div>

</div>