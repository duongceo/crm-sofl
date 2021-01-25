<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sale
 *
 * @author CHUYEN
 */
class Sale extends MY_Controller {

    public $L = array();

    public function __construct() {
        parent::__construct();
        $this->data['top_nav'] = 'sale/common/top-nav';
        $data['time_remaining'] = 0;
        $input = array();
        $input['select'] = 'date_recall';
        $input['where']['sale_staff_id'] = $this->user_id;
        $input['where']['date_recall >'] = time();
        $input['order']['date_recall'] = 'ASC';
        $input['limit'] = array('1', '0');
        $noti_contact = $this->contacts_model->load_all($input);
        if (!empty($noti_contact)) {
            $time_remaining = $noti_contact[0]['date_recall'] - time();
            $data['time_remaining'] = ($time_remaining < 1800) ? $time_remaining : 0;
        }
        $this->load->vars($data);
        $this->_loadCountListContact();
    }

    function index($offset = 0) {
//		$this->load->helper('cookie');
//		$get_cookie = get_cookie('sale_first_login_day');
////		print_arr($_COOKIE);
//		if (!isset($get_cookie)) {
//			redirect(base_url('sale/get_phone_missed_call'));
//		}

        $data = $this->_get_all_require_data();
        $get = $this->input->get();

        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa gọi lần nào và contact là của riêng TVTS, sắp xếp theo ngày nhận contact
         *
         */
        $conditional['where'] = array('call_status_id' => '0', 'sale_staff_id' => $this->user_id, 'is_hide' => '0');
        //$conditional['order'] = array('date_handover' => 'DESC');
		$conditional['order'] = array('date_rgt' => 'DESC');

        //$this->per_page = 1;
        
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		//echo '<pre>'; print_r($data_pagination);die;

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
        $data['right_col'] = array('language');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */

        $this->table .= 'date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['progressType'] = 'Tiến độ ngày hôm nay';
		$data['progress'] = $this->GetProccessToday();
		$data['progress_sale'] = $data['progress']['progress_sale'];

//		print_arr($data);
//		$data['sale_call_process'] = $this->sale_call_process();
        $data['titleListContact'] = 'Danh sách contact mới';
        $data['actionForm'] = 'sale/transfer_contact';
        $informModal = 'sale/modal/transfer_multi_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'sale/modal/transfer_one_contact sale/modal/transfer_one_contact_to_manager';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function has_callback($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array(
            'date_recall >' => '0',
            // 'date_recall <' => strtotime('tomorrow'),
            'sale_staff_id' => $this->user_id,
            'is_hide' => '0',
		);
        $conditional['where_not_in'] = array(
            'call_status_id' => $this->_get_stop_care_call_stt(),
//            'ordering_status_id' => $this->_get_stop_care_order_stt()
			'level_contact_id' => array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'),
		);

        $conditional['order'] = array('date_recall' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['total_contact'] = $data_pagination['total_row'];
        $contacts = $data_pagination['data'];

        $this->load->model('notes_model');
        foreach ($contacts as &$value) {
            $input = array();
            //$input['where'] = array('contact_code' => $value['phone'] . '_' . $value['course_code']);
			$input['where'] = array('contact_id' => $value['id']);
            $input['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= '<p>' . date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . '</p>';
                }
                $value['last_note'] = $notes;
            } else {
                $value['last_note'] = $notes;
            }
        }
        unset($value);

        $data['contacts'] = $contacts;

        $data['left_col'] = array('date_recall', 'date_rgt', 'date_last_calling');
//        $data['right_col'] = array('');

        $this->table = 'selection name phone last_note level_language level_contact fee date_recall';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact có lịch hẹn gọi lại';
        $data['actionForm'] = 'sale/transfer_contact';
        $informModal = 'sale/modal/transfer_multi_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'sale/modal/transfer_one_contact sale/modal/transfer_one_contact_to_manager';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

	function can_save($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();

		$conditional['where']['sale_staff_id'] = $this->user_id;
		$conditional['where']['is_hide'] = '0';
		$conditional['where']['(call_status_id = '. _KHONG_NGHE_MAY_ .' OR level_contact_id IN ("L1.4", "L2", "L2.1", "L2.2"))'] = 'NO-VALUE';
//            $conditional['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
		$conditional['where_not_in'] = array(
			'call_status_id' => $this->_get_stop_care_call_stt(),
			'level_contact_id' => array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'),
		);
		$conditional['order'] = array('date_last_calling' => 'DESC');

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);

        //$data['contacts']
        $contacts = $data_pagination['data'];
		//echo '<pre>'; print_r(contacts);die;
        $this->load->model('notes_model');
        foreach ($contacts as &$value) {
            $input = array();
            //$input['where'] = array('contact_code' => $value['phone'] . '_' . $value['course_code']);
			$input['where'] = array('contact_id' => $value['id']);
            $input['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= '<p>' . date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . '</p>';
                }
                $value['last_note'] = $notes;
            } else {
                $value['last_note'] = $notes;
            }
        }
        unset($value);

        $data['contacts'] = $contacts;
        $data['total_contact'] = $data_pagination['total_row'];
        $data['left_col'] = array('date_handover', 'date_last_calling','call_status');
        $data['right_col'] = array('care_number');

        $this->table = 'selection name phone last_note call_stt level_contact fee date_last_calling date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact còn cứu được';
        $data['actionForm'] = 'sale/transfer_contact';
        $informModal = 'sale/modal/transfer_multi_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'sale/modal/transfer_one_contact sale/modal/transfer_one_contact_to_manager';
        $data['outformModal'] = explode(' ', $outformModal);
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

