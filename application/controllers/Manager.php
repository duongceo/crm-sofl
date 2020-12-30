<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Manager extends MY_Controller {

    public $L = array();

    function __construct() {
        parent::__construct();
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'level_contact_id' => '', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id' => '0');
        $this->L['L1'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id >' => '0');
        $this->L['L1_trung'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('is_hide' => '0');
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

    function index($offset = 0) {
        $data = $this->get_all_require_data();
        //var_dump($data);
        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

        $conditional['where'] = array('call_status_id' => '0', 'level_contact_id' => '', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id' => '0');
        $conditional['order'] = array('date_rgt' => 'DESC');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /*
         * Lấy danh sách contacts
         */
        $contacts = $data_pagination['data'];
        foreach ($contacts as &$value) {
            $value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);

        $data['contacts'] = $contacts;
        $data['progress'] = $this->GetProccessToday();
        $data['progressType'] = 'Tiến độ các team ngày hôm nay';
        $data['total_contact'] = $data_pagination['total_row'];
		
		//print_arr($data);
        /*
         * Lấy link phân trang
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('duplicate', 'date_rgt');
        //$data['right_col'] = array('tv_dk');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'class_study_id fee paid date_rgt matrix';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact mới không trùng';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function new_duplicate($offset = 0) {
        $data = $this->get_all_require_data();
        //print_arr($data);
        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

        $conditional['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id >' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /*
         * Lấy danh sách contacts
         */
        $contacts = $data_pagination['data'];
        foreach ($contacts as &$value) {
            $value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);

        $data['contacts'] = $contacts;
        $data['progress'] = $this->GetProccessToday();
        $data['progressType'] = 'Tiến độ các team ngày hôm nay';

        $data['total_contact'] = $data_pagination['total_row'];
        /*
         * Lấy link phân trang
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('duplicate', 'date_rgt');
//        $data['right_col'] = array('');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'class_study_id date_rgt matrix';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact mới bị trùng';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);
        /*
         * Các file js cần load
         */

//        $data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact',
//            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
//        );
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    /*
    function transfer_contact_sale($offset = 0) {
        $data = $this->get_all_require_data();
        // echo "<pre>"; print_r($data);
        $get = $this->input->get();
        // echo "<pre>"; print_r($get);die();

        $conditional['where'] = array('is_transfer' => '1');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        $contacts = $data_pagination['data'];

        // echo "<pre>"; print_r($contacts);die();

        $this->load->model('notes_model');
        $this->load->model('transfer_logs_model');
        $this->load->model('staffs_model');
        foreach ($contacts as &$value) {
            $input1 = array();
            $input1['where'] = array('contact_id' => $value['id']);
            $input1['order'] = array('id' => 'DESC');
            $contact_transfer = $this->transfer_logs_model->load_all($input1);
            // echo "<pre>"; print_r($contact_transfer);
            $sale_transfer = '';
            $sale_receive = '';
            $sale_transfer = $this->staffs_model->find_staff_name($contact_transfer[0]['sale_id_1']);
            $sale_receive = $this->staffs_model->find_staff_name($contact_transfer[0]['sale_id_2']);

            // echo $sale_transfer . '--' . $sale_receive;die();

            $input = array();
            $input['where'] = array('contact_code' => $value['phone'] . '_' . $value['course_code']);
            $input['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= '<p>' . date('d/m/Y', $value2['time']) . ' ==> ' . $value2['content'] . '</p>';
                }
                $notes .= '<strong>' . $sale_transfer . ' - chuyển contact tới - '. $sale_receive .'</strong>';
                $value['last_note'] = $notes;
            } else {
                $notes .= '<strong>' . $sale_transfer . ' - chuyển contact tới - '. $sale_receive .'</strong>';
                $value['last_note'] = $notes;
            }
        }
        // die();
        $data['contacts'] = $contacts;

        $data['total_contact'] = $data_pagination['total_row'];

        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);

        $data['left_col'] = array('tu_van', 'date_handover', 'date_last_calling','call_status');
        $data['right_col'] = array('is_transfered', 'course_code');

        $this->table = 'selection name phone last_note call_stt course_code price_purchase date_last_calling date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact chờ chuyển';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);
		
//		$data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact',
//            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
//        );

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
       
    }
    */

    function view_all_contact($offset = 0) {
        $data = $this->get_all_require_data();

        $input = array();
        $input['where'] = array(
            'role_id' => 6,
            'active' => 1
		);
        $data['marketers'] = $this->staffs_model->load_all($input);
		
		$input['where'] = array(
			'parent_id !=' => '' 
		);
		
		$this->load->model('level_contact_model');
		$this->load->model('level_student_model');
		$data['level_contact_detail'] = $this->level_contact_model->load_all($input);
		$data['level_student_detail'] = $this->level_student_model->load_all($input);

        $get = $this->input->get();
//		print_arr($get);
        /*
         * Điều kiện lấy contact :
         * lấy tất cả contact nên $conditional là mảng rỗng
         *
         */
        $conditional['where'] = array('is_hide' => '0');

        if (isset($get['export_all'])) {
            $post = [];
            $allContact = $this->_query_all_from_get($get, $conditional, 100000, $offset);
              // echoQuery();die;
            foreach ($allContact['data'] as $value) {
                $post['contact_id'][] = $value['id'];
            }
            $this->ExportToExcel($post);
        }

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        /*
         * Lấy link phân trang và danh sách contacts
         */

        $contacts = $data_pagination['data'];
//		print_arr($contacts);

        foreach ($contacts as &$value) {
            $value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);

        $data['contacts'] = $contacts;
        $data['progress'] = $this->GetProccessThisMonth();
        $data['progressType'] = 'Tiến độ các team tháng này';
        $data['total_contact'] = $data_pagination['total_row'];
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);

        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('care_number', 'language', 'level_language', 'sale', 'marketer', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling', 'date_paid');
        $data['right_col'] = array('branch', 'is_old', 'source', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		 
        $this->table .= 'fee paid call_stt level_contact level_student date_rgt date_handover date_last_calling';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách toàn bộ contact';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

//    function view_pivot_table() {
//        $data = $this->data;
//        $data['left_col'] = array('date_rgt');
//        $data['load_js'] = array('m_pivot_table');
//        $data['content'] = 'manager/pivot_table';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

    function view_duplicate() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
            'call_status' => array(),
            'payment_method_rgt' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('duplicate_id' => $post['duplicate_id']);
        $input['limit'] = array('10', '0');
        $duplicate_contacts = $this->contacts_model->load_all($input);
        $data['rows'] = $duplicate_contacts;
        $input3 = array();
        $input3['where'] = array('id' => $post['duplicate_id']);
        $primary_contact = $this->contacts_model->load_all($input3);
        $data['primary_contact'] = $primary_contact;
        $data['total_contact'] = count($duplicate_contacts);
        $this->load->view('manager/modal/view_duplicate', $data);
    }

    // <editor-fold defaultstate="collapsed" desc="hàm add contact và các hàm phụ trợ">
    /* ========================  hàm add contact và các hàm phụ trợ =========================== */

//    public function add_contact() {
//        $input = $this->input->post();
////        print_arr($input);
//        $this->load->library('form_validation');
//        $this->form_validation->set_rules('name', 'Họ tên', 'trim|required|min_length[2]');
//        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|min_length[3]');
//        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|min_length[2]|integer');
////        $this->form_validation->set_rules('class_study_id', 'Mã khóa học', 'required|callback_check_course_code');
////        $this->form_validation->set_rules('source_id', 'Nguồn contact', 'required|callback_check_source_id');
//        if (!empty($input)) {
//            $result = array();
//            if ($this->form_validation->run() == FALSE) {
//                $result['success'] = 0;
//                $result['message'] = 'Có lỗi xảy ra trong quá trình nhập liệu!';
//                $require_model = array(
//                    'class_study' => array(
//                        'where' => array('active' => '1'),
//                    ),
//                    'sources' => array()
//                );
//                $data = array_merge($this->data, $this->_get_require_data($require_model));
//                //  $data['content'] = 'manager/add_contact';
//                $data['content'] = 'common/modal/add_new_contact';
//                $this->load->view('common/modal/add_new_contact', $data);
//                $result['content'] = $this->load->view('common/modal/add_new_contact', $data, true);
//                echo json_encode($result);
//                die;
////                $this->session->set_tempdata('message', 'Có lỗi xảy ra trong quá trình nhập liệu', 2);
////                $this->session->set_tempdata('msg_success', 0, 2);
////                $this->_view_add_contact();
//            } else {
//                $param['name'] = $input['name'];
//                $param['email'] = $input['email'];
//                $param['address'] = $input['address'];
//
//				$t = stripos($param['address'], 'mh');
//				if ($t === false) {
//					$param['is_consultant'] = 0;
//				} else {
//					$param['is_consultant'] = 1;
//				}
//
//                $param['phone'] = trim($input['phone']);
//                $param['class_study_id'] = $input['class_study_id'];
//                $param['source_id'] = $input['source_id'];
//                $param['payment_method_rgt'] = $input['payment_method_rgt'];
//                $param['fee'] = $input['fee'];
//                $param['paid'] = $input['paid'];
//                $param['date_rgt'] = time();
//                $param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], $input['phone'], $input['class_study_id']);
//                $param['last_activity'] = time();
////                $param['source_sale_id'] = $input['source_sale_id'];
//                $id = $this->contacts_model->insert_return_id($param, 'id');
//				$a = $this->contacts_backup_model->insert_return_id($param, 'id');
//                if ($input['note'] != '') {
//                    $param2 = array(
//                        'contact_id' => $id,
//                        'content' => $input['note'],
//                        'time' => time(),
//                        'sale_id' => $this->user_id,
//                        'contact_code' => $this->contacts_model->get_contact_code($id)
//                    );
//                    $this->load->model('notes_model');
//                    $this->notes_model->insert($param2);
//                }
//                $data2 = [];
//
//                $data2['title'] = 'Có 1 contact mới đăng ký';
//                $data2['message'] = 'Click để xem ngay';
//
//                require_once APPPATH . 'libraries/Pusher.php';
//                $options = array(
//                    'cluster' => 'ap1',
//                    'encrypted' => true
//                );
////                $pusher = new Pusher(
////                        '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
////                );
//				$pusher = new Pusher(
//					'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
//				);
//
//                $pusher->trigger('my-channel', 'notice', $data2);
//                $result['success'] = 1;
//                $result['message'] = 'Thêm thành công contact!';
//                echo json_encode($result);
//                die;
//            }
//        } else {
//            $this->_view_add_contact();
//        }
//    }

//    private function _view_add_contact() {
//        $require_model = array(
//            'class_study' => array(
//                'where' => ['active' => '1'],
//            ),
//            'sources' => array()
//        );
//        $data = array_merge($this->data, $this->_get_require_data($require_model));
//        //  $data['content'] = 'manager/add_contact';
//        $data['content'] = 'common/modal/add_new_contact';
//        $this->load->view('common/modal/add_new_contact', $data);
//    }

//    function check_source_id($str) {
//        if ($str == 0) {
//            $this->form_validation->set_message('check_source_id', 'Vui lòng chọn {field}!');
//            return false;
//        }
//        return true;
//    }

    /* ========================  hàm add contact và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm chia contact (chia riêng contact) và các hàm phụ trợ">
    /* ========================  hàm chia contact (chia riêng contact) và các hàm phụ trợ =========================== */
    function divide_contact() {
        $post = $this->input->post();
        // echo "<pre>";print_r($post);die();

        $this->_action_divide_contact($post);
    }

    /*
     * Chia contact
     */

    private function _action_divide_contact($post) {
        $result = array();
        $this->load->model('Staffs_model');

        if (empty($post)) {
            $result['success'] = 0;
            $result['message'] = "Có lỗi xảy ra! Mã lỗi : 30201";
            echo json_encode($result);
            die;
        }
        if (!isset($post['contact_id'])) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }

		$sale_id = $post['sale_id'];
        $contact_ids = is_array($post['contact_id']) ? $post['contact_id'] : array($post['contact_id']);
        $note = $post['note'];

		if ($post['transfer_contact'] == 2) {
			$this->load->model('transfer_logs_model');

            $data_cancel = array(
                'last_activity' => time(),
                'is_transfer' => '0'
            );

            // $data2 = array('is_transfered' => '0');

            foreach ($contact_ids as $value) {
                $where_cancel = array('id' => $value);
                $this->contacts_model->update($where_cancel, $data_cancel);

                $where2 = array('contact_id' => $value);
                $this->transfer_logs_model->delete($where2);
            }

            $result['success'] = 1;
            $result['message'] = 'Đã hủy chuyển contact';
            echo json_encode($result);
            die;
        }

        if ($sale_id == 0) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn nhân viên TVTS!";
            echo json_encode($result);
            die;
        }
        if (empty($contact_ids)) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }

        if ($post['transfer_contact'] == 1) {
            $this->load->model('transfer_logs_model');

            $data_transfer = array(
                'is_transfered' => '1'
            );

            // $this->transfer_logs_model->update($where_transfer, $data_transfer);

            $data = array(
                'sale_staff_id' => $sale_id,
                'is_transfered' => '1',
                'date_transfer' => time(),
                'last_activity' => time()
            );

            foreach ($contact_ids as $value) {
                $where = array('id' => $value);
                $this->contacts_model->update($where, $data);

                $where_transfer = array(
                    'contact_id' => $value
                );

                $this->transfer_logs_model->update($where_transfer, $data_transfer);
            }

            if ($note != '') {
                $this->load->model('notes_model');
                foreach ($contact_ids as $value) {
                    $param2 = array(
                        'contact_id' => $value,
                        'content' => $note,
                        'time' => time(),
                        'sale_id' => $this->user_id,
                        'contact_code' => $this->contacts_model->get_contact_code($value)
                    );
                    $this->notes_model->insert($param2);
                }
            }

            $staff_name = $this->Staffs_model->find_staff_name($sale_id);

            $result['success'] = 1;
            $result['message'] = 'Đã chuyển contact cho nhân viên ' . $staff_name;
            echo json_encode($result);
            die;
        }

        $checkContactCanBeDivide = $this->_check_contact_can_be_divide($contact_ids);
        if (!empty($checkContactCanBeDivide)) {
            echo json_encode($checkContactCanBeDivide);
            die;
        }
        $data = array(
            'sale_staff_id' => $sale_id,
            'date_handover' => time(),
            'last_activity' => time()
        );
        foreach ($contact_ids as $value) {
            $where = array('id' => $value);
            $this->contacts_model->update($where, $data);
        }
        if ($note != '') {
            $this->load->model('notes_model');
            foreach ($contact_ids as $value) {
                $param2 = array(
                    'contact_id' => $value,
                    'content' => $note,
                    'time' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($value)
                );
                $this->notes_model->insert($param2);
            }
        }

        $staff_name = $this->Staffs_model->find_staff_name($sale_id);

        $result['success'] = 1;
        $result['message'] = 'Phân contact thành công cho nhân viên ' . $staff_name;
        echo json_encode($result);
        die;
    }

	// chia đều contact
    function divide_contact_auto() {
        $post = $this->input->post();
        $result = array();
        $this->load->model('Staffs_model');
        if (empty($post)) {
            $result['success'] = 0;
            $result['message'] = "Có lỗi xảy ra! Mã lỗi : 30201";
            echo json_encode($result);
            die;
        }

        if (!isset($post['contact_id'])) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }

        $sale_id = is_array($post['sale_id']) ? $post['sale_id'] : array($post['sale_id']);
        $contact_ids = is_array($post['contact_id']) ? $post['contact_id'] : array($post['contact_id']);
        // var_dump($contact_ids);die();
        if ($sale_id == 0) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn nhân viên TVTS!";
            echo json_encode($result);
            die;
        }

        if (empty($contact_ids)) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }

        $checkContactCanBeDivide = $this->_check_contact_can_be_divide($contact_ids);
        if (!empty($checkContactCanBeDivide)) {
            echo json_encode($checkContactCanBeDivide);
            die;
        }

        $data1 = array(
            // 'sale_staff_id' => $sale_id,
            'date_handover' => time(),
            'last_activity' => time()
        );

        foreach ($contact_ids as $value) {
            $where = array('id' => $value);
            $this->contacts_model->update($where,$data1);
        }

        shuffle($contact_ids); //trộn đều các contact
//		print_arr($contact_ids);

        $this->load->model('Staffs_model');
        $input = array();
        foreach ($sale_id as $key => $value) {
			$input['where'] = array('id' => $value);
			$sale[] = $this->staffs_model->load_all($input);
			$sale[$key][0]['count'] = 0;
        }

        //$this->action_divide_contact_auto($sales, $contact_ids, 0);
		$this->action_divide_contact_auto_test($sale, $contact_ids, 0);
        // var_dump($contacts);die();

    }

//    function action_divide_contact_auto($sales, $contact_ids, $i) {
//        /*
//         * Hàm đệ quy chia đều contact
//         * Chia từng contact 1 cho các TVTS với số lượng max của từng TVTS
//         * $i: số thứ tự của contact
//         */
//        // var_dump($sales[1][0]['max_contact']);die();
//        // var_dump($contacts[$i][0]['id']);die();
//        $stop = true; // cờ kiểm tra dừng chia
//        $count = 0;
//        foreach ($sales as $value) {
//            foreach ($value as $val) {
//                // echo($val['max_contact'].'<br>');
//                if (!isset($contact_ids[$i]))
//                    return false;
//                if ($count < $val['max_contact']) {
//                    $where = array('id' => $contact_ids[$i]);
//                    $data = array(
//                        // 'draft_sale_staff_id' => $val['id'],
//                        'sale_staff_id' => $val['id']
//                    );
//                    $this->contacts_model->update($where, $data);
//                    $count++;
//                    $i++;
//                    $stop = false;
//                }
//            }
//        }
//
//        if (!$stop) {
//            $this->action_divide_contact_auto($sales, $contact_ids, $i);
//        }
//
//        $result['success'] = 1;
//        $result['message'] = 'Phân contact thành công';
//        echo json_encode($result);
//        die;
//    }

	function action_divide_contact_auto_test($sale, $contact_ids, $i) {

		$tmp = 0;
      	foreach ($contact_ids as $value) {
			$count_sale = count($sale);
			if ($sale[$i][0]['count'] < $sale[$i][0]['max_contact']){
//				echo $value . '<br>';
				$where = array('id' => $value);
				$data = array(
					'sale_staff_id' => $sale[$i][0]['id']
				);
				$this->contacts_model->update($where, $data);
//				echo $sale[$i][0]['count'].'-'. $sale[$i][0]['max_contact'].'-'.$sale[$i][0]['name'] .'-'.$value. '<br>';
				$sale[$i][0]['count'] ++;
				$i++; //đếm lần lượt từng sale nhận contact
				$tmp++;
//				echo $i .'-'.'<hr>';
				if ($i == $count_sale) {
					$i = 0;
				}
			}
		}

      	$result['success'] = 1;
      	$result['message'] = 'Phân ' . $tmp . ' contact thành công';
      	echo  json_encode($result);
		die();
	}

    /*
     * Check điều kiện chia contact (Contact không bị trùng và contact chưa được phân cho ai)
     */

    private function _check_contact_can_be_divide($contact_ids) {
        $result = array();
        $this->load->model('Staffs_model');
        foreach ($contact_ids as $value) {
            $input = array();
            $input['select'] = 'sale_staff_id, id, duplicate_id, is_hide';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);

            if (empty($rows)) {
                $result['success'] = 0;
                $result['message'] = "Không tồn tại khách hàng này! Mã lỗi : 30203";
            }
            if ($rows[0]['is_hide'] == '1') {
                $result['success'] = 0;
                $result['message'] = "Contact này đã bị xóa, vì vậy không thể phân contact này được!";
            }

            if ($rows[0]['sale_staff_id'] > 0) {
                $name = $this->Staffs_model->find_staff_name($rows[0]['sale_staff_id']);
                $msg = 'Contact có id = ' . $rows[0]['id'] . ' đã được phân cho TVTS: ' . $name . '. Vì vậy không thể phân tiếp được nữa!';
                $result['success'] = 0;
                $result['message'] = $msg;
            }
//            if ($this->role_id == 3 && $rows[0]['duplicate_id'] > 0) {
//                $msg = 'Contact "' . $rows[0]['name'] . '" có id = ' . $rows[0]['id'] . ' bị trùng. '
//                        . 'Vì vậy không thể phân contact đó được! Vui lòng thực hiện lại';
//                $result['success'] = 0;
//                $result['message'] = $msg;
//            }
        }

        return $result;
    }

    /* ========================  hàm chia contact (chia riêng contact) và các hàm phụ trợ  (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm chia contact (chia đều contact) và các hàm phụ trợ">
    /* ========================  hàm chia contact (chia đều contact) và các hàm phụ trợ =========================== */
