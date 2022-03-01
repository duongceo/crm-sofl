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
        $input['where'] = array('call_status_id' => '0', 'level_contact_id' => '', 'sale_staff_id' => '0', 'duplicate_id' => '0');
        $this->L['L1'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'duplicate_id !=' => '0');
        $this->L['L1_trung'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

    function index($offset = 0) {
        $data = $this->get_all_require_data();
        //var_dump($data);
        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         */

        $conditional['where'] = array('call_status_id' => '0', 'level_student_id' => '', 'sale_staff_id' => '0', 'duplicate_id' => '0');
        $conditional['order'] = array('date_rgt' => 'DESC');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /* Lấy danh sách contacts */
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
        /* Lấy link phân trang */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        /* Filter ở cột trái và cột phải */
        $data['left_col'] = array('duplicate', 'date_rgt');
        //$data['right_col'] = array('tv_dk');

        /* Các trường cần hiện của bảng contact (đã có default) */
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

        $conditional['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'duplicate_id >' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /* Lấy danh sách contacts */
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

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
	
	function contact_cancel($offset = 0) {
        $data = $this->get_all_require_data();
        //print_arr($data);
        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

        $conditional['where'] = array(
			'level_contact_detail' => 'L5.4',
		);
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /* Lấy danh sách contacts */
        $contacts = $data_pagination['data'];

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
        $data['left_col'] = array('date_rgt_study', 'date_rgt');
        //$data['right_col'] = array();

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'class_study_id date_rgt';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact mới bị trùng';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);

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
//		$this->load->model('level_student_model');
		$data['level_contact_detail'] = $this->level_contact_model->load_all($input);
//		$data['level_student_detail'] = $this->level_student_model->load_all($input);

        $get = $this->input->get();
//		print_arr($get);
        /*
         * Điều kiện lấy contact :
         * lấy tất cả contact nên $conditional là mảng rỗng
         *
         */
        $conditional['where'] = array();

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
        $data['left_col'] = array('care_number', 'sale', 'language', 'level_language', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling', 'date_paid', 'study_date_start', 'study_date_end', 'date_customer_care_call', 'date_transfer');
        $data['right_col'] = array('branch', 'class_study', 'is_old', 'complete_fee', 'source', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_study', 'customer_care_call_stt');

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

    // <editor-fold defaultstate="collapsed" desc="hàm chia contact (chia riêng contact) và các hàm phụ trợ">
    /* ========================  hàm chia contact (chia riêng contact) và các hàm phụ trợ =========================== */
    function divide_contact() {
        $post = $this->input->post();
        $this->_action_divide_contact($post);
    }

    /* Chia contact */
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

//		if ($post['transfer_contact'] == 2) {
//			$this->load->model('transfer_logs_model');
//
//            $data_cancel = array(
//                'last_activity' => time(),
//                'is_transfer' => '0'
//            );
//
//            // $data2 = array('is_transfered' => '0');
//
//            foreach ($contact_ids as $value) {
//                $where_cancel = array('id' => $value);
//                $this->contacts_model->update($where_cancel, $data_cancel);
//
//                $where2 = array('contact_id' => $value);
//                $this->transfer_logs_model->delete($where2);
//            }
//
//            $result['success'] = 1;
//            $result['message'] = 'Đã hủy chuyển contact';
//            echo json_encode($result);
//            die;
//        }

//        if ($post['transfer_contact'] == 1) {
//            $this->load->model('transfer_logs_model');
//
//            $data_transfer = array(
//                'is_transfered' => '1'
//            );
//
//            // $this->transfer_logs_model->update($where_transfer, $data_transfer);
//
//            $data_contact = array(
//                'sale_staff_id' => $sale_id,
////                'is_transfered' => '1',
//                'date_transfer' => time(),
//                'last_activity' => time()
//            );
//
//            foreach ($contact_ids as $value) {
//                $where = array('id' => $value);
//                $this->contacts_model->update($where, $data_contact);
//
//                $where_transfer = array(
//                    'contact_id' => $value
//                );
//
//                $this->transfer_logs_model->update($where_transfer, $data_transfer);
//            }
//
//            if ($note != '') {
//                $this->load->model('notes_model');
//                foreach ($contact_ids as $value) {
//                    $param2 = array(
//                        'contact_id' => $value,
//                        'content' => $note,
//                        'time' => time(),
//                        'sale_id' => $this->user_id,
//                        'contact_code' => $this->contacts_model->get_contact_code($value)
//                    );
//                    $this->notes_model->insert($param2);
//                }
//            }
//
//            $staff_name = $this->Staffs_model->find_staff_name($sale_id);
//
//            $result['success'] = 1;
//            $result['message'] = 'Đã chuyển contact cho nhân viên ' . $staff_name;
//            echo json_encode($result);
//            die;
//        }

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

//        $data1 = array(
//            // 'sale_staff_id' => $sale_id,
//            'date_handover' => time(),
//            'last_activity' => time()
//        );
//
//        foreach ($contact_ids as $value) {
//            $where = array('id' => $value);
//            $this->contacts_model->update($where,$data1);
//        }

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
					'sale_staff_id' => $sale[$i][0]['id'],
					'date_handover' => time(),
					'last_activity' => time()
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

    /* Check điều kiện chia contact (Contact không bị trùng và contact chưa được phân cho ai) */
    private function _check_contact_can_be_divide($contact_ids) {
        $result = array();
        $this->load->model('Staffs_model');
        foreach ($contact_ids as $value) {
            $input = array();
            $input['select'] = 'sale_staff_id, id, duplicate_id';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);

            if (empty($rows)) {
                $result['success'] = 0;
                $result['message'] = "Không tồn tại khách hàng này! Mã lỗi : 30203";
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

    // <editor-fold defaultstate="collapsed" desc="Các báo cáo">
    function view_report_sale() {
		$require_model = array(
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
				)
			),
			'branch' => array(),
//			'sources' => array()
		);
		$data = array_merge($this->data, $this->_get_require_data($require_model));
		$language = $data['language_study'];

        $get = $this->input->get();

		$input = array();
		$input['select'] = 'id, name, out_report';
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
					'where' => array('date_handover !=' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
                'CHUA_GOI' => array(
                    'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
				'XU_LY' => array(
                    'where' => array('call_status_id !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
				'NGHE_MAY' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'KHONG_NGHE_MAY' => array(
					'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
                'L1' => array(
                    'where' => array('date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'level_contact_id' => 'L1'),
                ),
                'L2' => array(
                    'where' => array('level_contact_id' => 'L2', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L3' => array(
                    'where' => array('level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L4' => array(
                    'where' => array('level_contact_id' => 'L4', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L5' => array(
                    'where' => array('level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L6' => array(
                    'where' => array('level_student_id' => 'L6', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L7' => array(
                    'where' => array('level_student_id' => 'L7', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'L8' => array(
                    'where' => array('level_contact_id' => 'L5', 'level_student_id !=' => 'L8.1', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
                ),
                'LC' => array(
                    'where' => array('date_rgt >=' => $startDate, 'date_rgt <=' => $endDate,
                        '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ' OR `call_status_id` = 5 OR `level_contact_detail IN` ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
                ),
                /*
                'CON_CUU_DUOC' => array(
                    'where' => array('date_rgt >' => $startDate, 'date_rgt <' => $endDate,
                        '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                ),
                */
            );
        } else {
            $conditionArr = array(
				'NHAN' => array(
					'where' => array('call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'duplicate_id' => '0', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
				),
				'CHUA_GOI' => array(
					'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
				),
				'XU_LY' => array(
					'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'NGHE_MAY' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'KHONG_NGHE_MAY' => array(
					'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L1' => array(
					'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'level_contact_id' => 'L1'),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
				),
				'L4' => array(
					'where' => array('level_contact_id' => 'L4', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L5' => array(
					'where' => array('duplicate_id' => '0', 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L6' => array(
					'where' => array('level_student_id' => 'L6', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L7' => array(
					'where' => array('level_student_id' => 'L7', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'level_student_id !=' => 'L8.1', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
                'LC' => array(
                    'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate,
                        '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ' OR `call_status_id` = 5 OR `level_contact_detail` IN ("L1.1", "L1.2", "L1.3"))' => 'NO-VALUE'),
                ),
				/*
                'CON_CUU_DUOC' => array(
                    'where' => array('date_rgt >' => $startDate, 'date_rgt <' => $endDate,
                        '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                ),
                */
            );
        }

		unset($get['filter_date_date_happen']);

//		$time_start = microtime(true);

//		$input_source['where'] = array('out_report' => '1');
//		$this->load->model('sources_model');
//		$source = $this->sources_model->load_all($input_source);
//		$source_arr = array();
//		if (!empty($source)) {
//            $source_arr = array_column($source, 'id');
//		}

		if ($this->role_id == 11) {
			$conditionArr = array(
				'NHAN' => array(
					'where' => array('call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'duplicate_id' => '0', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate)
				),
				'CHUA_GOI' => array(
					'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
				),
				'XU_LY' => array(
					'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
			);
		}

//		$input_contact = array();
//		$input_contact['select'] = 'id';
//		$input_contact['where']['date_paid >='] = $startDate;
//		$input_contact['where']['date_paid <='] = $endDate;
//		$input_contact['where']['level_contact_id'] = 'L5';

		foreach ($conditionArr as $key2 => $value2) {
			$temp_sale = 0;
        	foreach ($staffs as $key_staff => $value_staff) {
				$conditional_1 = array();
				$conditional_1['where']['sale_staff_id'] = $value_staff['id'];
				//$conditional_1['where_not_in']['source_id'] = $source_arr;
				$conditional = array_merge_recursive($conditional_1, $value2);
                $staffs[$key_staff][$key2] = $this->_query_for_report($get, $conditional);
                //$conditionArr_staff[$key2]['sum'] += $staffs[$key][$key2];
				$temp_sale += $staffs[$key_staff][$key2];
				if ($value_staff['out_report'] == 1) { // ko tính contact này vào tổng
					$temp_sale = $temp_sale - $staffs[$key_staff][$key2];
				}
				$data[$key2] = $temp_sale;
				$staffs[$key_staff]['RE'] = $this->get_re($conditional_1, $startDate, $endDate);
				//$data['RE'] += $staffs[$key_staff]['RE'];
            }

			if ($this->role_id == 3 || $this->user_id == 16) {
                if ($this->user_id == 16 && in_array($key2, array('L6', 'L7'))) {
                    continue;
                }
				$temp_language = 0;
				foreach ($language as $key_language => $value_language) {
					$conditional = array();
					$conditional['where']['language_id'] = $value_language['id'];
//					$conditional['where_not_in']['source_id'] = $source_arr;
                    if ($this->role_id == 1) {
                        $conditional['where_in']['source_id'] = array(1, 2, 3, 5, 7, 8, 12, 16, 17, 18);
                    }
//					$conditional['where_not_in']['sale_staff_id'] = array(5, 18);
					if ($key2 == 'NHAN' && !isset($get['tic_report'])) {
						unset($value2['where']['date_handover >='], $value2['where']['date_handover <=']);
						$value2['where']['date_rgt >='] = $startDate;
						$value2['where']['date_rgt <='] = $endDate;
//						$value2['where']['duplicate_id'] = '0';
//						$value2['where']['call_status_id NOT IN (1, 3)'] = 'NO-VALUE';
//						$value2['where']['level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")'] = 'NO-VALUE';
					}
					$conditional = array_merge_recursive($conditional, $value2);
					$language[$key_language][$key2] = $this->_query_for_report($get, $conditional);
					$temp_language += $language[$key_language][$key2];
					$data[$key2 . '_L'] = $temp_language;
				}
			}
        }

		$total_re = 0;
		foreach ($staffs as $value) {
			$total_re += $value['RE'];
			$data['RE'] = $total_re;
		}

		$data['language'] = $language;
//		$data['source'] = $source;
        $data['staffs'] = $staffs;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('branch', 'date_happen_1', 'tic_report');
        $data['right_col'] = array('is_old', 'language');
        $data['load_js'] = array('m_view_report');
        $data['content'] = 'manager/view_report';
        if($this->role_id == 1){
            $data['top_nav'] = 'sale/common/top-nav';
        }
//        print_arr($data);
        $this->	load->view(_MAIN_LAYOUT_, $data);
    }

    function view_report_kpi_sale() {
        $require_model = array(
            'language_study' => array(
                'where' => array(
                    'out_report' => '0'
                )
            ),
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $language = $data['language_study'];

        $get = $this->input->get();

//        $input = array();
//        $input['select'] = 'id, name, out_report';
//        $input['where'] = array('role_id' => 1, 'active' => 1);
//        $staffs = $this->staffs_model->load_all($input);

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

        $conditionArr = array(
            'NHAN' => array(
                'where' => array('call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'duplicate_id' => '0', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
            ),
            'CHUA_GOI' => array(
                'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
            ),
            'XU_LY' => array(
                'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'NGHE_MAY' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'KHONG_NGHE_MAY' => array(
                'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'L1' => array(
                'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'level_contact_id' => 'L1'),
            ),
            'L2' => array(
                'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'L3' => array(
                'where' => array('level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
            ),
            'L4' => array(
                'where' => array('level_contact_id' => 'L4', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'L5' => array(
                'where' => array('duplicate_id' => '0', 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
            ),
            'L6' => array(
                'where' => array('level_student_id' => 'L6', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
            ),
            'L7' => array(
                'where' => array('level_student_id' => 'L7', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
            ),
            'L8' => array(
                'where' => array('level_contact_id' => 'L5', 'level_student_id !=' => 'L8.1', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
            ),
            'LC' => array(
                'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate,
                    '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ' OR `call_status_id` = 5 OR `level_contact_detail` IN ("L1.1", "L1.2", "L1.3"))' => 'NO-VALUE'),
            ),
        );

        unset($get['filter_date_date_happen']);
        foreach ($conditionArr as $key2 => $value2) {
            $temp_language = 0;
            foreach ($language as $key_language => $value_language) {
                $conditional = array();
                $conditional['where']['language_id'] = $value_language['id'];
                $conditional['where_in']['source_id'] = array(1, 2, 3, 5, 7, 8, 12, 16, 17, 18);
//					$conditional['where_not_in']['sale_staff_id'] = array(5, 18);
//                if ($key2 == 'NHAN' && !isset($get['tic_report'])) {
//                    unset($value2['where']['date_handover >='], $value2['where']['date_handover <=']);
//                    $value2['where']['date_rgt >='] = $startDate;
//                    $value2['where']['date_rgt <='] = $endDate;
//                }
                $conditional = array_merge_recursive($conditional, $value2);
                $language[$key_language][$key2] = $this->_query_for_report($get, $conditional);
                $temp_language += $language[$key_language][$key2];
                $data[$key2 . '_L'] = $temp_language;
            }
        }

//        $total_re = 0;
//        foreach ($staffs as $value) {
//            $total_re += $value['RE'];
//            $data['RE'] = $total_re;
//        }

        $data['language'] = $language;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('date_happen_1');
//        $data['right_col'] = array();
        $data['content'] = 'manager/view_report_kpi_sale';

        $this->	load->view(_MAIN_LAYOUT_, $data);
    }

    function view_report_revenue() {
        $this->load->helper('manager_helper');
		$this->load->model('paid_model');
		$this->load->model('language_study_model');
		$this->load->model('branch_model');
		$require_model = array(
			'branch' => array(
				'where' => array(
					'active' => 1,
				)
			),
			'language_study' => array(
				'where' => array(
					'active' => 1,
					'out_report' => '0'
				)
			),
			'source_revenue' => array()
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

		if ($this->role_id != 12) {
            $input_re = array();
            $input_re['select'] = 'SUM(paid) as paiding';
            $input_re['where'] = array(
                'time_created >=' => $date_from,
                'time_created <=' => $date_end,
                'source_revenue_id !=' => 2
            );
            if (isset($get['filter_source_revenue_id']) && $get['filter_source_revenue_id'] != '') {
                unset($input_re['where']['source_revenue_id !=']);
                $input_re['where_in']['source_revenue_id'] = $get['filter_source_revenue_id'];
            }

            $input_source['where'] = array('out_report' => '1');
            $this->load->model('sources_model');
            $source = $this->sources_model->load_all($input_source);
            $source_arr = array();
            if (!empty($source)) {
                foreach ($source as $item) {
                    $source_arr[] = $item['id'];
                }
            }

            $input_language['where']['active'] = 1;
            $language = $this->language_study_model->load_all($input_language);

            $language_re = array();
            foreach ($language as $value) {
                $input_re['where_not_in']['source_id'] = $source_arr;
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

            $data['language_re'] = $language_re;
        } else {
            $data['branch'] = array();
            $data['branch'][] = array(
		        'id' => $this->branch_id,
                'name' => $this->branch_model->find_branch_name($this->branch_id)
            );
        }

		//unset($data['branch'][0]);
		foreach ($data['language_study'] as $v_language) {
			$re_new_temp = 0;
			$re_old_temp = 0;
			foreach ($data['branch'] as $v_branch) {
				$input_re = array();
				$input_re['select'] = 'SUM(paid) as paiding';
				$input_re['where'] = array(
					'time_created >=' => $date_from,
					'time_created <=' => $date_end,
					'language_id' => $v_language['id'],
					'branch_id' => $v_branch['id'],
					'source_revenue_id !=' => 2
				);

				if (isset($get['filter_source_revenue_id']) && $get['filter_source_revenue_id'] != '') {
					unset($input_re['where']['source_revenue_id !=']);
					$input_re['where_in']['source_revenue_id'] = $get['filter_source_revenue_id'];
				}

				$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
				$input_re_old = array_merge_recursive(array('where' => array('student_old' => '1')), $input_re);

				$re[$v_branch['id']]['branch_name'] = $v_branch['name'];
//				$re[$v_branch['id']][$v_language['id']]['re_total'] = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
				$re[$v_branch['id']][$v_language['id']]['re_new'] = (int) $this->paid_model->load_all($input_re_new)[0]['paiding'];
				$re[$v_branch['id']][$v_language['id']]['re_old'] = (int) $this->paid_model->load_all($input_re_old)[0]['paiding'];

				$re_new_temp += $re[$v_branch['id']][$v_language['id']]['re_new'];
				$total[$v_language['id']]['total_re_new'] = $re_new_temp;

				$re_old_temp += $re[$v_branch['id']][$v_language['id']]['re_old'];
				$total[$v_language['id']]['total_re_old'] = $re_old_temp;
        	}
		}

		//print_arr($re);

		$data['re'] = $re;
		$data['total'] = $total;
		$data['startDate'] = $date_from;
		$data['endDate'] = $date_end;

		$data['left_col'] = array('date_happen_1', 'source_revenue');
        $data['content'] = 'manager/view_report_revenue';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_payment_method() {
		$this->load->model('paid_model');
		$this->load->model('branch_model');
		$this->load->model('language_study_model');
		$require_model = array(
			'branch' => array(),
			'payment_method_rgt' => array(
				'where' => array('active' => 1)
			),
			'language_study' => array(),
			'account_banking' => array()
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
        $date_for_report = $this->display_date(trim($dateArr[0]), trim($dateArr[1]), 'Y-m-d');

        if ($this->role_id == 12) {
            $branch[] = array('id' => $this->branch_id, 'name' => $this->branch_model->find_branch_name($this->branch_id));
            $data['branch'] = $branch;
        }

        $cash_day = array();
		$re = array();
		foreach ($data['branch'] as $v_branch) {
			foreach ($data['payment_method_rgt'] as $v_payment) {
				$input_re = array();
				$input_re['select'] = 'SUM(paid) as paiding';
				$input_re['where'] = array(
					'time_created >=' => $date_from,
					'time_created <=' => $date_end,
					'payment_method_id' => $v_payment['id'],
					'branch_id' => $v_branch['id']
				);
				if (isset($get['filter_language_id'])) {
					$input_re['where_in']['language_id'] = $get['filter_language_id'];
				}
				
				$re[$v_branch['id']]['branch_name'] = $v_branch['name'];
				$re[$v_branch['id']][$v_payment['id']]['re_total'] = (int) $this->paid_model->load_all($input_re)[0]['paiding'];

				if ($v_payment['id'] == 4) {
					foreach ($data['account_banking'] as $account) {
						$input_re['where']['account_banking_id'] = $account['id'];
						$re[$v_branch['id']][$v_payment['id']][$account['bank']]['re_total'] = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
					}
				}
			}

            foreach ($date_for_report as $value_date) {
                $input_paid_date['select'] = 'SUM(paid) AS PAID';
                $input_paid_date['where'] = array(
                    'day' => $value_date,
                    'branch_id' => $v_branch['id'],
                    'payment_method_id' => 1
                );

                $cash = $this->paid_model->load_all($input_paid_date);
                if (!empty($cash)) {
                    $cash_day[$v_branch['name']]['total'] += $cash[0]['PAID'];
                    $cash_day[$v_branch['name']][$value_date] = $cash[0]['PAID'];
                }
            }
		}

//		print_arr($re);
		$data['re'] = $re;
		$data['startDate'] = $date_from;
		$data['endDate'] = $date_end;
		$data['cash'] = $cash_day;
		$data['date'] = $date_for_report;
		$data['left_col'] = array('date_happen_1', 'language');
		$data['content'] = 'manager/view_report_payment_method';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_student_branch() {
		$require_model = array(
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
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
					'where' => array('date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate, 'is_old' => '0', 'duplicate_id' => '0',
						'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_handover !=' => '0', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L5_1' => array(
					'where' => array('level_contact_id' => 'L5', 'source_id NOT IN (9, 10, 11, 13)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L5_2' => array(
					'where' => array('level_contact_id' => 'L5', 'source_id IN (9, 10, 11, 13)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'is_old' => '0', 'duplicate_id' => '0',
						'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'is_old' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'is_old' => '0', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
				),
				'L5_1' => array(
					'where' => array('level_contact_id' => 'L5', 'source_id NOT IN (9, 10, 11, 13)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L5_2' => array(
					'where' => array('level_contact_id' => 'L5', 'source_id IN (9, 10, 11, 13)' => 'NO-VALUE', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
			);
		}

//		unset($data['branch'][0]);
		unset($data['language_study'][3]);
		unset($get['filter_date_date_happen']);

		$branch = array();
		$total = array();
		if ($this->role_id == 12) {
			$this->load->model('branch_model');
			foreach ($data['language_study'] as $item) {
				foreach ($conditionArr as $key2 => $value2) {
					$conditional = array();
					$conditional['where']['branch_id'] = $this->branch_id;
					$conditional['where']['language_id'] = $item['id'];
//					$conditional['where_not_in']['sale_staff_id'] = array(5, 18);
					$conditional = array_merge_recursive($conditional, $value2);
//					echo '<pre>'; print_r($conditional);
					$branch[$this->branch_id]['name'] = $this->branch_model->find_branch_name($this->branch_id);
					$branch[$this->branch_id][$item['id']][$key2] = $this->_query_for_report($get, $conditional);
//					$data[$branch_id] += $branch[$branch_id][$key2];
				}
			}
		} else {
			foreach ($data['language_study'] as $item) {
				foreach ($conditionArr as $key2 => $value2) {
					$temp = 0;
					foreach ($data['branch'] as $key => $value) {
						$conditional = array();
						$conditional['where']['branch_id'] = $value['id'];
						$conditional['where']['language_id'] = $item['id'];
//						$conditional['where_not_in']['sale_staff_id'] = array(5, 18);
						$conditional = array_merge_recursive($conditional, $value2);
	//						echo '<pre>'; print_r($conditional);
						$branch[$key]['name'] = $value['name'];
						$branch[$key][$item['id']][$key2] = $this->_query_for_report($get, $conditional);
						$temp += $branch[$key][$item['id']][$key2];
						$total[$item['id']][$key2] = $temp;
					}
				}
			}
			$branch['total'] = $total;
			$branch['total']['name'] = 'Tổng';
		}

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
					'out_report' => '0'
				)
			),
			'sources' => array(
				'where' => array(
					'active' => 1,
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
					'where' => array('duplicate_id' => '0', 'is_old' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L3' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L5' => array(
					'where' => array('duplicate_id' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L8' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('is_old' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L3' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
				),
				'L5' => array(
					'where' => array('duplicate_id' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L8' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
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
				foreach ($data['language_study'] as $value_language) {
					$conditional_1 = array();
					$conditional_1['where']['language_id'] = $value_language['id'];
					$conditional = array_merge_recursive($conditional_1, $conditional_source, $value);

					$report[$value_language['name']][$value_source['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_source), $startDate, $endDate, 'report');
					$report[$value_language['name']][$value_source['name']][$key_condition] = $this->_query_for_report($get, $conditional);
				}

				$conditional_2 = array_merge_recursive($conditional_source, $value);
				$data['sources'][$key_source][$key_condition] = $this->_query_for_report($get, $conditional_2);
			}

			$data['sources'][$key_source]['RE'] = $this->get_re($conditional_source, $startDate, $endDate, 'report');
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'tic_report');
//		$data['right_col'] = array('is_old');
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
					'active' => 1,
//					'sale_study_abroad' => 1
				)
			),
			'sources' => array(
				'where' => array(
					'active' => 1,
//					'out_report' => 1
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
					'where' => array('date_handover !=' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L3' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L5' => array(
					'where' => array('duplicate_id' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L8' => array(
					'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
				),
				'L5' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
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
					
					if ($report[$value_source['name']][$value_sale['name']][$key_condition] == 0 && $report[$value_source['name']][$value_sale['name']]['RE'] == 0) {
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

	public function view_report_sale_language() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1,
					'out_report' => '0'
				)
			),
			'language_study' => array(
				'where' => array(
					'active' => 1
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
					'where' => array('date_handover !=' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_handover !=' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L5' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt >=' => $startDate, 'date_rgt <=' => $endDate),
				),
			);
		} else {
			$conditionArr = array(
				'L1' => array(
					'where' => array('date_handover >=' => $startDate, 'date_handover <=' => $endDate, 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				),
				'L2' => array(
					'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
				),
				'L3' => array(
					'where' => array('level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
				),
				'L5' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
				'L8' => array(
					'where' => array('level_contact_id' => 'L5', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
				),
			);
		}

		unset($get['filter_date_date_happen']);

		$report = array();
//		$total = array();
		foreach ($data['language_study'] as $key_language => $value_language) {
			$conditional_language = array();
			$conditional_language['where']['language_id'] = $value_language['id'];
//			$conditional_source['where_not_in']['sale_staff_id'] = array(5);

			foreach ($data['staffs'] as $value_sale) {
				foreach ($conditionArr as $key_condition => $value) {
					$conditional_sale = array();
					$conditional_sale['where']['sale_staff_id'] = $value_sale['id'];
					$conditional = array_merge_recursive($conditional_sale, $conditional_language, $value);

//					$report[$value_language['name']][$value_sale['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_language), $startDate, $endDate);
					$report[$value_language['name']][$value_sale['name']][$key_condition] = $this->_query_for_report($get, $conditional);

				}

				if ($report[$value_language['name']][$value_sale['name']]['L1'] == 0 && $report[$value_language['name']][$value_sale['name']]['L5'] == 0) {
					unset($report[$value_language['name']][$value_sale['name']]);
				}
			}

			if (empty($report[$value_language['name']])) {
				unset($report[$value_language['name']]);
			}

			$data['staffs'][$key_language]['RE'] = $this->get_re($conditional_language, $startDate, $endDate);
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'tic_report');
//		$data['right_col'] = array('source');
		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_sale_language';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	private function get_re($condition_id=[], $startDate=0, $endDate=0, $report='') {
		$this->load->model('paid_model');
		$input_contact = array();
		$input_contact['select'] = 'id';
		$input_contact['where']['date_paid >='] = $startDate;
		$input_contact['where']['date_paid <='] = $endDate;
//		$input_contact['where']['level_contact_id'] = 'L5';
		$input_contact = array_merge_recursive($condition_id, $input_contact);
//		print_arr($input_contact);
		$contact = $this->contacts_model->load_all($input_contact);

		$contact_id = array();
		foreach ($contact as $item) {
			$contact_id[] = $item['id'];
		}

		$re = 0;
		if (!empty($contact_id)) {
			$input_re['select'] = 'SUM(paid) as paiding';
			$input_re['where'] = array(
				'time_created >=' => $startDate,
				'time_created <=' => $endDate,
			);
			if ($report != '') {
				$input_re['where']['student_old'] = '0';
			}
			//print_arr($input_re);

			$input_re['where_in']['contact_id'] = $contact_id;

			$re = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
		}

		return $re;
	}

	public function view_report_class_study() {
    	$this->load->model('class_study_model');
		$require_model = array(
			'character_class' => array(),
			'branch' => array(
                'where' => array(
                    'active' => 1
                )
            ),
			'language_study' => array(
				'where' => array(
					'out_report' => '0',
                    'active' => 1
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
			),
			'ĐA_KT' => array(
				'where' => array('time_end_real >=' => $startDate, 'time_end_real <=' => $endDate, 'character_class_id' => 3),
			),
			'DK_KT' => array(
				'where' => array('time_end_expected >=' => $startDate, 'time_end_expected <=' => $endDate),
			),
		);

		$conditionalArr_contact = array(
			'L7' => array(
				'where' => array('level_study_id' => 'L7', 'date_action_of_study >=' => $startDate, 'date_action_of_study <=' => $endDate),
			),
			'L8' => array(
				'where' => array('level_student_id' => 'L8', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
			),
            'L8.1' => array(
				'where' => array('level_student_id' => 'L8.1', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
			),
		);

		unset($data['language_study'][3]);
		unset($get['filter_date_date_happen']);

		$branch = array();
		foreach ($data['branch'] as $key => $value_branch) {
			foreach ($data['language_study'] as $value_language) {
				foreach ($conditionArr as $key_class => $value_class) {
					$conditional = array();
					$conditional['select'] = 'class_study_id';
					$conditional['where']['branch_id'] = $value_branch['id'];
					$conditional['where']['language_id'] = $value_language['id'];
					$conditional = array_merge_recursive($conditional, $value_class);

					$class = $this->class_study_model->load_all($conditional);
					$branch[$value_branch['name']][$value_language['name']][$key_class] = count($class);

					$class_study_array = $this->get_class_id($class);
					if (!empty($class_study_array)) {
						$input_contact = array();
						$input_contact['select'] = 'id';
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

	public function view_report_customer_care() {
		$require_model = array(
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
				)
			),
		);

		$data = array_merge($this->data, $this->_get_require_data($require_model));
		$get = $this->input->get();

		$input = array();
		$input['where'] = array('role_id' => 12, 'active' => 1);
		$staff_customer_care_today = $staff_customer_care = $this->staffs_model->load_all($input);

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

		$conditionArr = array(
			'XU_LY' => array(
				'where' => array('customer_care_call_id !=' => '0'),
			),
			'NGHE_MAY' => array(
				'where' => array('customer_care_call_id' => 1),
			),
			'KO_NGHE_MAY' => array(
				'where' => array('customer_care_call_id' => 2),
			),
			'THAM_KHAO' => array(
				'where' => array('status_end_student_id' => 1),
			),
			'DONG_Y' => array(
				'where' => array('status_end_student_id' => 2),
			),
			'TU_CHOI' => array(
				'where' => array('status_end_student_id' => 3),
			),
		);

		$date_today_start = strtotime(date('d-m-Y'));
		$date_today_end = strtotime(date('d-m-Y')) + 3600 * 24 - 1;

		unset($get['filter_date_date_happen']);

		$conditional_date = array();
		$conditional_date['where']['date_customer_care_call >='] = $startDate;
		$conditional_date['where']['date_customer_care_call <='] = $endDate;

		$conditional_date_today = array();
		$conditional_date_today['where']['date_customer_care_call >='] = $date_today_start;
		$conditional_date_today['where']['date_customer_care_call <='] = $date_today_end;

		$staff_customer_care_today = array();
		foreach ($conditionArr as $key2 => $value2) {
			$temp_cc = 0;
			foreach ($staff_customer_care as $key_staff => $value_staff) {
				$conditional_staff = array();
				$conditional_staff['where']['staff_care_branch_id'] = $value_staff['id'];
				$conditional = array_merge_recursive($conditional_staff, $conditional_date, $value2);
				$staff_customer_care[$key_staff][$key2] = $this->_query_for_report($get, $conditional);

				$conditional_today = array_merge_recursive($conditional_staff, $conditional_date_today, $value2);
				$staff_customer_care_today[$key_staff][$key2] = $this->_query_for_report($get, $conditional_today);

				$temp_cc += $staff_customer_care[$key_staff][$key2];
				$data[$key2] = $temp_cc;
			}
		}
//		print_arr($staff_customer_care_today);

		$data['staffs'] = $staff_customer_care;
		$data['staff_customer_care_today'] = $staff_customer_care_today;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1');
//		$data['right_col'] = array('is_old');
//		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_customer_care';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_care_L7() {
    	$this->load->model('class_study_model');
		$require_model = array(
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
				)
			),
			'level_study' => array(
				'where' => array('parent_id' => 'L7')
			),
			'character_class' => array()
		);

		$data = array_merge($this->data, $this->_get_require_data($require_model));
		$get = $this->input->get();

//		$input = array();
//		$input['where'] = array('role_id' => 10, 'active' => 1);
//		$staff_customer_care = $this->staffs_model->load_all($input);

		/* Mảng chứa các ngày lẻ */
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

		if ($this->role_id != 12) {
			unset($data['branch'][0], $data['branch'][8]);
			$branch = $data['branch'];
		} else {
			$branch[] = array('id' => $this->branch_id, 'name' => $this->branch_model->find_branch_name($this->branch_id));
		}
		unset($get['filter_date_date_happen']);

		$report = array();
		$report_class = array();
		foreach ($branch as $key_branch => $value_branch) {
//			$temp_cc = 0;
			foreach ($data['level_study'] as $key_level => $value_level) {
				foreach ($data['language_study'] as $value_language) {
					$conditional = array();
					$conditional['where']['level_study_id'] = $value_level['level_id'];
					$conditional['where']['date_rgt_study >='] = $date_from;
					$conditional['where']['date_rgt_study <='] = $date_end;
					$conditional['where']['branch_id'] = $value_branch['id'];
					$conditional['where']['language_id'] = $value_language['id'];
//					$conditional = array_merge_recursive($conditional, $value_branch);
					$report[$value_branch['name']][$value_language['name']][$value_level['level_id']] = $this->_query_for_report($get, $conditional);
//					$temp_cc += $report[$value_branch['name']][$value_level['level_id']];
//					$data[$key2] = $temp_cc;
				}

				$input_class = array();
				$input_class['where'] = array(
					'time_start >=' => $date_from + 7*24*60*60,
					'time_start <=' => $date_end,
//					'character_class_id' => 2,
					'branch_id' => $value_branch['id']
				);

				if (isset($get['filter_character_class_id']) && $get['filter_character_class_id'] != '') {
					$input_class['where_in']['character_class_id'] = $get['filter_character_class_id'];
				} else {
					$input_class['where']['character_class_id'] = 2;
				}

				$class = $this->class_study_model->load_all($input_class);

				if (!empty($class)) {
					foreach ($class as $value_class) {
						$input_contact = array();
						$input_contact['where']['class_study_id'] = $value_class['class_study_id'];
						$input_contact['where']['level_contact_id'] = 'L5';
						$report_class[$value_branch['name']][$value_class['class_study_id']]['student'] = $this->_query_for_report($get, $input_contact);

						$input_contact['where']['status_end_student_id'] = 4;
						$report_class[$value_branch['name']][$value_class['class_study_id']]['student_L8'] = $this->_query_for_report($get, $input_contact);

						unset($input_contact['where']['level_contact_id']);
						$input_class_level_study = array_merge_recursive($input_contact, array('where' => array('level_study_id' => $value_level['level_id'])));
						$report_class[$value_branch['name']][$value_class['class_study_id']][$value_level['level_id']] = $this->_query_for_report($get, $input_class_level_study);
					}
				}
			}
		}
//		print_arr($report_class);

		$data['report'] = $report;
		$data['report_class'] = $report_class;
		$data['startDate'] = $date_from;
		$data['endDate'] = $date_end;
		$data['left_col'] = array('date_happen_1', 'character_class');
//		$data['right_col'] = array('is_old');
//		$data['load_js'] = array('m_view_report');
		$data['content'] = 'manager/view_report_care_l7';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_sale_handle() {
		$this->load->model('call_log_model');
		$require_model = array(
			'language_study' => array(),
		);

		$data = array_merge($this->data, $this->_get_require_data($require_model));
		$get = $this->input->get();

		/* Mảng chứa các ngày lẻ */
		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$start_date = trim($dateArr[0]);
		$start_date = strtotime(str_replace("/", "-", $start_date));
		$end_date = trim($dateArr[1]);
		$end_date = strtotime(str_replace("/", "-", $end_date)) + 3600 * 24 - 1;

		$input_call = array(
			'XU_LY' => array(
				'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $start_date, 'date_last_calling <=' => $end_date),
			),
			'CON_CUU_DUOC' => array(
				'where' => array('date_handover >=' => $start_date, 'date_handover <=' => $end_date,
					'(call_status_id = ' . _KHONG_NGHE_MAY_ . ' OR level_contact_id IN ("L3", "L2"))' => 'NO-VALUE'),
			),
			'CO_LICH_GOI_LAI' => array(
				'where' => array('date_recall >=' => $start_date, 'date_recall <=' => $end_date)
			),
		);

		for ($i=1; $i<6; $i++) {
			$input_call['LAN_' . $i] = array(
				'select' => 'contact_id',
				'where' => array('time_created >=' => $start_date, 'time_created <=' => $end_date),
				'group_by' => array('contact_id'),
				'having' => array('COUNT(contact_id)' => $i)
			);
		}

		$date_today_start = strtotime(date('d-m-Y'));
		$date_today_end = strtotime(date('d-m-Y')) + 3600 * 24 - 1;
		$input_call_today = array(
			'XU_LY' => array(
				'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $date_today_start, 'date_last_calling <=' => $date_today_end),
			),
			'CON_CUU_DUOC' => array(
				'where' => array('date_handover >=' => $date_today_start, 'date_handover <=' => $date_today_end,
					'(call_status_id = ' . _KHONG_NGHE_MAY_ . ' OR level_contact_id IN ("L3", "L2"))' => 'NO-VALUE'),
			),
			'CO_LICH_GOI_LAI' => array(
				'where' => array('date_recall >=' => $date_today_start, 'date_recall <=' => $date_today_end)
			),
		);

		for ($i=1; $i<6; $i++) {
			$input_call_today['LAN_' . $i] = array(
				'select' => 'contact_id',
				'where' => array('time_created >=' => $date_today_start, 'time_created <=' => $date_today_end),
				'group_by' => array('contact_id'),
				'having' => array('COUNT(contact_id)' => $i)
			);
		}

		unset($get['filter_date_date_happen']);

		$input = array();
		$input['select'] = 'id, name';
		$input['where'] = array('role_id' => 1, 'active' => 1);
		$staff= $this->staffs_model->load_all($input);
		
//		$temp_cc = 0;
		foreach ($staff as $key_staff => $value_staff) {
			foreach ($input_call as $key_call => $value_call) {
				$conditional_staff = array();
				if ($key_call == 'XU_LY' || $key_call == 'CON_CUU_DUOC' || $key_call == 'CO_LICH_GOI_LAI') {
					$conditional_staff['where']['sale_staff_id'] = $value_staff['id'];
					$conditional = array_merge_recursive($conditional_staff, $value_call);
					$staff[$key_staff][$key_call] = $this->_query_for_report($get, $conditional);
				} else {
					$conditional_staff['where']['staff_id'] = $value_staff['id'];
					$conditional = array_merge_recursive($conditional_staff, $value_call);
					$count_call = $this->call_log_model->load_all($conditional);
					$staff[$key_staff][$key_call] = (!empty($count_call)) ? count($count_call) : 0;
				}
			}

			foreach ($input_call_today as $key_call_today => $value_call_today) {
				$conditional_staff = array();
				if ($key_call_today == 'XU_LY' || $key_call_today == 'CON_CUU_DUOC' || $key_call_today == 'CO_LICH_GOI_LAI') {
					$conditional_staff['where']['sale_staff_id'] = $value_staff['id'];
					$conditional = array_merge_recursive($conditional_staff, $value_call_today);
					$staff[$key_staff][$key_call_today . '_TODAY'] = $this->_query_for_report($get, $conditional);
				} else {
					$conditional_staff['where']['staff_id'] = $value_staff['id'];
					$conditional = array_merge_recursive($conditional_staff, $value_call_today);
					$count_call = $this->call_log_model->load_all($conditional);
					$staff[$key_staff][$key_call_today . '_TODAY'] = (!empty($count_call)) ? count($count_call) : 0;
				}
			}

		}
//		print_arr($staff);

		$data['staffs'] = $staff;
		$data['startDate'] = $start_date;
		$data['endDate'] = $end_date;
		$data['left_col'] = array('date_happen_1');
//		$data['right_col'] = array('is_old');
		$data['content'] = 'manager/view_report_sale_handle';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_revenue_class() {
		$this->load->model('paid_model');
		$this->load->model('class_study_model');
		$this->load->model('branch_model');

		$require_model = array(
			'branch' => array(),
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

		if ($this->role_id != 12) {
			unset($data['branch'][0], $data['branch'][8]);
			$branch = $data['branch'];
		} else {
			$branch[] = array('id' => $this->branch_id, 'name' => $this->branch_model->find_branch_name($this->branch_id));
		}

		$report = array();
		foreach ($branch as $v_branch) {
			$input_class = array();
			$input_class['where'] = array(
				'time_start >=' => $date_from,
				'time_start <=' => $date_end,
				'character_class_id' => 2,
				'branch_id' => $v_branch['id']
			);
			if (isset($get['filter_language_id'])) {
				$input_class['where_in']['language_id'] = $get['filter_language_id'];
			}

			$class = $this->class_study_model->load_all($input_class);

			if (!empty($class)) {
				foreach ($class as $value_class) {
					$contact_id_arr = $this->get_contact_id($value_class['class_study_id']);
					if (!empty($contact_id_arr)) {
						$input_re = array();
						$input_re['select'] = 'SUM(paid) AS RE';
						$input_re['where_in']['contact_id'] = $contact_id_arr;
						$re_class = $this->paid_model->load_all($input_re);
						$report[$v_branch['name']][$value_class['class_study_id']]['RE'] = (!empty($re_class)) ? $re_class[0]['RE'] : 0;
						$report[$v_branch['name']][$value_class['class_study_id']]['student'] = count($contact_id_arr);
						$report[$v_branch['name']][$value_class['class_study_id']]['salary_teacher'] = $value_class['salary_per_day']*$value_class['lesson_learned'];
					}
				}
			}
		}

//		print_arr($report);
		$data['report'] = $report;
		$data['startDate'] = $date_from;
		$data['endDate'] = $date_end;

		$data['left_col'] = array('date_happen_1');
		$data['content'] = 'manager/view_report_revenue_class';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_compare_source() {
		$require_model = array(
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
				)
			),
			'sources' => array(
				'where' => array(
					'active' => 1,
					'out_report' => '0'
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
//		$startDate = trim($dateArr[0]);
//		$startDate = strtotime(str_replace("/", "-", $startDate));
//		$endDate = trim($dateArr[1]);
//		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

		if (isset($get['filter_date_date_happen_compare']) && $get['filter_date_date_happen_compare'] != '') {
			$time_compare = $get['filter_date_date_happen_compare'];
		} else {
			$time_compare = str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[0])))))) . ' - ' . str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[1]))))));
		}

		$date_array = array($time_compare, $time);

		$conditionArr = array(
			'L1' => array(
				'where' => array('duplicate_id' => '0', 'is_old' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				'time' => 'filter_date_date_rgt'
			),
			'L5' => array(
				'where' => array('duplicate_id' => '0', 'is_old' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'level_contact_id' => 'L5'),
				'time' => 'filter_date_date_rgt_study'
			),
		);

		unset($get['filter_date_date_happen']);

		$report = array();
//		$total = array();
		foreach ($data['sources'] as $key_source => $value_source) {
			$conditional_source = array();
			$conditional_source['where']['source_id'] = $value_source['id'];
			$conditional_source['where_not_in']['sale_staff_id'] = array(5, 18);
			foreach ($date_array as $value_date) {
				foreach ($conditionArr as $key_condition => $value_condition) {
					foreach ($data['language_study'] as $value_language) {
						$condition_language = array();
						$get_time = array($value_condition['time'] => $value_date);
						$condition_language['where']['language_id'] = $value_language['id'];
						$conditional = array_merge_recursive($condition_language, $conditional_source, $value_condition);

//						$report[$value_language['name']][$value_source['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_source), $startDate, $endDate, 'report');
						$report[$value_language['name']][$value_date][$value_source['name']][$key_condition] = $this->_query_for_report($get_time, $conditional);
					}
				}
			}
		}

//		print_arr($report);

		$data['report'] = $report;
//		$data['startDate'] = $startDate;
//		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1', 'date_happen_compare');
//		$data['right_col'] = array('is_old');
		$data['content'] = 'manager/view_report_compare_source';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_compare_sale() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'active' => 1,
					'role_id' => 1,
					'out_report' => '0'
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
//		$startDate = trim($dateArr[0]);
//		$startDate = strtotime(str_replace("/", "-", $startDate));
//		$endDate = trim($dateArr[1]);
//		$endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

		if (isset($get['filter_date_date_happen_compare']) && $get['filter_date_date_happen_compare'] != '') {
			$time_compare = $get['filter_date_date_happen_compare'];
		} else {
			$time_compare = str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[0])))))) . ' - ' . str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[1]))))));
		}

		$date_array = array($time_compare, $time);

		$conditionArr = array(
			'L1' => array(
				'where' => array('call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				'time' => 'filter_date_date_handover'
			),
			'L5' => array(
				'where' => array('level_contact_id' => 'L5'),
				'time' => 'filter_date_date_rgt_study'
			),
		);

		unset($get['filter_date_date_happen']);

		$report = array();
//		$total = array();
		foreach ($data['staffs'] as $key_source => $value_sale) {
			$conditional_sale = array();
			$conditional_sale['where']['sale_staff_id'] = $value_sale['id'];
			foreach ($date_array as $value_date) {
				foreach ($conditionArr as $key_condition => $value_condition) {
					$get_time = array($value_condition['time'] => $value_date);
					$conditional = array_merge_recursive($conditional_sale, $value_condition);

//						$report[$value_language['name']][$value_source['name']]['RE'] = $this->get_re(array_merge_recursive($conditional_1, $conditional_source), $startDate, $endDate, 'report');
					$report[$value_date][$value_sale['name']][$key_condition] = $this->_query_for_report($get_time, $conditional);

				}
			}
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['left_col'] = array('date_happen_1', 'date_happen_compare');
//		$data['right_col'] = array('is_old');
		$data['content'] = 'manager/view_report_compare_sale';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_sale_handle_source_data() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1,
					'out_report' => '0'
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
		$date_from_arr = trim($dateArr[0]);
		$startDate = strtotime(str_replace("/", "-", $date_from_arr));
		$date_end_arr = trim($dateArr[1]);
		$endDate = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24;

//		echo $startDate . ' - ' . $endDate;die;

		$conditionArr = array(
			'XU_LY' => array(),
			'KNM' => array(
				'where' => array('call_status_id' => _KHONG_NGHE_MAY_),
			),
			'L1' => array(
				'where' => array('level_contact_id' => 'L1'),
			),
			'L2' => array(
				'where' => array('level_contact_id' => 'L2'),
			),
			'L3' => array(
				'where' => array('level_contact_id' => 'L3'),
			),
			'L4' => array(
				'where' => array('level_contact_id' => 'L4'),
			),
			'L5' => array(
				'where' => array('level_contact_id' => 'L5'),
			),
		);

		unset($get['filter_date_date_happen']);

		$date_for_report = array_reverse($this->display_date($date_from_arr, $date_end_arr));
		$report = array();
		foreach ($data['staffs'] as $value_staff) {
			foreach ($date_for_report as $value_date) {
				foreach ($conditionArr as $key_condition => $value_condition) {
					$condition_1 = array();
					$condition_1['where']['date_last_calling >='] = strtotime(str_replace("/", "-", $value_date));
					$condition_1['where']['date_last_calling <='] = strtotime(str_replace("/", "-", $value_date)) + 3600 * 24 - 1;
					$condition_1['where']['sale_staff_id'] = $value_staff['id'];
					$condition_1['where']['source_id'] = 15;
					$conditional = array_merge_recursive($condition_1, $value_condition);
					$report[$value_staff['name']][$value_date][$key_condition] = $this->_query_for_report($get, $conditional);
					if ($report[$value_staff['name']][$value_date]['XU_LY'] == 0) {
						unset($report[$value_staff['name']][$value_date]);
					}
				}
				
			}
			if (empty($report[$value_staff['name']])) {
				unset($report[$value_staff['name']]);
			}
		}

//		print_arr($report);

		$data['report'] = $report;
		$data['date_for_report'] = $date_for_report;
//		$data['startDate'] = $startDate;
//		$data['endDate'] = $endDate;
		$data['left_col'] = array('date_happen_1');
		$data['content'] = 'manager/view_report_sale_handle_source_data';
//        print_arr($data);
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

    public function view_report_salary_teacher() {
        $this->load->model('teacher_model');
        $this->load->model('language_study_model');
        $this->load->model('branch_model');
        $this->load->model('mechanism_model');

        $require_model = array(
            'branch' => array(
                'where' => array(
                    'active' => 1,
                )
            ),
            'language_study' => array(
                'where' => array(
                    'is_primary' => 1
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
        $date_from = strtotime(str_replace("/", "-", trim($dateArr[0])));
        $date_end = strtotime(str_replace("/", "-", trim($dateArr[1]))) + 3600 * 24 - 1;

        $input_salary = array();
        $input_salary['select'] = 'SUM(money) as MONEY';
        $input_salary['where'] = array(
            'time_created >=' => $date_from,
            'time_created <=' => $date_end,
            'mechanism' => 2
        );

        $salary = array();
        $total = array();

        //unset($data['branch'][0]);
        foreach ($data['language_study'] as $v_language) {
            $re_new_temp = 0;
            $re_old_temp = 0;
            foreach ($data['branch'] as $v_branch) {
                $input_teacher['where'] = array(
                    'branch_id' => $v_branch['id'],
                    'language_id' => $v_language['id'],
                );

                $input_salary = array();
                $input_salary['select'] = 'SUM(money) as MONEY';
                $input_re['where'] = array(
                    'time_created >=' => $date_from,
                    'time_created <=' => $date_end,
                    'branch_id' => $v_branch['id'],
                    'mechanism' => 2
                );

//                $input_salary['where_in']['teacher_id'] =

                if (isset($get['filter_source_revenue_id']) && $get['filter_source_revenue_id'] != '') {
                    unset($input_re['where']['source_revenue_id !=']);
                    $input_re['where_in']['source_revenue_id'] = $get['filter_source_revenue_id'];
                }

                $input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
                $input_re_old = array_merge_recursive(array('where' => array('student_old' => '1')), $input_re);

                $salary[$v_branch['id']]['branch_name'] = $v_branch['name'];
//				$re[$v_branch['id']][$v_language['id']]['re_total'] = (int) $this->paid_model->load_all($input_re)[0]['paiding'];
                $salary[$v_branch['id']][$v_language['id']]['re_new'] = (int) $this->paid_model->load_all($input_re_new)[0]['paiding'];
                $salary[$v_branch['id']][$v_language['id']]['re_old'] = (int) $this->paid_model->load_all($input_re_old)[0]['paiding'];

                $re_new_temp += $salary[$v_branch['id']][$v_language['id']]['re_new'];
                $total[$v_language['id']]['total_re_new'] = $re_new_temp;

                $re_old_temp += $salary[$v_branch['id']][$v_language['id']]['re_old'];
                $total[$v_language['id']]['total_re_old'] = $re_old_temp;
            }
        }

        //print_arr($salary);

        $data['salary'] = $salary;
        $data['total'] = $total;
        $data['startDate'] = $date_from;
        $data['endDate'] = $date_end;

        $data['left_col'] = array('date_happen_1', 'source_revenue');
        $data['content'] = 'manager/view_report_revenue';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_care_class() {
        $this->load->model('class_study_model');

        $get = $this->input->get();

        $input = array();
        $input['where'] = array('role_id' => 10, 'active' => 1);
        $staff_customer_care = $this->staffs_model->load_all($input);

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

        $conditionArr = array(
            'CHUA_CHAM' => array(
                'where' => array('number_care' => '0'),
            ),
            'DA_CHAM' => array(
                'where' => array('number_care !=' => '0'),
            ),
            'LAN_1' => array(
                'where' => array('number_care' => 1),
            ),
            'LAN_2' => array(
                'where' => array('number_care' => 2),
            ),
            'LAN_3' => array(
                'where' => array('number_care' => 3),
            ),
        );

        unset($get['filter_date_date_happen']);

        $conditional_date_end_expected = array();
        $conditional_date_end_expected['where']['time_end_expected >='] = $startDate;
        $conditional_date_end_expected['where']['time_end_expected <='] = $endDate;

        $conditional_date_end_real = array();
        $conditional_date_end_real['where']['time_end_real >='] = $startDate;
        $conditional_date_end_real['where']['time_end_real <='] = $endDate;

        $data_end_expected = $data_end_real = array();
        foreach ($conditionArr as $key2 => $value2) {
//            $temp_cc = 0;
            foreach ($staff_customer_care as $key_staff => $value_staff) {
                $conditional_staff = array();
                $conditional_staff['select'] = 'id';
                $conditional_staff['where']['staff_customer_id'] = $value_staff['id'];
                $conditional = array_merge_recursive($conditional_staff, $value2);
                $staff_customer_care[$key_staff][$key2] = count($this->class_study_model->load_all($conditional));
//                $temp_cc += $staff_customer_care[$key_staff][$key2];
//                $data[$key2] = $temp_cc;
                $conditional_end_expected = array_merge_recursive($conditional, $conditional_date_end_expected);
                $data_end_expected[$value_staff['name']][$key2] = count($this->class_study_model->load_all($conditional_end_expected));

                $conditional_end_real = array_merge_recursive($conditional, $conditional_date_end_real);
                $data_end_real[$value_staff['name']][$key2] = count($this->class_study_model->load_all($conditional_end_real));
            }
        }

        $data['staffs'] = $staff_customer_care;
        $data['data_end_expected'] = $data_end_expected;
        $data['data_end_real'] = $data_end_real;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('date_happen_1');
        $data['content'] = 'manager/view_report_care_class';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_care_class_total() {
        $this->load->model('class_study_model');
        $require_model = array(
            'language_study' => array(
                'where' => array(
                    'out_report' => '0',
                    'active' => 1
                )
            ),
            'branch' => array(
                'where' => array(
                    'active' => 1
                )
            )
        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));
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

        $conditionArr = array(
            'CHUA_CHAM' => array(
                'where' => array('number_care' => '0'),
            ),
            'DA_CHAM' => array(
                'where' => array('number_care !=' => '0'),
            ),
            'LAN_1' => array(
                'where' => array('number_care' => 1),
            ),
            'LAN_2' => array(
                'where' => array('number_care' => 2),
            ),
            'LAN_3' => array(
                'where' => array('number_care' => 3),
            ),
        );

        unset($get['filter_date_date_happen']);

        $conditional_date_end_expected = array();
        $conditional_date_end_expected['where']['time_end_expected >='] = $startDate;
        $conditional_date_end_expected['where']['time_end_expected <='] = $endDate;

        $conditional_date_end_real = array();
        $conditional_date_end_real['where']['time_end_real >='] = $startDate;
        $conditional_date_end_real['where']['time_end_real <='] = $endDate;

        $branch = $data_end_expected = $data_end_real = array();
        foreach ($conditionArr as $key2 => $value2) {
            foreach ($data['branch'] as $key => $value_branch) {
                foreach ($data['language_study'] as $value_language) {
                    $conditional = array();
                    $conditional['select'] = 'id';
                    $conditional['where']['branch_id'] = $value_branch['id'];
                    $conditional['where']['language_id'] = $value_language['id'];
                    $conditional = array_merge_recursive($conditional, $value2);
                    $branch[$value_branch['name']][$value_language['name']][$key2] = count($this->class_study_model->load_all($conditional));

                    $conditional_end_expected = array_merge_recursive($conditional, $conditional_date_end_expected);
                    $data_end_expected[$value_branch['name']][$value_language['name']][$key2] = count($this->class_study_model->load_all($conditional_end_expected));

                    $conditional_end_real = array_merge_recursive($conditional, $conditional_date_end_real);
                    $data_end_real[$value_branch['name']][$value_language['name']][$key2] = count($this->class_study_model->load_all($conditional_end_real));
                }
            }
        }

        $data['branch'] = $branch;
        $data['data_end_expected'] = $data_end_expected;
        $data['data_end_real'] = $data_end_real;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('date_happen_1');
        $data['content'] = 'manager/view_report_care_class_total';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_staff_care_branch() {
        $require_model = array(
            'language_study' => array(
                'where' => array(
                    'out_report' => '0'
                )
            ),
            'branch' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $get = $this->input->get();

        $input = array();
        $input['select'] = 'id, name';
        $input['where'] = array('role_id' => 12, 'active' => 1);
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

        $conditionArr = array(
                'NHAN' => array(
                    'where' => array('call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'duplicate_id' => '0', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
                ),
                'CHUA_GOI' => array(
                    'where' => array('call_status_id' => '0', 'level_contact_id' => '', 'date_handover >=' => $startDate, 'date_handover <=' => $endDate),
                ),
                'XU_LY' => array(
                    'where' => array('call_status_id !=' => '0', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'NGHE_MAY' => array(
                    'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'KHONG_NGHE_MAY' => array(
                    'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'L1' => array(
                    'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate, 'level_contact_id' => 'L1'),
                ),
                'L2' => array(
                    'where' => array('level_contact_id' => 'L2', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'L3' => array(
                    'where' => array('level_contact_id' => 'L3', 'date_confirm >=' => $startDate, 'date_confirm <=' => $endDate),
                ),
                'L4' => array(
                    'where' => array('level_contact_id' => 'L4', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'L5' => array(
                    'where' => array('duplicate_id' => '0', 'level_contact_id' => 'L5', 'is_old' => '0', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
                ),
                'L6' => array(
                    'where' => array('level_student_id' => 'L6', 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
                ),
                'L7' => array(
                    'where' => array('level_student_id' => 'L7', 'date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate),
                ),
                'L8' => array(
                    'where' => array('level_contact_id' => 'L5', 'level_student_id !=' => 'L8.1', 'is_old' => 1, 'date_rgt_study >=' => $startDate, 'date_rgt_study <=' => $endDate),
                ),
                'LC' => array(
                    'where' => array('date_last_calling >=' => $startDate, 'date_last_calling <=' => $endDate,
                        '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ' OR `call_status_id` = 5 OR `level_contact_detail` IN ("L1.1", "L1.2", "L1.3"))' => 'NO-VALUE'),
                ),
                /*
                'CON_CUU_DUOC' => array(
                    'where' => array('date_rgt >' => $startDate, 'date_rgt <' => $endDate,
                        '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                ),
                */
            );

        unset($get['filter_date_date_happen']);

        foreach ($conditionArr as $key2 => $value2) {
            $temp_sale = 0;
            foreach ($staffs as $key_staff => $value_staff) {
                $conditional_1 = array();
                $conditional_1['where']['staff_care_branch_id'] = $value_staff['id'];
                //$conditional_1['where_not_in']['source_id'] = $source_arr;
                $conditional = array_merge_recursive($conditional_1, $value2);
                $staffs[$key_staff][$key2] = $this->_query_for_report($get, $conditional);
                //$conditionArr_staff[$key2]['sum'] += $staffs[$key][$key2];
                $temp_sale += $staffs[$key_staff][$key2];
                if ($value_staff['out_report'] == 1) { // ko tính contact này vào tổng
                    $temp_sale = $temp_sale - $staffs[$key_staff][$key2];
                }
                $data[$key2] = $temp_sale;
                $staffs[$key_staff]['RE'] = $this->get_re($conditional_1, $startDate, $endDate);
                //$data['RE'] += $staffs[$key_staff]['RE'];
            }
        }

        $total_re = 0;
        foreach ($staffs as $value) {
            $total_re += $value['RE'];
            $data['RE'] = $total_re;
        }

        $data['staffs'] = $staffs;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('branch', 'date_happen_1');
        $data['right_col'] = array('language');
        $data['content'] = 'manager/view_report_staff_care_branch';
        if($this->role_id == 1){
            $data['top_nav'] = 'sale/common/top-nav';
        }
        $this->	load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_ty_le_dang_ky_di_len() {
        $this->load->model('class_study_model');
        $require_model = array(
            'branch' => array(
                'where' => array(
                    'active' => 1
                )
            )
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $get = $this->input->get();

        /* Mảng chứa các ngày lẻ */
        if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
            $time = $get['filter_date_date_happen'];
        } else {
            $time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
        }

        $dateArr = explode('-', $time);
        $startDate = strtotime(str_replace("/", "-", trim($dateArr[0])));
        $endDate = strtotime(str_replace("/", "-", trim($dateArr[1]))) + 3600 * 24 - 1;

        unset($get['filter_date_date_happen']);

        if ($this->role_id != 12) {
            $branch = $data['branch'];
        } else {
            $branch[] = array('id' => $this->branch_id, 'name' => $this->branch_model->find_branch_name($this->branch_id));
        }

        $level = array(
            array('LV0', 0, 40),
            array('LV1', 40, 60),
            array('LV2', 60, 70),
            array('LV3', 70, 80),
            array('LV4', 80, 90),
            array('LV5', 90, 100),
            array('LV6', 100, 110),
        );

        foreach ($branch as $key_branch => &$value_branch) {
            $conditional_class['select'] = 'id, class_study_id';
            $conditional_class['where']['branch_id'] = $value_branch['id'];
            $conditional_class['where']['time_end_real >='] = $startDate;
            $conditional_class['where']['time_end_real <='] = $endDate;

            $class_of_branch = $this->class_study_model->load_all($conditional_class);
            if (!empty($class_of_branch)) {
                foreach ($class_of_branch as $value_class) {
                    $input_contact = array();
                    $input_contact['select'] = 'id';
                    $input_contact['where']['(class_study_id = "'. $value_class['class_study_id'] .'" OR class_foreign_id LIKE "%'. $value_class['class_study_id'] .'%")'] = 'NO-VALUE';
                    $input_contact['where']['level_contact_id'] = 'L5';
                    $input_contact['where']['level_contact_detail !='] = 'L5.4';
                    $L7 = count($this->contacts_model->load_all($input_contact));
                    if ($L7) {
                        $input_contact['where'] = array();
                        $input_contact['where']['class_study_id'] = $value_class['class_study_id'];
                        $input_contact['where']['level_study_id'] = 'L7.6';
                        $L7_6 = count($this->contacts_model->load_all($input_contact));

                        foreach ($level as $value_level) {
                            $temp = 0;
                            list($name, $limit1, $limit2) = $value_level;
                            if ($limit1 <= round($L7_6/$L7 * 100) && round($L7_6/$L7 * 100) < $limit2) {
                                $temp += 1;
                            };
                            $value_branch[$name] += $temp;
                        }
                    }
                }
            }
        }

        $data['level'] = $level;
        $data['branch'] = $branch;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['left_col'] = array('date_happen_1');
//        $data['right_col'] = array('language');
        $data['content'] = 'manager/view_report_ty_le_dang_ky_di_len';

        $this->	load->view(_MAIN_LAYOUT_, $data);
    }

	private function get_contact_id($class_id) {
		$input_contact = array();
		$input_contact['select'] = 'id';
		$input_contact['where']['class_study_id'] = $class_id;
		$input_contact['where']['level_contact_id'] = 'L5';
		$contact_arr = $this->contacts_model->load_all($input_contact);
    	$contact_id_arr = array();
    	if (!empty($contact_arr)) {
			foreach ($contact_arr as $item) {
				$contact_id_arr[] = $item['id'];
			}
		}
		return $contact_id_arr;
	}

	private function get_class_id($class_arr) {
		$class_id_arr = array();
		if (!empty($class_arr)) {
			foreach ($class_arr as $item) {
				$class_id_arr[] = $item['class_study_id'];
			}
		}
		return $class_id_arr;
	}
	// </editor-fold>

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
            'level_study' => array(),
			'language_study' => array(),
			'customer_call_status' => array(),
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
        $inputContact['where'] = array('date_rgt >=' => strtotime(date('d-m-Y')));
        $today = $this->contacts_model->load_all($inputContact);
  
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $total_marketing_day,
            'name' => 'Marketing',
            'type' => 'C3'
        );
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_old' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_sale_day_L5,
            'name' => 'Học viên mới',
            'type' => 'L5'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

		$inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_old' => '1');
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
		$input['where']['out_report'] = '0';
		$input['where']['active'] = 1;
		$language = $this->language_study_model->load_all($input);
		
		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'source_revenue_id' => 1,
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
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')));
        $today = $this->contacts_model->load_all($inputContact);
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $qr[0]['targets'] * 30,
            'name' => 'Marketing',
            'type' => 'C3'
		);
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('01-m-Y')), 'is_old' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_month_L5,
            'name' => 'Học viên mới',
            'type' => 'L5'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

		$inputContact['where'] = array('date_rgt_study >=' => strtotime(date('1-m-Y')), 'is_old' => 1);
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
		$input['where']['out_report'] = '0';
		$input['where']['active'] = 1;
		$language = $this->language_study_model->load_all($input);
		
		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'source_revenue_id' => 1,
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
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Địa chỉ');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Số điện thoại');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Học phí');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Khóa học');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Tổng số giờ');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Lớp');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Học phí gốc');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Thời gian học');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày học');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày khai giảng');
		//$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'ID cơ sở');
		//$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'ID ngoại ngữ');
		$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày đăng ký');

		//$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ghi chú');

		$rowCount++;

        //đổ dữ liệu ra file excel
		$this->load->model('class_study_model');
		$this->load->model('level_language_model');
		$this->load->model('time_model');
		$this->load->model('day_model');
        $i = 1;
//		$rowCount = 2;
        foreach ($post['contact_id'] as $value) {
            $input = array();
            //$input['select'] = 'name, branch_id, language_id, email, phone, date_rgt';
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);
			
			
			$input_class['where'] = array('class_study_id' => $contact['class_study_id']);
			$class = $this->class_study_model->load_all($input_class);
//          print_arr($value);
			$course = $this->level_language_model->get_name_level_language($contact[0]['level_language_id']);
			$time = $this->time_model->get_time($class[0]['time_id']);
			$day = $this->day_model->get_day($class[0]['day_id']);

            $columnName = 'A';
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['fee']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $course);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, !empty($class) ? $class[0]['total_lesson'] : 0);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['class_study_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 0);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $time);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $day);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, !empty($class) ? date('d/m/Y', $class[0]['time_start']) : 0);
            //$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['branch_id']);
            //$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['language_id']);
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
