<?php

include_once(realpath(__DIR__) . '/../../autoload.php');

use Controllers\AuthController;

$auth_obj = new AuthController;
if (isset($_SESSION['admin'])) {
    $user_array = $_SESSION['admin'];
    $user_info = $_SESSION['admin']->name . ' (' . ucfirst($_SESSION['admin']->role) . ')';
} elseif (isset($_SESSION['munshi'])) {
    $user_array = $_SESSION['munshi'];
    $user_info = $_SESSION['munshi']->name . ' (' . ucfirst($_SESSION['munshi']->role) . ')';
} elseif (isset($_SESSION['owner'])) {
    $user_array = $_SESSION['owner'];
    $user_info = $_SESSION['owner']->name . ' (' . ucfirst($_SESSION['owner']->role) . ')';
}
?>
<!-- <nav>
    <ul>
        <a href="index.php">
            <li>Home</li>
        </a>
        <a href="index.php?route=purchase">
            <li>Manage Purchases</li>
        </a>
        <a href="index.php?route=customer">
            <li>Manage Customers</li>
        </a>

        <a href="index.php?route=items">
            <li>Manage Items</li>
        </a>

        <a href="<?php // $auth_obj->logout();
                    ?>">
            <li>Logout</li>
        </a>
    </ul>
</nav> -->
<?php
// } elseif ($_SESSION['munshi']) {
?>
<!-- <nav>
        <ul>
            <li>Home</li>
            <li>Manage Customers</li>
            <a href="<?php //$auth_obj->logout(); 
                        ?>">
                <li>Logout</li>
            </a>
        </ul>
    </nav> -->
<?php
// }





// $ContObj->logChkpharmaAdmin();
?>