//    function find_contact() {
//        $get = $this->input->get();
//        $conditional = ''; //' AND `sale_staff_id` = ' . $this->user_id;
//        $data = $this->_common_find_all($get, $conditional);
//        $table = 'selection contact_id name phone address ';
//        $table .= 'date_rgt date_last_calling call_stt action';
//        $data['table'] = explode(' ', $table);
//        $data['content'] = 'sale/find_contact';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

    public function transfer_contact() {
        $post = $this->input->post();
        $list = isset($post['contact_id']) ? $post['contact_id'] : array();
        $note = $post['note'];
        $this->_action_transfer_contact($post['sale_id'], $list, $note);
    }

    public function transfer_one_contact() {
        $post = $this->input->post();
		//echo '<pre>'; print_r($post);die;
        $this->_action_transfer_contact($post['sale_id'], array($post['contact_id']), $post['note']);
    }
	
	public function transfer_one_contact_to_manager() {
		$post = $this->input->post();
		//echo $this->user_id;die;
		//echo '<pre>'; print_r($post);
		
		if (empty($post['sale_id'])) {
            redirect_and_die('Vui lòng chọn nhân viên TVTS!');
        }
        if (empty($post['contact_id'])) {
            redirect_and_die('Vui lòng chọn contact!');
        }
        $this->_check_contact_can_be_transfer($post['contact_id']);
        $this->load->model('transfer_logs_model');
		/*
        $data = array(
            'sale_staff_id' => $sale_transfer_id,
            'date_transfer' => time(),
            'last_activity' => time()
        ); */
		$where = array('id' => $post['contact_id']);
		$data =  array(
			'is_transfer' => '1',
		);
		$this->contacts_model->update($where, $data);

		if (is_array($post['contact_id']) == true) {
			foreach ($post['contact_id'] as $value) {
				$where1 = array('id' => $value);
				$this->contacts_model->update($where1, $data);
				$this->transfer_logs_model->insert(array(
					'contact_id' => $value,
					'sale_id_1' => $this->user_id,
					'sale_id_2' => $post['sale_id'],
					'time' => time(),
					'is_transfered' => '0'
				));
			}
		} else {
			$this->transfer_logs_model->insert(array(
				'contact_id' => $post['contact_id'],
				'sale_id_1' => $this->user_id,
				'sale_id_2' => $post['sale_id'],
				'time' => time(),
				'is_transfered' => '0'
			));
		}

        if ($post['note'] != '') {
            $this->load->model('notes_model');
			if (is_array($post['contact_id']) == true) {
				foreach ($post['contact_id'] as $value) {
					$param2 = array();
					$param2 = array(
						'contact_id' => $value,
						'content' => $post['note'],
						'time' => time(),
						'sale_id' => $this->user_id,
						'contact_code' => $this->contacts_model->get_contact_code($value)
					);
					$this->notes_model->insert($param2);
				}
			} else {
				$param2 = array();
				$param2 = array(
					'contact_id' => $post['contact_id'],
					'content' => $post['note'],
					'time' => time(),
					'sale_id' => $this->user_id,
					'contact_code' => $this->contacts_model->get_contact_code($post['contact_id'])
				);
				$this->notes_model->insert($param2);
			}
        }
		
        //$this->load->model('Staffs_model');
        //$staff_name = $this->Staffs_model->find_staff_name($sale_transfer_id);
        $msg = 'Chuyển nhượng thành công và đợi quản lý xét duyệt';
        show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], true);
	}

    function view_all_contact($offset = 0) {
        $data = $this->_get_all_require_data();
        $get = $this->input->get();
        $conditional['where'] = array('sale_staff_id' => $this->user_id, 'is_hide' => '0');
        $conditional['order'] = array('date_last_calling' => 'DESC');
		
		$input = array();
		$input['where'] = array(
			'parent_id !=' => '' 
		);
		
		$this->load->model('level_contact_model');
		$this->load->model('level_student_model');
		$data['level_contact_detail'] = $this->level_contact_model->load_all($input);
		$data['level_student_detail'] = $this->level_student_model->load_all($input);
		
		$data['left_col'] = array('care_number', 'language', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
        $data['right_col'] = array('call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');
		
//		if ($this->user_id == 18) {
//			unset($conditional['where']['sale_staff_id']);
//			$data['left_col'] = array('care_number','language', 'sale', 'marketer', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
//			$data['right_col'] = array('branch', 'source', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');
//		}
		
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $this->table .= 'fee paid call_stt level_contact level_student date_rgt date_last_calling';
        $data['table'] = explode(' ', $this->table);

		$data['progressType'] = 'Tiến độ các Team tháng này';
		$data['progress'] = $this->GetProccessThisMonth();

        $data['titleListContact'] = 'Danh sách toàn bộ contact';
        $data['actionForm'] = 'sale/transfer_contact';
        $informModal = 'sale/modal/transfer_multi_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'sale/modal/transfer_one_contact sale/modal/transfer_one_contact_to_manager';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_history_call() {
		$this->load->model('missed_call_model');

		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1
				)
			),
		);

		$data = $this->_get_require_data($require_model);

//		echo '<pre>'; print_r($data); die();

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
		$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24;

		$input = array();
//		$input['where'] = array(
//			'time_created >=' => $date_from,
//			'time_created <' => $date_end,
//		);

		if ($get['filter_sale_id']) {
			$input['where']['sale_id'] = $get['filter_sale_id'][0];
		}

		if ($get['filter_missed_call']) {
			$input['where']['missed_call'] = $get['filter_missed_call'];
		}

		if (isset($get['filter_search_phone_number'])) {
			$input = array();
			$input['like'] = array('source_number' => trim($get['filter_search_phone_number']));
			$input['or_like'] = array('destination_number' => trim($get['filter_search_phone_number']));
		}
