<?php

namespace Controllers;

// ini_set('display_error', 1);

use Models\Model;

class PurchaseController extends Model
{
    public function __construct()
    {
        $this->model = new Model;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['admin'])) {
            $this->user_array = $_SESSION['admin'];
            $this->user_id = $_SESSION['admin']->id;
            $this->user_account_id = $_SESSION['admin']->account_id;
        } elseif (isset($_SESSION['munshi'])) {
            $this->user_array = $_SESSION['munshi'];
            $this->user_id = $_SESSION['munshi']->id;
            $this->user_account_id = $_SESSION['munshi']->account_id;
        } elseif (isset($_SESSION['accountant'])) {
            $this->user_array = $_SESSION['accountant'];
            $this->user_id = $_SESSION['accountant']->id;
            $this->user_account_id = $_SESSION['accountant']->account_id;
            $this->user_role = $_SESSION['accountant']->role;
        } elseif (isset($_SESSION['owner'])) {
            $this->user_array = $_SESSION['owner'];
            $this->user_id = $_SESSION['owner']->id;
            $this->user_account_id = $_SESSION['owner']->account_id;
        }
    }

    public function random_no()
    {
        $rand_no = rand(000000000, 999999999);
        return $rand_no;
    }

    public function purchaseInvNo()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        // $this->sql = $this->model->rawCmd('SELECT COUNT(*) as pur_inv_no FROM `pur_inv_no`');
        $this->sql = $this->model->rawCmd('SELECT COUNT(*) as pur_inv_no FROM `pur_inv`');
        while ($this->rows = $this->sql->fetch_object()) {
            $data = $this->rows;
        }
        return $data;
    }

    public function listPurchases()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->rawCmd('SELECT * FROM `purinvretstk` INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id` INNER JOIN `items` ON `purinvretstk`.`item_id` = `items`.`id` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE doc_type = "purchase"');
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

    public function purchaseItem($payload)
    {
        try {
            $this->model->conn->begin_transaction();
            if (empty($payload['purchase_date'])) {
                $this->errors['purchase_date'] = 'Purchase Date is required';
            }

            if (empty($payload['vendor'])) {
                $this->errors['vendor'] = 'Vendor is required';
            }

            if (empty($payload['builty_no'])) {
                $this->errors['builty_no'] = 'Builty No is required';
            }

            if (empty($payload['vehicle_no'])) {
                $this->errors['vehicle_no'] = 'Vehicle No. is required';
            }

            if (empty($payload['items'])) {
                $this->errors['items'] = 'Items is required';
            }

            if (empty($payload['item_details'])) {
                $this->errors['item_details'] = 'Item Details is required';
            }

            if (empty($payload['qty'])) {
                $this->errors['qty'] = 'Quantity is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }


            $vendor_info_arr = explode('|', $payload['vendor']);
            $vendor_id = $vendor_info_arr[0];
            $vendor_city_id = $vendor_info_arr[1];
            $vendor_name = $vendor_info_arr[4];
            $vendor_city = $vendor_info_arr[5];

            $items_info_arr = explode('|', $payload['items']);
            $item_id = $items_info_arr[0];

            // Firstly check in pur_inv if already saved go ahead otherwise save in this table first 
            $chech_pur_inv_avaialble = $this->model->fetchSingle('pur_inv', 'pur_inv_no = ' . $payload['pur_inv_no'] . ' AND vendor_id = ' . $vendor_id . ' AND builty_no = "' . $payload['builty_no'] . '" AND vehicle_no = "' . $payload['vehicle_no'] . '"');

            if ($chech_pur_inv_avaialble->num_rows <= 0) {
                $data1 = [
                    'purchase_date' => $payload['purchase_date'],
                    'pur_inv_no' => $payload['pur_inv_no'],
                    'vendor_id' => $vendor_id,
                    'builty_no' => $payload['builty_no'],
                    'vehicle_no' => $payload['vehicle_no'],
                    'reg_by' => $this->user_id,
                ];
                $this->query = $this->model->insert('pur_inv', $data1);
            }

            // Getting Header and Sub Header IDs for future use
            $get_vendor_details = $this->model->fetchSingle('accounts', 'id = ' . $vendor_id);
            while ($this->rows = $get_vendor_details->fetch_object()) {
                $header_id = $this->rows->header_id;
                $sub_header_id = $this->rows->sub_header_id;
            }

            // Check if invoice items are available but in voice is not saved and DEO try to post item in an other customer within same invoice no. then halt
            $chech_record_avaialble = $this->model->fetchSingle('purinvretstk', 'inv_no = ' . $payload['pur_inv_no'] . ' AND doc_type = "purchase"');
            $available_id = null;
            if ($chech_record_avaialble->num_rows > 0) {
                while ($check_rows = $chech_record_avaialble->fetch_object()) {
                    $available_id = $check_rows->customer_acc_id;
                }

                if ($available_id != $vendor_id) {
                    $this->errors['vendor'] = 'You are trying to post in an other customer';
                    echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                    die();
                }
            }

            $rand_no = rand(000000000, 999999999);


            $data = [
                'trans_date' => $payload['purchase_date'],
                'inv_no' => $payload['pur_inv_no'],
                'customer_acc_id' => $vendor_id,
                'customer_city_id' => $vendor_city_id,
                'header_id' => $header_id,
                'sub_header_id' => $sub_header_id,
                'random_no' => $rand_no,
                'builty_no' => $payload['builty_no'],
                'vehicle_no' => $payload['vehicle_no'],
                'item_id' => $item_id,
                'item_details' => $payload['item_details'],
                'pur_qty' => $payload['qty'],
                'price' => ($payload['price'] != null ? $payload['price'] : 0),
                'reg_by' => $this->user_id,
                'doc_type' => 'purchase'
            ];
            $this->query = $this->model->insert('purinvretstk', $data);

            $data1 = [
                'purchase_date' => $payload['purchase_date'],
                'pur_inv_no' => $payload['pur_inv_no'],
                'vendor_id' => $vendor_id,
                'vendor_nm' => $vendor_name,
                'vendor_city' => $vendor_city,
                'random_no' => $rand_no,
                'item_id' => $item_id,
                'reg_by' => $this->user_id
                // 'builty_no' => $payload['builty_no'],
                // 'vehicle_no' => $payload['vehicle_no'],
            ];
            $this->query = $this->model->insert('pur_item_ref', $data1);

            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'purchases could not be saved',], 301);
                die();
            }

            $this->model->conn->commit();
            echo json_encode(['success' => true, 'message' => 'purchases added'], 201);
            die();
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function savePurchaseInvoce($payload)
    {
        try {
            $this->model->conn->begin_transaction();
            $check_inv_items = $this->model->fetchSingle('purinvretstk', 'inv_no = ' . $payload['pur_inv_no']);
            if ($check_inv_items->num_rows <= 0) {
                echo json_encode(['success' => false, 'message' => 'please add item in invoice',], 301);
                die();
            }

            if (empty($payload['vendor'])) {
                $this->errors['vendor'] = 'Vendor is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }


            // get the customer information to save the invoice
            // $sql_inner = $this->model->rawCmd("SELECT * FROM `purinvretstk` 
            // INNER JOIN `accounts` ON `purinvretstk`.`customer_acc_id` = `accounts`.`id`
            // WHERE inv_no = " . $payload['pur_inv_no']);

            $customer_info_arr = explode('|', $payload['vendor']);
            $customer_acc_id = $customer_info_arr[0];
            $header_id = $customer_info_arr[1];
            $sub_header_id = $customer_info_arr[2];
            $customer_city_id = $customer_info_arr[3];
            $customer_name = $customer_info_arr[4];
            $customer_city = $customer_info_arr[5];

            $vendor_info_arr = explode('|', $payload['inventory']);
            $sales_rev_id = $vendor_info_arr[0];
            $sales_header_id = $vendor_info_arr[1];
            $sales_sub_header_id = $vendor_info_arr[2];


            // check if an other customer is selected
            $check_inv_belongs_to = $this->model->rawCmd('SELECT * FROM `purinvretstk` WHERE inv_no = ' . $payload['pur_inv_no'] . ' AND doc_type = "purchase" LIMIT 1');
            while ($belongs_rows = $check_inv_belongs_to->fetch_object()) {
                $c_id = $belongs_rows->customer_acc_id;
            }

            if ($customer_acc_id != $c_id) {
                $this->errors['vendor'] = 'Please select the same vendor';
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }


            $get_inv_info = $this->model->rawCmd('SELECT SUM(pur_qty*price) as inv_amt FROM `purinvretstk` WHERE inv_no = ' . $payload['pur_inv_no']);
            while ($amt_row = $get_inv_info->fetch_object()) {
                $inv_total_amt = $amt_row->inv_amt;
            }

            // BELOW CODE WILL BE TRANSFERED TO VENDOR BILL MAKING

            // $gj_customer_payload = [
            //     'gj_date' => $payload['trans_date'],
            //     'inv_no' => $payload['pur_inv_no'],
            //     'details' =>  '$item_name',
            //     'customer_acc_id' => $customer_acc_id,
            //     // 'header_id' => $header_id,
            //     'customer_header_id' => $sub_header_id,
            //     'customer_sub_header_id' => $customer_city_id,
            //     'dr' => $inv_total_amt,
            //     'doc_type' => 'purchase',
            //     'reg_by' => 1
            // ];

            // $this->model->insert('ledger', $gj_customer_payload);

            // $gj_sales_revenue_payload = [
            //     'gj_date' => $payload['trans_date'],
            //     'inv_no' => $payload['pur_inv_no'],
            //     'details' =>  $customer_name . ' ' . $customer_city,
            //     'customer_acc_id' => $sales_rev_id,
            //     // 'header_id' => $header_id,
            //     'customer_header_id' => $sales_header_id,
            //     'customer_sub_header_id' => $sales_sub_header_id,
            //     'cr' => $inv_total_amt,
            //     'doc_type' => 'purchase',
            //     'reg_by' => 1
            // ];

            // $this->model->insert('ledger', $gj_sales_revenue_payload);

            $update_invoced_payload = [
                'invoiced' => '1'
            ];

            $this->query = $this->model->update('purinvretstk', $update_invoced_payload, 'inv_no = ' . $payload['pur_inv_no']);

            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'purchase could not be saved',], 301);
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
}