//    function divide_contact_even() {
//        $post = $this->input->post();
//        if (empty($post)) {
//            die('Có lỗi xảy ra! Mã lỗi : 30401');
//        }
//        $contact_ids = $post['contact_id'];
//
//        if (count($contact_ids) == 0) {
//            $msg = 'Không có contact nào được chọn';
//            show_error_and_redirect($msg, base_url('manager'), false);
//        }
//
//        $this->_check_contact_can_be_divide($contact_ids);
//
//        /* reset toàn bộ contact phân nháp trước đó mà người dùng chưa hủy nháp */
//        $data1 = array('has_draft_divide' => '0');
//        $this->contacts_model->update(array(), $data1);
//
//        /* Lưu nháp các contact đã chọn */
//        foreach ($contact_ids as $value) {
//            $where = array('id' => $value);
//            $data2 = array('has_draft_divide' => 1);
//            $this->contacts_model->update($where, $data2);
//        }
//
//        $require_model = array(
//            'contacts' => array(
//                'where' => array('has_draft_divide' => 1),
//                'order' => array('id' => 'DESC')
//            ),
//            'staffs' => array(
//                'where' => array('role_id' => 1, 'active' => 1),
//            ),
//            'courses' => array()
//        );
//        $data = array_merge($this->data, $this->_get_require_data($require_model));
//
//        $this->table .= 'date_rgt matrix';
//        $data['table'] = explode(' ', $this->table);
//        $data['content'] = 'manager/divide_contact_even';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

//    function draft_divide_contact_even3() {
//        $this->load->model('Staffs_model');
//        $input = array();
//        $input['where'] = array(
//            'has_draft_divide' => 1
//        );
//        $input['order'] = array('id' => 'DESC');
//        $contacts = $this->contacts_model->load_all($input);
//        shuffle($contacts); //trộn đều các contact
//
//        $post = $this->input->post();
//        if (!empty($post['max_contact'])) {
//            /* ================cập nhật contact max cho mỗi nhân viên ======================== */
//            foreach ($post['max_contact'] as $key => $value) {
//                if ($value == '' || intval($value) < 0) {
//                    $name = $this->Staffs_model->find_staff_name($key);
//                    $msg = 'Vui lòng điền số lượng contact tối đa cho nhân viên "' . $name . '". Tối thiểu là 0 contact.';
//                    die($msg);
//                }
//                $data1 = array('max_contact' => $value);
//                $where = array('id' => $key);
//                $this->staffs_model->update($where, $data1);
//            }
//            $this->_common_load_view_draft_divide($contacts);
//        } else {
//            $this->_common_load_view_draft_divide($contacts);
//        }
//    }

//    private function _common_load_view_draft_divide($contacts) {
//        $require_model = array(
//            'staffs' => array(
//                'where' => array('role_id' => 1, 'active' => 1)
//            ),
//            'courses' => array()
//        );
//        $data = array_merge($this->data, $this->_get_require_data($require_model));
//
//        foreach ($data['staffs'] as $key => $value) {
//            $data['staffs'][$key]['count'] = 0;
//        }
//
//        $this->draft_divide_contact_even1($data['staffs'], $contacts, 0);
//
//        foreach ($data['staffs'] as $key => $value) {
//            $input = array();
//            $input['where'] = array('draft_sale_staff_id' => $value['id']);
//            $input['order'] = array('id' => 'DESC');
//            $data['staffs'][$key]['contacts'] = $this->contacts_model->load_all($input);
//            $data['staffs'][$key]['cancel_contact'] = 1;
//        }
//        $data['total_contact'] = count($contacts);
//        $table = 'selection contact_id name phone address course_code price_purchase ';
//        $table .= 'date_rgt matrix action';
//        $data['table'] = explode(' ', $table);
//        $data['load_js'] = array('m_cancel_contact');
//        $data['content'] = 'manager/draft_divide_contact_even';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

//    function draft_divide_contact_even1($staffs, $contacts, $i) {
//        /*
//         * Hàm đệ quy chia đều contact
//         * Chia từng contact 1 cho các TVTS với số lượng max của từng TVTS
//         * $i: số thứ tự của contact
//         */
//        $stop = true; // cờ kiểm tra dừng chia
//        foreach ($staffs as $key => $value) {
//            if (!isset($contacts[$i]))
//                return false;
//            if ($value['count'] < $value['max_contact']) {
//                $where = array('id' => $contacts[$i]['id']);
//                $data = array(
//                    'draft_sale_staff_id' => $value['id']
//                );
//                $this->contacts_model->update($where, $data);
//                $staffs[$key]['count'] ++;
//                $i++;
//                $stop = false;
//            }
//        }
//        if (!$stop) {
//            $this->draft_divide_contact_even1($staffs, $contacts, $i);
//        }
//    }

//    function cancel_multi_contact() {
//        $post = $this->input->post();
//        if (empty($post['contact_id'])) {
//            redirect_and_die('Vui lòng chọn Contact!');
//        }
//        foreach ($post['contact_id'] as $value) {
//            $where = array('id' => $value);
//            $data = array('has_draft_divide' => '0', 'draft_sale_staff_id' => '0');
//            $this->contacts_model->update($where, $data);
//        }
//        $msg = 'Bỏ chọn contact thành công!';
//        show_error_and_redirect($msg);
//    }

//    function cancel_one_contact() {
////        $post = $this->input->post();
////        $post['contact_id'];
////        if ($post['contact_id'] > 0) {
////            $where = array('id' => $post['contact_id']);
////            $data = array('has_draft_divide' => '0', 'draft_sale_staff_id' => '0');
////            if ($this->contacts_model->update($where, $data)) {
////                echo 1;
////            }
////        }
////    }

