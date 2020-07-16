<?php

// Quang NV

class Student extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index($offset=0) {
		$data = $this->data;
		$branch_id = $this->session->userdata('branch_id');
		$role_id =  $this->session->userdata('role_id');

		$get = $this->input->get();

		if ($role_id == 12) {
			$conditional['where']['branch_id'] = $branch_id;
		}

		$conditional['where_in']['level_contact_id'] = array('L5', 'L5.1', 'L5.2', 'L5.3');
		$conditional['order'] = array('date_confirm' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/*
         * Lấy link phân trang và danh sách contacts
         */

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$data['left_col'] = array('date_rgt');
		$data['right_col'] = array('class_study');

		$this->table .= 'paid date_confirm';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['titleListContact'] = 'Danh sách học viên';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);

	}
}
