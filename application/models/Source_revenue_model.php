<?php
class Source_revenue_model extends MY_Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'source_revenue';
	}

	function find_source_name($id) {

		$input2 = array();

		$input2['where'] = array('id' => $id);

		$sources = $this->load_all($input2);

		if (!empty($sources)) {

			return $sources[0]['name'];

		}

		return 0;

	}
}