//    function confirm_divide_contact_even() {
//        $post = $this->input->post();
//        if (isset($post['submit_ok']) && $post['submit_ok'] == 'OK') {
//            $query1 = 'UPDATE `tbl_contact` set `sale_staff_id` = `draft_sale_staff_id`, `date_handover`=' . time()
//                    . ', `last_activity` = ' . time() . ' WHERE `draft_sale_staff_id` > 0';
//            $query2 = 'UPDATE `tbl_contact` set `draft_sale_staff_id` = 0, `has_draft_divide` = 0 WHERE `draft_sale_staff_id` > 0';
//            $total = $this->contacts_model->query($query1);
//            $this->contacts_model->query($query2);
//            $msg = 'Phân thành công ' . $total . ' contact!';
//            show_error_and_redirect($msg, base_url('manager'));
//        }
//        if (isset($post['submit_cancel']) && $post['submit_cancel'] == 'Cancel') {
//            $query = 'UPDATE `tbl_contact` set `draft_sale_staff_id` = 0, `has_draft_divide` = 0 WHERE `draft_sale_staff_id` > 0';
//            $this->contacts_model->query($query);
//            $msg = 'Hủy bỏ thành công nghiệp vụ phân đều contact';
//            show_error_and_redirect($msg, base_url('manager'));
//        }
//    }

    /* ========================  hàm chia contact (chia đều contact) và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm xóa contact và các hàm phụ trợ">
    /* ========================  hàm xóa contact và các hàm phụ trợ =========================== */
//    function delete_contact() {
//        $post = $this->input->post();
//        if (empty($post['contact_id'])) {
//            redirect_and_die('Vui lòng chọn contact!');
//        }
//        $this->_check_contact_can_be_delete($post['contact_id']);
//        foreach ($post['contact_id'] as $value) {
//            $where = array('id' => $value);
//            $data = array('is_hide' => 1, 'last_activity' => time());
//            $this->contacts_model->update($where, $data);
//        }
//        $msg = 'Xóa thành công các contact vừa chọn!';
//        show_error_and_redirect($msg);
//    }

//    function delete_one_contact() {
//        $post = $this->input->post();
//        if (!empty($post['contact_id'])) {
//            $this->_check_contact_can_be_delete(array($post['contact_id']));
//            $where = array('id' => $post['contact_id']);
//            $data = array('is_hide' => 1, 'last_activity' => time());
//            $this->contacts_model->update($where, $data);
//            echo '1';
//        }
//    }

