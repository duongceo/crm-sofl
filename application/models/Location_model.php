<?php

class Location_model extends MY_Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'location';
	}

	public function find_location_name($id) {
		$name = '';
		$input2 = array();
		$input2['where'] = array('id' => $id);
		$names = $this->load_all($input2);
		if (!empty($names)) {
			$name = $names[0]['location'];
		}
		return $name;
	}

}
