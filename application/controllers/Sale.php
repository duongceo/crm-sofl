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
        $data['right_col'] = array('class_study');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */

        $this->table .= 'date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;
        /*
         * Các file js cần load
         */

//        $data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//            's_check_edit_contact', 's_transfer_contact', 's_show_script', 'm_view_duplicate'
//        );

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

        /*
         * Các file js cần load
         */

//        $data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//            's_check_edit_contact', 's_transfer_contact', 's_show_script'
//        );

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
//				'ordering_status_id' => $this->_get_stop_care_order_stt()
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
        $data['left_col'] = array('tv_dk', 'date_handover', 'date_last_calling','call_status');
//        $data['right_col'] = array();

        $this->table = 'selection name phone last_note call_stt level_contact class_study_id fee date_last_calling date_rgt date_handover';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

//        $data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//            's_check_edit_contact', 's_transfer_contact', 's_show_script'
//        );

        $data['titleListContact'] = 'Danh sách contact còn cứu được';
        $data['actionForm'] = 'sale/transfer_contact';
        $informModal = 'sale/modal/transfer_multi_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'sale/modal/transfer_one_contact sale/modal/transfer_one_contact_to_manager';
        $data['outformModal'] = explode(' ', $outformModal);
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function find_contact() {
        $get = $this->input->get();
        $conditional = ''; //' AND `sale_staff_id` = ' . $this->user_id;
        $data = $this->_common_find_all($get, $conditional);
        $table = 'selection contact_id name phone address ';
        $table .= 'date_rgt date_last_calling call_stt action';
        $data['table'] = explode(' ', $table);
        $data['content'] = 'sale/find_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

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
		
		$data['left_col'] = array('language', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
        $data['right_col'] = array('call_status', 'level_contact', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');
		
		if ($this->user_id == 18) {
			unset($conditional['where']['sale_staff_id']);
			$data['left_col'] = array('language', 'sale', 'marketer', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
			$data['right_col'] = array('branch', 'source', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');
		}
		
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $this->table .= 'fee paid call_stt level_contact level_student date_rgt date_last_calling';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */

//        $data['load_js'] = array(
//            'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//            's_check_edit_contact', 's_transfer_contact', 's_show_script', 'm_view_duplicate'
//        );

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

    public function add_contact() {
        $input = $this->input->post();
//		echo '<pre>';print_r($input);die;
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('name', 'Họ tên', 'trim|required|min_length[2]');
//        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|min_length[2]|integer');
//        $this->form_validation->set_rules('language_id', 'Ngoại ngữ', 'required');
//        $this->form_validation->set_rules('date_rgt', 'Ngày contact về', 'required');
//        $this->form_validation->set_rules('branch_id', 'Cơ sở', 'required');
//        $this->form_validation->set_rules('is_old', 'Học viên cũ hay mới ?', 'required');
//        $this->form_validation->set_rules('source_id', 'Nguồn contact', 'required|callback_check_source_id');
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
					)
				);
                $data = array_merge($this->data, $this->_get_require_data($require_model));
                //print_arr($data);
                $data['content'] = 'sale/add_contact';
                $this->load->view(_MAIN_LAYOUT_, $data);
            } else {
				//echo '<pre>';print_r($input);die;
				$param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], $input['phone'], $input['level_language_id']);
				
				if ($param['duplicate_id'] > 0) {
                    show_error_and_redirect('Contact bạn vừa thêm bị trùng, nên không thể thêm được nữa!', 0, $input['back_location']);
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
				
					if ($param['level_contact_id'] == 'L5') {
						if (isset($input['date_rgt_study']) && $input['date_rgt_study'] != '') {
							$param['date_rgt_study'] = $input['date_rgt_study'];
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
					} else {
						$param['date_paid'] = time();
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
						'time_created' => time(),
						'language_id' => $input['language_id'],
						'branch_id' => $input['branch_id'],
						'day' => date('Y-m-d', time()),
						'student_old' => $input['is_old'],
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
				)
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
	
	private function _set_call_log($id, $post, $rows) {
        $data = array();
        $data['contact_id'] = $id;
        $data['staff_id'] = $this->user_id;
		
		if (isset($post['level_contact_detail']) && !empty($post['level_contact_detail']) && $post['level_contact_detail'] != '') {
			$post['level_contact_id'] = $post['level_contact_detail'];
		}

		if (isset($post['level_student_detail']) && !empty($post['level_student_detail']) && $post['level_student_detail'] != '') {
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

    function check_course_code($str) {
        if ($str == 'empty') {
            $this->form_validation->set_message('check_course_code', 'Vui lòng chọn {field}!');
            return false;
        }
        return true;
    }

    function check_source_id($str) {
        if ($str == 0) {
            $this->form_validation->set_message('check_source_id', 'Vui lòng chọn {field}!');
            return false;
        }
        return true;
    }

    function view_report() {
        $require_model = array(
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $get = $this->input->get();

        $conditional = array();
        $conditional['where']['sale_staff_id'] = $this->user_id;
        $data['L1'] = $this->_query_for_report($get, $conditional);

        $conditional = array();
        $conditional['where']['sale_staff_id'] = $this->user_id;
        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
        $data['L2'] = $this->_query_for_report($get, $conditional);

        $conditional = array();
        $conditional['where']['sale_staff_id'] = $this->user_id;
        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
        $conditional['where']['ordering_status_id'] = _DONG_Y_MUA_;
        $data['L6'] = $this->_query_for_report($get, $conditional);

        $conditional = array();
        $conditional['where']['sale_staff_id'] = $this->user_id;
        $conditional['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;
        $conditional['where']['ordering_status_id'] = _DONG_Y_MUA_;
//        $conditional['where']['(`cod_status_id` = ' . _DA_THU_COD_ . ' OR `cod_status_id` = ' . _DA_THU_LAKITA_ . ')'] = 'NO-VALUE';
        $data['L7L8'] = $this->_query_for_report($get, $conditional);

        $data['left_col'] = array('course_code','tic_report');
        $data['right_col'] = array('date_handover');

         /*
          * Các file js cần load
          */
        $data['load_js'] = array('common_real_filter_contact', 'm_view_report');
        $data['content'] = 'sale/view_report';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function show_script_modal() {
        $post = $this->input->post();
        $script_id = $post['script_id'];
        $input = array();
        $input['where'] = array('id' => $script_id);
        $this->load->model('scripts_model');
        $content = $this->scripts_model->load_all($input);
        echo html_entity_decode($content[0]['content']);
        //$this->load->view('sale/show_script');
    }

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
            $input['select'] = 'name, sale_staff_id, call_status_id, ordering_status_id';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
            if ($rows[0]['sale_staff_id'] != $this->user_id) {
                $msg = 'Contact này không được phân cho bạn vì vậy bạn không thể chuyển nhượng contact này!';
                show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
            }
            if (in_array($rows[0]['call_status_id'], $this->_get_stop_care_call_stt()) || in_array($rows[0]['ordering_status_id'], $this->_get_stop_care_order_stt())) {
                $name = $rows[0]['name'];
                $transfered_contact = false;
                break;
            }
        }
        if (!$transfered_contact) {
            $msg = 'Contact ' . $name . ' ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chuyển nhượng contact này!';
            show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
        }

//        foreach ($list as $value) {
//            $input = array();
//            $input['where'] = array('id' => $value);
//            $rows = $this->contacts_model->load_all($input);
//            if ($rows[0]['duplicate_id'] > 0) {
//                $msg = 'Contact "' . $rows[0]['name'] . '" có id = ' . $rows[0]['id'] . ' bị trùng. '
//                        . 'Vì vậy không thể chuyển nhượng contact đó được! Vui lòng thực hiện lại';
//                show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
//            }
//        }
        foreach ($list as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
            if (empty($rows)) {
                die('Không tồn tại khách hàng này! Mã lỗi : 30203');
            }
        }
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

    private function _get_stop_care_order_stt() {
        $arr = array();
        $this->load->model("ordering_status_model");
        $stop_care_order_stt_where = array();
        $stop_care_order_stt_where['where'] = array('stop_care' => 1);
        $stop_care_order_stt_id = $this->ordering_status_model->load_all($stop_care_order_stt_where);
        if (!empty($stop_care_order_stt_id)) {
            foreach ($stop_care_order_stt_id as $value) {
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
                    'active' => 1
                )
            ),
            'class_study' => array(
                'where' => array('active' => '1'),
                'order' => array(
                    'class_study_id' => 'ASC'
                )
            ),
			'level_contact' => array(),
			'level_student' => array(),
            'branch' => array('active' => 1),
            'level_language' => array(),
            'language_study' => array(),
            'call_status' => array('order' => array('sort' => 'ASC')),
            'ordering_status' => array('order' => array('sort' => 'ASC')),
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
        $total = $this->GetProccessThisMonth();
        $total_marketing_day = round($total['marketing']['kpi']/30);
        $total_sale_day_L6 = round($total['sale']['kpi']/30);
        $total_day_L8 = round($total_sale_day_L6*0.85);

        $progress = [];
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
  
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => $total_marketing_day,
            'name' => 'Marketing',
            'type' => 'C3'
        );
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_confirm >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_sale_day_L6,
            'name' => 'TVTS',
            'type' => 'L6'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);
		
		$progress['progressbar'] = $progress;

        // thêm hàng cod L8
//        $inputContact = array();
//        $inputContact['select'] = 'id';
//        $inputContact['where'] = array('date_receive_lakita >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
//        $today = $this->contacts_model->load_all($inputContact);
//        $progress['cod'] = array(
//            'count' => count($today),
//            'kpi' => $total_day_L8,
//            'name' => 'COD',
//            'type' => 'L8'
//        );
//        $progress['cod']['progress'] = round($progress['cod']['count'] / $progress['cod']['kpi'] * 100, 2);

        return $progress;
    }
	
	//làm KPI động thì làm ở chỗ nãy
    protected function GetProccessThisMonth() {

		// tính L6,L8 theo thang
        $total = 0;
        $this->load->model('staffs_model');
        $qr = $this->staffs_model->SumTarget();
		//echo $qr[0]['targets'];die;
        $total_month_L6 = round($qr[0]['targets']*30*0.61);
        $total_month_L8 = round($total_month_L6*0.85);

        $progress = [];
        $inputContact = array();
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

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_confirm >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => $total_month_L6,
            'name' => 'TVTS',
            'type' => 'L6'
		);
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);
		
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
        switch ($post['type']) {
            case 'new':
                $input = array();
                $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => $this->user_id, 'is_hide' => '0');
                $input['order'] = array('date_handover' => 'DESC');
                break;
            case 'call_back':
                $input = array();
                $input['where'] = array(
                    'date_recall >' => '0',
                    'date_recall <' => strtotime('tomorrow'),
                    'sale_staff_id' => $this->user_id,
                    'is_hide' => '0'
                );
                $input['where_not_in'] = array(
                    'call_status_id' => $this->_get_stop_care_call_stt(),
//                    'ordering_status_id' => $this->_get_stop_care_order_stt()
					'level_contact_id' => array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5'),
                );
                break;
            case 'less_3':
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
                $input['where']['sale_staff_id'] = $this->user_id;
                $input['where']['is_hide'] = '0';
                $input['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
                if(!empty($array)){
					$input['where_in']['id'] = $array;
				}
                break;
            case 'more_3':
                $this->load->model('call_log_model');
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
                $input = array();
                $input['where']['sale_staff_id'] = $this->user_id;
                $input['where']['is_hide'] = '0';
                $input['where']['(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))'] = 'NO-VALUE';
                if(!empty($array)){
					$input['where_in']['id'] = $array;
				}
                break;
            default :
        }

        $data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $this->table .= 'date_rgt date_handover link';
        $data['table'] = explode(' ', $this->table);
        echo $this->load->view('common/content/tbl_contact', $data);
    }
}