//    private function _check_contact_can_be_delete($list) {
//        $this->load->model('Staffs_model');
//        foreach ($list as $value) {
//            $input = array();
//            $input['select'] = 'duplicate_id, sale_staff_id';
//            $input['where'] = array('id' => $value);
//            $rows = $this->contacts_model->load_all($input);
//            if ($rows[0]['duplicate_id'] == 0) {
//                redirect_and_die('Contact ' . $rows[0]['name'] . ' không bị trùng, vì vậy không thể xóa contact này!');
//            }
//            if ($rows[0]['sale_staff_id'] > 0) {
//                $name = $this->Staffs_model->find_staff_name($rows[0]['sale_staff_id']);
//                $msg = 'Contact này đã được bàn giao cho TVST: "' . $name . '", vì vậy không thể xóa contact này!';
//                redirect_and_die($msg);
//            }
//        }
//    }

    /* ========================  hàm xóa contact và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Tìm kiếm contact">
//    function find_contact() {
//        $get = $this->input->get();
//        $data = $this->_common_find_all($get);
//        $this->table .= 'date_rgt date_last_calling call_stt ordering_stt action';
//        $data['table'] = explode(' ', $this->table);
//        $data['content'] = 'manager/find_contact';
//        $data['load_js'] = array('common_real_search');
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Báo cáo chi tiết của sale">
    function view_report_sale() {

		$require_model = array(
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
		);
		$data = array_merge($this->data, $this->_get_require_data($require_model));
		$language = $data['language_study'];

//		$this->load->model('call_log_model');
        $get = $this->input->get();
		//echo '<pre>'; print_r($get);die;

		$input = array();
		$input['where'] = array('role_id' => 1, 'active' => 1);
        $staffs = $this->staffs_model->load_all($input);

        /* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$startDate = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $startDate));
		$endDate = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

        if (isset($get['tic_report']) && !empty($get['tic_report'])) {
            $conditionArr = array(
				'NHAN' => array(
					'where' => array('date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
                'CHUA_GOI' => array(
                    'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0'),
                    'sum' => 0
                ),
				'XU_LY' => array(
                    'where' => array('call_status_id !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0'),
                    'sum' => 0
                ),
				'NGHE_MAY' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'KHONG_NGHE_MAY' => array(
					'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
                'L1' => array(
                    'where' => array('is_hide' => '0', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'level_contact_id' => 'L1'),
                    'sum' => 0
                ),
                'L2' => array(
                    'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L3' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L4' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L4', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L5' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L6' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L6', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L7' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L7', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'L8' => array(
                    'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L8', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                    'sum' => 0
                ),
                'LC' => array(
                    'where' => array('is_hide' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate,
                        '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ')' => 'NO-VALUE'),
                    'sum' => 0
                ),
                /*
                'CON_CUU_DUOC' => array(
                    'where' => array('is_hide' => '0', 'date_rgt >' => $startDate, 'date_rgt <' => $endDate,
                        '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                    'sum' => 0
                ),
                */
            );
        } else {
            $conditionArr = array(
				'NHAN' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'CHUA_GOI' => array(
					'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'XU_LY' => array(
					'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'NGHE_MAY' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'KHONG_NGHE_MAY' => array(
					'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'L1' => array(
					'where' => array('is_hide' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'level_contact_id' => 'L1'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
					'sum' => 0
				),
				'L4' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L4', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L6' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L6', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L7' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L7', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L8', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
                'LC' => array(
                    'where' => array('is_hide' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate,
                        '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ')' => 'NO-VALUE'),
                    'sum' => 0
                ),
				/*
                'CON_CUU_DUOC' => array(
                    'where' => array('is_hide' => '0', 'date_rgt >' => $startDate, 'date_rgt <' => $endDate,
                        '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                    'sum' => 0
                ),
                */
            );
        }

		unset($get['filter_date_date_happen']);

//		$time_start = microtime(true);

		$input_contact = array();
		$input_contact['select'] = 'id';
		$input_contact['where']['date_paid >='] = $startDate;
		$input_contact['where']['date_paid <='] = $endDate;
		$input_contact['where']['level_contact_id'] = 'L5';

		foreach ($conditionArr as $key2 => $value2) {
        	foreach ($staffs as $key_staff => $value_staff) {
				$conditional_1 = array();
				$conditional_1['where']['sale_staff_id'] = $value_staff['id'];
				$conditional_1['where_not_in']['source_id'] = array(11);
				$conditional = array_merge_recursive($conditional_1, $value2);

                $staffs[$key_staff][$key2] = $this->_query_for_report($get, $conditional);
                //$conditionArr_staff[$key2]['sum'] += $staffs[$key][$key2];
				$data[$key2] += $staffs[$key_staff][$key2];

				if ($value_staff['out_report'] == 1) { // ko tính contact này vào tổng
					$data[$key2] = $data[$key2] - $staffs[$key_staff][$key2];
				}

				$staffs[$key_staff]['RE'] = $this->get_re($conditional_1, $startDate, $endDate);
				//$data['RE'] += $staffs[$key_staff]['RE'];
				
            }
			
			if ($this->role_id == 3) {
				foreach ($language as $key_language => $value_language) {
					$conditional = array();
					$conditional['where']['language_id'] = $value_language['id'];
					$conditional['where_not_in']['source_id'] = array(9, 10);
					$conditional['where_not_in']['sale_staff_id'] = array(5, 18);
					if ($key2 == 'NHAN' && empty($get['tic_report'])) {
						unset($value2['where']['date_handover >='], $value2['where']['date_handover <=']);
						$value2['where']['date_rgt >='] = $startDate;
						$value2['where']['date_rgt <='] = $endDate;
						$value2['where']['duplicate_id'] = '0';
					}
					$conditional = array_merge_recursive($conditional, $value2);
					$language[$key_language][$key2] = $this->_query_for_report($get, $conditional);
					$data[$key2 . '_L'] += $language[$key_language][$key2];
				}
			}

        }
		
		foreach ($staffs as $value) {
			$data['RE'] += $value['RE'];
		}

//		Tính thời gian thực hiện của khối lệnh trên
//		$time_end = microtime(true);
//		$execution_time = ($time_end - $time_start)/60;
//		echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';die();

//		foreach ($staffs as $key => $value) {
//            $input = array();
//            $input['where']['staff_id'] = $value['id'];
//            $input['where']['time >'] = $startDate;
//            $input['where']['time <'] = $endDate;
//            $staffs[$key]['LUOT_GOI'] = count($this->call_log_model->load_all($input));
//            $conditionArr['LUOT_GOI']['sum'] += $staffs[$key]['LUOT_GOI'];
//            if ($value['id'] == 163) { // ko tính contact trùng vào tổng
//                $conditionArr['LUOT_GOI']['sum'] = $conditionArr['LUOT_GOI']['sum'] - $staffs[$key]['LUOT_GOI'];
//            }
//        }

		$data['language'] = $language;
//		$data['source'] = $source;
        $data['staffs'] = $staffs;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('branch', 'date_happen_1', 'tic_report');
        $data['right_col'] = array('is_old');
        $data['load_js'] = array('m_view_report');
        $data['content'] = 'manager/view_report';
        if($this->role_id == 1){
            $data['top_nav'] = 'sale/common/top-nav';
        }
//        print_arr($data);
        $this->	load->view(_MAIN_LAYOUT_, $data);
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Báo cáo doanh thu theo cơ sở và ngôn ngữ">
    function view_report_revenue() {
        $this->load->helper('manager_helper');
		$this->load->model('paid_model');
		$require_model = array(
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
		);
		$data = array_merge($this->data, $this->_get_require_data($require_model));

        $get = $this->input->get();

		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$date_from = trim($dateArr[0]);
		$date_from = strtotime(str_replace("/", "-", $date_from));
		$date_end = trim($dateArr[1]);
		$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;

		$input_re = array();
		$input_re['select'] = 'SUM(paid) as paiding';
		$input_re['where'] = array(
			'time_created >=' => $date_from,
			'time_created <=' => $date_end,
		);

		$language_re = array();
		foreach ($data['language_study'] as $value) {

			$input_re['where_not_in']['source_id'] = array(9, 10, 11);
			$language_input_re_new = array_merge_recursive(array('where' => array('student_old' => '0', 'language_id' => $value['id'])), $input_re);
			$language_input_re_old = array_merge_recursive(array('where' => array('student_old' => '1', 'language_id' => $value['id'])), $input_re);
			$language_input_re = array_merge_recursive(array('where' => array('language_id' => $value['id'])), $input_re);

			$language_re[$value['id']]['language_name'] = $value['name'];
			$language_re[$value['id']]['re_total'] = (int) $this->paid_model->load_all($language_input_re)[0]['paiding'];
			$language_re[$value['id']]['re_new'] = (int) $this->paid_model->load_all($language_input_re_new)[0]['paiding'];
			$language_re[$value['id']]['re_old'] = (int) $this->paid_model->load_all($language_input_re_old)[0]['paiding'];

		}

		$re = array();
		$total = array();
		unset($data['branch'][0]);
		foreach ($data['branch'] as $v_branch) {
        	foreach ($data['language_study'] as $v_language) {
				$input_re = array();
				$input_re['select'] = 'SUM(paid) as paiding';
				$input_re['where'] = array(
					'time_created >=' => $date_from,
					'time_created <=' => $date_end,
					'language_id' => $v_language['id'],
					'branch_id' => $v_branch['id']
				);

				$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
				$input_re_old = array_merge_recursive(array('where' => array('student_old' => '1')), $input_re);

				$re[$v_branch['id']]['branch_name'] = $v_branch['name'];
//				$re[$v_branch['id']][$v_language['id']]['re_total'] = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
				$re[$v_branch['id']][$v_language['id']]['re_new'] = (int) $this->paid_model->load_all($input_re_new)[0]['paiding'];
				$re[$v_branch['id']][$v_language['id']]['re_old'] = (int) $this->paid_model->load_all($input_re_old)[0]['paiding'];

				$total[$v_language['id']]['total_re_new'] += $re[$v_branch['id']][$v_language['id']]['re_new'];
				$total[$v_language['id']]['total_re_old'] += $re[$v_branch['id']][$v_language['id']]['re_old'];
        	}
		}

//		print_arr($total);

		$data['language_re'] = $language_re;
		$data['re'] = $re;
		$data['total'] = $total;
		$data['startDate'] = $date_from;
		$data['endDate'] = $date_end;

		$data['left_col'] = array('date_happen_1');
        $data['content'] = 'manager/view_report_revenue';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

//    Báo cáo số lượng học viên của cơ sở
	function view_report_student_branch() {
		$require_model = array(
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
		);
		$data = $this->_get_require_data($require_model);

		$get = $this->input->get();

		/* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$startDate = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $startDate));
		$endDate = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

//		echo $startDate . ' - ' . $endDate;die;

		if (isset($get['tic_report']) && !empty($get['tic_report'])) {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'source_id NOT IN (9, 10, 11)' => 'NO-VALUE', 'is_hide' => '0', 'is_old' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_handover !=' => '0', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L5_1' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'source_id NOT IN (9, 10, 11)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L5_2' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'source_id IN (9, 10, 11)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'source_id NOT IN (9, 10, 11)' => 'NO-VALUE', 'is_hide' => '0', 'is_old' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'is_old' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'is_old' => '0', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
					'sum' => 0
				),
				'L5_1' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'source_id NOT IN (9, 10, 11)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L5_2' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'source_id IN (9, 10, 11)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
			);
		}

		unset($data['branch'][0]);
		unset($get['filter_date_date_happen']);

		$branch = array();
		$total = array();
		if ($this->role_id == 12) {
			$this->load->model('branch_model');
			$branch_id = $this->session->userdata('branch_id');
			foreach ($data['language_study'] as $item) {
				foreach ($conditionArr as $key2 => $value2) {
					$conditional = array();
					$conditional['where']['branch_id'] = $branch_id;
					$conditional['where']['language_id'] = $item['id'];
//					$conditional['where_not_in']['source_id'] = array(9, 10, 11);
					$conditional = array_merge_recursive($conditional, $value2);
//					echo '<pre>'; print_r($conditional);
					$branch[$branch_id]['name'] = $this->branch_model->find_branch_name($branch_id);
					$branch[$branch_id][$item['id']][$key2] = $this->_query_for_report($get, $conditional);
//					$data[$branch_id] += $branch[$branch_id][$key2];
				}
			}
		} else {
			foreach ($data['branch'] as $key => $value) {
				foreach ($data['language_study'] as $item) {
					foreach ($conditionArr as $key2 => $value2) {
						$conditional = array();
						$conditional['where']['branch_id'] = $value['id'];
						$conditional['where']['language_id'] = $item['id'];
//						$conditional['where_not_in']['source_id'] = array(9, 10, 11);
						$conditional = array_merge_recursive($conditional, $value2);
//						echo '<pre>'; print_r($conditional);
						$branch[$key]['name'] = $value['name'];
						$branch[$key][$item['id']][$key2] = $this->_query_for_report($get, $conditional);
						$total[$item['id']][$key2] += $branch[$key][$item['id']][$key2];
					}
				}
			}
			$branch['total'] = $total;
			$branch['total']['name'] = 'Tổng';
//			print_arr($branch);
		}

	//	print_arr($branch);

		$data['branch'] = $branch;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'tic_report');
		$data['right_col'] = array('source');
		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_student_branch';
		if($this->role_id == 1){
			$data['top_nav'] = 'sale/common/top-nav';
		}
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);

	}

	public function view_report_source() {
		$require_model = array(
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
			'sources' => array(
				'where' => array(
					'active' => 1
				)
			)
		);
		$data = $this->_get_require_data($require_model);

		$get = $this->input->get();

		/* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$startDate = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $startDate));
		$endDate = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

//		echo $startDate . ' - ' . $endDate;die;

		if (isset($get['tic_report']) && !empty($get['tic_report'])) {
			$conditionArr = array(
				'L1' => array(
					'where' => array('duplicate_id' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0', 'is_old' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('duplicate_id' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0', 'is_old' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
					'sum' => 0
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
			);
		}

		unset($get['filter_date_date_happen']);
		
		$report = array();
//		$total = array();
		foreach ($data['sources'] as $key_source => $value_source) {
			$conditional_source = array();
			$conditional_source['where']['source_id'] = $value_source['id'];
			$conditional_source['where_not_in']['sale_staff_id'] = array(5);

			foreach ($conditionArr as $key_condition => $value) {
				foreach ($data['language_study'] as $value_language) {
					$conditional_1 = array();
					$conditional_1['where']['language_id'] = $value_language['id'];
					$conditional = array_merge_recursive($conditional_1, $conditional_source, $value);

					$report[$value_language['name']][$value_source['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_source), $startDate, $endDate);
					$report[$value_language['name']][$value_source['name']][$key_condition] = $this->_query_for_report($get, $conditional);
				}

				$conditional_2 = array_merge_recursive($conditional_source, $value);
				$data['sources'][$key_source][$key_condition] = $this->_query_for_report($get, $conditional_2);
			}

			$data['sources'][$key_source]['RE'] = $this->get_re($conditional_source, $startDate, $endDate);
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'tic_report');
//		$data['right_col'] = array('source');
		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_source';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_sale_source() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1
				)
			),
			'sources' => array(
				'where' => array(
					'active' => 1,
					'out_report' => 1
				)
			)
		);

		$data = $this->_get_require_data($require_model);

		$get = $this->input->get();

		/* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$startDate = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $startDate));
		$endDate = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

//		echo $startDate . ' - ' . $endDate;die;

		if (isset($get['tic_report']) && !empty($get['tic_report'])) {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
					'sum' => 0
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'is_hide' => '0'),
					'sum' => 0
				),
				'L2' => array(
					'where' => array('is_hide' => '0', 'level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
					'sum' => 0
				),
				'L3' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
					'sum' => 0
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
				'L8' => array(
					'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
					'sum' => 0
				),
			);
		}

		unset($get['filter_date_date_happen']);

		$report = array();
//		$total = array();
		foreach ($data['sources'] as $key_source => $value_source) {
			$conditional_source = array();
			$conditional_source['where']['source_id'] = $value_source['id'];
//			$conditional_source['where_not_in']['sale_staff_id'] = array(5);

			foreach ($conditionArr as $key_condition => $value) {
				foreach ($data['staffs'] as $value_sale) {
					$conditional_1 = array();
					$conditional_1['where']['sale_staff_id'] = $value_sale['id'];
					$conditional = array_merge_recursive($conditional_1, $conditional_source, $value);

					$report[$value_source['name']][$value_sale['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_source), $startDate, $endDate);
					$report[$value_source['name']][$value_sale['name']][$key_condition] = $this->_query_for_report($get, $conditional);

					if ($report[$value_source['name']][$value_sale['name']]['L1'] == 0 && $report[$value_source['name']][$value_sale['name']]['L2'] == 0
					&& $report[$value_source['name']][$value_sale['name']]['L3'] == 0 &&$report[$value_source['name']][$value_sale['name']]['L5'] == 0) {
						unset($report[$value_source['name']][$value_sale['name']]);
					}
				}

				//$conditional_2 = array_merge_recursive($conditional_source, $value);
				//$data['sources'][$key_source][$key_condition] = $this->_query_for_report($get, $conditional_2);
			}

			if (empty($report[$value_source['name']])) {
				unset($report[$value_source['name']]);
			}

			$data['sources'][$key_source]['RE'] = $this->get_re($conditional_source, $startDate, $endDate);
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'tic_report');
//		$data['right_col'] = array('source');
		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_sale_source';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	private function get_re($condition_id=[], $startDate=0, $endDate=0) {
		$this->load->model('paid_model');
		$input_contact = array();
		$input_contact['select'] = 'id';
		$input_contact['where']['date_paid >='] = $startDate;
		$input_contact['where']['date_paid <='] = $endDate;
		$input_contact['where']['level_contact_id'] = 'L5';
		$input_contact = array_merge_recursive($condition_id, $input_contact);
//		print_arr($input_contact);
		$contact = $this->contacts_model->load_all($input_contact);

		$contact_id = array();
		foreach ($contact as $item) {
			$contact_id[] = $item['id'];
		}

		if (!empty($contact_id)) {
			$input_re['select'] = 'SUM(paid) as paiding';
			$input_re['where'] = array(
				'time_created >=' => $startDate,
				'time_created <=' => $endDate,
			);
			$input_re['where_in']['contact_id'] = $contact_id;
			$re = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
		} else {
			$re = 0;
		}

		return $re;
	}

	public function view_report_class_study() {

    	$this->load->model('class_study_model');
		$require_model = array(
			'character_class' => array(),
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
		);

		$data = $this->_get_require_data($require_model);

		$get = $this->input->get();

		/* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$startDate = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $startDate));
		$endDate = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

//		echo $startDate . ' - ' . $endDate;die;

		$conditionArr = array(
			'ĐA_KG' => array(
				'where' => array('time_start >=' => $startDate, 'time_start <=' => $endDate, 'character_class_id' => 2),
				'sum' => 0
			),
			'ĐA_KT' => array(
				'where' => array('time_end_expected >=' => $startDate, 'time_end_expected <=' => $endDate, 'character_class_id' => 3),
				'sum' => 0
			),
		);

		$conditionalArr_contact = array(
			'L7' => array(
				'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L7', 'date_last_calling >' => $startDate, 'date_last_calling <' => $endDate),
				'sum' => 0
			),
			'L8' => array(
				'where' => array('is_hide' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_student_id' => 'L8', 'date_rgt_study >=' => $startDate, 'date_rgt_study <' => $endDate),
				'sum' => 0
			),
		);

		unset($data['branch'][0]);
		unset($get['filter_date_date_happen']);

		$branch = array();

		foreach ($data['branch'] as $key => $value_branch) {
			foreach ($data['language_study'] as $value_language) {
				foreach ($conditionArr as $key_class => $value_class) {
					$conditional = array();
					$conditional['where']['branch_id'] = $value_branch['id'];
					$conditional['where']['language_id'] = $value_language['id'];
					$conditional = array_merge_recursive($conditional, $value_class);

					$class = $this->class_study_model->load_all($conditional);
					$branch[$value_branch['name']][$value_language['name']][$key_class] = count($class);

					$class_study_array = $this->get_class_id($class);
					if (!empty($class_study_array)) {
						$input_contact = array();
						$input_contact['where_in']['class_study_id'] = $class_study_array;
						$branch[$value_branch['name']][$value_language['name']]['HV_'.$key_class] = count($this->contacts_model->load_all($input_contact));
					} else {
						$branch[$value_branch['name']][$value_language['name']]['HV_'.$key_class] = 0;
					}
				}

				foreach ($conditionalArr_contact as $key_contact => $value_contact) {
					$conditional_contact = array();
					$conditional_contact['where']['branch_id'] = $value_branch['id'];
					$conditional_contact['where']['language_id'] = $value_language['id'];
					$conditional_contact = array_merge_recursive($conditional_contact, $value_contact);

					$branch[$value_branch['name']][$value_language['name']][$key_contact] = $this->_query_for_report($get, $conditional_contact);
				}
			}
		}

		$data['branch'] = $branch;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1');
//		$data['right_col'] = array('source');
//		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_class_study';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	private function get_class_id($class_arr) {
    	$class_id_arr = array();
    	if (empty($class_arr)) {
    		return $class_id_arr;
		} else {
			foreach ($class_arr as $item) {
				$class_id_arr[] = $item['class_study_id'];
    		}
			return $class_id_arr;
		}
	}

    // <editor-fold defaultstate="collapsed" desc="get_all_require_data">
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
            'payment_method_rgt' => array(),
            'sources' => array(),
            'channel' => array(),
            'branch' => array(),
            'level_language' => array(),
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
			'language_study' => array(),
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }


     /* ====================xuất file excel============================== */
     /*
    function export_for_send_provider() {

        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('cod_status_model');
        $this->load->model('notes_model');
        $this->load->model('staffs_model');
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setSize(11)->setBold(true)->setName('Times New Roman');
        //     ->getColor()->setRGB('FFFFFF')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size' => 15,
                'name' => 'Times New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:I100")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);

        foreach (range('A', 'G') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

        //set độ rộng của các cột
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

        //set tên các cột cần in
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Contact id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Họ tên');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'SĐT');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Trạng thái gọi');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Trạng thái đơn hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Trạng thái giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Ma trận');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Ghi chú');
        $rowCount++;

        //đổ dữ liệu ra file excel
        foreach ($post['contact_id'] as $key => $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input)[0];

            $all_note = '';
            $note = array();
            $note['where'] = array('contact_id' => $value);
            $notes = $this->notes_model->load_all($note);
            if (!empty($notes)) {
                foreach ($notes as $value2) {
                    $all_note .= 'Ngày: ' . date('H:i:s d/m/Y', $value2['time']) . ' - Người viết: '
                            . $this->staffs_model->find_staff_name($value2['sale_id']) . ' - Nội dung: ' . html_entity_decode($value2['content']);
                }
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $contact['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $contact['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $contact['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $contact['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $contact['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->call_status_model->find_call_status_desc($contact['call_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->ordering_status_model->find_ordering_status_desc($contact['ordering_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $this->cod_status_model->find_cod_status_desc($contact['cod_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $contact['matrix']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $all_note);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':H' . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }
//die;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;

    }
     */
     /* ====================xuất file excel (end)============================== */

    // </editor-fold>

    protected function GetProccessToday() {
        //L6,L8 tính theo ngày
        $total = $this->GetProccessThisMonth();
        $total_marketing_day = round($total['marketing']['kpi']/30);
        $total_sale_day_L5 = round($total['sale']['kpi']/30);
		$total_to_day_L8 = 30;

        $progress = [];
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >=' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
  
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $total_marketing_day,
            'name' => 'Marketing',
            'type' => 'C3'
        );
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_hide' => '0', 'is_old' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_sale_day_L5,
            'name' => 'Học viên mới',
            'type' => 'L5'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

		$inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_hide' => '0', 'is_old' => '1');
		$today = $this->contacts_model->load_all($inputContact);
		$progress['branch'] = array(
			'count' => count($today),
			'kpi' => $total_to_day_L8,
			'name' => 'Học viên cũ',
			'type' => 'L8'
		);
		$progress['branch']['progress'] = round($progress['branch']['count'] / $progress['branch']['kpi'] * 100, 2);

		$progress['progressbar'] = $progress;
		
		$this->load->model('language_study_model');
		$this->load->model('paid_model');
		$input['where']['no_report'] = '0';
		$language = $this->language_study_model->load_all($input);
		
		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'paid !=' => 0,
				'time_created >=' => strtotime(date('d-m-Y'))
			);
			$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
			$input_re_old = array_merge_recursive(array('where' => array('student_old' => 1)), $input_re);
			
			$progress['old'][$value['name']] = $this->paid_model->load_all($input_re_old);
			$progress['new'][$value['name']] = $this->paid_model->load_all($input_re_new);
			
			$total_new += $progress['new'][$value['name']][0]['RE'];
			$total_old += $progress['old'][$value['name']][0]['RE'];
		}
		$progress['total_new'] = $total_new;
		$progress['total_old'] = $total_old;
		//print_arr($progress);

        return $progress;
    }
	
	//làm KPI động thì làm ở chỗ nãy
    protected function GetProccessThisMonth() {
		// tính L6,L8 theo thang
        $this->load->model('staffs_model');
        $qr = $this->staffs_model->SumTarget();
		//echo $qr[0]['targets'];die;
        $total_month_L5 = round($qr[0]['targets']*30);
		$total_month_L8 = 500;

        $progress = [];
		$input['where']['no_report'] = '0';
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $qr[0]['targets'] * 30,
            'name' => 'Marketing',
            'type' => 'C3'
		);
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('01-m-Y')), 'is_hide' => '0', 'is_old' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_month_L5,
            'name' => 'Học viên mới',
            'type' => 'L5'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

		$inputContact['where'] = array('date_rgt_study >=' => strtotime(date('1-m-Y')), 'is_hide' => '0', 'is_old' => '1');
		$today = $this->contacts_model->load_all($inputContact);
		$progress['branch'] = array(
			'count' => count($today),
			'kpi' => $total_month_L8,
			'name' => 'Học viên cũ',
			'type' => 'L8'
		);
		$progress['branch']['progress'] = round($progress['branch']['count'] / $progress['branch']['kpi'] * 100, 2);
		
		$progress['progressbar'] = $progress;
		
		$this->load->model('language_study_model');
		$this->load->model('paid_model');
		$input['where']['no_report'] = '0';
		$language = $this->language_study_model->load_all($input);
		
		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'paid !=' => 0,
					'time_created >=' => strtotime(date('01-m-Y'))
			);
			$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
			$input_re_old = array_merge_recursive(array('where' => array('student_old' => 1)), $input_re);
			
			$progress['old'][$value['name']] = $this->paid_model->load_all($input_re_old);
			$progress['new'][$value['name']] = $this->paid_model->load_all($input_re_new);
			
			$total_new += $progress['new'][$value['name']][0]['RE'];
			$total_old += $progress['old'][$value['name']][0]['RE'];
		}
		$progress['total_new'] = $total_new;
		$progress['total_old'] = $total_old;
		
        return $progress;
    }

	/* ====================xuất file excel============================== */
    public function ExportToExcel($post=array()) {

    	if (empty($post)) {
			$post = $this->input->post();
		}

		$this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setSize(11)->setBold(true)->setName('Times New Roman');
        //     ->getColor()->setRGB('FFFFFF')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $styleArray = array(
//            'font' => array(
//                'bold' => true,
//                'color' => array('rgb' => 'FFFFFF'),
//                'size' => 15,
//                'name' => 'Times New Roman'
//            ),
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
//            )
//        );
//        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->applyFromArray($styleArray);
//        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
//        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $objPHPExcel->getActiveSheet()->getStyle("A2:R200")->getFont()->setSize(15)->setName('Times New Roman');
//        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
//        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);

        //set tên các cột cần in
		$columnName = 'A';
		$rowCount = 1;
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'STT');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Họ tên');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Email');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Số điện thoại');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'ID cơ sở');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'ID ngoại ngữ');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ghi chú');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày đăng ký');

		$rowCount++;

        //đổ dữ liệu ra file excel
        $i = 1;
