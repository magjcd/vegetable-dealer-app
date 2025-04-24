<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class UserController extends Model
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
        } elseif (isset($_SESSION['owner'])) {
            $this->user_array = $_SESSION['owner'];
            $this->user_id = $_SESSION['owner']->id;
            $this->user_account_id = $_SESSION['owner']->account_id;
        }
    }

    public function listUsers()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;
            $this->query = $this->model->fetchAll('users');
            if ($this->query->num_rows >= 1) {
                while ($this->rows = $this->query->fetch_object()) {
                    $this->data[] = $this->rows;
                }
                return $this->data;
            }
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function addUser($payload)
    {
        try {

            $this->model->conn->begin_transaction();
            if (empty($payload['name'])) {
                $this->errors['name'] = 'نام در ج کریں';
            }

            if (empty($payload['user_name'])) {
                $this->errors['user_name'] = 'یوزر نیم در ج کریں';
            }

            if (empty($payload['address'])) {
                $this->errors['address'] = 'پیہ در ج کریں';
            }

            if (empty($payload['role'])) {
                $this->errors['role'] = 'رول در ج کریں';
            }

            if (empty($payload['contact_no'])) {
                $this->errors['contact_no'] = 'رابظہ نمبر در ج کریں';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $role_arr = explode('|', $payload['role']);
            $role_id = $role_arr[0];
            $role_name = $role_arr[1];

            $accounts_data = [
                'account_holder_name' => $payload['name'],
                'address' => $payload['address'],
                'contact_no' => $payload['contact_no'],
                'header_id' => 1,
                'sub_header_id' => 5,
                'reg_by' => $this->user_id

            ];
            $this->model->insert('accounts', $accounts_data);
            $last_insert_id = $this->model->conn->insert_id;

            $users_data = [
                'name' => $payload['name'],
                'email' => $payload['user_name'],
                'password' => hash('sha256', 'Password@1'),
                'role' => $role_name,
                'account_id' => $last_insert_id

            ];
            $this->model->insert('users', $users_data);


            $profiles_data = [
                'full_name' => $payload['name'],
                'address' => $payload['address'],
                'contact_no' => $payload['contact_no'],
                'user_id' => $this->user_id

            ];
            $this->query = $this->model->insert('profiles', $profiles_data);

            $this->model->conn->commit();
            if ($this->query) {
                echo json_encode(['success' => true, 'message' => 'یوزر کا اندراج ہو چکا ہے۔'], 201);
                die();
            } else {
                echo json_encode(['success' => false, 'message' => 'یوزر کا اندراج نہیں ہو سکا۔'], 201);
                die();
            }
        } catch (\Exception $e) {
            $this->model->conn->rollback();
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
