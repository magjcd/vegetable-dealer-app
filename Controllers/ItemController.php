<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class ItemController extends Model
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

    public function listItems()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = null;

            $this->query = $this->model->fetchAll('items');
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

    public function addItem($payload)
    {
        try {

            if (empty($payload['item_name'])) {
                $this->errors['item_name'] = 'Item Name is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $data = [
                'item_name' => $payload['item_name']
            ];

            $this->query = $this->model->insert('items', $data);
            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'item could not be saved',], 301);
                die();
            }

            echo json_encode(['success' => true, 'message' => 'item record added'], 201);
            die();
        } catch (\Exception $e) {
            echo json_encode(['success' => true, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