//		print_arr($input);

		if (isset($get['filter_number_records'])) {
			$input['limit'] = array($get['filter_number_records'], '0');
		} else {
			$input['limit'] = array('40', '0');
		}
		$input['order']['time_created'] = 'desc';

		$data['history_call'] = $this->missed_call_model->load_all($input);

		$total_fee_call = 0;
		if (isset($data['history_call'])) {
			foreach ($data['history_call'] as &$value) {
				$value['sale_name'] = $this->staffs_model->find_staff_name($value['sale_id']);
				$total_fee_call += $value['fee_call'];
				if ($value['link_conversation'] != '') {
					$value['link_conversation'] = explode('&', $value['link_conversation'])[0] . '&amp';
				}
			}
		}
		unset($value);

		$data['sale'] = $data['staffs'];
		$data['total_fee_call'] = $total_fee_call;
		$data['startDate'] = isset($date_from) ? $date_from : '0';
		$data['endDate'] = isset($date_end) ? $date_end : '0';
		$data['left_col'] = array('date_happen_1', 'sale', 'missed_call');
		$data['right_col'] = array('search_phone_number');
		$data['content'] = 'sale/view_history_call';
		//echo '<pre>';print_r($data);die();

		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function update_missed_call() {
		$this->load->model('missed_call_model');

    	$post = $this->input->post();
//    	print_arr($post);
    	$where = array('source_number' => $post['phone_number']);
		$data = array(
			'date_recall' => time(),
			'sale_recall' => 1,
			'missed_call' => 0,
			'sale_id' => $this->user_id
		);

		$this->missed_call_model->update($where, $data);

		echo '1';
	}

    public function add_contact() {
        $input = $this->input->post();
//		echo '<pre>';print_r($input);die;
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('name', 'Họ tên', 'trim|required|min_length[2]');
//        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|min_length[2]|integer');
        $this->form_validation->set_rules('language_id', 'Ngoại ngữ', 'required');
        $this->form_validation->set_rules('date_rgt', 'Ngày contact về', 'required');
        $this->form_validation->set_rules('branch_id', 'Cơ sở', 'required');
        $this->form_validation->set_rules('is_old', 'Học viên cũ hay mới ?', 'required');
        $this->form_validation->set_rules('source_id', 'Nguồn contact', 'required');

        if (!empty($input)) {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_tempdata('message', 'Có lỗi xảy ra trong quá trình nhập liệu', 2);
                $this->session->set_tempdata('msg_success', 0, 2);
                $require_model = array(
					'branch' => array(),
					'language_study' => array(),
					'call_status' => array(),
					'level_contact' => array(
						'where' => array(
							'parent_id' => ''
						),
					),
					'level_student' => array(
						'where' => array(
							'parent_id' => ''
						),
					),
					'level_language' => array(),
					'class_study' => array(),
					'sources' => array(),
					'payment_method_rgt' => array(),
					'campaign' =>array(
						'where' => array('active' => '1', 'marketer_id' => $this->user_id),
						'order' => array(
							'name' => 'ASC'
						)
					),
					'adset' =>array(
						'where' => array('active' => '1', 'marketer_id' => $this->user_id),
						'order' => array(
							'name' => 'ASC'
						)
					),
					'ad' =>array(
						'where' => array('active' => '1', 'marketer_id' => $this->user_id),
						'order' => array(
							'name' => 'ASC'
						)
					),
					'channel' => array(
						'where' => array('active' => '1'),
						'order' => array('name' => 'ASC')
					),
					'staffs' => array(
						'where' => array(
							'role_id' => 1,
							'active' => 1
						)
					),
				);
                $data = array_merge($this->data, $this->_get_require_data($require_model));
//                print_arr($data);
                $data['content'] = 'sale/add_contact';
                $this->load->view(_MAIN_LAYOUT_, $data);
            } else {
				//echo '<pre>';print_r($input);die;
				if ($input['is_old'] == 0) {
					$param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], trim($input['phone']), $input['level_language_id']);
					if ($param['duplicate_id'] > 0) {
						show_error_and_redirect('Contact bạn vừa thêm bị trùng, nên không thể thêm được nữa!', 0, $input['back_location']);
					}
				}

                $param['name'] = $input['name'];
                $param['email'] = $input['email'];
//                $param['address'] = $input['address'];
				$param['branch_id'] = $input['branch_id'];
				$param['language_id'] = $input['language_id'];
				$param['level_language_id'] = $input['level_language_id'];
                $param['phone'] = trim($input['phone']);
                $param['class_study_id'] = $input['class_study_id'];
                $param['source_id'] = $input['source_id'];
                $param['payment_method_rgt'] = $input['payment_method_rgt'];
//                $param['fee'] = $input['fee'];
//                $param['paid'] = $input['paid'];
                $param['channel_id'] = $input['channel_id'];
                $param['date_rgt'] = strtotime($input['date_rgt']);
                $param['level_contact_id'] = $input['level_contact_id'];
                $param['level_student_id'] = $input['level_student_id'];
                $param['call_status_id'] = $input['call_status_id'];
                $param['is_old'] = $input['is_old'];

