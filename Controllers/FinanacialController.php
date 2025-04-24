<?php

namespace Controllers;

use Models\Model;


class FinanacialController extends Model
{
    public $errors = [];
    protected $query;

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
            $this->user_role = $_SESSION['admin']->role;
        } elseif (isset($_SESSION['munshi'])) {
            $this->user_array = $_SESSION['munshi'];
            $this->user_id = $_SESSION['munshi']->id;
            $this->user_account_id = $_SESSION['munshi']->account_id;
            $this->user_role = $_SESSION['munshi']->role;
        } elseif (isset($_SESSION['owner'])) {
            $this->user_array = $_SESSION['owner'];
            $this->user_id = $_SESSION['owner']->id;
            $this->user_account_id = $_SESSION['owner']->account_id;
            $this->user_role = $_SESSION['owner']->role;
        }
    }

    public function listSalesInventory($acc_nm)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->fetchSingle('accounts', 'account_holder_name = "' . $acc_nm . '"');
            // if ($this->query->num_rows > 0) {
            while ($this->rows = $this->query->fetch_object()) {
                $this->data[] = $this->rows;
            }
            return $this->data;
            // }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function addGjEntry($payload)
    {
        echo $payload['cr'];
        try {
            $this->model->conn->begin_transaction();
            if (empty($payload['account_info'])) {
                $this->errors['account_info'] = 'اکاؤنٹ منتخب کریں';
            }

            // if (isset($payload['collector']) && empty($payload['collector'])) {
            //     $this->errors['collector'] = 'وصول کنندہ کی تفصیل ڈالیں';
            // }

            if (empty($payload['details'])) {
                $this->errors['details'] = 'تفصیل ڈالیں';
            }

            if (empty($payload['dr']) && empty($payload['cr'])) {
                $this->errors['dr'] = 'نام یا جمع ڈالیں';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            // Customer Information
            $customer_info_arr = explode('|', $payload['account_info']);
            $customer_acc_id = $customer_info_arr[0];
            $header_id = $customer_info_arr[1];
            $sub_header_id = $customer_info_arr[2];

            if (!empty($payload['collector'])) {

                // Collector Information
                $collector_info_arr = explode('|', $payload['collector']);
                $collector_acc_id = $collector_info_arr[0];
                $collector_header_id = $collector_info_arr[1];
                $collector_sub_header_id = $collector_info_arr[2];

                // Customer Information
                $data1 = [
                    'gj_date' => $payload['trans_date'],
                    'customer_acc_id' => $collector_acc_id,
                    'customer_header_id' => $collector_header_id,
                    'customer_sub_header_id' => $collector_sub_header_id,
                    'details' => $payload['details'],
                    // 'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                    'cr' => ($payload['dr'] ? $payload['dr'] : 0),
                    'doc_type' => 'gj',
                    'reg_by' => $this->user_id
                ];

                $this->model->insert('ledger', $data1);
            }

            // Customer Information
            $data = [
                'gj_date' => $payload['trans_date'],
                'customer_acc_id' => $customer_acc_id,
                'customer_header_id' => $header_id,
                'customer_sub_header_id' => $sub_header_id,
                'details' => $payload['details'],
                'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                'cr' => ($payload['cr'] ? $payload['cr'] : 0),
                'doc_type' => 'gj',
                'reg_by' => $this->user_id
            ];

            $this->query = $this->model->insert('ledger', $data);
            $this->model->conn->commit();
            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'انٹری ریکارڈ نہیں ہو سکی۔'], 302);
                die();
            }

            echo json_encode(['success' => true, 'message' => 'انٹری ریکارڈ ہو چکی ہے۔'], 201);
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function listCollection($date)
    {
        try {

            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $dt = (!empty($date) ? $date : date('Y-m-d'));

            if ($this->user_role == 'admin') {
                $this->query = $this->model->rawCmd('SELECT `ledger`.`id` as id, `ledger`.`details` as details, `ledger`.`dr` as dr, `ledger`.`cr` as cr, `ledger`.`reg_by` as reg_by, `accounts`.`account_holder_name` as account_holder_name  FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE `ledger`.`gj_date` = "' . $dt . '"');
            } else {
                $this->query = $this->model->rawCmd('SELECT `ledger`.`id` as id, `ledger`.`details` as details, `ledger`.`dr` as dr, `ledger`.`cr` as cr, `ledger`.`reg_by` as reg_by, `accounts`.`account_holder_name` as account_holder_name  FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE `ledger`.`gj_date` = "' . $dt . '" AND `ledger`.`customer_acc_id` = ' . $this->user_account_id . ' AND `ledger`.`reg_by` = ' . $this->user_id);
            }

            while ($this->rows = $this->query->fetch_object()) {
                $this->data[] = $this->rows;
            }
            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function listFullCollection($payload, $acc_id)
    {
        try {
            $new_data = [];
            $name = null;
            $dt = (!empty($payload['collection_date']) ? $payload['collection_date'] : date('Y-m-d'));
            $list_prev_date_recs = $this->model->rawCmd('SELECT sum(dr-cr) as tot_bal FROM `ledger` WHERE customer_acc_id = ' . $acc_id . ' AND gj_date <= "' . $dt . '"');

            $tot_bal = $list_prev_date_recs->fetch_object();
            $name = 'tot_bal';
            $tbl = $name = $tot_bal;
            // array_push($new_data, $tbl);
            $new_data['tot_bal'] = $tbl;

            $list_prev_date_recs = $this->model->rawCmd('SELECT dr FROM `ledger` WHERE customer_acc_id = ' . $acc_id . ' AND gj_date = "' . $dt . '"');
            $list_prev_date_recs->fetch_object();

            $dr = $list_prev_date_recs->fetch_object();
            $name = 'dr';
            $drr = $name = $dr;
            // array_push($new_data, $drr);
            $new_data['dr'] = $dr;

            $list_prev_date_recs = $this->model->rawCmd('SELECT cr FROM `ledger` WHERE customer_acc_id = ' . $acc_id . ' AND gj_date = "' . $dt . '"');
            $list_prev_date_recs->fetch_object();

            $cr = $list_prev_date_recs->fetch_object();
            $name = 'cr';
            $crr = $name = $cr;
            // array_push($new_data, $crr);
            $new_data['cr'] = $cr;

            // while ($ledger_rows = $list_prev_date_recs->fetch_object()) {
            //     $tot_bal = $ledger_rows->tot_bal;
            //     $name = 'tot_bal';
            //     $tbl = $name = $tot_bal;
            //     array_push($new_data, $tbl);
            //     // array_push($new_arr, $this->data = $inner_rows);
            // }
            return $new_data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
