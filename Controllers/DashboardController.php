<?php

namespace Controllers;

use Models\Model;


class DashboardController extends Model
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
        } elseif (isset($_SESSION['accountant'])) {
            $this->user_array = $_SESSION['accountant'];
            $this->user_id = $_SESSION['accountant']->id;
            $this->user_account_id = $_SESSION['accountant']->account_id;
            $this->user_role = $_SESSION['accountant']->role;
        } elseif (isset($_SESSION['owner'])) {
            $this->user_array = $_SESSION['owner'];
            $this->user_id = $_SESSION['owner']->id;
            $this->user_account_id = $_SESSION['owner']->account_id;
            $this->user_role = $_SESSION['owner']->role;
        }
    }

    public function dailySell($payload)
    {
        try {
            $dt = (!empty($payload['date']) ? $payload['date'] : date('Y-m-d'));
            if ($this->user_role == 'owner') {
                $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as day_sell FROM `purinvretstk` WHERE trans_date = "' . $dt . '"');
                $day_sl_obj = $this->query->fetch_object();
                echo (($day_sl_obj->day_sell != null) ? $day_sl_obj->day_sell : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as day_sell FROM `purinvretstk` WHERE trans_date = "' . $dt . '" AND reg_by = ' . $this->user_id);
                $day_sl_obj = $this->query->fetch_object();
                echo (($day_sl_obj->day_sell != null) ? $day_sl_obj->day_sell : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function monthlySell($payload)
    {
        try {
            $dt = (!empty($payload['date']) ? $payload['date'] : date('Y-m-t'));
            $m = date('Y-m-01');
            if ($this->user_role == 'owner') {
                // echo 'SELECT SUM(sl_qty*price) as monthly_sell FROM `purinvretstk` WHERE trans_date >= "' . $m . '" AND trans_date <= "' . $dt . '"';
                $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as monthly_sell FROM `purinvretstk` WHERE trans_date >= "' . $m . '" AND trans_date <= "' . $dt . '"');
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_sell != null) ? $monthly_sl_obj->monthly_sell : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(sl_qty*price) as monthly_sell FROM `purinvretstk` WHERE trans_date >= "' . $m . '" AND trans_date <= "' . $dt . '" AND reg_by = ' . $this->user_id);
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_sell != null) ? $monthly_sl_obj->monthly_sell : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function dailyCollection($payload)
    {
        try {
            $dt = (!empty($payload['date']) ? $payload['date'] : date('Y-m-d'));
            if ($this->user_role == 'owner') {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as day_collection FROM `ledger` WHERE gj_date = "' . $dt . '" AND customer_sub_header_id = 5 AND doc_type = "gj"');
                $day_collection_obj = $this->query->fetch_object();
                echo (($day_collection_obj->day_collection != null) ? $day_collection_obj->day_collection : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as day_collection FROM `ledger` WHERE gj_date = "' . $dt . '" AND customer_sub_header_id = 5 AND doc_type = "gj" AND reg_by = ' . $this->user_id);
                $day_collection_obj = $this->query->fetch_object();
                echo (($day_collection_obj->day_collection != null) ? $day_collection_obj->day_collection : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function monthlyCollection($payload)
    {
        try {
            $td = (!empty($payload['date']) ? $payload['date'] : date('Y-m-t'));
            $fm = date('Y-m-01');
            if ($this->user_role == 'owner') {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as monthly_collection FROM `ledger` WHERE gj_date >= "' . $fm . '" AND gj_date <= "' . $td . '" AND customer_sub_header_id = 5 AND doc_type = "gj"');
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_collection != null) ? $monthly_sl_obj->monthly_collection : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as monthly_collection FROM `ledger` WHERE gj_date >= "' . $fm . '" AND gj_date <= "' . $td . '" AND customer_sub_header_id = 5 AND doc_type = "gj" AND reg_by = ' . $this->user_id);
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_collection != null) ? $monthly_sl_obj->monthly_collection : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function dayBankPostion($payload)
    {
        try {
            $dt = (!empty($payload['date']) ? $payload['date'] : date('Y-m-d'));
            if ($this->user_role == 'owner') {
                $this->query = $this->model->rawCmd('SELECT SUM(dr-cr) as day_bank_position FROM `ledger` WHERE gj_date = "' . $dt . '" AND customer_sub_header_id = 6 AND doc_type = "gj"');
                $day_bank_position_obj = $this->query->fetch_object();
                echo (($day_bank_position_obj->day_bank_position != null) ? $day_bank_position_obj->day_bank_position : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as day_bank_position FROM `ledger` WHERE gj_date = "' . $dt . '" AND customer_sub_header_id = 6 AND doc_type = "gj" AND reg_by = ' . $this->user_id);
                $day_bank_position_obj = $this->query->fetch_object();
                echo (($day_bank_position_obj->day_bank_position != null) ? $day_bank_position_obj->day_bank_position : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function monthlyBankPosition($payload)
    {
        try {
            $td = (!empty($payload['date']) ? $payload['date'] : date('Y-m-d'));
            $fm = date('Y-m-01');
            if ($this->user_role == 'owner') {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as monthly_bank_position FROM `ledger` WHERE gj_date >= "' . $fm . '" AND gj_date <= "' . $td . '" AND customer_sub_header_id = 6 AND doc_type = "gj"');
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_bank_position != null) ? $monthly_sl_obj->monthly_bank_position : 0);
            } else {
                $this->query = $this->model->rawCmd('SELECT SUM(cr) as monthly_bank_position FROM `ledger` WHERE gj_date >= "' . $fm . '" AND gj_date <= "' . $td . '" AND customer_sub_header_id = 6 AND doc_type = "gj" AND reg_by = ' . $this->user_id);
                $monthly_sl_obj = $this->query->fetch_object();
                echo (($monthly_sl_obj->monthly_bank_position != null) ? $monthly_sl_obj->monthly_bank_position : 0);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function monthlyChartCollection()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = array();;
            $months_array = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

            foreach ($months_array as $month_array) {
                $this->query = $this->model->rawCmd('SELECT sum(cr) as month_coll FROM ledger WHERE customer_sub_header_id = 5 AND gj_date >= "' . date('Y-' . $month_array . '-01') . '" AND gj_date <= "' . date('Y-' . $month_array . '-t') . '"');
                array_push($this->data, $this->query->fetch_object()->month_coll);
            }

            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }

    public function monthlyChartSell()
    {
        try {
            $this->query = null;
            $this->rows = null;
            $this->data = array();;
            $months_array = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

            foreach ($months_array as $month_array) {
                $this->query = $this->model->rawCmd('SELECT sum(sl_qty*price) as month_sell FROM `purinvretstk` WHERE trans_date >= "' . date('Y-' . $month_array . '-01') . '" AND trans_date <= "' . date('Y-' . $month_array . '-t') . '" AND doc_type = "sell"');
                array_push($this->data, $this->query->fetch_object()->month_sell);
            }

            return $this->data;
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], 500);
            die();
        }
    }
}