//                print_arr($param);
				
				switch($this->role_id){
					case 1:
						$param['sale_staff_id'] = $this->user_id;
						break;
					case 6:
						$param['marketer_id'] = $this->user_id;
						break;
				}
				
				if ($this->role_id == 12) {
					if ($param['branch_id'] == 0) {
						show_error_and_redirect('Contact bạn vừa thêm chưa cập nhật cơ sở', 0, $input['back_location']);
					}
				}
				
				if (isset($input['level_contact_id']) && $input['level_contact_id'] != '') {
					if(!isset($input['call_status_id']) || $input['call_status_id'] != 4) {
						show_error_and_redirect('Contact bạn vừa thêm ko đúng logic trạng thái contact và trạng thái gọi', 0, $input['back_location']);
					}
					
					if(!isset($input['level_language_id']) || $input['level_language_id'] == 0) {
						show_error_and_redirect('Contact đã đăng ký thành công thì phải có trình độ ngoại ng', 0, $input['back_location']);
					}
				
					if ($input['level_contact_id'] == 'L5') {
						if (isset($input['date_rgt_study']) && $input['date_rgt_study'] != '') {
							$param['date_rgt_study'] = strtotime($input['date_rgt_study']);
							
							$student = $this->create_new_account_student($input['name'], $input['phone'], $input['level_language_id']);
							if ($student->success != 0) {
								$param['sent_account_online'] = 1;
								$param['date_active'] = time();
							}
						} else {
							show_error_and_redirect('Contact đăng ký thành công thì phải có ngày đăng ký', 0, $input['back_location']);
						}
//						if (!isset($input['language_id']) || $input['language_id'] == '') {
//							show_error_and_redirect('Contact đăng ký thành công thì phải có ngôn ngữ đăng ký', 0, $input['back_location'
//						}
					}
					
					if ($param['level_contact_id'] == 'L3') {
						$param['date_confirm'] = time();
					}
					
					$param['date_last_calling'] = time();

				}
				
				if (isset($input['level_student_id']) && $input['level_student_id'] != '') {
					if(!isset($input['call_status_id']) || $input['call_status_id'] != 4) {
						show_error_and_redirect('Contact bạn vừa thêm ko đúng logic trạng thái học viên và trạng thái gọi', 0, $input['back_location']);
					}
				
					if (!isset($input['level_contact_id']) || $input['level_contact_id'] != 'L5') {
						show_error_and_redirect('Contact bạn vừa thêm ko đúng logic trạng thái học viên và trạng thái contact', 0, $input['back_location']);
					}
					
					if ($input['level_student_id'] == 'L8') {
						if (!isset($input['is_old']) || $input['is_old'] == 0) {
							show_error_and_redirect('Contact có phải là học viên cũ ko?', 0, $input['back_location']);
						}
					}
				}
				
				if (isset($input['fee']) && $input['fee'] != '') {
					$param['fee'] = str_replace(',', '', $input['fee']);
					if (strlen($param['fee']) < 6 || (strlen($param['fee']) > 7)) {
						show_error_and_redirect('Contact bạn vừa thêm có số tiền học phí không đúng chuẩn', 0, $input['back_location']);
					}
				}
				
				if (isset($input['paid']) && $input['paid'] != '') {
					$param['paid'] = str_replace(',', '', $input['paid']);
					if(!isset($input['call_status_id']) || $input['call_status_id'] != 4) {
						show_error_and_redirect('Contact bạn vừa thêm ko đúng logic tiền đóng và trạng thái gọi', 0, $input['back_location']);
					}
				
					if (!isset($input['level_contact_id']) || $input['level_contact_id'] != 'L5') {
						show_error_and_redirect('Contact bạn vừa thêm ko đúng logic tiền đóng và trạng thái contact', 0, $input['back_location']);
					}
					
					if (strlen($param['paid']) < 6 || strlen($param['paid']) > 7 || ((int)$param['paid'] > (int)$param['fee'])) {
						show_error_and_redirect('Contact bạn vừa thêm có số tiền đã đóng không đúng chuẩn', 0, $input['back_location']);
					} else if ($param['paid'] == $param['fee']) {
						$param['complete_fee'] = 1;
					}

					if (isset($input['date_paid']) && $input['date_paid'] != '') {
						$param['date_paid'] = strtotime($input['date_paid']);
					} else {
						show_error_and_redirect('Contact đóng tiền thì phải có ngày đóng tiền', 0, $input['back_location']);
					}
				}

				if ($this->role_id == 10) {
					$param['care_page_staff_id'] = $this->user_id;
					if (isset($input['sale_staff_id']) && $input['sale_staff_id'] != 0) {
						$param['sale_staff_id'] = $input['sale_staff_id'];
					}
				}

				//$param['date_rgt'] = time();
                $param['date_handover'] = time();
                
//                print_arr($param);
                $param['last_activity'] = time();
//                $param['source_sale_id'] = $input['source_sale_id'];
                
				if(isset($input['campaign_id']) && !empty($input['campaign_id'])){
					$param['campaign_id'] = $input['campaign_id'];
				}
				if(isset($input['adset_id']) && !empty($input['adset_id'])){
					$param['adset_id'] = $input['adset_id'];
				}
				if(isset($input['ad_id']) && !empty($input['ad_id'])){
					$param['ad_id'] = $input['ad_id'];
				}
//				print_arr($param);
				
                $id = $this->contacts_model->insert_return_id($param, 'id');
//				$id_backup = $this->contacts_backup_model->insert_return_id($param, 'id');
				
                if ($input['note'] != '') {
					$param2 = array(
						'contact_id' => $id,
						'content' => $input['note'],
						'time_created' => time(),
						'sale_id' => $this->user_id,
						'contact_code' => $this->contacts_model->get_contact_code($id),
						'class_study_id' => 0
					);
					//print_arr($param2);
					$this->load->model('notes_model');
					$this->notes_model->insert($param2);
				}
				
				if (isset($input['paid']) && $input['paid'] != '') {
					$param3 = array(
						'contact_id' => $id,
						'paid' => $param['paid'],
						'time_created' => $param['date_paid'],
						'language_id' => $input['language_id'],
						'branch_id' => $input['branch_id'],
						'day' => date('Y-m-d', $param['date_paid']),
						'student_old' => $input['is_old'],
						'source_id' => $input['source_id'],
					);
					//print_arr($param2);
					$this->load->model('paid_model');
					$this->paid_model->insert($param3);
				}
				
				if (isset($input['level_contact_id']) && $input['level_contact_id'] != '') {
					$this->_set_call_log($id, $input);
				}
				
                $data2 = [];
                $data2['title'] = 'Có 1 contact mới đăng ký';
                $data2['message'] = 'Click để xem ngay';

                require_once APPPATH . 'libraries/Pusher.php';

                $options = array(
                    'cluster' => 'ap1',
                    'encrypted' => true,
                    'useTLS' => true
                );

