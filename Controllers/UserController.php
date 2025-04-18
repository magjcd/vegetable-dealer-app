<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class UserController extends Model
{
    public function __construct()
    {
        $this->model = new Model;
    }

    public function fetchAllUsers()
    {
        $this->query = $this->model->fetchAll('users');
        if ($this->query->num_rows >= 1) {
            while ($this->rows = $this->query->fetch_object()) {
                $this->data[] = $this->rows;
            }
            return $this->data;
        }
    }

    public function insertUser()
    {
        $array = [
            'name' => 'M. Haris Ali',
            'email' => 'magjcd4@gmail.com',
            'password' => 'Password@1'
        ];

        $this->query = $this->model->insert('users', $array);
        if ($this->query) {
            echo json_encode(['success' => true, 'message' => 'user added'], 201);
        } else {
            echo json_encode(['success' => false, 'message' => 'user added'], 201);
        }
    }
}
