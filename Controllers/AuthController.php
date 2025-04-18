<?php

namespace Controllers;

use Models\Model;


class AuthController extends Model
{
    public $errors = [];
    protected $query;

    public function __construct()
    {
        $this->model = new Model;
    }

    public function checkIfLoggedIn()
    {
        if (count($_SESSION) == 0) {
            header('location: login');
            die();
        } else {
            header('location: index');
            die();
        }
    }

    public function login($data)
    {
        try {
            if (empty($data['email'])) {
                $this->errors['email'] = 'email is required';
            }

            if (empty($data['password'])) {
                $this->errors['password'] = 'password is required';
            }

            if (count($this->errors) > 0) {
                echo json_encode(['success' => false, 'errors' => $this->errors], 401);
                die();
            }

            $payload = 'email = "' . $data['email'] . '" AND  password = "' . $data['password'] . '"';

            $this->query = $this->model->fetchSingle('users', $payload);


            if ($this->query->num_rows >= 1) {

                while ($this->rows = $this->query->fetch_object()) {
                    $this->data = $this->rows;
                }

                session_start();
                // echo json_encode($this->data->name);
                $_SESSION[$this->data->role] = $this->data;

                // header('location: index');
                echo json_encode(['success' => true, 'response' => 'loged in', 'data' => $this->data], 200);
                die();
                // return $this->errors['logged_in'] = 'logged in....';
            } else {
                echo json_encode(['success' => false, 'invalid_credentials' => 'invalid credentials....'], 401);
                die();
                // return $this->errors['logged_in'] = 'coud not logged in....';
            }
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function logout()
    {
        session_destroy();
        header('location: login.php');
    }
}
