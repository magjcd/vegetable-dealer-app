<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class SellController extends Model
{
    public function __construct()
    {
        $this->model = new Model;
    }

    public function sellInvNo()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        $this->sql = $this->model->rawCmd('SELECT COUNT(*) as sell_inv_no FROM `sell_inv_no`');
        while ($this->rows = $this->sql->fetch_object()) {
            $data = $this->rows;
        }
        return $data;
    }

    // Calculating Purchase and Sell for Kachi
    public function availableQty()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;

        $this->sql = $this->model->fetchAll('pur_item_ref');
        while ($this->rows = $this->sql->fetch_object()) {
            $random_nos[] = $this->rows->random_no;
        }
        $new_arr = [];

        if (!empty($random_nos)) {
            foreach ($random_nos as $random_no) {
                $sql_inner = $this->model->rawCmd("SELECT *,SUM(pur_qty) as tot_pur_qty, SUM(sl_qty) as tot_sl_qty FROM `purinvretstk` 
            INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id`
            INNER JOIN `pur_item_ref` ON `purinvretstk`.`random_no` = `pur_item_ref`.`random_no`
            INNER JOIN `cities` ON `purinvretstk`.`customer_city_id` = `cities`.`id`
            INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id`
            WHERE `purinvretstk`.`random_no` = $random_no");
                while ($inner_rows = $sql_inner->fetch_object()) {
                    array_push($new_arr, $this->data = $inner_rows);
                }
            }
        }
        return $new_arr;
    }

    public function kachiItemEntry($payload)
    {
        try {
            $this->model->conn->begin_transaction();
            $this->query = null;
            if (empty($payload['vendor'])) {
                $this->errors['vendor'] = 'Vendor is required';
            }

            if (empty($payload['customer'])) {
                $this->errors['customer'] = 'Customer is required';
            }

            if (empty($payload['qty'])) {
                $this->errors['qty'] = 'Quantity is required';
            }

            if (empty($payload['price'])) {
                $this->errors['price'] = 'Price is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $vendor_info_arr = explode('|', $payload['vendor']);
            $random_no = $vendor_info_arr[0];
            $builty_no = $vendor_info_arr[1];
            $vehicle_no = $vendor_info_arr[2];
            $item_id = $vendor_info_arr[3];
            $item_name = $vendor_info_arr[4];

            $customer_info_arr = explode('|', $payload['customer']);
            $customer_acc_id = $customer_info_arr[0];
            $header_id = $customer_info_arr[1];
            $sub_header_id = $customer_info_arr[2];
            $customer_city_id = $customer_info_arr[3];
            $customer_name = $customer_info_arr[4];
            $customer_city = $customer_info_arr[5];

            $vendor_info_arr = explode('|', $payload['revenue']);
            $sales_rev_id = $vendor_info_arr[0];
            $sales_header_id = $vendor_info_arr[1];
            $sales_sub_header_id = $vendor_info_arr[2];

            // Check if invoice items are available but invoice is not saved and DEO try to post item in an other customer within same invoice no. then halt
            $chech_record_avaialble = $this->model->fetchSingle('purinvretstk', 'inv_no = ' . $payload['sell_inv_no'] . ' AND doc_type = "sell"');
            $available_id = null;
            if ($chech_record_avaialble->num_rows > 0) {
                while ($check_rows = $chech_record_avaialble->fetch_object()) {
                    $available_id = $check_rows->customer_acc_id;
                }
                // echo json_encode(['success' => false, 'errors' => $available_id == $customer_acc_id], 401);

                // die();
                if ($available_id != $customer_acc_id) {
                    $this->errors['customer'] = 'You are trying to post in an other customer';
                    echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                    die();
                }
            }


            $data = [
                'trans_date' => $payload['trans_date'],
                'inv_no' => $payload['sell_inv_no'],
                'random_no' => $random_no,
                'builty_no' => $builty_no,
                'vehicle_no' => $vehicle_no,
                'item_id' => $item_id,
                'customer_acc_id' => $customer_acc_id,
                'header_id' => $header_id,
                'sub_header_id' => $sub_header_id,
                'customer_city_id' => $customer_city_id,
                'sl_qty' => $payload['qty'],
                'price' => $payload['price'],
                'doc_type' => 'sell'
            ];



            $this->query = $this->model->insert('purinvretstk', $data);

            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'sell could not be saved',], 301);
                die();
            }

            $this->model->conn->commit();

            echo json_encode(['success' => true, 'message' => 'item added'], 201);
            die();
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function saveKachiInvoce($payload)
    {
        try {
            $this->model->conn->begin_transaction();
            $check_inv_items = $this->model->fetchSingle('purinvretstk', 'inv_no = ' . $payload['sell_inv_no']);
            if ($check_inv_items->num_rows <= 0) {
                echo json_encode(['success' => false, 'message' => 'please add item in invoice',], 301);
                die();
            }

            if (empty($payload['customer'])) {
                $this->errors['customer'] = 'Customer is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }


            // get the customer information to save the invoice
            // $sql_inner = $this->model->rawCmd("SELECT * FROM `purinvretstk` 
            // INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id`
            // WHERE inv_no = " . $payload['sell_inv_no']);

            $customer_info_arr = explode('|', $payload['customer']);
            $customer_acc_id = $customer_info_arr[0];
            $header_id = $customer_info_arr[1];
            $sub_header_id = $customer_info_arr[2];
            $customer_city_id = $customer_info_arr[3];
            $customer_name = $customer_info_arr[4];
            $customer_city = $customer_info_arr[5];

            $vendor_info_arr = explode('|', $payload['revenue']);
            $sales_rev_id = $vendor_info_arr[0];
            $sales_header_id = $vendor_info_arr[1];
            $sales_sub_header_id = $vendor_info_arr[2];


            // check if an other customer is selected
            $check_inv_belongs_to = $this->model->rawCmd('SELECT * FROM `purinvretstk` WHERE inv_no = ' . $payload['sell_inv_no'] . ' AND doc_type = "sell" LIMIT 1');
            while ($belongs_rows = $check_inv_belongs_to->fetch_object()) {
                $c_id = $belongs_rows->customer_acc_id;
            }

            if ($customer_acc_id != $c_id) {
                $this->errors['customer'] = 'Please select the same customer';
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }


            $get_inv_info = $this->model->rawCmd('SELECT SUM(sl_qty*price) as inv_amt FROM `purinvretstk` WHERE inv_no = ' . $payload['sell_inv_no']);
            while ($amt_row = $get_inv_info->fetch_object()) {
                $inv_total_amt = $amt_row->inv_amt;
            }

            // get all the item of invoice of customer
            $check_inv_belongs_to = $this->model->rawCmd('SELECT * FROM `purinvretstk` INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id` WHERE inv_no = ' . $payload['sell_inv_no'] . ' AND doc_type = "sell"');
            while ($belongs_rows = $check_inv_belongs_to->fetch_object()) {
                $item_array[$belongs_rows->item_name] = $belongs_rows->sl_qty;
            }

            // echo $it_arr = json_encode(array_map('utf8_encode', $item_array));
            // die();
            // Customer Account
            $gj_customer_payload = [
                'gj_date' => $payload['trans_date'],
                'inv_no' => $payload['sell_inv_no'],
                'details' =>  'items',
                'customer_acc_id' => $customer_acc_id,
                // 'header_id' => $header_id,
                'customer_header_id' => $sub_header_id,
                'customer_sub_header_id' => $customer_city_id,
                'dr' => $inv_total_amt,
                'doc_type' => 'sell',
                'reg_by' => 1
            ];
            $this->model->insert('ledger', $gj_customer_payload);

            // Sales Revenue account
            $gj_sales_revenue_payload = [
                'gj_date' => $payload['trans_date'],
                'inv_no' => $payload['sell_inv_no'],
                'details' =>  $customer_name . ' ' . $customer_city,
                'customer_acc_id' => $sales_rev_id,
                // 'header_id' => $header_id,
                'customer_header_id' => $sales_header_id,
                'customer_sub_header_id' => $sales_sub_header_id,
                'cr' => $inv_total_amt,
                'doc_type' => 'sell',
                'reg_by' => 1
            ];

            $this->model->insert('ledger', $gj_sales_revenue_payload);

            $sell_inv_no = [
                'trans_date' => $payload['trans_date'],
                'customer_id' => $customer_acc_id,
                'reg_by' => 1
            ];

            $this->model->insert('sell_inv_no', $sell_inv_no);

            $update_invoced_payload = [
                'invoiced' => '1'
            ];

            $this->query = $this->model->update('purinvretstk', $update_invoced_payload, 'inv_no = ' . $payload['sell_inv_no']);

            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'sell could not be saved',], 301);
                die();
            }
            $this->model->conn->commit();
            echo json_encode(['success' => true, 'message' => 'invoice saved'], 201);
            die();
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // The record that has been added in an invoice or invoice has been saved in sell_inv_no table
    public function listKachiSellInvoiced($date = null)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $dt = (!empty($date) ? $date : date('Y-m-d'));
            // $dt = date('Y-m-d');
            $this->query = $this->model->rawCmd('SELECT * FROM `purinvretstk` INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id` INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE `purinvretstk`.doc_type = "sell" AND `purinvretstk`.invoiced="1" AND `purinvretstk`.trans_date ="' . $dt . '"');
            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
                return $this->data;
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // The record that has not been added in an invoice or invoice has not been saved in sell_inv_no table
    public function listKachiSellUnInvoiced()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->rawCmd('SELECT * FROM `purinvretstk` INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id` INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE `purinvretstk`.doc_type = "sell" AND `purinvretstk`.invoiced="0"');
            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
                return $this->data;
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // Start Mandi Book
    // 1st Step
    public function listMandiBook($customer_id, $date)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $dt = ($date != null) ? $date : date('Y-m-d');

            $this->query = $this->model->rawCmd('SELECT * FROM `purinvretstk` 
            INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id` 
            INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id` 
            INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` 
            WHERE customer_acc_id = "' . $customer_id . '"' . ' AND doc_type = "sell" AND trans_date ="' . $dt . '"');

            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
            }
            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // 2nd Step
    public function listMandiBookAccounts($date = null)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $data1 = null;
            $dt = ($date != null) ? $date : date('Y-m-d');

            $this->model->rawCmd("DROP TABLE IF EXISTS `mandi_table`");
            $this->model->rawCmd('CREATE TABLE mandi_table SELECT DISTINCT customer_acc_id FROM `purinvretstk` WHERE trans_date = "' . $dt . '" AND sub_header_id = 1');
            $this->query  = $this->model->rawCmd("SELECT * FROM `mandi_table`");

            while ($this->rows = $this->query->fetch_assoc()) {
                $this->rows;
                foreach ($this->rows as $r) {
                    // $query1 = $this->model->rawCmd('SELECT * FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE `accounts`.`id` = ' . $r);
                    $query1 = $this->model->rawCmd('SELECT * FROM `accounts` WHERE `accounts`.`id` = ' . $r);
                    while ($rows1 = $query1->fetch_assoc()) {
                        $this->data[] = $rows1;
                    }
                }
            }

            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // Single Customer Mandi Book Total
    // 3rd Step
    public function SngCustomerMandiBookTotal($customer_id, $date)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $dt = ($date != null) ? $date : date('Y-m-d');

            $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as customer_mandi_total FROM `purinvretstk`
            WHERE customer_acc_id = "' . $customer_id . '"' . ' AND doc_type = "sell" AND trans_date ="' . $dt . '"');

            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data = $this->rows;
                }
            }
            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    // 4th Step
    public function MandiBookDayTotalAmount($date)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $dt = ($date != null) ? $date : date('Y-m-d');

            $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as mandi_book_day_total FROM `purinvretstk`
            WHERE doc_type = "sell" AND trans_date ="' . $dt . '"');

            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data = $this->rows;
                }
            }
            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }
    // End Mandi Book
}
