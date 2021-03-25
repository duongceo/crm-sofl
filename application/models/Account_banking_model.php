<?php

class Account_banking_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'account_banking';
	}
}
