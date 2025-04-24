<div class="container">

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"> وصولی بک</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>

    </div>
    <form id="gj_form" action="" method="POST">
        <div class="form-group">
            <span class="text-success"></span>
            <span class="text-danger"></span>
        </div>

        <div class="form-group" style="text-align: right;">
            <label for="collection_date">
                <h5>
                    تاریخ
                </h5>
            </label>
            <input type="date" id="collection_date" name="collection_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
            </select>
            <span class="text-danger" id="error_collection_date"></span>
        </div>
        <button type="submit" id="get_collection" class="btn btn-primary">Add</button>
    </form>

    <div style="overflow: auto;" id="list_collection"></div>
</div>

<script>
    $(document).ready(function() {
        $('#collection_date').on('change', function(e) {
            e.preventDefault();
            let payload = {
                collection_date: $('#collection_date').val()
            }

            $.ajax({
                url: 'Views/reports/list_collection.php',
                type: 'POST',
                data: payload,

                success: function(data) {
                    $('#list_collection').html(data)
                    console.log(data);
                },
                error: function(request, status, error) {
                    console.log(request.responseText);

                }
            })
        })
    });
</script>