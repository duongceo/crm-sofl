<?php

class Customer_care extends MY_Controller {

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
//        $data['actionForm'] = 'customer_care/transfer_contact';
//        $informModal = 'customer_care/modal/transfer_multi_contact';
//        $data['informModal'] = explode(' ', $informModal);
//        $outformModal = 'customer_care/modal/transfer_one_contact sale/modal/show_script';
//        $data['outformModal'] = explode(' ', $outformModal);
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
//        $data['actionForm'] = 'customer_care/transfer_contact';
//        $informModal = 'customer_care/modal/transfer_multi_contact';
//        $data['informModal'] = explode(' ', $informModal);
//        $outformModal = 'customer_care/modal/transfer_one_contact sale/modal/show_script';
//        $data['outformModal'] = explode(' ', $outformModal);
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