//                $pusher = new Pusher(
//                        '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
//                );

                $pusher = new Pusher(
                    'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
                );

                $pusher->trigger('my-channel', 'notice', $data2);
                show_error_and_redirect('Thêm thành công contact', $input['back_location']);
            }
        } else {
            $require_model = array(
            	'branch' => array(),
                'language_study' => array(),
				'call_status' => array(),
                'level_contact' => array(
					'where' => array(
						'parent_id' => ''
					),
				),
				'level_student' => array(
					'where' => array(
						'parent_id' => ''
					),
				),
                'level_language' => array(),
                'class_study' => array(),
                'sources' => array(),
				'payment_method_rgt' => array(),
				'campaign' =>array(
					'where' => array('active' => '1', 'marketer_id' => $this->user_id),
					'order' => array(
						'name' => 'ASC'
					)
				),
				'adset' =>array(
					'where' => array('active' => '1', 'marketer_id' => $this->user_id),
					'order' => array(
						'name' => 'ASC'
					)
				),
				'ad' =>array(
					'where' => array('active' => '1', 'marketer_id' => $this->user_id),
					'order' => array(
						'name' => 'ASC'
					)
				),
				'channel' => array(
					'where' => array('active' => '1'),
					'order' => array('name' => 'ASC')
				),
				'staffs' => array(
					'where' => array(
						'role_id' => 1,
						'active' => 1
					)
				),
            );
            $data = array_merge($this->data, $this->_get_require_data($require_model));
			
			if ($this->role_id == 12 || $this->role_id == 6) {
				$data['top_nav'] = 'manager/common/top-nav';
			}
//            print_arr($data);
            $data['content'] = 'sale/add_contact';

            $this->load->view(_MAIN_LAYOUT_, $data);
        }
    }
	
	public function create_new_account_student($name = '', $phone = '', $level_language_id = '') {
        if ($phone != '' && $level_language_id != '') {
			$this->load->model('level_language_model');
			$contact_s = $this->level_language_model->find_course_combo($level_language_id);
//			echo $contact_s;die();
			// $courseCode = explode(",", $contact_s);
			$contact = array(
				'course_code' => $contact_s,
				'name' => $name,
				'phone' => $phone,
				'type' => 'offline'
			);

			$student = $this->_create_account_student_offline($contact);
//			return json_encode($student); die();
			return $student;
        }
    }
	
	 //api tạo tài khoản cho học viên
    private function _create_account_student_offline($contact) {
        require_once APPPATH . "libraries/Rest_Client.php";
		$config = array(
			'server' => 'http://sofl.edu.vn',
			'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
			'api_name' => 'sofl-key'
		);
        $restClient = new Rest_Client($config);
        $uri = "account_api/create_new_account";
        $student = $restClient->post($uri, $contact);
        return $student;
    }
    //end
	
	private function _set_call_log($id, $post, $rows) {
        $data = array();
        $data['contact_id'] = $id;
        $data['staff_id'] = $this->user_id;
		
		if (isset($post['level_contact_detail']) && $post['level_contact_detail'] != '') {
			$post['level_contact_id'] = $post['level_contact_detail'];
		}

		if (isset($post['level_student_detail']) && $post['level_student_detail'] != '') {
			$post['level_student_id'] = $post['level_student_detail'];
		}

        $statusArr = array('call_status_id', 'level_contact_id', 'level_student_id');
        foreach ($statusArr as $value) {
            if (isset($post[$value])) {
                $data[$value] = $post[$value];
            } else {
                $data[$value] = "-1";
            }
        }
		
        $data['time_created'] = time();

        $data['content_change'] = 'Thêm contact mới';
        $this->load->model('call_log_model');
        $this->call_log_model->insert($data);
    }

//    function check_source_id($str) {
//        if ($str == 0) {
//            $this->form_validation->set_message('check_source_id', 'Vui lòng chọn {field}!');
//            return false;
//        }
//        return true;
//    }

//    function view_report() {
//        $require_model = array(
//            'courses' => array()
//        );
//        $data = array_merge($this->data, $this->_get_require_data($require_model));
//        $get = $this->input->get();
//
//        $conditional = array();
//        $conditional['where']['sale_staff_id'] = $this->user_id;
//        $data['L1'] = $this->_query_for_report($get, $conditional);
//
//        $conditional = array();
//        $conditional['where']['sale_staff_id'] = $this->user_id;
//        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//        $data['L2'] = $this->_query_for_report($get, $conditional);
//
//        $conditional = array();
//        $conditional['where']['sale_staff_id'] = $this->user_id;
//        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//        $conditional['where']['ordering_status_id'] = _DONG_Y_MUA_;
//        $data['L6'] = $this->_query_for_report($get, $conditional);
//
//        $conditional = array();
//        $conditional['where']['sale_staff_id'] = $this->user_id;
//        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
//        $conditional['where']['ordering_status_id'] = _DONG_Y_MUA_;
////        $conditional['where']['(`cod_status_id` = ' . _DA_THU_COD_ . ' OR `cod_status_id` = ' . _DA_THU_LAKITA_ . ')'] = 'NO-VALUE';
//        $data['L7L8'] = $this->_query_for_report($get, $conditional);
//
//        $data['left_col'] = array('course_code','tic_report');
//        $data['right_col'] = array('date_handover');
//
//         /*
//          * Các file js cần load
//          */
//        $data['load_js'] = array('common_real_filter_contact', 'm_view_report');
//        $data['content'] = 'sale/view_report';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }

