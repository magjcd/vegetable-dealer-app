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
        // echo $payload['cr'];
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
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

            if (empty($payload['dr']) && empty($payload['cr'])) {
                $this->errors['dr'] = 'نام یا جمع ڈالیں';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $uniq_id = uniqid(); // it generates unique ID of current time in microseconds in order to control two entries in ledger table, it will assign two records that come in database simultaneously and easy to identify delete the relevat records

            if ($this->user_role == 'admin') {
                if (!empty($payload['collector'])) { // for collection entry alognwith collector record entry

                    // Collector Information
                    $collector_info_arr = explode('|', $payload['collector']);
                    $collector_acc_id = $collector_info_arr[0];
                    $collector_header_id = $collector_info_arr[1];
                    $collector_sub_header_id = $collector_info_arr[2];
                    $collector_name = $collector_info_arr[3];

                    // Getting user information
                    $user_query = $this->model->fetchSingle('users', 'account_id = ' . $collector_acc_id);
                    $user_info = $user_query->fetch_object();

                    // Customer Information
                    $customer_info_arr = explode('|', $payload['account_info']);
                    $customer_acc_id = $customer_info_arr[0];
                    $customer_header_id = $customer_info_arr[1];
                    $customer_sub_header_id = $customer_info_arr[2];
                    $customer_name = $customer_info_arr[3];
                    $customer_ct_name = $customer_info_arr[4];

                    // Collector payload 
                    if (!empty($payload['dr'])) { // for reverse entry as well
                        $collector_data1 = [
                            'gj_date' => $payload['trans_date'],
                            'customer_acc_id' => $collector_acc_id,
                            'customer_header_id' => $collector_header_id,
                            'customer_sub_header_id' => $collector_sub_header_id,
                            'details' => $customer_name . ' ' . $customer_ct_name . ' - ' . $payload['details'],
                            'cr' => ($payload['dr'] ? $payload['dr'] : 0),
                            'doc_type' => 'gj',
                            'uniq_id' => $uniq_id,
                            'on_behalf_of' => $user_info->id,
                            'reg_by' => $this->user_id
                        ];
                    } elseif (!empty($payload['cr'])) {
                        $collector_data1 = [
                            'gj_date' => $payload['trans_date'],
                            'customer_acc_id' => $collector_acc_id,
                            'customer_header_id' => $collector_header_id,
                            'customer_sub_header_id' => $collector_sub_header_id,
                            'details' => $customer_name . ' ' . $customer_ct_name . ' - ' . $payload['details'],
                            'dr' => ($payload['cr'] ? $payload['cr'] : 0),
                            'doc_type' => 'gj',
                            'uniq_id' => $uniq_id,
                            'on_behalf_of' => $user_info->id,
                            'reg_by' => $this->user_id
                        ];
                    }
                    $this->model->insert('ledger', $collector_data1);


                    // Customer payload
                    $customer_data1 = [
                        'gj_date' => $payload['trans_date'],
                        'customer_acc_id' => $customer_acc_id,
                        'customer_header_id' => $customer_header_id,
                        'customer_sub_header_id' => $customer_sub_header_id,
                        'details' => $collector_name . ' - ' . $payload['details'],
                        'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                        'cr' => ($payload['cr'] ? $payload['cr'] : 0),
                        'doc_type' => 'gj',
                        'uniq_id' => $uniq_id,
                        'on_behalf_of' => $user_info->id,
                        'reg_by' => $this->user_id
                    ];

                    $this->model->insert('ledger', $customer_data1);
                } else { // for single record entry

                    // Collector Information
                    $customer_info_arr = explode('|', $payload['account_info']);
                    $customer_acc_id = $customer_info_arr[0];
                    $customer_header_id = $customer_info_arr[1];
                    $customer_sub_header_id = $customer_info_arr[2];

                    // Customer payload
                    $customer_data1 = [
                        'gj_date' => $payload['trans_date'],
                        'customer_acc_id' => $customer_acc_id,
                        'customer_header_id' => $customer_header_id,
                        'customer_sub_header_id' => $customer_sub_header_id,
                        'details' => $payload['details'],
                        'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                        'cr' => ($payload['cr'] ? $payload['cr'] : 0),
                        'doc_type' => 'gj',
                        'reg_by' => $this->user_id
                    ];

                    $this->query = $this->model->insert('ledger', $customer_data1);
                }
            } else { // Collector Direct records collection

                // Collector Information
                $collector_info_arr = explode('|', $payload['collector']);
                $collector_acc_id = $collector_info_arr[0];
                $collector_header_id = $collector_info_arr[1];
                $collector_sub_header_id = $collector_info_arr[2];
                $collector_name = $collector_info_arr[3];

                // Getting user information
                $user_query = $this->model->fetchSingle('users', 'account_id = ' . $collector_acc_id);
                $user_info = $user_query->fetch_object();

                // Customer Information
                $customer_info_arr = explode('|', $payload['account_info']);
                $customer_acc_id = $customer_info_arr[0];
                $header_id = $customer_info_arr[1];
                $sub_header_id = $customer_info_arr[2];

                // Customer Payload
                $data = [
                    'gj_date' => $payload['trans_date'],
                    'customer_acc_id' => $customer_acc_id,
                    'customer_header_id' => $header_id,
                    'customer_sub_header_id' => $sub_header_id,
                    'details' => $collector_name . ' ' . $payload['details'],
                    'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                    'doc_type' => 'gj',
                    'uniq_id' => $uniq_id,
                    'on_behalf_of' => $user_info->id,
                    'reg_by' => $this->user_id
                ];
                $this->query = $this->model->insert('ledger', $data);

                $collector_id = $this->user_account_id;
                $collector_query = $this->model->fetchSingle('accounts', 'id=' . $collector_id);
                $collector_object = $collector_query->fetch_object();

                // Collector Information
                $data1 = [
                    'gj_date' => $payload['trans_date'],
                    'customer_acc_id' => $collector_object->id,
                    'customer_header_id' => $collector_object->header_id,
                    'customer_sub_header_id' => $collector_object->sub_header_id,
                    'details' => $customer_acc_id . ' - ' . $payload['details'],
                    'cr' => $payload['dr'],
                    'doc_type' => 'gj',
                    'uniq_id' => $uniq_id,
                    'on_behalf_of' => $user_info->id,
                    'reg_by' => $this->user_id
                ];
                $this->query = $this->model->insert('ledger', $data1);
            }

            $this->model->conn->commit();
            if (!$this->model->conn->commit()) {
                echo json_encode(['success' => false, 'message' => 'انٹری ریکارڈ نہیں ہو سکی۔'], 302);
                die();
            }

            echo json_encode(['success' => true, 'message' => 'انٹری ریکارڈ ہو چکی ہے۔'], 201);
            die();
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
                // $this->query = $this->model->rawCmd('SELECT `ledger`.`id` as id, `ledger`.`details` as details, `ledger`.`dr` as dr, `ledger`.`cr` as cr, `ledger`.`reg_by` as reg_by, `accounts`.`account_holder_name` as account_holder_name, uniq_id as uniq_id, `users`.`name` as reg_name FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` INNER JOIN `users` ON `ledger`.`on_behalf_of` = `users`.`id` WHERE `ledger`.`gj_date` = "' . $dt . '" AND `ledger`.`customer_sub_header_id` != 5 AND doc_type= "gj"');
                $this->query = $this->model->rawCmd('SELECT `ledger`.`id` as id, `ledger`.`details` as details, `ledger`.`dr` as dr, `ledger`.`cr` as cr, `ledger`.`reg_by` as reg_by, `accounts`.`account_holder_name` as account_holder_name, uniq_id as uniq_id, `users`.`name` as reg_name FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` INNER JOIN `users` ON `ledger`.`on_behalf_of` = `users`.`id` WHERE `ledger`.`gj_date` = "' . $dt . '" AND doc_type= "gj"');
            } else {
                $this->query = $this->model->rawCmd('SELECT `ledger`.`id` as id, `ledger`.`details` as details, `ledger`.`dr` as dr, `ledger`.`cr` as cr, `ledger`.`reg_by` as reg_by, `accounts`.`account_holder_name` as account_holder_name, uniq_id as uniq_id  FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE `ledger`.`gj_date` = "' . $dt . '" AND `ledger`.`customer_sub_header_id` = 1 AND `ledger`.`on_behalf_of` = ' . $this->user_id . ' AND doc_type= "gj"');
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
            $dt = (!empty($payload['collection_date']) ? $payload['collection_date'] : date('Y-m-d'));
            $list_prev_date_recs = $this->model->rawCmd('SELECT sum(`ledger`.`cr`-`ledger`.`dr`) as prev_bal,`accounts`.`account_holder_name` as account_holder_name FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE customer_acc_id = ' . $acc_id . ' AND gj_date < "' . $dt . '"');
            $tot_bal = $list_prev_date_recs->fetch_object();

            $list_dr_date_recs = $this->model->rawCmd('SELECT SUM(dr) as dr,`accounts`.`account_holder_name` as account_holder_name1 FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE dr != 0 AND customer_acc_id = ' . $acc_id . ' AND gj_date = "' . $dt . '"');
            $dr = $list_dr_date_recs->fetch_object();

            $list_cr_date_recs = $this->model->rawCmd('SELECT SUM(cr) as cr,`accounts`.`account_holder_name` as account_holder_name2 FROM `ledger` INNER JOIN `accounts` ON `ledger`.`customer_acc_id` = `accounts`.`id` WHERE cr != 0 AND  customer_acc_id = ' . $acc_id . ' AND gj_date = "' . $dt . '"');
            $cr = $list_cr_date_recs->fetch_object();

            $new_data = [
                'account_holder_name' => $tot_bal->account_holder_name ?? $dr->account_holder_name1 ?? $cr->account_holder_name2,
                'prev_bal' => $tot_bal->prev_bal,
                'dr' => $dr->dr,
                'cr' => $cr->cr,
            ];
            return $new_data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function gjAccountBalance($payload)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            if ($payload['account_info'] != null) {

                // Customer Information
                $customer_info_arr = explode('|', $payload['account_info']);
                $customer_acc_id = $customer_info_arr[0];

                $this->query = $this->model->rawCmd('SELECT SUM(cr-dr) as acc_bal FROM `ledger` WHERE customer_acc_id = ' . $customer_acc_id);
                echo $this->query->fetch_object()->acc_bal;
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function munshiCollectionBalance()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            if ($this->user_role == 'munshi') {
                $this->query = $this->model->rawCmd('SELECT SUM(cr-dr) as munshi_collection_bal FROM `ledger` WHERE customer_acc_id = ' . $this->user_account_id);
                echo $this->query->fetch_object()->munshi_collection_bal;
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function deleteCollectionRecord($payload)
    {
        try {
            $this->query = $this->model->delete('ledger', 'uniq_id="' . $payload['uniq_id'] . '"');
            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'انٹری ڈیلیٹ نہیں ہو سکی۔' . 'sfsdfdsfds'], 302);
                die();
            }
            echo json_encode(['success' => true, 'message' => 'انٹری ڈیلیٹ ہو چکی ہے۔'], 200);
            die();
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function getAccountDetails($payload)
    {
        try {
            // echo json_encode($payload);
            // die();

            $this->query = null;
            $this->rows = null;
            $this->data = null;

            if (empty($payload['from_date']) && empty($payload['from_date'])) {
                $this->errors['from_date'] = 'تاریخ کا ینتخاب کریں';
            }

            if (empty($payload['to_date']) && empty($payload['to_date'])) {
                $this->errors['to_date'] = 'تاریخ کا ینتخاب کریں';
            }

            if (empty($payload['account_info']) && empty($payload['account_info'])) {
                $this->errors['account_info'] = 'اکائونٹ منتخب کریں';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            // Customer Information
            $customer_info_arr = explode('|', $payload['account_info']);
            $customer_acc_id = $customer_info_arr[0];

            $this->query = $this->model->rawCmd('SELECT `ledger`.`details`,`ledger`.`dr`,`ledger`.`cr` FROM `ledger` WHERE customer_acc_id = ' . $customer_acc_id . ' AND gj_date >= "' . $payload['from_date'] . '" AND gj_date <= "' . $payload['to_date'] . '"');
            while ($this->rows = $this->query->fetch_object()) {
                $this->data[] = $this->rows;
            }
            // echo json_encode(['success' => true, 'data' => $this->data], 200);
            // return;
            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
