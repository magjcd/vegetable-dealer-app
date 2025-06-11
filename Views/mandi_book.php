<div class="container">

    <div>
        <h3 style="text-align: center;"> منڈی بک کی تفصیل</h3>
    </div>
    <form id="mandi_book_form" action="index?route=mandi_book" method="POST">

        <div class="form-group">
            <span class="text-success"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="mandi_book_date">
                <h5>
                    تاریخ
                </h5>
            </label>
            <input type="date" id="mandi_book_date" name="mandi_book_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            <span class="text-danger" id="error_sell_date"></span>
            <button type="submit" id="" class="btn btn-primary">Generate Report</button>
        </div>
    </form>

    <?php
    if (isset($_POST['mandi_book_date'])) {
        $list_accs = $obj_sell->listMandiBookAccounts($_POST['mandi_book_date']);
        $mandi_book_day_total = $obj_sell->MandiBookDayTotalAmount($_POST['mandi_book_date']);
    ?>

        <?php

        if (!empty($list_accs)) {
        ?>

            <div style="text-align: center; border-bottom: #000;">
                <h4>
                    <?php echo 'تاریخ: ' . $_POST['mandi_book_date'] . ' منڈی ٹوٹل :' . $mandi_book_day_total->mandi_book_day_total; ?>
                </h4>
                <?php
                foreach ($list_accs as $list_acc) {
                    $mandi_books = $obj_sell->listMandiBook($list_acc['id'], $_POST['mandi_book_date']);
                    $customer_mandi_book_total = $obj_sell->SngCustomerMandiBookTotal($list_acc['id'], $_POST['mandi_book_date'])
                ?>
                    <div class="card-outer-body">
                        <div class="card">

                            <div class="card-body text-right" style="background-color: #f2f2f2;">
                                <h4 class="card-title"><?php echo $list_acc['account_holder_name']; ?></h4>
                                <?php
                                foreach ($mandi_books as $mandi_book) {
                                ?>
                                    <p class="card-text"><?php echo ($mandi_book->sl_qty * $mandi_book->price) . ' = ' . $mandi_book->price .  ' x ' . $mandi_book->item_name . ' ' . $mandi_book->sl_qty; ?></p>
                                <?php } ?>
                                <p><?php echo $customer_mandi_book_total->customer_mandi_total; ?></p>
                                <a href="index?route=account_details" class="btn btn-primary stretched-link">Goto Account</a>
                            </div>
                        </div>
                    </div>
            <?php }
            } else {
                echo 'No Customers are avaialable for this date';
            } ?>
        <?php } ?>
            </div>

</div>

<script>
    // $(document).ready(function() {
    //     $('#myTable').DataTable();

    // })
</script>