//		$rowCount = 2;
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['select'] = 'name, branch_id, language_id, email, phone, date_rgt';
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);
//            print_arr($value);

            $columnName = 'A';
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['branch_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['language_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, date('d/m/Y', $contact[0]['date_rgt']));
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
//            $BStyle = array(
//                'borders' => array(
//                    'allborders' => array(
//                        'style' => PHPExcel_Style_Border::BORDER_THICK,
//                        'color' => array('rgb' => '151313')
//                    )
//                )
//            );
//            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':' . $columnName . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }

//        foreach (range('A', $columnName) as $columnID) {
//            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
//        }

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel;charset=utf-8');
		header('Content-Disposition: attachment;filename="Contact_' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
        die;
    }
	/* ====================xuất file excel (end)============================== */

    // HuyNV Fix report operation
//    function show_report_operation() {
//        $this->load->helper('manager_helper');
//        $this->load->helper('common_helper');
//        $this->load->model('campaign_cost_model');
//        $this->load->model('cost_warehouse_model');
//        $this->load->model('Cost_GA_campaign_model');
//        $this->load->model('campaign_model');
//        $get = $this->input->get();
//
//        $data = '';
//
//        $typeKPI = array(
//            'L7+L8' => 10000000,
//            'marketing' => 2000000,
//            'priceC3' => 50000,
//            'C1' => 15400,
//            'C2' => 530,
//            'C3' => 60,
//            'L1' => 30,
//            'L2' => 30,
//            'L6' => 30,
//            'L8' => 30,
//            'Hủy đơn / L6' => 5
//        );
//
//        if (isset($get['tic_report'])) {
//            /* các loại báo cáo */
//            $typeReport = array(
//                'user' => 'date_rgt',
//                'marketing' => 'time',
//                'C3' => 'date_rgt',
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_rgt',
//                'L7_revenue' => 'date_rgt',
//                'L8_revenue' => 'date_rgt',
//                're_buy' => 'date_rgt',
//                'active' => 'date_rgt',
//                'no_active' => 'date_rgt',
//                'huydon' => 'date_rgt'
//            );
//        } else {
//            /* các loại báo cáo */
//            $typeReport = array(
//                'user' => 'date_rgt',
//                'marketing' => 'time',
//                'C3' => 'date_rgt',
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_confirm',
//                'L7_revenue' => 'date_receive_cod',
//                'L8_revenue' => 'date_receive_lakita',
//                're_buy' => 'date_rgt',
//                'active' => 'date_active',
//                'no_active' => 'date_rgt',
//                'huydon' => 'date_receive_cancel_cod'
//            );
//        }
//
//        /* Mảng chứa các ngày lẻ */
//        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
//            $startDate = strtotime($get['filter_date_happen_from']);
//            $endDate = strtotime($get['filter_date_happen_end']);
//        } else {
//            $startDate = strtotime(date('01-m-Y'));
//            $endDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
//        }
//        $dateArray = h_get_time_range($startDate, $endDate);
//
//        /* danh sách campaign dùng để tính chi phí marketing */
//        $input_campaign = array();
//        $input_campaign['select'] = 'id';
//
//        if (isset($get['filter_marketer_id'])) {
//            $input_campaign['where_in']['marketer_id'] = $get['filter_marketer_id'];
//        }
//
//        //campaign FB
//        $input_campaign['where']['channel_id'] = 2;
//        $campaign_fb = $this->campaign_model->load_all($input_campaign);
//        $campaign_fb_list = array();
//        foreach ($campaign_fb as $value){
//            $campaign_fb_list[] = $value['id'];
//        }
//
//        //campaign GA
//        $input_campaign['where']['channel_id'] = 3;
//        $campaign_ga = $this->campaign_model->load_all($input_campaign);
//        $campaign_ga_list = array();
//        foreach ($campaign_ga as $value){
//            $campaign_ga_list[] = $value['id'];
//        }
//
//        $Report = array();
//
//        foreach ($typeReport as $report_type => $typeDate) {
//            $total = 0;
//            $total2 = 0;
//            foreach ($dateArray as $key => $time) {
//                $week = $key;
//
//                $input = array();
//
//                $input['where'][$typeDate . ' >='] = $time;
//                $input['where'][$typeDate . ' <='] = $time + 86400 - 1;
//
//                // Số người đồng ý mua theo từng ngày
//                if ($report_type == 'user') {
//                    $input['select'] = 'phone';
//                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
//                    $input['where']['duplicate_id'] = '';
//                    $contact = '';
//                    $contact_new = array();
//                    $contact = $this->contacts_model->load_all($input);
//                    foreach ($contact as $key => $value) {
//                        $contact_new[] = $value['phone'];
//                    }
//                    $contact_new = array_unique($contact_new);
//
//                    $array = array();
//                    $array['value'] = count($contact_new);
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Số lượng C3 theo ngày
//                if ($report_type == 'C3') {
//                    $input['select'] = 'id';
//                    $input['where']['is_hide'] = '0';
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $array['value/kpi'] = round($array['value'] / $typeKPI['C3'], 2) * 100 . '%';
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $array['Lũy kế /kpi'] = round($array['Lũy kế'] / ($typeKPI['C3'] * date('t')), 2) * 100 . '%';
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Số lượng L1 theo ngày
//                if ($report_type == 'L1') {
//                    $contact = '';
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Số lượng L2 theo ngày
//                if ($report_type == 'L2') {
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
//                    $input['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Số lượng L6 theo ngày
//                if ($report_type == 'L6') {
//                    $input['select'] = 'id';
//                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Số lượng hủy đơn
//                if ($report_type == 'huydon') {
//                    $input['select'] = 'id';
//                    $input['where']['cod_status_id'] = _HUY_DON_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                // Doanh thu L7 & L8
//                if ($report_type == 'L7_revenue' || $report_type == 'L8_revenue') {
//                    $input['select'] = 'id,price_purchase';
//                    if ($report_type == 'L7_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_COD_;
//                    }
//
//                    if ($report_type == 'L8_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_LAKITA_;
//                    }
//                    $contact = '';
//                    $contact = $this->contacts_model->load_all($input);
//
//                    $array1 = array();
//                    $array1['value'] = sum_L8($contact);
//                    $total += $array1['value'];
//                    $array1['Lũy kế'] = $total;
//                    $Report[$report_type]['revenue'][$week] = $array1;
//
//                    $array2 = array();
//                    $array2['value'] = count($contact);
//                    $array2['value/kpi'] = round(count($contact) / $typeKPI['L8'], 2);
//                    $total2 += $array2['value'];
//                    $array2['Lũy kế'] = $total2;
//                    $array2['Lũy kế /kpi'] = round($array2['Lũy kế'] / ($typeKPI['L8'] * date('t')), 2) * 100 . '%';
//                    $Report[$report_type]['count'][$week] = $array2;
//                }
//
//                // Chi phi Marketing
//                if ($report_type == 'marketing') {
//
//                    // lấy chi fb
//                    $input_fb = array();
//                    $input_fb['select'] = 'SUM(spend) as spend';
//                    $input_fb['where']['time >='] = $time;
//                    $input_fb['where']['time <='] = $time + 24 * 3600 - 1;
//                    $input_fb['where_in']['campaign_id'] = $campaign_fb_list;
//                    $sum_spend_fb = $this->campaign_cost_model->load_all($input_fb);
//                    $spend_fb = (empty($sum_spend_fb))?0:(int)$sum_spend_fb [0]['spend'];
//
//                    //lấy chi ga
//                    $input_ga = array();
//                    $input_ga['select'] = 'SUM(spend) as spend';
//                    $input_ga['where']['time >='] = $time;
//                    $input_ga['where']['time <='] = $time + 24 * 3600 - 1;
//                    $input_ga['where_in']['campaign_id'] = $campaign_ga_list;
//                    $sum_spend_ga = $this->Cost_GA_campaign_model->load_all($input_ga);
//                    $spend_ga = (empty($sum_spend_ga))?0:(int)$sum_spend_ga [0]['spend'];
//
//                    //lấy chi email
//                    $input_em = array();
//                    $input_em['select'] = 'spend';
//                    $input_em['where']['time >='] = $time;
//                    $input_em['where']['time <='] = $time + 24 * 3600 - 1;
//                    $sum_spend_email = $this->cost_warehouse_model->load_all($input_em);
//                    $spend_em = (empty($sum_spend_email))?0:(int)$sum_spend_email [0]['spend'];
//
//                    //Tổng chi marketing
//                    $sum_perday_spend = $spend_fb+$spend_ga+$spend_em;
//
//                    $total += round($sum_perday_spend);
//                    $array = array();
//                    $array['value'] = round($sum_perday_spend);
//                    $array['value/kpi'] = round($array['value'] / $typeKPI['marketing'], 2) * 100 . '%';
//                    $array['Lũy kế'] = $total;
//                    $array['Lũy kế /kpi'] = round($array['Lũy kế'] / ($typeKPI['marketing'] * date('t')), 2) * 100 . '%';
//                    $Report[$report_type][$week] = $array;
//                    // $total += $Report[$report_type][$week];
//                }
//
//                if ($report_type == 're_buy') {
//                    $input['select'] = 'distinct(phone), date_rgt';
//
//                    $input['where']['is_hide'] = '0';
////                    $input['where']['affiliate_id'] = '0';
//                    $input['where']['duplicate_id'] = '';
//                    $input['where']['ordering_status_id'] = 4;
//                    $input['order'] = array('id' => 'desc');
//                    $contact_list_buy = $this->contacts_model->load_all($input);
//
//                    $contact_re_buy = array();
//
//                    foreach ($contact_list_buy as $value) {
//                        $input = '';
//                        $input['select'] = 'phone,email,course_code,date_rgt';
//                        $input['where']['phone'] = $value['phone'];
//                        $input['where']['is_hide'] = '0';
////                        $input['where']['affiliate_id'] = '0';
//                        $input['where']['duplicate_id'] = '0';
//                        $input['where']['ordering_status_id'] = 4;
//                        $input['where']['date_rgt <'] = $value['date_rgt'] - 172800;
//                        $input['order'] = array('id' => 'desc');
//
//                        $contact = $this->contacts_model->load_all($input);
//
//                        if (!empty($contact)) {
//                            $contact_re_buy[] = $value;
//                        }
//                    }
//                    $array = array();
//                    $array['value'] = count($contact_re_buy);
//                    // $array['value'] = $contact_re_buy;
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'active') {
//                    $input['select'] = 'id';
//                    $input['where']['id_lakita !='] = '';
////                    $input['where']['affiliate_id'] = '0';
//                    $input['where']['cod_status_id >'] = 1;
//                    $input['where']['cod_status_id <'] = 4;
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'no_active') {
//                    $input['select'] = 'id';
//                    $input['where']['id_lakita'] = '';
////                    $input['where']['affiliate_id'] = '0';
//                    $input['where']['cod_status_id >'] = 1;
//                    $input['where']['cod_status_id <'] = 4;
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//            }
//        }
//
//        /* tầng doanh thu */
//        $L7L8 = array();
//        foreach ($Report['L7_revenue']['revenue'] as $key => $value) {
//            $L7L8[$key]['value'] = $Report['L8_revenue']['revenue'][$key]['value'] + $value['value'];
//            $L7L8[$key]['value/kpi'] = round($L7L8[$key]['value'] / $typeKPI['L7+L8'], 2) * 100 . '%';
//            $L7L8[$key]['Lũy kế'] = $Report['L8_revenue']['revenue'][$key]['Lũy kế'] + $value['Lũy kế'];
//            $L7L8[$key]['Lũy kế /kpi'] = round($L7L8[$key]['Lũy kế'] / ($typeKPI['L7+L8'] * date('t')), 2) * 100 . '%';
//        }
//
//        /* tầng maketing */
//        /* chi marketing */
//        $marketing_fee = $Report['marketing'];
//        /* số C3 */
//        $C3 = $Report['C3'];
//        /* Giá C3 */
//        $priceC3 = array();
//        foreach ($Report['marketing'] as $key => $value) {
//            $priceC3[$key]['value'] = ($Report['C3'][$key]['value'] > 0) ? round($value['value'] / $Report['C3'][$key]['value']) : 'N/A';
//            $priceC3[$key]['value/kpi'] = round(str_replace('%', '', $priceC3[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['priceC3'], $typeKPI['C3'])), 2) * 100 . '%';
//            $priceC3[$key]['Lũy kế'] = ($Report['C3'][$key]['Lũy kế'] > 0) ? round($value['Lũy kế'] / $Report['C3'][$key]['Lũy kế']) : 'N/A';
//            $priceC3[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $priceC3[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['priceC3'] * date('t'), $typeKPI['C3'] * date('t'))), 2) * 100 . '%';
//        }
//        /* chất lượng C3 */
//        $L8_C3 = array();
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_C3[$key]['value'] = h_get_progress($value['value'], $Report['C3'][$key]['value']);
//            $L8_C3[$key]['value/kpi'] = round(str_replace('%', '', $L8_C3[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L8'], $typeKPI['C3'])), 2) * 100 . '%';
//            $L8_C3[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['C3'][$key]['Lũy kế']);
//            $L8_C3[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_C3[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L8'] * date('t'), $typeKPI['C3'] * date('t'))), 2) * 100 . '%';
//        }
//
//        /* tầng sale */
//        /* chất lượng tổng L8/L1 */
//        $L8_L1 = array();
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_L1[$key]['value'] = h_get_progress($value['value'], $Report['L1'][$key]['value']);
//            $L8_L1[$key]['value/kpi'] = round(str_replace('%', '', $L8_L1[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L8'], $typeKPI['L1'])), 2) * 100 . '%';
//            $L8_L1[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L1'][$key]['Lũy kế']);
//            $L8_L1[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_L1[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L8'] * date('t'), $typeKPI['L1'] * date('t'))), 2) * 100 . '%';
//        }
//        /* Chất lượng contact L2/L1 */
//        $L2_L1 = array();
//        foreach ($Report['L2']as $key => $value) {
//            $L2_L1[$key]['value'] = h_get_progress($value['value'], $Report['L1'][$key]['value']);
//            $L2_L1[$key]['value/kpi'] = round(str_replace('%', '', $L2_L1[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L2'], $typeKPI['L1'])), 2) * 100 . '%';
//            '__';
//            $L2_L1[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L1'][$key]['Lũy kế']);
//            $L2_L1[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L2_L1[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L2'] * date('t'), $typeKPI['L1'] * date('t'))), 2) * 100 . '%';
//        }
//        /* Chất lượng sale L6/L2 */
//        $L6_L2 = array();
//        foreach ($Report['L6'] as $key => $value) {
//            $L6_L2[$key]['value'] = h_get_progress($value['value'], $Report['L2'][$key]['value']);
//            $L6_L2[$key]['value/kpi'] = round(str_replace('%', '', $L6_L2[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L6'], $typeKPI['L2'])), 2) * 100 . '%';
//            $L6_L2[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L2'][$key]['Lũy kế']);
//            $L6_L2[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L6_L2[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L6'] * date('t'), $typeKPI['L2'] * date('t'))), 2) * 100 . '%';
//        }
//
//        // Chất lượng COD Hủy đơn / L6
//        $fail_L6 = array();
//        foreach ($Report['huydon'] as $key => $value) {
//            $fail_L6[$key]['value'] = h_get_progress($value['value'], $Report['L6'][$key]['value']);
//            $fail_L6[$key]['value/kpi'] = round(str_replace('%', '', $fail_L6[$key]['value']) / $typeKPI['Hủy đơn / L6'], 2) * 100 . '%';
//            $fail_L6[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L6'][$key]['Lũy kế']);
//            $fail_L6[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $fail_L6[$key]['Lũy kế']) / ($typeKPI['Hủy đơn / L6'] * date('t')), 2) * 100 . '%';
//        }
//        /* chỉ số arpu = doanh thu( L7 +l8) / số (L1) */
//        /* nếu 1 khách hàng mua 3 lần bình thường tính là 3 L1 nhưng ở đây chỉ tính là 1 L1 */
//        $arpu = array();
//        foreach ($L7L8 as $key => $value) {
//            if ($Report['user'][$key]['value'] != 0) {
//                $arpu[$key]['value'] = round($value['value'] / $Report['user'][$key]['value'], 0);
//            } else {
//                $arpu[$key]['value'] = 'N/A';
//            }
//            $arpu[$key]['value/kpi'] = '__';
//            if ($Report['user'][$key]['Lũy kế'] != 0) {
//                $arpu[$key]['Lũy kế'] = round($value['Lũy kế'] / $Report['user'][$key]['Lũy kế'], 0);
//            } else {
//                $arpu[$key]['Lũy kế'] = 'N/A';
//            }
//            $arpu[$key]['Lũy kế /kpi'] = '__';
//        }
//
//        //Tầng chăm sóc khách hàng;
//        $S1_S0 = array();
//        foreach ($Report['active'] as $key => $value) {
//            $S1_S0[$key]['value'] = $value['value'] . ' - ' . h_get_progress($value['value'], $Report['L7_revenue']['count'][$key]['value'] + $Report['L8_revenue']['count'][$key]['value']);
//            $S1_S0[$key]['value/kpi'] = '__';
//            $S1_S0[$key]['Lũy kế'] = $value['Lũy kế'] . ' - ' . h_get_progress($value['Lũy kế'], $Report['L7_revenue']['count'][$key]['Lũy kế'] + $Report['L8_revenue']['count'][$key]['Lũy kế']);
//            $S1_S0[$key]['Lũy kế /kpi'] = '__';
//        }
//        //chưa kích hoạt
//        $S1_S00 = array();
//        foreach ($Report['no_active'] as $key => $value) {
//            $S1_S00[$key]['value'] = $value['value'] . ' - ' . h_get_progress($value['value'], $Report['L7_revenue']['count'][$key]['value'] + $Report['L8_revenue']['count'][$key]['value']);
//            $S1_S00[$key]['value/kpi'] = '__';
//            $S1_S00[$key]['Lũy kế'] = $value['Lũy kế'] . ' - ' . h_get_progress($value['Lũy kế'], $Report['L7_revenue']['count'][$key]['Lũy kế'] + $Report['L8_revenue']['count'][$key]['Lũy kế']);
//            $S1_S00[$key]['Lũy kế /kpi'] = '__';
//        }
//
//        $S5_S0 = array();
//        foreach ($Report['re_buy'] as $key => $value) {
//            $S5_S0[$key]['value'] = $value['value'] . ' - ' . h_get_progress($value['value'], $Report['L7_revenue']['count'][$key]['value'] + $Report['L8_revenue']['count'][$key]['value']);
//            $S5_S0[$key]['value/kpi'] = '__';
//            $S5_S0[$key]['Lũy kế'] = $value['Lũy kế'] . ' - ' . h_get_progress($value['Lũy kế'], $Report['L7_revenue']['count'][$key]['Lũy kế'] + $Report['L8_revenue']['count'][$key]['Lũy kế']);
//            $S5_S0[$key]['Lũy kế /kpi'] = '__';
//        }
//
//        $Report3 = array(
//            'Doanh thu (L7+L8)' => array_reverse($L7L8),
//            'Chi phí marketing' => array_reverse($marketing_fee),
//            'Số C3' => array_reverse($Report['C3']),
//            'Giá C3' => array_reverse($priceC3),
//            'Chất lượng C3 L8/C3' => array_reverse($L8_C3),
//            'Chất lượng tổng L8/L1' => array_reverse($L8_L1),
//            'Chất lượng contact L2/L1' => array_reverse($L2_L1),
//            'Chất lượng sale L6/L2' => array_reverse($L6_L2),
//            'Chất lượng COD (Hủy đơn)/L6' => array_reverse($fail_L6),
//            'ARPU' => array_reverse($arpu),
//            'Kích hoạt' => array_reverse($S1_S0),
//            'Chưa kích hoạt' => array_reverse($S1_S00),
//            'Mua lại' => array_reverse($S5_S0)
//        );
//
//        $data['left_col'] = array('date_happen', 'tic_report');
//        $data['kpi'] = $typeKPI;
//        $data['date'] = array_reverse($dateArray);
//        $data['Report'] = $Report3;
//        $data['startDate'] = isset($startDate) ? $startDate : '0';
//        $data['endDate'] = isset($endDate) ? $endDate : '0';
//
//        $data['content'] = 'manager/show_report_operation';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

//    function view_report_operation() {
//        $this->load->helper('manager_helper');
//        $this->load->helper('common_helper');
//        $get = $this->input->get();
//
//        $data = '';
//
//        $typeKPI = array(
//            'L7+L8' => 10000000,
//            'marketing' => 2000000,
//            'priceC3' => 50000,
//            'C1' => 15400,
//            'C2' => 530,
//            'C3' => 60,
//            'L1' => 30,
//            'L2' => 30,
//            'L6' => 30,
//            'L8' => 30
//        );
//
//        if (isset($get['tic_report'])) {
//            /* các loại báo cáo */
//            $typeReport = array(
//                'user' => 'date_rgt',
//                'marketing' => 'time',
//                'C3' => 'date_rgt',
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_rgt',
//                'L7_revenue' => 'date_rgt',
//                'L8_revenue' => 'date_rgt',
//                're_buy' => 'date_rgt',
//                'active' => 'date_rgt'
//            );
//        } else {
//            /* các loại báo cáo */
//            $typeReport = array(
//                'user' => 'date_rgt',
//                'marketing' => 'time',
//                'C3' => 'date_rgt',
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_confirm',
//                'L7_revenue' => 'date_receive_cod',
//                'L8_revenue' => 'date_receive_lakita',
//                're_buy' => 'date_rgt',
//                'active' => 'date_active'
//            );
//        }
//
//        /* Mảng chứa các ngày lẻ */
//        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
//            $startDate = strtotime($get['filter_date_happen_from']);
//            $endDate = strtotime($get['filter_date_happen_end']);
//        } else {
//            $startDate = strtotime(date('01-m-Y'));
//            $endDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
//        }
//        $dateArray = h_get_time_range($startDate, $endDate);
//
////         echo '<pre>';
////        print_r($dateArray);die;
//        /* lấy mảng các loại contact */
//        $Report = array();
//        foreach ($typeReport as $report_type => $typeDate) {
//            $total = 0;
//            $total2 = 0;
//            $kpix = 1;
//            foreach ($dateArray as $key => $time) {
//                $week = $key;
//
//                $input = array();
//
//                $input['where'][$typeDate . ' >='] = $time;
//                $input['where'][$typeDate . ' <='] = $time + 86400 - 1;
//                if ($report_type == 'user') {
//                    $input['select'] = 'phone';
//                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
//                    $input['where']['duplicate_id'] = '';
////                    $input['where']['affiliate_id'] = '0';
//                    $contact = '';
//                    $contact_new = array();
//                    $contact = $this->contacts_model->load_all($input);
//                    foreach ($contact as $key => $value) {
//                        $contact_new[] = $value['phone'];
//                    }
//                    $contact_new = array_unique($contact_new);
//
//                    $array = array();
//                    $array['value'] = count($contact_new);
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'C3') {
//                    $input['select'] = 'id';
//                    $input['where']['is_hide'] = '0';
////                    $input['where']['affiliate_id'] = '0';
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $array['value/kpi'] = round($array['value'] / $typeKPI['C3'], 2) * 100 . '%';
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $array['Lũy kế /kpi'] = round($array['Lũy kế'] / ($typeKPI['C3'] * date('t')), 2) * 100 . '%';
//                    $kpix++;
//                    $Report[$report_type][$week] = $array;
//                }
//                if ($report_type == 'L1') {
//                    $contact = '';
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
////                    $input['where']['affiliate_id'] = '0';
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//                if ($report_type == 'L2') {
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
//                    $input['where']['duplicate_id'] = '0';
//                    $input['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'L6') {
//                    $input['select'] = 'id';
//                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
////                    $input['where']['affiliate_id'] = '0';
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }        // HuyNV add huydon				//if ($report_type == 'huydon') {                //   $input['select'] = 'id';                //    $input['where']['cod_status_id'] = _HUY_DON_;                //    $array = array();                //    $array['value'] = count($this->contacts_model->load_all($input));                //    $total += $array['value'];                //    $array['Lũy kế'] = $total;                //    $Report[$report_type][$week] = $array;                //}				// HuyNV end huydon
//
//                if ($report_type == 'L7_revenue' || $report_type == 'L8_revenue') {
//                    $input['select'] = 'id,price_purchase';
//                    if ($report_type == 'L7_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_COD_;
////                        $input['where']['affiliate_id'] = '0';
//                    }
//
//                    if ($report_type == 'L8_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_LAKITA_;
////                        $input['where']['affiliate_id'] = '0';
//                    }
//                    $contact = '';
//                    $contact = $this->contacts_model->load_all($input);
//
//                    $array1 = array();
//                    $array1['value'] = sum_L8($contact);
//                    $total += $array1['value'];
//                    $array1['Lũy kế'] = $total;
//                    $Report[$report_type]['revenue'][$week] = $array1;
//
//                    $array2 = array();
//                    $array2['value'] = count($contact);
//                    $array2['value/kpi'] = round(count($contact) / $typeKPI['L8'], 2);
//                    $total2 += $array2['value'];
//                    $array2['Lũy kế'] = $total2;
//                    $array2['Lũy kế /kpi'] = round($array2['Lũy kế'] / ($typeKPI['L8'] * $kpix), 2) * 100 . '%';
//                    $kpix++;
//                    $Report[$report_type]['count'][$week] = $array2;
//                }
//                if ($report_type == 'marketing') {
//                    $this->load->model('campaign_cost_model');
//                    $input['select'] = 'id,spend';
//                    $marketing_fee = $this->campaign_cost_model->load_all($input);
//                    $sum = 0;
//                    foreach ($marketing_fee as $value) {
//                        $sum += $value['spend'];
//                    }
//                    $total += $sum;
//                    $array = array();
//                    $array['value'] = $sum;
//                    $array['value/kpi'] = round($array['value'] / $typeKPI['marketing'], 2) * 100 . '%';
//                    $array['Lũy kế'] = $total;
//                    $array['Lũy kế /kpi'] = round($array['Lũy kế'] / ($typeKPI['marketing'] * $kpix), 2) * 100 . '%';
//                    $kpix++;
//                    $Report[$report_type][$week] = $array;
//                    // $total += $Report[$report_type][$week];
//                }
//                if ($report_type == 're_buy') {
//                    $input['select'] = 'distinct(phone)';
//
//                    $input['where']['is_hide'] = '0';
////                    $input['where']['affiliate_id'] = '0';
//                    $input['where']['duplicate_id'] = '';
//                    $input['where']['ordering_status_id'] = 4;
//                    $input['order'] = array('id' => 'desc');
//                    $contact_list_buy = $this->contacts_model->load_all($input);
//
//                    $contact_re_buy = array();
//                    foreach ($contact_list_buy as $value) {
//                        $input = '';
//                        $input['select'] = 'phone,email,course_code,date_rgt';
//                        $input['where']['phone'] = $value['phone'];
//                        $input['where']['is_hide'] = '0';
////                        $input['where']['affiliate_id'] = '0';
//                        $input['where']['duplicate_id'] = '';
//                        $input['where']['ordering_status_id'] = 4;
//                        $input['order'] = array('id' => 'desc');
//                        $contact = '';
//                        $contact = $this->contacts_model->load_all($input);
//                        $count = count($contact);
//                        if ($count > 1) {
//                            for ($i = 0; $i < $count - 1; $i++) {
//                                if (($contact[0]['date_rgt'] - $contact[$i + 1]['date_rgt']) > 172800) {
//                                    $contact_re_buy[] = $contact[$i];
//                                    break;
//                                }
//                            }
//                        }
//                    }
//                    $array = array();
//                    $array['value'] = count($contact_re_buy);
//                    // $array['value'] = $contact_re_buy;
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'active') {
//                    $input['select'] = 'id';
//                    $input['where']['id_lakita !='] = '';
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//            }
//            //   $Report[$report_type]['Lũy kế'] = $total;
////            if ($report_type == 'L8_revenue') {
////                $Report[$report_type]['count']['Lũy kế'] = $total2;
////            }
//        }
//
//        /* tầng doanh thu */
//        $L7L8 = array();
//        $kpix = 1;
//        foreach ($Report['L7_revenue']['revenue'] as $key => $value) {
//            $L7L8[$key]['value'] = $Report['L8_revenue']['revenue'][$key]['value'] + $value['value'];
//            $L7L8[$key]['value/kpi'] = round($L7L8[$key]['value'] / $typeKPI['L7+L8'], 2) * 100 . '%';
//            $L7L8[$key]['Lũy kế'] = $Report['L8_revenue']['revenue'][$key]['Lũy kế'] + $value['Lũy kế'];
//            $L7L8[$key]['Lũy kế /kpi'] = round($L7L8[$key]['Lũy kế'] / ($typeKPI['L7+L8'] * date('t')), 2) * 100 . '%';
//            $kpix++;
//        }
//
//        /* tầng maketing */
//        /* chi marketing */
//        $marketing_fee = $Report['marketing'];
//        /* số C3 */
//        $C3 = $Report['C3'];
//        /* Giá C3 */
//        $priceC3 = array();
//        $kpix = 1;
//        foreach ($Report['marketing'] as $key => $value) {
//            $priceC3[$key]['value'] = ($Report['C3'][$key]['value'] > 0) ? round($value['value'] / $Report['C3'][$key]['value']) : 'N/A';
//            $priceC3[$key]['value/kpi'] = round(str_replace('%', '', $priceC3[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['priceC3'], $typeKPI['C3'])), 2) * 100 . '%';
//            $priceC3[$key]['Lũy kế'] = ($Report['C3'][$key]['Lũy kế'] > 0) ? round($value['Lũy kế'] / $Report['C3'][$key]['Lũy kế']) : 'N/A';
//            $priceC3[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $priceC3[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['priceC3'] * $kpix, $typeKPI['C3'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }
//        /* chất lượng C3 */
//        $L8_C3 = array();
//        $kpix = 1;
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_C3[$key]['value'] = h_get_progress($value['value'], $Report['C3'][$key]['value']);
//            $L8_C3[$key]['value/kpi'] = round(str_replace('%', '', $L8_C3[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L8'], $typeKPI['C3'])), 2) * 100 . '%';
//            $L8_C3[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['C3'][$key]['Lũy kế']);
//            $L8_C3[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_C3[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L8'] * $kpix, $typeKPI['C3'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }
//
//        /* tầng sale */
//        /* chất lượng tổng L8/L1 */
//        $L8_L1 = array();
//        $kpix = 1;
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_L1[$key]['value'] = h_get_progress($value['value'], $Report['L1'][$key]['value']);
//            $L8_L1[$key]['value/kpi'] = round(str_replace('%', '', $L8_L1[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L8'], $typeKPI['L1'])), 2) * 100 . '%';
//            $L8_L1[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L1'][$key]['Lũy kế']);
//            $L8_L1[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_L1[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L8'] * $kpix, $typeKPI['L1'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }
//        /* Chất lượng contact L2/L1 */
//        $L2_L1 = array();
//        $kpix = 1;
//        foreach ($Report['L2']as $key => $value) {
//            $L2_L1[$key]['value'] = h_get_progress($value['value'], $Report['L1'][$key]['value']);
//            $L2_L1[$key]['value/kpi'] = round(str_replace('%', '', $L2_L1[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L2'], $typeKPI['L1'])), 2) * 100 . '%';
//            '__';
//            $L2_L1[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L1'][$key]['Lũy kế']);
//            $L2_L1[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L2_L1[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L2'] * $kpix, $typeKPI['L1'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }
//        /* Chất lượng sale L6/L2 */
//        $L6_L2 = array();
//        $kpix = 1;
//        foreach ($Report['L6'] as $key => $value) {
//            $L6_L2[$key]['value'] = h_get_progress($value['value'], $Report['L2'][$key]['value']);
//            $L6_L2[$key]['value/kpi'] = round(str_replace('%', '', $L6_L2[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L6'], $typeKPI['L2'])), 2) * 100 . '%';
//            $L6_L2[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L2'][$key]['Lũy kế']);
//            $L6_L2[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L6_L2[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L6'] * $kpix, $typeKPI['L2'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }  // HuyNV edit report
//        /* Chất lượng cod L8/L6 */
//        $L8_L6 = array();
//        $kpix = 1;
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_L6[$key]['value'] = h_get_progress($value['value'], $Report['L6'][$key]['value']);
//            $L8_L6[$key]['value/kpi'] = round(str_replace('%', '', $L8_L6[$key]['value']) / str_replace('%', '', h_get_progress($typeKPI['L8'], $typeKPI['L6'])), 2) * 100 . '%';
//            $L8_L6[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L6'][$key]['Lũy kế']);
//            $L8_L6[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_L6[$key]['Lũy kế']) / str_replace('%', '', h_get_progress($typeKPI['L8'] * $kpix, $typeKPI['L6'] * $kpix)), 2) * 100 . '%';
//            $kpix++;
//        }    // Hủy đơn (Hủy đơn / L6)		//foreach ($Report['huydon'] as $key => $value) {        //    $L8_L6[$key]['value'] = h_get_progress($value['value'], $Report['L6'][$key]['value']);        //    $L8_L6[$key]['value/kpi'] = round(str_replace('%', '', $L8_L6[$key]['value']) / $typeKPI['huydon'] , 2) * 100 . '%';        //    $L8_L6[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L6'][$key]['Lũy kế']);        //    $L8_L6[$key]['Lũy kế /kpi'] = round(str_replace('%', '', $L8_L6[$key]['Lũy kế']) / ($typeKPI['huydon'] * date('t')), 2) * 100 . '%';        //}				// HuyNV edit report end
//
//        /* chỉ số arpu = doanh thu( L7 +l8) / số (L1) */
//        /* nếu 1 khách hàng mua 3 lần bình thường tính là 3 L1 nhưng ở đây chỉ tính là 1 L1 */
//        $arpu = array();
//        $kpix = 1;
//        foreach ($L7L8 as $key => $value) {
//            if ($Report['user'][$key]['value'] != 0) {
//                $arpu[$key]['value'] = round($value['value'] / $Report['user'][$key]['value'], 0);
//            } else {
//                $arpu[$key]['value'] = 'N/A';
//            }
//            $arpu[$key]['value/kpi'] = '__';
//            if ($Report['user'][$key]['Lũy kế'] != 0) {
//                $arpu[$key]['Lũy kế'] = round($value['Lũy kế'] / $Report['user'][$key]['Lũy kế'], 0);
//            } else {
//                $arpu[$key]['Lũy kế'] = 'N/A';
//            }
//            $arpu[$key]['Lũy kế /kpi'] = '__';
//        }
//
//        //Tầng chăm sóc khách hàng;
//        $S1_S0 = array();
//        $kpix = 1;
//        foreach ($Report['active'] as $key => $value) {
//            $S1_S0[$key]['value'] = h_get_progress($value['value'], $Report['L7_revenue']['count'][$key]['value'] + $Report['L8_revenue']['count'][$key]['value']);
//            $S1_S0[$key]['value/kpi'] = '__';
//            $S1_S0[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L7_revenue']['count'][$key]['Lũy kế'] + $Report['L8_revenue']['count'][$key]['Lũy kế']);
//            $S1_S0[$key]['Lũy kế /kpi'] = '__';
//        }
//
//        $S5_S0 = array();
//        $kpix = 1;
//        foreach ($Report['re_buy'] as $key => $value) {
//            $S5_S0[$key]['value'] = h_get_progress($value['value'], $Report['L7_revenue']['count'][$key]['value'] + $Report['L8_revenue']['count'][$key]['value']);
//            $S5_S0[$key]['value/kpi'] = '__';
//            $S5_S0[$key]['Lũy kế'] = h_get_progress($value['Lũy kế'], $Report['L7_revenue']['count'][$key]['Lũy kế'] + $Report['L8_revenue']['count'][$key]['Lũy kế']);
//            $S5_S0[$key]['Lũy kế /kpi'] = '__';
//        }
//        $Report3['Doanh thu (L7+L8)'] = $L7L8;
//
//        $Report3['Chi phí marketing'] = $marketing_fee;
//        $Report3['Số C3'] = $Report['C3'];
//        $Report3['Giá C3'] = $priceC3;
//        $Report3['Chất lượng C3 L8/C3'] = $L8_C3;
//
//        $Report3['Chất lượng tổng L8/L1'] = $L8_L1;
//        $Report3['Chất lượng contact L2/L1'] = $L2_L1;
//        $Report3['Chất lượng sale L6/L2'] = $L6_L2;
//        $Report3['Chất lượng COD L8/L6'] = $L8_L6;
//
//
//        $Report3['ARPU'] = $arpu;
//        $Report3['Kích hoạt'] = $S1_S0;
//        $Report3['Mua lại'] = $S5_S0;
////        echo '<pre>';
////        print_r($Report['re_buy']);
////         print_r($Report['L7_revenue']['count']);
////          print_r($Report['L8_revenue']['count']);die;
//////        print_r($Report3);
////        //  print_r($dateArray);
////    //    die;
//        $data['left_col'] = array('date_happen', 'tic_report');
//        $data['kpi'] = $typeKPI;
//        $data['date'] = $dateArray;
//        $data['Report'] = $Report3;
//        $data['startDate'] = isset($startDate) ? $startDate : '0';
//        $data['endDate'] = isset($endDate) ? $endDate : '0';
//        $data['content'] = 'manager/view_report_operation';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }
//
//    function view_report_sale_operation() {
//        $this->load->helper('manager_helper');
//        $this->load->helper('common_helper');
//        $get = $this->input->get();
//
//        $data = '';
//
//        if (isset($get['tic_report'])) {
//            $typeReport = array(
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_rgt',
//                'L7_revenue' => 'date_rgt',
//                'L8_revenue' => 'date_rgt',
//            );
//        } else {
//            /* các loại báo cáo */
//            $typeReport = array(
//                'L1' => 'date_rgt',
//                'L2' => 'date_rgt',
//                'L6' => 'date_confirm',
//                'L7_revenue' => 'date_receive_cod',
//                'L8_revenue' => 'date_receive_lakita',
//            );
//        }
//
//        /* Mảng chứa các ngày lẻ */
//        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
//            $startDate = strtotime($get['filter_date_happen_from']);
//            $endDate = strtotime($get['filter_date_happen_end']) + 86399;
//        } else {
//            $startDate = strtotime(date('01-m-Y'));
//            $endDate = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
//        }
//        $dateArray = h_get_time_range($startDate, $endDate);
//
//        /* lấy mảng các loại contact */
//        $Report = array();
//        foreach ($typeReport as $report_type => $typeDate) {
//            $total = 0;
//            $total2 = 0;
//            $kpix = 1;
//            foreach ($dateArray as $key => $time) {
//                $week = $key;
//
//                $input = array();
//
//                $input['where'][$typeDate . ' >='] = $time;
//                $input['where'][$typeDate . ' <='] = $time + 86400 - 1;
//                if ($report_type == 'L1') {
//                    $contact = '';
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//                if ($report_type == 'L2') {
//                    $input['select'] = 'id';
//                    $input['where']['duplicate_id'] = '';
//                    $input['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'L6') {
//                    $input['select'] = 'id';
//                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
//
//                    $array = array();
//                    $array['value'] = count($this->contacts_model->load_all($input));
//                    $total += $array['value'];
//                    $array['Lũy kế'] = $total;
//                    $Report[$report_type][$week] = $array;
//                }
//
//                if ($report_type == 'L7_revenue' || $report_type == 'L8_revenue') {
//                    $input['select'] = 'id,price_purchase';
//                    if ($report_type == 'L7_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_COD_;
//                    }
//
//                    if ($report_type == 'L8_revenue') {
//                        $input['where']['cod_status_id'] = _DA_THU_LAKITA_;
//                    }
//                    $contact = '';
//                    $contact = $this->contacts_model->load_all($input);
//
//                    $array1 = array();
//                    $array1['value'] = sum_L8($contact);
//                    $total += $array1['value'];
//                    $array1['Lũy kế'] = $total;
//                    $Report[$report_type]['revenue'][$week] = $array1;
//
//                    $array2 = array();
//                    $array2['value'] = count($contact);
//                    $total2 += $array2['value'];
//                    $array2['Lũy kế'] = $total2;
//                    $kpix++;
//                    $Report[$report_type]['count'][$week] = $array2;
//                }
//            }
//        }
//
//        $L1 = $Report['L1'];
//        $L8 = $Report['L8_revenue']['count'];
//
//        /* tầng doanh thu */
//        $L7L8 = array();
//
//        foreach ($Report['L7_revenue']['revenue'] as $key => $value) {
//            $L7L8[$key]['value'] = $Report['L8_revenue']['revenue'][$key]['value'] + $value['value'];
//        }
//
//        /* tầng sale */
//        /* chất lượng tổng L8/L1 */
//        $L8_L1 = array();
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_L1[$key]['value'] = str_replace("N/A", "0", str_replace("%", "", h_get_progress($value['value'], $Report['L1'][$key]['value'])));
//        }
//        /* Chất lượng sale L6/L2 */
//        $L6_L2 = array();
//        foreach ($Report['L6'] as $key => $value) {
//            $L6_L2[$key]['value'] = str_replace("N/A", "0", str_replace("%", "", h_get_progress($value['value'], $Report['L2'][$key]['value'])));
//        }
//
//        /* Chất lượng contact L2/L1 */
//        $L2_L1 = array();
//        foreach ($Report['L2']as $key => $value) {
//            $L2_L1[$key]['value'] = str_replace("N/A", "0", str_replace("%", "", h_get_progress($value['value'], $Report['L1'][$key]['value'])));
//        }
//
//        /* Chất lượng cod L8/L6 */
//        $L8_L6 = array();
//        foreach ($Report['L8_revenue']['count'] as $key => $value) {
//            $L8_L6[$key]['value'] = str_replace("N/A", "0", str_replace("%", "", h_get_progress($value['value'], $Report['L6'][$key]['value'])));
//        }
//
//        $priceL8 = array();
//        foreach ($L7L8 as $key => $value) {
//            $priceL8[$key]['value'] = 0;
//        }
//
//        $Report3['L1'] = $L1;
//        $Report3['L8'] = $L8;
//        $Report3['L7L8'] = $L7L8;
//        $Report3['L8/L1'] = $L8_L1;
//        $Report3['L2/L1'] = $L2_L1;
//        $Report3['L6/L2'] = $L6_L2;
//        $Report3['L8/L6'] = $L8_L6;
//        $Report3['priceL8'] = $priceL8;
//
//        $a = array_keys($dateArray);
//
//        $last_day = array_pop($a);
//
//        $total = array();
//        $total['L1'] = $Report['L1'][$last_day]['Lũy kế'];
//        $total['L2'] = $Report['L2'][$last_day]['Lũy kế'];
//        $total['L6'] = $Report['L6'][$last_day]['Lũy kế'];
//        $total['L7'] = $Report['L7_revenue']['count'][$last_day]['Lũy kế'];
//        $total['L8'] = $Report['L8_revenue']['count'][$last_day]['Lũy kế'];
//        $total['revenue'] = $Report['L7_revenue']['revenue'][$last_day]['Lũy kế'] + $Report['L8_revenue']['revenue'][$last_day]['Lũy kế'];
//        $total['priceL8'] = 0;
//        $total['L2/L1'] = h_get_progress($total['L2'], $total['L1']);
//        $total['L6/L2'] = h_get_progress($total['L6'], $total['L2']);
//        $total['L8/L6'] = h_get_progress($total['L8'], $total['L6']);
//        $total['L8/L1'] = h_get_progress($total['L8'], $total['L1']);
//
////         echo '<pre>';
////         print_r($total);
////         print_r($Report3);
////        print_r($Report);
////        print_r($dateArray);
////        die;
//
//        $data['left_col'] = array('date_happen', 'marketer', 'tic_report');
//        $data['report3'] = $Report3;
//        $data['total'] = $total;
//        $data['per_day'] = $dateArray;
//        $data['slide_menu'] = 'manager/common/menu';
//        $data['top_nav'] = 'manager/common/top-nav';
//        $data['content'] = 'manager/view_report_sale_operation';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }
	
//	public function view_report_power_bi() {
//		//$data['bi'] = '<iframe width="100%" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiMGI4ZTA3NjMtNmJmOS00MGIwLWE4NDUtZTBiOWQ4YTZiMzZhIiwidCI6Ijc3MWEwYTMzLTUxY2ItNGNiNS1hZGQ2LWVmNGIwNzJiYThkOSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>';
//		$data['bi'] = '<iframe width="100%" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiMmI5NmE3OTgtNTFmZS00NjA1LTgxMjktZjgxNWJmZTQzZGY0IiwidCI6Ijc3MWEwYTMzLTUxY2ItNGNiNS1hZGQ2LWVmNGIwNzJiYThkOSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>';
//		$data['slide_menu'] = 'manager/common/menu';
//		$data['top_nav'] = 'manager/common/top-nav';
//		$data['content'] = 'manager/view_report_power_bi';
//		$this->load->view(_MAIN_LAYOUT_, $data);
//	}


//    public function detail_contact() {
//        $post = $this->input->post();
//        // echo "<pre>"; print_r($post);die();
//
//        $this->load->model('sources_model');
//        $input_source['where'] = array();
//        $source = $this->sources_model->load_all($input_source);
//
//        $this->load->model('call_status_model');
//        $input_call_stt['where'] = array();
//        $call_stt = $this->call_status_model->load_all($input_call_stt);
//
//        if (isset($post['time_start']) || isset($post['time_end'])) {
//        	$date_start = $post['time_start'];
//        	$date_end = $post['time_end'];
//
//        } else {
//	        $date_start = strtotime(date('01-m-Y'));
//	        // $date_start = 1561939200;
//	        $date_end = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
//	        // $date_end = 1564531200;
//        }
//        //echo "<pre>"; print_r($call_stt);die();
//
//		switch ($post['type_contact']) {
//            case 'L1':
//                foreach ($source as $key => $value) {
//					$input_L1['where'] = array(
//						'source_id' => $value['id'],
//						'sale_staff_id' => $post['staff_id'],
//						'date_rgt >=' => $date_start,
//						'date_rgt <=' => $date_end,
//						// 'date_handover >=' => $date_start,
//						// 'date_handover <=' => $date_end,
//						'is_hide' => '0',
//						'duplicate_id' => '0'
//					);
//					$L1 = $this->contacts_model->load_all($input_L1);
//
//					$sum_L[] = array(
//						'head' => $this->sources_model->find_source_name($value['id']),
//						'sum' => count($L1),
//						'type_ct' => 'L1'
//					);
//				}
//				break;
//
//            case 'L2':
//				foreach ($call_stt as $key => $value) {
//					$input_L2['where'] = array(
//						'call_status_id' => $value['id'],
//						'sale_staff_id' => $post['staff_id'],
//						'date_rgt >=' => $date_start,
//						'date_rgt <=' => $date_end,
//						// 'date_handover >=' => $date_start,
//						// 'date_handover <=' => $date_end,
//						'is_hide' => '0',
//						'duplicate_id' => '0'
//					);
//					$L2 = $this->contacts_model->load_all($input_L2);
//
//					$sum_L[] = array(
//						'head' => $this->call_status_model->find_call_status_desc($value['id']),
//						'sum' => count($L2),
//						'type_ct' => 'L2'
//					);
//				}
//				break;
//
//			case 'L6':
//				foreach ($source as $key => $value) {
//					$input_L6['where'] = array(
//						'source_id' => $value['id'],
//						'sale_staff_id' => $post['staff_id'],
//						// 'date_rgt >=' => $date_start,
//						// 'date_rgt <=' => $date_end,
//						'date_rgt >=' => $date_start,
//						'date_rgt <=' => $date_end,
//						'is_hide' => '0',
//						'duplicate_id' => '0',
//						'call_status_id' => _DA_LIEN_LAC_DUOC_,
//						'ordering_status_id' => _DONG_Y_MUA_
//					);
//					$L6 = $this->contacts_model->load_all($input_L6);
//
//					$sum_L[] = array(
//						'head' => $this->sources_model->find_source_name($value['id']),
//						'sum' => count($L6),
//						'type_ct' => 'L6'
//					);
//				}
//				break;
//        }
//
//       // echo '<pre>';print_r($sum_L);die;
//
//        $body = '<table class="table table-bordered table-striped table-hover table-view-2">
//
//				<thead>
//					<tr>';
//						foreach ($sum_L as $key => $value) {
//							$body .= '<th>' . $value['head'] . '</th>';
//
//						}
//
//					$body .= '</tr>
//
//				</thead>
//
//				<tbody>';
//
//					foreach ($sum_L as $key => $value) {
//						$body .= '<td class="text-center"> <strong>'.$value['sum'].'</strong> - <i>'.(round($value['sum']/$post['total'], 4)*100).'% </i>'.'</td>';
//					}
//
//			   $body .= '</tbody>
//
//			</table>';
//
//      	echo $body;
//
//    }


}
