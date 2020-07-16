<?php

 /*

 * @author QuangNV

 */

class Teacher_model extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table = 'teacher';

	}

	public function find_teacher_name($id) {

		$name = '';

		$input2 = array();

		$input2['where'] = array('id' => $id);

		$staffs = $this->load_all($input2);

		if (!empty($staffs)) {

			$name = $staffs[0]['name'];

		}

		return $name;

	}

	public function GetStaffImage($id) {

		$name = '';

		$input2 = array();

		$input2['where'] = array('id' => $id);

		$staffs = $this->load_all($input2);

		if (!empty($staffs)) {

			$name = $staffs[0]['image'];

		}

		return $name;

	}

}

