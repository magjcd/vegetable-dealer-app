<?php

include_once(realpath(__DIR__) . '/../../autoload.php');

use Controllers\AuthController;

// if ($_SESSION['admin']) {
$auth_obj = new AuthController;
?>
<!-- <nav>
    <ul>
        <a href="index.php">
            <li>Home</li>
        </a>
        <a href="index.php?page=purchase">
            <li>Manage Purchases</li>
        </a>
        <a href="index.php?page=customer">
            <li>Manage Customers</li>
        </a>

        <a href="index.php?page=items">
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
						
						<a href="index?page=invTray" accesskey="i">
							<li>
								<i class='fas fa-file' accesskey="v"></i>
								&nbsp;<u>I</u>nvoice
							</li>
						</a>

						<a href="index?page=retPurStk">
							<li>
								<i class='fas fa-undo'></i>
								&nbsp;<u>R</u>eturn Stock
							</li>
						</a>

						<a href="index?page=purTray" accesskey="p">
							<li><i class="fas fa-shopping-cart"></i>
								<u>P</u>urchase Stock Menu
							</li>
						</a>

						<a href="index?page=gjTray" accesskey="j">
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
						<a href="index?page=addSubHdAcc" accesskey="v"><li>Sub Headers</li></a>
						<a href="index?page=cusTp" accesskey="t"><li>Customer Type</li></a>
						<a href="index?page=addAccCus" accesskey="a"><li>Customer Account</li></a>
						<a href="index?page=addTown" accesskey=""><li>Town</li></a>
						<a href="index?page=addSlMan" accesskey=""><li>Salesman</li></a>
						<a href="index?page=addDlMan" accesskey=""><li>Deliveryman</li></a>
						<a href="index?page=addAccLed" accesskey="t"><li>Ledger Account</li></a>
					</ul>
				</li> -->

                <li>
                    <!-- <i class="fas fa-users"></i>&nbsp;
                    Users Operations<i class="fas fa-caret-right" id="animate"></i>
                    <ul class="subMenu"> -->
                    <a href="index" accesskey="u">
                <li>City Management</li>
                </a>
                <!-- <a href="index?page=slManTrgt" accesskey="v"><li>Salesman Target</li></a> -->
                <a href="index?page=customer" accesskey="g">
                    <li>Account Management</li>
                </a>
                <a href="index?page=items" accesskey="s">
                    <li>Items Management</li>
                </a>

                <a href="index?page=purchases" accesskey="s">
                    <li>Items Management</li>
                </a>
                <!-- </ul> -->
                </li>

                <!-- <li>
					<i class="fas fa-shuttle-van"></i>&nbsp;
					Van<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?page=slInvDSS" accesskey="s"><li>DSS / Loading</li></a>
						<a href="index?page=slManTrgt" accesskey="v"><li>Salesman Target</li></a>
					</ul>
				</li> -->

                <!-- <li>
					<i class="fas fa-folder-open" accesskey="r"></i>&nbsp;
					Reports&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?page=rptDwAcc" accesskey="d"><li>Date Wise Account Report</li></a>
						<a href="index?page=rptDwSHd" accesskey=""><li>Sub-Header Wise Account Report</li></a>
						<a href="index?page=rptCompDW" accesskey="r"><li>Date Wise Company Report</li></a>
						<a href="index?page=rptCompCusDW&action=CG" accesskey="g"><li>Group Wise Report</li></a>
						<a href="index?page=rptCompCusDW&action=CC" accesskey="c"><li>Customer Company Report</li></a>
					</ul>
				</li> -->

                <!-- 				<li>
					<i class="fas fa-briefcase-medical"></i>&nbsp;
					Company&nbsp;<i class="fas fa-caret-right" id="animate"></i>
					<ul class="subMenu">
						<a href="index?page=addComp" accesskey="c"><li><u>C</u>ompany</li></a>
						<a href="index?page=addGrp" accesskey="g"><li><u>G</u>roup</li></a>
						<a href="index?page=addPrd" accesskey="u"><li>Prod<u>u</u>ct</li></a>
					</ul>
				</li> -->

                <li>
                    <i class="fas fa-link"></i>&nbsp;
                    Connect&nbsp;<i class="fas fa-caret-right" id="animate"></i>
                    <ul class="subMenu">
                        <a href="index?page=compPrivilege" accesskey="r">
                            <li>Company / Group P<u>r</u>ivilege</li>
                        </a>
                        <!-- <a href="index?page=addGrp" accesskey="g"><li><u>G</u>roup</li></a>
						<a href="index?page=addPrd" accesskey="u"><li>Prod<u>u</u>ct</li></a> -->
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
                <a href="index?route=customer">
                    <i class="fa fa-user-circle"></i>
                </a>
            </div>

            <div>
                <a href="index?route=purchase">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>

            <div>
                <a href="index?route=items">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>

            <div>
                <a href="">
                    <a href="logout" accesskey="l"><i class="fa fa-sign-out"></i></a>
                </a>
            </div>

            <div style="width: auto;">
                <?php
                echo 'Admin';
                ?>
            </div>

        </div>
    </div>
</div>