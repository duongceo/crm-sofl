<?php

class Customer_care extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();

        $conditional['where']['level_student_id'] = 'L6';
        $conditional['order'] = array('date_rgt_study' => 'ASC');

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        /*
         * Lấy link phân trang và danh sách contacts
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

		$input['where'] = array(
			'parent_id !=' => ''
		);
		$this->load->model('level_student_model');
		$data['level_student_detail'] = $this->level_student_model->load_all($input);

        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('branch', 'class_study', 'study_date_start', 'study_date_end');
        $data['right_col'] = array('language', 'level_student_detail');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table = 'selection name phone branch language class_study_id level_language date_rgt_study';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact đã nhập vào hôm nay';
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

	function view_contact_recall($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['date_recall_customer_care !='] = '';
		$conditional['order'] = array('date_recall_customer_care' => 'ASC');

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
		$data['left_col'] = array('date_recall_customer_care', 'study_date_start', 'study_date_end');
		$data['right_col'] = array('branch', 'class_study',  'language');

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table = 'selection name phone branch language class_study_id level_language date_customer_care_call';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào hôm nay';
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
		$this->table = 'selection name phone branch language level_language date_rgt_study';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

    private function _get_all_require_data() {
        $require_model = array(
        	'class_study' => array(),
			'branch' => array(),
            'language_study' => array(),
			'level_language' => array(),
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }

//    public function transfer_contact() {
//        $post = $this->input->post();
//        $list = isset($post['contact_id']) ? $post['contact_id'] : array();
//        $this->_action_transfer_contact($post['customer_care_id'], $list);
//    }
//
//    public function transfer_one_contact() {
//        $post = $this->input->post();
//        $this->_action_transfer_contact($post['customer_care_id'], array($post['contact_id']));
//    }
//
//    private function _action_transfer_contact($customer_care_transfer_id, $contact_id) {
//        if ($customer_care_transfer_id == 0) {
//            redirect_and_die('Vui lòng chọn nhân viên CSKH!');
//        }
//        if (empty($contact_id)) {
//            redirect_and_die('Vui lòng chọn contact!');
//        }
//
//        $data = array(
//            'customer_care_staff_id' => $customer_care_transfer_id,
//            'last_activity' => time()
//        );
//
//        foreach ($contact_id as $value) {
//            $where = array('id' => $value);
//            $this->contacts_model->update($where, $data);
//        }
//
//        $this->load->model('Staffs_model');
//        $staff_name = $this->Staffs_model->find_staff_name($sale_transfer_id);
//        $msg = 'Chuyển nhượng thành công cho nhân viên <strong>' . $staff_name . '</strong>';
//        show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], true);
//    }
    
}
