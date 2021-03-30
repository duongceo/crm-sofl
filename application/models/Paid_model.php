<?php

class Paid_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'paid';
    }

	 public function load_all_paid_log($input_call_log) {
	 	$this->load->model('branch_model');
	 	$this->load->model('language_study_model');
	 	$this->load->model('source_revenue_model');
	 	$this->load->model('payment_method_rgt_model');
	 	$paid_logs = $this->load_all($input_call_log);
	 	if (isset($paid_logs)) {
	 		foreach ($paid_logs as $key => $value) {
	 			$paid_logs[$key]['branch_name'] = $this->branch_model->find_branch_name($value['branch_id']);
	 			$paid_logs[$key]['language_name'] = $this->language_study_model->find_language_name($value['language_id']);
	 			$paid_logs[$key]['source_revenue_name'] = $this->source_revenue_model->find_source_name($value['source_revenue_id']);
	 			$paid_logs[$key]['payment_method_name'] = $this->payment_method_rgt_model->find_payment_method_rgt_desc($value['payment_method_id']);
	 		}
	 		return $paid_logs;
	 	} else return array();
	 }

}
