<?php

// Quang NV

class Student extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index($offset=0) {
		$data = $this->get_all_require_data();
		$branch_id = $this->session->userdata('branch_id');
		$role_id =  $this->session->userdata('role_id');

		$get = $this->input->get();

		if ($role_id == 12) {
			$conditional['where']['branch_id'] = $branch_id;
		}

		$conditional['where']['level_contact_id'] = 'L5';
		$conditional['order'] = array('date_confirm' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/*
         * Lấy link phân trang và danh sách contacts
         */
		 
		$data['progress'] = $this->GetProccessToday();
		$data['progressType'] = 'Doanh thu tại cơ sở ngày hôm nay';
		
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$data['left_col'] = array('date_rgt', 'date_confirm', 'date_rgt_study');
		$data['right_col'] = array('class_study');

		$this->table .= 'class_study_id fee paid level_contact level_student date_rgt date_rgt_study';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['titleListContact'] = 'Danh sách học viên';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);

	}
	
	function view_all_contact($offset = 0) {
        $data = $this->get_all_require_data();
		
        $get = $this->input->get();
        $conditional['where'] = array('branch_id' => $this->session->userdata('branch_id'), 'is_hide' => '0');
        $conditional['order'] = array('date_rgt' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];
		
		$input = array();
		$input['where'] = array(
			'parent_id !=' => '' 
		);
		
		$this->load->model('level_contact_model');
		$this->load->model('level_student_model');
		$data['level_contact_detail'] = $this->level_contact_model->load_all($input);
		$data['level_student_detail'] = $this->level_student_model->load_all($input);
		
		$data['progress'] = $this->GetProccessThisMonth();
		$data['progressType'] = 'Doanh thu tại cơ sở tháng này';

        $data['left_col'] = array('date_rgt', 'date_handover', 'date_recall', 'date_confirm', 'date_rgt_study');
        $data['right_col'] = array('call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');

        $this->table .= 'fee paid call_stt level_contact date_rgt date_last_calling';
        $data['table'] = explode(' ', $this->table);
		
        $data['titleListContact'] = 'Danh sách toàn bộ contact';
		
		
		
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

	private function get_all_require_data() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1,
                    'active' => 1
                )
            ),
            'class_study' => array(
                'where' => array(
                    'active' => 1
                ),
                'order' => array(
                    'class_study_id' => 'ASC'
                )
            ),
            'call_status' => array(),
            //'ordering_status' => array(),
            'payment_method_rgt' => array(),
            'sources' => array(),
            'channel' => array(),
            'branch' => array(),
            'level_language' => array(),
            'language_study' => array(),
			'level_contact' => array(
				'where' => array(
					'parent_id' => ''
				)
			),
			'level_student' => array(
				'where' => array(
					'parent_id' => ''
				)
			),
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }
}
