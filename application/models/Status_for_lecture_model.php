<?php
class Status_for_lecture_model extends MY_Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'status_for_lecture';
	}
}
