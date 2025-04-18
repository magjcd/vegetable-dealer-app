<?php

namespace Controllers;

ini_set('display_error', 1);

use Models\Model;

class GeneralController extends Model
{
    public function __construct()
    {
        $this->model = new Model;
    }

    public function fetchAllCities()
    {
        $this->query = null;
        $this->rows = null;
        $this->data = null;
        $this->query = $this->model->fetchAll('cities');
        // if ($this->query->num_rows >= 1) {
        while ($this->rows = $this->query->fetch_object()) {
            $this->data[] = $this->rows;
        }
        return $this->data;
        // }
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
        $this->query = $this->model->rawCmd("SELECT * FROM sub_headers WHERE sub_header_name IN ('Accounts Receivable','Accounts Payable')");

        while ($this->rows = $this->query->fetch_object()) {
            $this->data[] = $this->rows;
        }
        return $this->data;
    }
}
