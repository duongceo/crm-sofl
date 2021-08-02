<?php

class Day_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'days';
	}

	public function get_day($id=0) {
		$name = '';
		$input2 = array();
		$input2['where'] = array('id' => $id);
		$names = $this->load_all($input2);
		if (!empty($names)) {
			$name = $names[0]['days'];
		}
		return $name;
	}

}
