<?php

include_once('../../autoload.php');
ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Controllers\GeneralController;

$obj_general = new GeneralController;

if ($_POST['flag'] == 'list_sub_headers') {
    $list_sub_headers = $obj_general->listSubHeaders($_POST['header_id']);
?>
    <option value="">Select a Sub Header</option>
    <option value="" disabled>--------------------------------</option>
    <?php
    foreach ($list_sub_headers as $list_sub_header) {
    ?>
        <option value="<?php echo $list_sub_header->id; ?>"><?php echo $list_sub_header->sub_header_name; ?></option>
<?php
    }
}
