<div class="dashboard-main-container">
    <h4>Dashboard</h4>
    <?php
    // echo '<pre>';
    // if (gc_enabled()) gc_collect_cycles();
    // print_r(gc_status());
    ?>
    <div>
        <input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>" hidden />
    </div>
    <div class="dashboard_boxes" style="background-color: red; color: #fff;">
        <p>
            <b>
                <h4 style="border-bottom: 1px solid #fff;">ٹوٹل منڈی</h4>
            </b>
        <table style="text-align: right; margin-right: 5px; width: 100%;">
            <tr>
                <td><span id="day_sell">2,10,000</span></td>
                <th><span>آج کی منڈی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
            <tr>
                <td><span id="month_sell">50,10,000</span></td>
                <th><span>اس مہینے کی منڈی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
        </table>
        </p>
    </div>
    &nbsp;

    <div class="dashboard_boxes" style="background-color: green; color: #fff;">

        <p>
            <b>
                <h4 style="border-bottom: 1px solid #fff;">وصولی</h4>
            </b>
        <table style="text-align: right; margin-right: 5px; width: 100%;">
            <tr>
                <td><span id="day_collection">2,10,000</span></td>
                <th><span>آج کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
            <tr>
                <td><span id="month_collection">50,10,000</span></td>
                <th><span> اس مہینے کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
        </table>
        </p>
    </div>
    &nbsp;

    <div class="dashboard_boxes" style="background-color: blue; color: #fff;">
        <p>
            <b>
                <h4 style="border-bottom: 1px solid #fff;">وصولی</h4>
            </b>
        <table style="text-align: right; margin-right: 5px; width: 100%;">
            <tr>
                <td><span>2,10,000</span></td>
                <th><span>آج کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
            <tr>
                <td><span>50,10,000</span></td>
                <th><span> اس مہینے کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
        </table>
        </p>
    </div>
    &nbsp;

    <div class="dashboard_boxes" style="background-color: yellow; color: #000;">
        <p>
            <b>
                <h4 style="border-bottom: 1px solid #000;">وصولی</h4>
            </b>
        <table style="text-align: right; margin-right: 5px; width: 100%;">
            <tr>
                <td><span>2,10,000</span></td>
                <th><span>آج کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
            <tr>
                <td><span>50,10,000</span></td>
                <th><span> اس مہینے کی وصولی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
        </table>
        </p>
    </div>
</div>

<script>
    $(document).ready(function() {
        const date = $('#to_date').val();

        function daily_sell(date) {

            let payload = {
                flag: 'dashboard_daily_sell',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                // beforeSend: function() {
                //     $('#get_account_details').html('wait....');
                // },

                success: function(data) {
                    $('#day_sell').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        function monthly_sell(date) {

            let payload = {
                flag: 'dashboard_monthly_sell',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                // beforeSend: function() {
                //     $('#get_account_details').html('wait....');
                // },

                success: function(data) {
                    console.log(data);

                    $('#month_sell').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        function daily_collection(date) {

            let payload = {
                flag: 'dashboard_daily_collection',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                // beforeSend: function() {
                //     $('#get_account_details').html('wait....');
                // },

                success: function(data) {
                    $('#day_collection').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        function monthly_collection(date) {

            let payload = {
                flag: 'dashboard_monthly_collection',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                // beforeSend: function() {
                //     $('#get_account_details').html('wait....');
                // },

                success: function(data) {
                    console.log(data);

                    $('#month_collection').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        daily_sell();
        monthly_sell();
        daily_collection();
        monthly_collection();
    })
</script>