//    function show_script_modal() {
//        $post = $this->input->post();
//        $script_id = $post['script_id'];
//        $input = array();
//        $input['where'] = array('id' => $script_id);
//        $this->load->model('scripts_model');
//        $content = $this->scripts_model->load_all($input);
//        echo html_entity_decode($content[0]['content']);
//        //$this->load->view('sale/show_script');
//    }

    function noti_contact_recall() {
        $input['select'] = 'id, name, phone, date_recall, sale_staff_id';
        if ($this->role_id == 1) {
            $input['where']['sale_staff_id'] = $this->user_id;
        }
//	  	if ($this->role_id == 2) {
//			$input['where']['cod_status_id >'] = '0';
//        }
        $input['where']['date_recall >'] = '0';
        $input['where']['date_recall <='] = time();
        $input['order']['date_recall'] = 'DESC';
        $noti_contact = $this->contacts_model->load_all($input);
        if (!empty($noti_contact)) {
            $result = array();
            if (time() - $noti_contact[0]['date_recall'] < 30) {
                $result['sound'] = 1;
                if ($noti_contact[0]['cod_status_id'] == 0) {
                    $result['image'] = base_url('public/images/recall.jpg');
                    $result['message'] = 'Có contact (sale) cần gọi lại ngay bây giờ!';
                } else {
                    $result['image'] = base_url('public/images/ship.png');
                    $result['message'] = 'Có contact (cod) cần gọi lại ngay bây giờ!';
                }
            }
            foreach ($noti_contact as &$value) {
                $value['date_recall'] = date('H:i j/n/Y', $value['date_recall']);
            }
            
            unset($value);
            $num_noti_contact = count($noti_contact);

            $result['num_noti'] = $num_noti_contact;
            $result['contacts_noti'] = $noti_contact;
            $this->renderJSON($result);
        }
    }

    private function _action_transfer_contact($sale_transfer_id, $contact_id, $note) {
        if ($sale_transfer_id == 0) {
            redirect_and_die('Vui lòng chọn nhân viên TVTS!');
        }
        if (empty($contact_id)) {
            redirect_and_die('Vui lòng chọn contact!');
        }
        $this->_check_contact_can_be_transfer($contact_id);
        $this->load->model('transfer_logs_model');
        $data = array(
            'sale_staff_id' => $sale_transfer_id,
            'date_transfer' => time(),
            'last_activity' => time()
        );

        foreach ($contact_id as $value) {
            $where = array('id' => $value);
            $this->contacts_model->update($where, $data);
            $this->transfer_logs_model->insert(array(
                'contact_id' => $value,
                'sale_id_1' => $this->user_id,
                'sale_id_2' => $sale_transfer_id,
                'time' => time()
            ));
        }

        if ($note != '') {
            $this->load->model('notes_model');
            foreach ($contact_id as $value) {
                $param2 = array();
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
        $this->load->model('Staffs_model');
        $staff_name = $this->Staffs_model->find_staff_name($sale_transfer_id);
        $msg = 'Chuyển nhượng thành công cho nhân viên <strong>' . $staff_name . '</strong>';
        show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], true);
    }

    private function _check_contact_can_be_transfer($list) {
        $transfered_contact = true;
        $name = '';
        foreach ($list as $value) {
            $input = array();
            $input['select'] = 'name, sale_staff_id, call_status_id';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
			if (empty($rows)) {
				die('Không tồn tại khách hàng này! Mã lỗi : 30203');
			}

            if ($rows[0]['sale_staff_id'] != $this->user_id && $this->role_id != 12) {
                $msg = 'Contact này không được phân cho bạn vì vậy bạn không thể chuyển nhượng contact này!';
                show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
            }
//            if (in_array($rows[0]['call_status_id'], $this->_get_stop_care_call_stt())) {
//                $name = $rows[0]['name'];
//                $transfered_contact = false;
//                break;
//            }
        }

        if (!$transfered_contact) {
            $msg = 'Contact ' . $name . ' ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chuyển nhượng contact này!';
            show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
        }

//        foreach ($list as $value) {
//            $input = array();
//            $input['where'] = array('id' => $value);
//            $rows = $this->contacts_model->load_all($input);
//            if (empty($rows)) {
//                die('Không tồn tại khách hàng này! Mã lỗi : 30203');
//            }
//        }
    }

    private function _get_stop_care_call_stt() {
        $arr = array();
        $this->load->model("call_status_model");
        $stop_care_call_stt_where = array();
        $stop_care_call_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->call_status_model->load_all($stop_care_call_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                $arr[] = $value['id'];
            }
        }
        return $arr;
    }

    private function _get_all_require_data() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1,
                    'active' => 1,
					'transfer_contact' => 1
                )
            ),
            'class_study' => array(
                'where' => array('active' => '1'),
                'order' => array(
                    'class_study_id' => 'ASC'
                )
            ),
			'level_contact' => array(
				'where' => array('parent_id' => '')
			),
			'level_student' => array(
				'where' => array('parent_id' => '')
			),
            'branch' => array('active' => 1),
            'level_language' => array(),
            'language_study' => array(),
            'call_status' => array('order' => array('sort' => 'ASC')),
            'payment_method_rgt' => array(),
			'link' => array(),
			'channel' => array(),
			'campaign' => array(),
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }

    private function _loadCountListContact() {
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => $this->user_id, 'is_hide' => '0');
        $this->L['L1'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where'] = array(
            'date_recall >' => '0',
            'sale_staff_id' => $this->user_id,
            'is_hide' => '0'
		);
        $input['where_not_in'] = array(
            'call_status_id' => $this->_get_stop_care_call_stt(),
//            'ordering_status_id' => $this->_get_stop_care_order_stt()
			'level_contact_id' => array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'),
		);
        $this->L['has_callback'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where']['sale_staff_id'] = $this->user_id;
        $input['where']['is_hide'] = '0';
        $input['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
        $this->L['can_save'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('sale_staff_id' => $this->user_id, 'is_hide' => '0');
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }
	
	 protected function GetProccessToday() {
    	 //L6,L8 tính theo ngày
//		 $total = $this->GetProccessThisMonth();
		 $total_sale_day_L5 = 50;
		 $total_to_day_L8 = 0;

//		 $progress = [];
		 $progress['progressbar'] = array();
		 $inputContact = array();
		 $inputContact['select'] = 'id';
		 $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_hide' => '0', 'is_old' => '0');
		 $today = $this->contacts_model->load_all($inputContact);
		 $progress['progressbar']['sale'] = array(
			 'count' => count($today),
			 'kpi' => $total_sale_day_L5,
			 'name' => 'Học viên mới',
			 'type' => 'L5',
			 'progress' => round(count($today) / $total_sale_day_L5 * 100, 2)
		 );
//		 $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

		 $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('d-m-Y')), 'is_hide' => '0', 'is_old' => '1');
		 $today = $this->contacts_model->load_all($inputContact);
		 $progress['progressbar']['branch'] = array(
			 'count' => count($today),
			 'kpi' => $total_to_day_L8,
			 'name' => 'Học viên cũ',
			 'type' => 'L8',
			 'progress' => round(count($today) / $total_to_day_L8 * 100, 2)
		 );
//		 $progress['branch']['progress'] = round($progress['branch']['count'] / $progress['branch']['kpi'] * 100, 2);

		 $this->load->model('call_log_model');
		 $input = array();
		 $input['select'] = 'distinct(contact_id)';
		 $input['where'] = array('staff_id' => $this->user_id);
		 $input['group_by'] = array('contact_id');

		 $input_called_1 = array_merge($input, array('having' => array('count(contact_id)' => 1)));
		 $input_called_2 = array_merge($input, array('having' => array('count(contact_id)' => 2)));
		 $input_called_3 = array_merge($input, array('having' => array('count(contact_id)' => 3)));

		 $called_1 = $this->call_log_model->load_all($input_called_1);
		 $called_2 = $this->call_log_model->load_all($input_called_2);
		 $called_3 = $this->call_log_model->load_all($input_called_3);

//		 $array = array();
		 foreach ($called_1 as $value) {
			 $array_called_1[] = $value['contact_id'];
		 }

		 foreach ($called_2 as $value) {
			 $array_called_2[] = $value['contact_id'];
		 }

		 foreach ($called_3 as $value) {
			 $array_called_3[] = $value['contact_id'];
		 }

		 $condition = array(
		 	 'L1' => array(
				 'where' => array('date_handover >=' => strtotime(date('d-m-Y')), 'is_hide' => '0')
			 ),
		 	 'L1_XULY' => array(
				 'where' => array('call_status_id !=' => 0, 'date_handover >=' => strtotime(date('d-m-Y')), 'is_hide' => '0')
			 ),
		 	 'KNM_LAN_1' => array(
		 		 'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling < ' => strtotime(date('d-m-Y'))),
				 'where_in' => array('id' => $array_called_1)
			 ),
			 'KNM_LAN_2' => array(
				 'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling < ' => strtotime(date('d-m-Y'))),
				 'where_in' => array('id' => $array_called_2)
			 ),
			 'KNM_LAN_3' => array(
				 'where' => array('call_status_id' => _KHONG_NGHE_MAY_, 'date_last_calling < ' => strtotime(date('d-m-Y'))),
				 'where_in' => array('id' => $array_called_3)
			 ),
			 'L3' => array(
			 	'where' => array('level_contact_id' => 'L3', 'date_last_calling < ' => strtotime(date('d-m-Y'))),
			 ),
			 'L2' => array(
			 	'where' => array('level_contact_id' => 'L2', 'date_last_calling < ' => strtotime(date('d-m-Y'))),
			 )
		 );

		 $get = array();
		 foreach ($condition as $key => $item) {
			 $conditional = array_merge_recursive($item, array('where' => array('sale_staff_id' => $this->user_id)));
			 $result[$key] = $this->_query_for_report($get, $conditional);
		 }

