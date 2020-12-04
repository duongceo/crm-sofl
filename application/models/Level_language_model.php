<?php

class Level_language_model extends MY_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'level_language';
	}

	function find_course_combo($level_language_id) {
		$combo = '';
		$input2 = array();
		$input2['where'] = array('id' => $level_language_id);
		$courses = $this->load_all($input2);

		if (!empty($courses)) {
			$combo = $courses[0]['level_code'];
		}
		return $combo;
	}

	public function get_name_level_language($id) {
		$name = '';
		$input2 = array();
		$input2['where'] = array('id' => $id);
		$names = $this->load_all($input2);
		if (!empty($names)) {
			$name = $names[0]['name'];
		}
		return $name;
	}

}
