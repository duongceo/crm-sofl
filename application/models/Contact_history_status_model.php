<?php

class Contact_history_status_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'contact_history_status';
	}
	
	public function call_procedure() {
		$query = $this->db->query("CALL pr_insert_data_to_cts_history_level_2()");
		//return $query->result_array();
	}
}

?>