<div>
    <div class="head" style="width: 100%;">
        <div class="header"></div>
        <input type="checkbox" id="check">
        <label for="check" class="ToggleMenu">
            <div class="navigation" accesskey="m">
                <div class="top"></div>
                <div class="middle"></div>
                <div class="bottom"></div>
            </div>
        </label>

        <div class="firmNm">
            <h5>MF & Co.</h5>
            <h6>Vegetable Dealer</h6>
        </div>
        <div class="sideBar">
            <ul class="sideMenu">
                <!-- <li>
					<i class='fas fa-pills'></i>&nbsp;
					Inventory<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						
						<a href="index?route=invTray" accesskey="i">
							<li>
								<i class='fas fa-file' accesskey="v"></i>
								&nbsp;<u>I</u>nvoice
							</li>
						</a>

						<a href="index?route=retPurStk">
							<li>
								<i class='fas fa-undo'></i>
								&nbsp;<u>R</u>eturn Stock
							</li>
						</a>

						<a href="index?route=purTray" accesskey="p">
							<li><i class="fas fa-shopping-cart"></i>
								<u>P</u>urchase Stock Menu
							</li>
						</a>

						<a href="index?route=gjTray" accesskey="j">
							<li><i class="fas fa-shopping-cart"></i>
								General<u>J</u>ournal
							</li>
						</a>
						
					</ul>
				</li> -->

                <!-- <li>
					<i class="fas fa-search"></i>&nbsp;
					New<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?route=addSubHdAcc" accesskey="v"><li>Sub Headers</li></a>
						<a href="index?route=cusTp" accesskey="t"><li>Customer Type</li></a>
						<a href="index?route=addAccCus" accesskey="a"><li>Customer Account</li></a>
						<a href="index?route=addTown" accesskey=""><li>Town</li></a>
						<a href="index?route=addSlMan" accesskey=""><li>Salesman</li></a>
						<a href="index?route=addDlMan" accesskey=""><li>Deliveryman</li></a>
						<a href="index?route=addAccLed" accesskey="t"><li>Ledger Account</li></a>
					</ul>
				</li> -->

                <li>
                    <!-- <i class="fas fa-users"></i>&nbsp;
                    Users Operations<i class="fas fa-caret-right" id="animate"></i>
                    <ul class="subMenu"> -->
                    <a href="index" accesskey="u">
                <li>City Management</li>
                </a>
                <!-- <a href="index?route=slManTrgt" accesskey="v"><li>Salesman Target</li></a> -->
                <a href="index?route=customer" accesskey="g">
                    <li>Account Management</li>
                </a>
                <a href="index?route=items" accesskey="s">
                    <li>Items Management</li>
                </a>

                <a href="index?route=purchases" accesskey="s">
                    <li>Items Management</li>
                </a>

                <a href="index?route=users_management" accesskey="s">
                    <li>Users Management</li>
                </a>
                <!-- </ul> -->
                </li>

                <!-- <li>
					<i class="fas fa-shuttle-van"></i>&nbsp;
					Van<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?route=slInvDSS" accesskey="s"><li>DSS / Loading</li></a>
						<a href="index?route=slManTrgt" accesskey="v"><li>Salesman Target</li></a>
					</ul>
				</li> -->

                <!-- <li>
					<i class="fas fa-folder-open" accesskey="r"></i>&nbsp;
					Reports&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?route=rptDwAcc" accesskey="d"><li>Date Wise Account Report</li></a>
						<a href="index?route=rptDwSHd" accesskey=""><li>Sub-Header Wise Account Report</li></a>
						<a href="index?route=rptCompDW" accesskey="r"><li>Date Wise Company Report</li></a>
						<a href="index?route=rptCompCusDW&action=CG" accesskey="g"><li>Group Wise Report</li></a>
						<a href="index?route=rptCompCusDW&action=CC" accesskey="c"><li>Customer Company Report</li></a>
					</ul>
				</li> -->

                <!-- 				<li>
					<i class="fas fa-briefcase-medical"></i>&nbsp;
					Company&nbsp;<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?route=addComp" accesskey="c"><li><u>C</u>ompany</li></a>
						<a href="index?route=addGrp" accesskey="g"><li><u>G</u>roup</li></a>
						<a href="index?route=addPrd" accesskey="u"><li>Prod<u>u</u>ct</li></a>
					</ul>
				</li> -->

                <li>
                    <i class="fas fa-link"></i>&nbsp;
                    Connect&nbsp;<i class="fas fa-caret-right" id="animate"></i>
                    <ul class="subMenu">
                        <a href="index?route=compPrivilege" accesskey="r">
                            <li>Company / Group P<u>r</u>ivilege</li>
                        </a>
                        <!-- <a href="index?route=addGrp" accesskey="g"><li><u>G</u>roup</li></a>
						<a href="index?route=addPrd" accesskey="u"><li>Prod<u>u</u>ct</li></a> -->
                    </ul>
                </li>

            </ul>

        </div>

        <div class="topMenu">
            <div>
                <a href="index">
                    <i class="fa fa-dashboard">&#xf0e4</i>
                </a>
            </div>

            <div>
                <a href="index?route=purchase">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>

            <div>
                <a href="index?route=kachi_book">
                    <i class="fa fa-balance-scale"></i>
                </a>
            </div>

            <div>
                <a href="index?route=mandi_book">
                    <i class="fa fa-book"></i>
                </a>
            </div>

            <div>
                <a href="index?route=general_journal">
                    <i class="fa fa-book-open"></i>
                </a>
            </div>

            <input type="checkbox" id="cart">
            <label for="cart">
                <div>
                    <!-- <a href=""> -->
                    <i class="fa fa-bell"></i>
                    <!-- </a> -->
                    <span id="cart_count" style="color: red;"></span>
                </div>
            </label>

            <div style="width: auto;" class="top_user_info">
                <?php
                echo $user_info;
                ?>
            </div>

            <div class="top_user_info">
                <a href="">
                    <a href="logout" accesskey="l"><i class="fa fa-sign-out"></i></a>
                </a>
            </div>
            <div class="kachi_cart" style="width: 100%;">
                <div style="overflow: auto;" id="view_kachi_report_unsaved"></div>
            </div>
        </div>
    </div>
    <!-- <div class="col-50">
		<div class="header"></div>
	</div> -->
</div>