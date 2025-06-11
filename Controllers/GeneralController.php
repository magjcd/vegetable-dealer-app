<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class GeneralController extends Model
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

    public function listAllCities()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        $this->query = $this->model->fetchAll('cities');

        while ($this->rows = $this->query->fetch_object()) {
            $this->data[] = $this->rows;
        }
        return $this->data;
    }

    public function listHeaders() {}

    public function listSubHeaders() {}

    public function listHeadersForAccounts()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        $this->query = $this->model->rawCmd("SELECT * FROM headers WHERE header_name IN ('Assets','Liabilities')");

        while ($this->rows = $this->query->fetch_object()) {
            $this->data[] = $this->rows;
        }
        return $this->data;
    }

    public function listSubHeadersForAccounts()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        // $this->query = $this->model->rawCmd("SELECT * FROM sub_headers WHERE sub_header_name IN ('Accounts Receivable','Accounts Payable')");
        $this->query = $this->model->rawCmd("SELECT * FROM sub_headers WHERE sub_header_name IN ('Accounts Receivable','Accounts Payable','Banks')");

        while ($this->rows = $this->query->fetch_object()) {
            $this->data[] = $this->rows;
        }
        return $this->data;
    }
}
