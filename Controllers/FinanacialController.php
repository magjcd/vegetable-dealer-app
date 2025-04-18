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
        try {

            if (empty($payload['account_info'])) {
                $this->errors['account_info'] = 'اکاؤنٹ منتخب کریں';
            }

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

            $customer_info_arr = explode('|', $payload['account_info']);
            $customer_acc_id = $customer_info_arr[0];
            $header_id = $customer_info_arr[1];
            $sub_header_id = $customer_info_arr[2];

            // echo json_encode($customer_acc_id . ' / ' . $header_id . ' - ' . $sub_header_id);
            // die();

            $data = [
                'gj_date' => $payload['trans_date'],
                'customer_acc_id' => $customer_acc_id,
                'customer_header_id' => $header_id,
                'customer_sub_header_id' => $sub_header_id,
                'details' => $payload['details'],
                'dr' => ($payload['dr'] ? $payload['dr'] : 0),
                'cr' => ($payload['cr'] ? $payload['cr'] : 0),
                'doc_type' => 'gj'
            ];

            $this->query = $this->model->insert('ledger', $data);
            if (!$this->query) {
                echo json_encode(['success' => false, 'message' => 'انٹری ریکارڈ نہیں ہو سکی۔'], 302);
            }

            echo json_encode(['success' => true, 'message' => 'انٹری ریکارڈ ہو چکی ہے۔'], 201);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
