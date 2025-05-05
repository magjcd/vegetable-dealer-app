<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class AccountController extends Model
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

    public function addAccount($payload)
    {
        try {

            if (empty($payload['account_holder_name'])) {
                $this->errors['account_holder_name'] = 'Account Holder Name is required';
            }

            if (empty($payload['header_id'])) {
                $this->errors['header_id'] = 'Header is required';
            }

            if (empty($payload['sub_header_id'])) {
                $this->errors['sub_header_id'] = 'Sub Header is required';
            }


            if (empty($payload['address'])) {
                $this->errors['address'] = 'address is required';
            }

            if (empty($payload['city_id'])) {
                $this->errors['city_id'] = 'City is required';
            }

            if (empty($payload['business_address'])) {
                $this->errors['business_address'] = 'Business Address is required';
            }

            if (empty($payload['contact_no'])) {
                $this->errors['contact_no'] = 'Contact No. is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $data = [
                'account_holder_name' => $payload['account_holder_name'],
                'header_id' => $payload['header_id'],
                'sub_header_id' => $payload['sub_header_id'],
                'address' => $payload['address'],
                'city_id' => $payload['city_id'],
                'business_address' => $payload['business_address'],
                'contact_no' => $payload['contact_no'],
                'reg_by' => 1
            ];

            $this->query = $this->model->insert('accounts', $data);
            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'customer could not be saved',], 301);
                die();
            }

            echo json_encode(['success' => true, 'message' => 'customer record added'], 201);
            die();
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function listAccounts()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            // $this->query = $this->model->fetchAll('accounts');
            $this->query = $this->model->rawCmd('SELECT * FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` INNER JOIN `users` ON `accounts`.`reg_by` = `users`.`id`');
            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
                return $this->data;
                // echo json_encode(['success' => true, 'data' => $this->data], 200);
                // die();
            }
            // echo json_encode(['success' => false, 'message' => 'no record is available'], 302);
            // die();
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function listAccountsForGJ()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            if ($this->user_role == 'admin') {
                $this->query = $this->model->rawCmd('SELECT `accounts`.`id` as id,`accounts`.`account_holder_name` as acc_name, `accounts`.`header_id` as hid, `accounts`.`sub_header_id` as subid, `cities`.`city_name` as ct_name FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id`');
            } else {
                $this->query = $this->model->rawCmd('SELECT `accounts`.`id` as id,`accounts`.`account_holder_name` as acc_name, `accounts`.`header_id` as hid, `accounts`.`sub_header_id` as subid, `cities`.`city_name` as ct_name FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE `accounts`.`sub_header_id` = 1');
            }
            if ($this->query->num_rows > 0) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
                return $this->data;
                // echo json_encode(['success' => true, 'data' => $this->data], 200);
                // die();
            }
            // echo json_encode(['success' => false, 'message' => 'no record is available'], 302);
            // die();
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function listUserAccountsForGJ()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->rawCmd('SELECT `accounts`.`id` as accounts_id,`accounts`.`account_holder_name` as acc_name, `accounts`.`header_id` as hid, `accounts`.`sub_header_id` as subid, `users`.`id` as users_id, `users`.`account_id` as user_acc_id FROM `accounts` INNER JOIN `users` ON `accounts`.`id` = `users`.`account_id`');
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

    public function listAccountsById($id)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->rawCmd('SELECT DISTINCT account_holder_name FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` INNER JOIN `users` ON `accounts`.`reg_by` = `users`.`id` WHERE `accounts`.id=' . $id);
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

    public function listAccountByType($cus_tp_id)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->rawCmd('SELECT `accounts`.`id` as id, `accounts`.`header_id` as header_id, `accounts`.`sub_header_id` as sub_header_id, `accounts`.`account_holder_name` as account_holder_name, `cities`.`id` as city_id, `cities`.`city_name` as city_name FROM `accounts` INNER JOIN `cities` ON `accounts`.`city_id` = `cities`.`id` WHERE sub_header_id = ' . $cus_tp_id);
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

    public function listAccountsByCitySubHeader($id, $s_hd_id)
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->fetchSingle('accounts', 'city_id = ' . $id . ' AND sub_header_id = ' . $s_hd_id);
            // if ($this->query->num_rows > 0) {
            while ($this->rows = $this->query->fetch_object()) {
                $this->data[] = $this->rows;
            }
            return $this->data;
            // }
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