//		 print_arr($result);

		 $progress['progress_sale'] = $result;

		 return $progress;
    }
	
	//làm KPI động thì làm ở chỗ nãy
    protected function GetProccessThisMonth() {
		// tính L6,L8 theo thang
        $this->load->model('staffs_model');
        $qr = $this->staffs_model->SumTarget();
        $total_month_L6 = round($qr[0]['targets']*30*0.3);
        $total_month_L8 = round($total_month_L6*0.85);

        $progress = [];
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >=' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $qr[0]['targets'] * 30,
            'name' => 'Marketing',
            'type' => 'C3'
		);
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt_study >=' => strtotime(date('01-m-Y')), 'is_hide' => '0', 'is_old' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_month_L6,
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

        return $progress;
	}

	public function sale_call_process() {
        $input = array();
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => $this->user_id, 'is_hide' => '0');
        $input['order'] = array('date_handover' => 'DESC');
        $data['have_call']['new_contact'] = $this->contacts_model->m_count_all_result_from_get($input);

        $input = array();
        $input['where'] = array(
            'date_recall >' => '0',
            'date_recall <' => strtotime('tomorrow'),
            'sale_staff_id' => $this->user_id,
            'is_hide' => '0'
        );
        $input['where_not_in'] = array(
            'call_status_id' => $this->_get_stop_care_call_stt(),
//            'ordering_status_id' => $this->_get_stop_care_order_stt()
			'level_contact_id' => array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'),
        );
        $data['have_call']['recall_contact'] = $this->contacts_model->m_count_all_result_from_get($input);
        $data['have_call']['total_have_call_contact'] = $data['have_call']['new_contact'] + $data['have_call']['recall_contact'];

        //contact còn cứu được
        $this->load->model('call_log_model');
        $input = array();
        $input['select'] = 'distinct(contact_id)';
        $input['where'] = array('staff_id' => $this->user_id);
        $input['group_by'] = array('contact_id');
        $input['having'] = array('count(contact_id) <=' => 3);
        $called_less_3 = $this->call_log_model->load_all($input);

        $array = array();
        foreach ($called_less_3 as $value) {
            $array[] = $value['contact_id'];
        }
        $input = array();
        $input['select'] = 'id';
        $input['where']['sale_staff_id'] = $this->user_id;
        $input['where']['is_hide'] = '0';
        $input['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
        if(!empty($array)){
            $input['where_in']['id'] = $array;
        }
        $data['can_save']['call_less_3'] = $this->contacts_model->m_count_all_result_from_get($input);

        $input = array();
        $input['select'] = 'distinct(contact_id)';
        $input['where'] = array('staff_id' => $this->user_id);
        $input['group_by'] = array('contact_id');
        $input['having'] = array('count(contact_id) >' => 3);
        $called_more_3 = $this->call_log_model->load_all($input);

        $array = array();
        foreach ($called_more_3 as $value) {
            $array[] = $value['contact_id'];
        }
        //ontact còn cứu được
        $input = array();
        $input['select'] = 'id';
        $input['where']['sale_staff_id'] = $this->user_id;
        $input['where']['is_hide'] = '0';
        $input['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
        if(!empty($array)){
            $input['where_in']['id'] = $array;
        }
        $data['can_save']['call_more_3'] = $this->contacts_model->m_count_all_result_from_get($input);

        return $data;
        print_r($data);
        //   echo $this->db->last_query();
    }

    public function sale_have_to_call() {

        $data = $this->_get_all_require_data();

        $post = $this->input->post();

		$this->load->model('call_log_model');
		$input_call = array();
		$input_call['select'] = 'distinct(contact_id)';
		$input_call['where'] = array('staff_id' => $this->user_id);
		$input_call['group_by'] = array('contact_id');

        switch ($post['type']) {
            case 'L1':
                $input = array();
                $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => $this->user_id, 'is_hide' => '0');
//                $input['order'] = array('date_handover' => 'DESC');
                break;

            case 'KNM_LAN_1':
                $input = array();
				$input_called_1 = array_merge($input_call, array('having' => array('count(contact_id)' => 1)));
				$called_1 = $this->call_log_model->load_all($input_called_1);
				foreach ($called_1 as $value) {
					$array_called_1[] = $value['contact_id'];
				}

                $input['where'] = array(
                    'call_status_id' => _KHONG_NGHE_MAY_,
                    'date_last_calling <' => strtotime(date('d-m-Y')),
                    'sale_staff_id' => $this->user_id,
                    'is_hide' => '0'
                );
                $input['where_in']['id'] = $array_called_1;
                break;

            case 'KNM_LAN_2':
				$input = array();
				$input_called_2 = array_merge($input_call, array('having' => array('count(contact_id)' => 2)));
				$called_2 = $this->call_log_model->load_all($input_called_2);
				foreach ($called_2 as $value) {
					$array_called_2[] = $value['contact_id'];
				}

				$input['where'] = array(
					'call_status_id' => _KHONG_NGHE_MAY_,
					'date_last_calling <' => strtotime(date('d-m-Y')),
					'sale_staff_id' => $this->user_id,
					'is_hide' => '0'
				);
				$input['where_in']['id'] = $array_called_2;
                break;

            case 'KNM_LAN_3':
				$input = array();
				$input_called_3 = array_merge($input_call, array('having' => array('count(contact_id)' => 3)));
				$called_3 = $this->call_log_model->load_all($input_called_3);
				foreach ($called_3 as $value) {
					$array_called_3[] = $value['contact_id'];
				}

				$input['where'] = array(
					'call_status_id' => _KHONG_NGHE_MAY_,
					'date_last_calling <' => strtotime(date('d-m-Y')),
					'sale_staff_id' => $this->user_id,
					'is_hide' => '0'
				);
				$input['where_in']['id'] = $array_called_3;
                break;

			case 'L3':
				$input = array();
				$input['where'] = array(
					'level_contact_id' => 'L3',
					'date_last_calling <' => strtotime(date('d-m-Y')),
					'sale_staff_id' => $this->user_id,
				);
				break;

			case 'L2':
				$input = array();
				$input['where'] = array(
					'level_contact_id' => 'L2',
					'date_last_calling <' => strtotime(date('d-m-Y')),
					'sale_staff_id' => $this->user_id,
				);
				break;
            default :
        }

        $data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $this->table .= 'date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);
        echo $this->load->view('common/content/tbl_contact', $data);
    }

//    public function get_phone_missed_call() {
//		$this->load->helper('cookie');
//		$expire = (int) strtotime('tomorrow');
//		setcookie("sale_first_login_day", time(), $expire);
//
//		$post = $this->input->post();
////		print_arr($post);
//		$data = $this->data;
//		$data['content'] = 'sale/get_phone_missed_call';
//
//		$this->load->view(_MAIN_LAYOUT_, $data);
//	}

    public function get_contact_from_phone() {
		$data = $this->_get_all_require_data();

		$post = $this->input->post();

		$input = array();
		$input['where'] = array('phone' => $post['phone_number']);

		$data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$this->table .= 'date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);
		echo $this->load->view('common/content/tbl_contact', $data);
	}
}
