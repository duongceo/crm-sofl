<?php

class Level_study_model extends MY_Model {

	function __construct() {
		parent::__construct();
		$this->table = 'level_study';
	}

	public function get_name_from_level($level_id = '') {
		$input['where'] = array(
			'level_id' => $level_id
		);
		$level_name = $this->load_all($input);
		if (isset($level_name)) {
			return $level_name[0]['level_id'] . ' - ' . $level_name[0]['name'] ;
		} else {
			return $level_id;
		}
	}
}
