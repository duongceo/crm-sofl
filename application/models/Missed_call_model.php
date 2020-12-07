<?php

class Missed_call_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'tbl_missed_call';
	}

}
