<?php


class Paid_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'paid';
    }

	public function load_all_paid_log($input_call_log) {
		$this->load->model('branch_model');
		$paid_logs = $this->load_all($input_call_log);
		if (isset($paid_logs)) {
			foreach ($paid_logs as $key => $value) {
				$paid_logs[$key]['branch_name'] = $this->branch_model->find_branch_name($value['branch_id']);
			}
			return $paid_logs;
		} else return array();
	}

}
