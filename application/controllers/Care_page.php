<?php

class Care_page extends MY_Controller {

	public $L = array();

	public function __construct() {
		parent::__construct();
	}

	function index($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['care_page_staff_id !='] = '0';
		$conditional['where']['date_handover >='] = strtotime(date('d-m-Y'));
		$conditional['order'] = array('date_handover' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/*
         * Lấy link phân trang và danh sách contacts
         */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('date_rgt');
//        $data['right_col'] = array('');

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table = 'selection name phone branch language level_language date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào hôm nay';
		$data['actionForm'] = '';
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function view_all_contact($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['care_page_staff_id !='] = '0';
		$conditional['order'] = array('date_handover' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/*
         * Lấy link phân trang và danh sách contacts
         */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('date_rgt');
//        $data['right_col'] = array('');

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table = 'selection name phone branch language level_language date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào';

		$data['actionForm'] = '';
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	private function _get_all_require_data() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 10,
					'active' => 1
				)
			),
			'branch' => array(),
			'language_study' => array(),
			'level_language' => array(),
		);
		return array_merge($this->data, $this->_get_require_data($require_model));
	}
}
