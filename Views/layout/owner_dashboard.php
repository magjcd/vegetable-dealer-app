<div class="dashboard-main-container">
    <div>
        <h4>Dashboard</h4>
        <?php

        use Controllers\DashboardController;

        include_once('./autoload.php');
        $obj_dash = new DashboardController;
        // echo json_encode($obj_dash->monthlyChartCollection())

        // echo '<pre>';
        // if (gc_enabled()) gc_collect_cycles();
        // print_r(gc_status());
        // print_r($obj_dash->monthlyChartCollection());

        ?>

        <div>
            <input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>" hidden />
        </div>
        <div class="dashboard_boxes red_card" style="">
            <p>
                <b>
                    <h4 style="border-bottom: 1px solid #fff;">ٹوٹل منڈی</h4>
                </b>
                <a href="index?route=mandi_book" class="card_hyper_link" style="text-decoration: none; color: #fff;">
                    <table style="text-align: right; margin-right: 5px; width: 100%;">
                        <tr>
                            <td><span id="day_sell" class="counter">0.00</span></td>
                            <th><span>آج کی منڈی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                        <tr>
                            <td><span id="month_sell" class="counter">0.00</span></td>
                            <th><span>اس مہینے کی منڈی&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                    </table>
                </a>
            </p>
        </div>
        &nbsp;

        <div class="dashboard_boxes green_card" style="background-color: green; color: #fff;">

            <p>
                <b>
                    <h4 style="border-bottom: 1px solid #fff;">وصول رقم</h4>
                </b>
                <a href="index?route=collection" class="card_hyper_link" style="text-decoration: none; color: #fff;">

                    <table style="text-align: right; margin-right: 5px; width: 100%;">
                        <tr>
                            <td><span id="day_collection" class="counter">0.00</span></td>
                            <th><span>آج کی وصول رقم&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                        <tr>
                            <td><span id="month_collection" class="counter">0.00</span></td>
                            <th><span> اس مہینے کی وصول رقم&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                    </table>
                </a>
            </p>
        </div>
        &nbsp;

        <div class="dashboard_boxes blue_card" style="background-color: blue; color: #fff;">
            <p>
                <b>
                    <h4 style="border-bottom: 1px solid #fff;">بینک</h4>
                </b>
                <a href="#" class="card_hyper_link" style="text-decoration: none; color: #fff;">
                    <table style="text-align: right; margin-right: 5px; width: 100%;">

                        <tr>
                            <td><span class="counter" id="day_bank_position">0.00</span></td>
                            <th><span>آج کا ڈپوزٹ&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>

                        <tr>
                            <td><span class="counter" id="month_bank_position">0.00</span></td>
                            <th><span> اس مہینے کا ڈپوزٹ&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>

                        <tr>
                            <td colspan="2" style="border-bottom: 1px solid #fff;"></td>
                        </tr>

                        <tr>
                            <td><span class="counter">0.00</span></td>
                            <th><span>ٹوٹل بیلینس&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>

                        <tr>
                            <td colspan="2" style="border-bottom: 1px double #fff;"></td>
                        </tr>

                    </table>
                </a>
            </p>
        </div>
        &nbsp;

        <div class="dashboard_boxes yellow_card" style="background-color: yellow; color: #000;">
            <p>
                <b>
                    <h4 style="border-bottom: 1px solid #000;">کیش فلو</h4>
                </b>
                <a href="#" class="card_hyper_link" style="text-decoration: none; color: #000;">

                    <table style="text-align: right; margin-right: 5px; width: 100%;">
                        <tr>
                            <td><span class="counter">0.00</span></td>
                            <th><span>کیش ان&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                        <tr>
                            <td><span class="counter">0.00</span></td>
                            <th><span> کیش آؤٹ&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                        </tr>
                    </table>
                </a>
            </p>
        </div>
    </div> <!-- End Main Cards -->

    <div> <!-- Sell ChartJS -->
        <canvas id="sellChart" style="width:100%;max-width:1440px; margin-left:auto; margin-right:auto; display: block;"></canvas>
    </div>

    <div> <!-- Sell ChartJS -->
        <canvas id="collectionChart" style="width:100%;max-width:1000px; margin-left:auto; margin-right:auto; display: block;"></canvas>
    </div>

    <div class="monthly_statistics mt-4" style="width:100%;max-width:1440px; margin-left:auto; margin-right:auto;">
        <div style="display:inline-block; border: 0px solid #000; border-radius: 5px; background-color: #f2f2f2; width:48%; height:200px; box-shadow: -10px 12px 8px rgb(102, 99, 99);">
            <h4 class="mt-3">Vendor of the Month</h4>
            <h3>اللہ دتہ ساہیوال</h3>
            <p><span>This Month</span> <span class="counter">3500000</span></p>
            <p><span>Previous Month</span> <span class="counter">3500000</span></p>
        </div>
        <div style="display:inline-block; border: 0px solid #000; border-radius: 5px; background-color: #f2f2f2; width:48%; height:200px; box-shadow: 10px 12px 8px rgb(102, 99, 99);">
            <h4 class="mt-3">Customer of the Month</h4>
            <h3>حامد علی جیکب آباد</h3>
            <p><span>This Month</span> <span class="counter">3500000</span></p>
            <p><span>Previous Month</span> <span class="counter">3500000</span></p>
        </div>
    </div>
</div>



<script type="text/javascript">
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

                success: function(data) {
                    console.log(data);

                    $('#month_collection').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        function day_bank_position(date) {

            let payload = {
                flag: 'dashboard_day_bank_position',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#day_bank_position').html(data);
                },

                error: function(request, status, error) {
                    console.log(error);
                }

            })
        }

        function monthly_bank_position(date) {

            let payload = {
                flag: 'dashboard_monthly_bank_position',
                date: date
            }

            $.ajax({
                url: 'Views/actions/dashboard_actions.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    console.log(data);

                    $('#month_bank_position').html(data);
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
        day_bank_position();
        monthly_bank_position();

    })


    // Sell ChartJS
    var xValues = ["جنوری", "فیبروری", "مارچ", "اپریل", "مئی", "جون", "جولائی", "اگست", "ستمبر", "اکتوبر", "نومبر", "دسمبر"];
    // var yValues = [55, 49, 44, 24, 33, 30, 35, 40, 38, 42, 55, 34];
    var barColors = ["red", "green", "blue", "orange", "brown", "purple", "green", "darkgray", "black", "green", "orange", "purple"];

    new Chart("sellChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: <?php echo json_encode($obj_dash->monthlyChartSell()); ?>
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "منتھلی سیل"
            }
        }
    });

    // Collection ChartJS
    var xValues = ["جنوری", "فیبروری", "مارچ", "اپریل", "مئی", "جون", "جولائی", "اگست", "ستمبر", "اکتوبر", "نومبر", "دسمبر"];
    // var yValues = [55, 49, 44, 24, 33, 30, 35, 40, 38, 42, 55, 34];
    var barColors = ["red", "green", "blue", "orange", "brown", "purple", "green", "darkgray", "black", "green", "orange", "purple"];

    new Chart("collectionChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: <?php echo json_encode($obj_dash->monthlyChartCollection()); ?>
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "منتھلی کلیکشن"
            }
        }
    });

    setTimeout(function() {

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    }, 500)
</script>