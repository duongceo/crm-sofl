<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Common extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function view_detail_contact() {
        $post = $this->input->post();
        $id = $post['contact_id'];
        $this->_common_view_contact($id);
    }

    private function _common_view_contact($id) {
        $input = array();
        $input['where'] = array('id' => $id);
        $rows = $this->contacts_model->load_all_contacts($input);
        if (empty($rows)) {
            echo 'Không tồn tại contact này!';
            die;
        }
        //$contact_code = $rows[0]['phone'] . '_' . $rows[0]['course_code'];
		$contact_id = $rows[0]['id'];
        $require_model = array(
            'staffs' => array(),
            'class_study' => array(),
            'notes' => array(
				'where' => array('contact_id' => $contact_id),
                'order' => array('time_created' => 'ASC')
            ),
//            'transfer_logs' => array(
//                'where' => array('contact_id' => $id, 'is_transfered' => 1)
//            ),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
			'level_contact' => array(
				'order' => array('level_id' => 'ASC')
			),
//            'ordering_status' => array(
//                'order' => array('sort' => 'ASC')
//            ),
            'payment_method_rgt' => array(),
            'sources' => array(),
			'branch' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $left_view = array(
            'contact_id' => 'view',
            'name' => 'view',
            'email' => 'view',
            'phone' => 'view',
            //'address' => 'view',
            'class_study_id' => 'view',
            'fee' => 'view',
            'paid' => 'view',
            'sale' => 'view',
            'source' => 'view',
        );
        $right_view = array(
//            'transfer_log' => 'view',
			'date_rgt' => 'view',
			'date_handover' => 'view',
            'call_stt' => 'view',
//            'ordering_stt' => 'view',
			'level_contact' => 'view',
            'payment_method_rgt' => 'view',
            'note' => 'view',
			'date_last_calling' => 'view',
			'date_confirm' => 'view',
			'date_recall' => 'view',
			'date_receive_cost' => 'view'
        );
		
		if ($this->role_id == 8) {
			unset($left_view['phone']);
		}
		
        $data['view_edit_left'] = $left_view;
        $data['view_edit_right'] = $right_view;

        $input_call_log = array();
        $input_call_log['where'] = array('contact_id' => $id);
		$input_call_log['order'] = array('time_created' => 'ASC');
        $this->load->model('call_log_model');
        $data['call_logs'] = $this->call_log_model->load_all_call_log($input_call_log);

        $data['rows'] = $rows[0];
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_detail_contact', $data, true);
        echo json_encode($result);
        die;
    }

    function show_edit_contact_modal() {
        $post = $this->input->post();

        if ($this->role_id == 1 || $this->role_id == 12) {  //sale && nhân viên cơ sở
            $left_edit = array(
//                'contact_id' => 'view',
                'name' => 'edit',
                'email' => 'edit',
                'phone' => 'edit',
				'branch' => 'edit',
				'level_language' => 'edit',
//                'address' => 'edit',
                'class_study_id' => 'edit',
                'fee' => 'edit',
                'paid' => 'edit',
            );
            $right_edit = array(
                'payment_method_rgt' => 'edit',
                'call_stt' => 'edit',
//                'ordering_stt' => 'edit',
                'level_contact' => 'edit',
                'date_recall' => 'edit',
//                'send_banking_info' => 'edit',
                'note' => 'edit',
				'date_rgt' => 'view',
				'date_handover' => 'view',
				'date_last_calling' => 'view',
				'date_confirm' => 'view',
            );
        }

//        if ($this->role_id == 2) { //cod
//            $left_edit = array(
//                'contact_id' => 'view',
//                'name' => 'edit',
//                'email' => 'view',
//                'phone' => 'edit',
//				  'is_black' => 'edit',
//                'address' => 'edit',
//                'course_code' => 'view',
//                'price_purchase' => 'edit',
//                'date_rgt' => 'view',
//                'date_handover' => 'view',
//                'date_confirm' => 'view',
//            );
//            $right_edit = array(
//                'sale' => 'view',
//                'payment_method_rgt' => 'edit',
//                'code_cross_check' => 'edit',
//                'provider' => 'edit',
//                'cod_status' => 'edit',
//                'date_recall' => 'edit',
//                'date_expect_receive_cod' => 'edit',
//                'weight_envelope' => 'edit',
//                'cod_fee' => 'edit',
//                'fee_resend' => 'edit',
//                'send_banking_info' => 'edit',
//                'send_account_lakita' => 'edit',
//				  'account_active' => 'view',
//                'note' => 'edit',
//                'note_cod' => 'edit'
//            );
//        }

        if ($this->role_id == 10) {  //chăm sóc khách hàng
            $left_edit = array(
                'contact_id' => 'view',
                'name' => 'view',
                'email' => 'view',
                'phone' => 'view',
                'address' => 'view',
                'class_study_id' => 'edit',
                'fee' => 'view',
                'paid' => 'view',
                'date_rgt' => 'view',
            );
            $right_edit = array(
                'payment_method_rgt' => 'view',
                'customer_care_call_stt' => 'edit',
                'note' => 'edit',
				'date_customer_care_handover' => 'view',
				'date_customer_care_call' => 'view',
//				'date_last_calling' => 'view',
            );
        }

//		if ($this->role_id == 13) { //affiliate
//			$left_edit = array(
//				'contact_id' => 'view',
//                'name' => 'edit',
//                'email' => 'edit',
//                'phone' => 'edit',
//                'address' => 'edit',
//                'course_code' => 'edit',
//                'price_purchase' => 'edit',
//                'source_sale_id' => 'edit',
//                'date_rgt' => 'view',
//                'date_handover' => 'view',
//                'date_last_calling' => 'view',
//                'date_confirm' => 'view',
//			);
//			$right_edit = array(
//                'transfer_log' => 'view',
//                'call_stt' => 'edit',
//                'ordering_stt' => 'edit',
//                'reason' => 'edit',
//                'payment_method_rgt' => 'edit',
//                'code_cross_check' => 'edit',
//                'provider' => 'edit',
//                'cod_status' => 'edit',
//                'date_recall' => 'edit',
//                'date_expect_receive_cod' => 'edit',
//                'weight_envelope' => 'edit',
//                'cod_fee' => 'edit',
//                'fee_resend' => 'edit',
//                'send_banking_info' => 'edit',
//                'send_account_lakita' => 'edit',
//                'note' => 'edit',
//                'note_cod' => 'edit'
//            );
//		}
		
        $this->_common_edit_contact($post, $left_edit, $right_edit);
    }

    protected function _common_edit_contact($post, $left_edit, $right_edit) {
        $input = array();
        $input['where'] = array('id' => trim($post['contact_id']));
        $rows = $this->contacts_model->load_all_contacts($input);

        $result = array();
        if (empty($rows)) {
            $result['success'] = 0;
            $result['message'] = 'Không tồn tại khách hàng này!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id == 1 && $rows[0]['sale_staff_id'] != $this->user_id) {
            $result['success'] = 0;
            $result['message'] = 'Contact này không được phân cho bạn!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id != 1 && $this->role_id != 2 && $this->role_id != 10 && $this->role_id != 12) {
            $result['success'] = 0;
            $result['message'] = 'Bạn không có quyền chỉnh sửa contact này!';
            echo json_encode($result);
            die;
        }

        $id = trim($post['contact_id']);
        //$contact_code = $rows[0]['phone'] . '_' . $rows[0]['course_code'];
		$contact_id = $rows[0]['id'];
		if ($id != $contact_id) {
			$result['success'] = 0;
			$result['message'] = 'ID contact không đúng';
			echo json_encode($result);
			die;
		}

		$require_model = array(
            'staffs' => array(),
            'class_study' => array(
				'where' => array('active' => 1, 'branch_id' => $rows[0]['branch_id']),
                'order' => array('class_study_id' => 'ASC')
            ),
            'branch' => array(),
            'notes' => array(
                //'where' => array('contact_code' => $contact_code),
				'where' => array('contact_id' => $contact_id),
                'order' => array('time_created' => 'ASC')
            ),
//            'transfer_logs' => array(
//                'where' => array('contact_id' => $id)
//            ),

			'level_contact' => array(
				'order' => array('level_id' => 'ASC'),
				'where' => array('parent_id' => ''),
			),
            'level_language' => array(
            	'where' => array('language_id' => $rows[0]['language_id'])
			),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
//            'ordering_status' => array(
//                'order' => array('sort' => 'ASC')
//            ),
            'payment_method_rgt' => array(),
        );

		if ($rows[0]['level_contact_id'] != '') {
			$this->load->model('level_contact_model');
			$rows[0]['level_contact_name'] = $this->level_contact_model->get_name_from_level($rows[0]['level_contact_id']);
		}

        $data = $this->_get_require_data($require_model);

        $data['view_edit_left'] = $left_edit;
        $data['view_edit_right'] = $right_edit;

        if ($this->role_id == 1 || $this->role_id == 12) {
            $edited_contact = ($this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['ordering_status_id']));
			$data['action_url'] = 'common/update_before_edit_contact/' . $id;
        }

//        if ($this->role_id == 2) {
//            if ($rows[0]['call_status_id'] != _DA_LIEN_LAC_DUOC_ || $rows[0]['ordering_status_id'] != _DONG_Y_MUA_) {
//                $edited_contact = false;
//            } else {
//                $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
//            }
//
//			$data['action_url'] = 'common/action_edit_contact/' . $id;
//        }

//        if ($this->role_id == 10) {
//            if ($rows[0]['cod_status_id'] < 2 || $rows[0]['cod_status_id'] > 3) {
//                $edited_contact = false;
//            } else {
//                $edited_contact = $this->_can_edit_by_customer_care($rows[0]['cod_status_id']);
//            }
//			$data['action_url'] = 'common/action_edit_contact/' . $id;
//        }
		
//		if ($this->role_id == 13) {
//            $edited_contact = ($rows[0]['cod_status_id'] == 3 || $rows[0]['cod_status_id'] == 4)?false:true;
//
//			// $data['action_url'] = 'common/update_before_edit_contact/' . $id;
//			$data['action_url'] = 'common/action_edit_contact/' . $id;
//        }
		
        $data['contact_id'] = $id;
        $data['edited_contact'] = $edited_contact;

        $input_call_log = array();
        $input_call_log['where'] = array('contact_id' => $id);
        $input_call_log['order'] = array('time_created' => 'ASC');
        $this->load->model('call_log_model');
        $data['call_logs'] = $this->call_log_model->load_all_call_log($input_call_log);

        $data['rows'] = $rows[0];
//        print_arr($data);
//		$data['action_url'] = 'common/action_edit_contact/' . $id;
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/edit_contact', $data, true);
        echo json_encode($result);
        die;
    }

    private function _can_edit_by_sale($call_stt, $level_contact) {
        $this->load->model("call_status_model");
        $stop_care_call_stt_where = array();
        $stop_care_call_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->call_status_model->load_all($stop_care_call_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                if ($value['id'] == $call_stt) {
                    return false;
                }
            }
        }

        $stop_care_call_order_id = array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5');
        if (in_array($level_contact, $stop_care_call_order_id)) {
			return false;
		}

//        if (!empty($stop_care_call_order_id)) {
//            foreach ($stop_care_call_order_id as $value) {
//                if ($value == $level_contact) {
//                    return false;
//                }
//            }
//        }


//        if ($ordering_stt == _DONG_Y_MUA_) {
//            return false;
//        }
        return true;
    }

//    protected function _can_edit_by_cod($cod_status_id) {
//        $this->load->model("cod_status_model");
//        $stop_care_cod_stt_where = array();
//        $stop_care_cod_stt_where['where'] = array('stop_care' => 1);
//        $stop_care_call_stt_id = $this->cod_status_model->load_all($stop_care_cod_stt_where);
//        if (!empty($stop_care_call_stt_id)) {
//            foreach ($stop_care_call_stt_id as $value) {
//                if ($value['id'] == $cod_status_id) {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }

//    protected function _can_edit_by_customer_care($cod_status_id) {
//        $this->load->model("cod_status_model");
//        $stop_care_cod_stt_where = array();
//        $stop_care_cod_stt_where['where'] = array('customer_care' => '0');
//        $stop_care_call_stt_id = $this->cod_status_model->load_all($stop_care_cod_stt_where);
//        if (!empty($stop_care_call_stt_id)) {
//            foreach ($stop_care_call_stt_id as $value) {
//                if ($value['id'] == $cod_status_id) {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
	
	/*update contact trước khi edit*/
	function update_before_edit_contact($id = 0){
        $post = $this->input->post();
//        print_arr($post);die();
        $param = array();
        $param['class_study_id'] = $post['class_study_id'];
        $where = array('id' => $id);
        $this->contacts_model->update($where, $param);
        $this->action_edit_contact($id);
    }

    function action_edit_contact($id = 0) {
        $result = array();
        $input = array();
        $input['where'] = array('id' => trim($id));
        $rows = $this->contacts_model->load_all($input);
		
		/*var_dump($rows);die;*/
		
        if (empty($rows)) {
            $result['success'] = 0;
            $result['message'] = 'Không tồn tại contact này!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id == 1 || $this->role_id == 12) { // sale && cơ sở
			if ($this->role_id == 12) {
				$this->_action_edit_by_sale(trim($id), $rows);
				die;
			} else if ($rows[0]['sale_staff_id'] != $this->user_id) {
                $result['success'] = 0;
                $result['message'] = "Contact này không được phân cho bạn, vì vậy bạn không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_sale(trim($id), $rows);
        } else if ($this->role_id == 2) {
            if ($rows[0]['ordering_status_id'] != _DONG_Y_MUA_ || $rows[0]['call_status_id'] != _DA_LIEN_LAC_DUOC_) {
                $result['success'] = 0;
                $result['message'] = "Contact không là L6, nên không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_cod(trim($id), $rows);
        } else if ($this->role_id == 10) { // chăm sóc khách hàng
            if ($rows[0]['cod_status_id'] != 2 && $rows[0]['cod_status_id'] != 3) {
                $result['success'] = 0;
                $result['message'] = "Contact chưa nhận COD, nên không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_customer_care(trim($id), $rows);
        } else if ($this->role_id == 13) {
        	if ($rows[0]['affiliate_id'] != $this->user_id) {
                $result['success'] = 0;
                $result['message'] = "Contact này không được phân cho bạn, vì vậy bạn không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_affiliate(trim($id), $rows);
        } else {
            $result['success'] = 0;
            $result['message'] = "Bạn không có quyền chỉnh sửa contact";
            echo json_encode($result);
            die;
        }
    }

    private function _action_edit_by_sale($id, $rows) {
        $result = array();
        $edited_contact = $this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['level_contact_id']);
        if (!$edited_contact) {
            $result['success'] = 0;
            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
            echo json_encode($result);
            die;
        }
        if (!empty($this->input->post())) {

            /*
             * Thông báo số chốt đơn
             */

            $dataPush = [];
            $dataPush['title'] = 'Lịch sử trang web (beta)';
            $dataPush['message'] = $this->staffs_model->find_staff_name($this->user_id) . ' đã cập nhật cuộc gọi';
            $dataPush['success'] = '0';

            $post = $this->input->post();
//			print_arr($post);
            $param = array();
            $post_arr = array('name', 'email', 'phone', 'branch_id', 'class_study_id', 'level_language_id', 'fee', 'paid', 'payment_method_rgt', 'call_status_id');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }

			if (isset($post['level_contact_id_child']) && !empty($post['level_contact_id_child']) && $post['level_contact_id_child'] != '') {
				$param['level_contact_id'] = $post['level_contact_id_child'];
			} else {
				$param['level_contact_id'] = $post['level_contact_id'];
			}

			$param['date_last_calling'] = time();
            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;

            /* Kiểm tra điều kiện các trạng thái và ngày hẹn gọi lại có logic ko */
            if (isset($post['call_status_id'])) {
				if ($post['call_status_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật trạng thái cuộc gọi!';
					echo json_encode($result);
					die;
				} else if (!in_array($post['call_status_id'], array(_KHONG_NGHE_MAY_, _NHAM_MAY_, _SO_MAY_SAI_))){
					if (isset($post['class_study_id']) && $post['class_study_id'] == '') {
						$result['success'] = 0;
						$result['message'] = 'Bạn phải chọn mã lớp học!';
						echo json_encode($result);
						die;
					}
				
					if (isset($post['fee']) && $post['fee'] == 0) {
						$result['success'] = 0;
						$result['message'] = 'Bạn phải cập nhật giá tiền mua!';
						echo json_encode($result);
						die;
					}
			
				}
			}

            $check_rule = $this->_check_rule($param['call_status_id'], $param['level_contact_id'], $param['date_recall']);

            if ($check_rule == false) {
                $result['success'] = 0;
                $result['message'] = 'Trạng thái gọi và trạng thái contact không logic!';
                echo json_encode($result);
                die;
            }

            $level_success = array('L3', 'L3.1', 'L3.2', 'L5', 'L5.1', 'L5.2', 'L5.3');
            if (in_array($param['level_contact_id'], $level_success)) {
                $param['date_confirm'] = time();

//                $input = [];
//                $input['where'] = array('id' => $this->user_id);
//                $thisSale = $this->staffs_model->load_all($input);
//
//                $inputPush = [];
//                $inputPush['select'] = 'id';
//                $inputPush['where'] = array('sale_staff_id' => $this->user_id, 'date_confirm >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
//                $today = $this->contacts_model->load_all($inputPush);
//                $totalL5 = count($today) + 1;
//
//                $dataPush['title'] = "L5 số " . $totalL5 . " của " . $thisSale[0]['short_name'] . " hôm nay";
//
//                if ($totalL5 < $thisSale[0]['targets']) {
//                    $dataPush['message'] = "Bạn còn " . ($thisSale[0]['targets'] - $totalL5) . " L6 nữa là đạt mục tiêu hôm nay!";
//                }
//                if ($totalL5 > $thisSale[0]['targets']) {
//                    $dataPush['message'] = "Xin chúc mừng, bạn đã vượt mục tiêu hôm nay. Cố gắng phát huy bạn nhé <3 <3 <3";
//                }

				$dataPush['message'] = 'Yeah Yeah !!';
                $dataPush['success'] = '1';
				
				 //Tạo tài khoản tự động cho học viên
//				$acc = $this->create_new_account_student(trim($id));

            } else {
                $param['date_confirm'] = '';
            }

//            print_arr($param);
			
            $param['last_activity'] = time();
            $where = array('id' => $id);
            $this->contacts_model->update($where, $param);
			
            if ($post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time_created' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id),
					'class_study_id' => 0
                );
				
				//print_arr($param2);
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
			
//			$this->load->model('call_log_model');
//			$input_log['where'] = array('contact_id' => $id);
//			if (empty($this->call_log_model->load_all($input_log))) {
//				$result['new'] = 1;
//			}
			
            $this->_set_call_log($id, $post, $rows);
			
            $result['success'] = 1;
            $result['role'] = 1;
            $result['message'] = 'Chăm sóc thành công contact!';
            echo json_encode($result);

            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true,
				'useTLS' => true
            );

//            $pusher = new Pusher(
//                    '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
//            );

			$pusher = new Pusher(
				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
			);

            $dataPush['image'] = $this->staffs_model->GetStaffImage($this->user_id);
            $pusher->trigger('my-channel', 'callLog', $dataPush);

            die;
        }
    }
	
	 //Tạo tài khoản học viên
//    public function create_new_account_student($id) {
//        $post = $this->input->post();
//        //return $id;
//        if (!empty($post) && isset($id)) {
//            $this->db->select('name, course_code, email, phone, payment_method_rgt');
//            $contacts = $this->contacts_model->find($id);
//			//var_dump($contacts);die;
//
//            if (!empty($contacts)) {
//
//                $contact = $contacts[0];
//
//                switch ($contact['course_code']) {
//                    case 'KT610':
//                        $contact['course_code'] = 'KT240';
//                        break;
//                    case 'KT620':
//                        $contact['course_code'] = 'KT270';
//                        break;
//                    case 'KT630':
//                        $contact['course_code'] = 'KT280';
//                        break;
//                    case 'KT460':
//                        $contact['course_code'] = 'KT290';
//                        break;
//                    default:
//                        break;
//                }
//
//                $this->load->model('courses_model');
//                $contact_s = $this->courses_model->find_course_combo($contact['course_code']);
//                // $courseCode = explode(",", $contact_s);
//                $contact['course_code'] = $contact_s;
//				//var_dump($contact);die;
//                if ($contact['name'] == '' || $contact['phone'] == '') {
//                    $result = [];
//                    $result['success'] = 0;
//                    $result['message'] = 'Contact đã chọn không có tên hoặc số đt hoặc địa chỉ! Vui lòng cập nhật thông tin khách hàng đầy đủ.';
//                    echo json_encode($result);
//                    die;
//                }
//
//                $student = $this->_create_account_student_lakita($contact);
//                // return json_encode($student);
//                if ($student->success != 0) {
//                    $contact['password'] = $student->password;
//
//					$id_lakita = $student->id_lakita;
//
//                    $where = array('id' => $id);
//
//                    $data = array('send_account_lakita' => 1, 'id_lakita' => $id_lakita, 'date_active' => time());
//
//                    $this->contacts_model->update($where, $data);
//
//                    return $student;
//                    // die();
//                } else {
//
//                    $id_lakita = $student->id_lakita;
//
//                    $where = array('id' => $id);
//
//                    $data = array('id_lakita' => $id_lakita);
//
//                    $this->contacts_model->update($where, $data);
//
//                    return $student;
//
//                }
//            }
//
//        }
//    }
    //end

    //api tạo tài khoản cho học viên
//    private function _create_account_student_lakita($contact) {
//        require_once APPPATH . "libraries/Rest_Client.php";
//        $config = array(
//            'server' => 'https://lakita.vn/',
//            'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
//            'api_name' => 'lakita-key'
//        );
//        $restClient = new Rest_Client($config);
//        $uri = "account_api/create_new_account";
//        $student = $restClient->post($uri, $contact);
//        return $student;
//    }
    //end

//    private function _action_edit_by_affiliate($id, $rows) {
//    	$result = array();
//        $edited_contact = ($rows[0]['cod_status_id'] == 3 || $rows[0]['cod_status_id'] == 4)?false:true;
//        if (!$edited_contact) {
//            $result['success'] = 0;
//            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
//            echo json_encode($result);
//            die;
//        }
//        if (!empty($this->input->post())) {
//
//            /*
//             * Thông báo số L6 gọi đc
//             */
//
//            $post = $this->input->post();
//            $param = array();
//            $post_arr = array('name', 'email', 'address', 'course_code', 'phone',
//                'price_purchase', 'payment_method_rgt', 'source_sale_id', 'call_status_id',
//                'ordering_status_id', 'note_cod', 'script','provider_id', 'reason_id', 'cod_status_id', 'code_cross_check','weight_envelope', 'cod_fee', 'fee_resend', 'date_expect_receive_cod');
//
//            foreach ($post_arr as $value) {
//                if (isset($post[$value])) {
//                    $param[$value] = $post[$value];
//                }
//            }
//
//            // echo "<pre>";print_r($param);die();
//            $param['date_last_calling'] = time();
//            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;
//            $param['date_expect_receive_cod'] = (isset($post['date_expect_receive_cod']) && $post['date_expect_receive_cod'] != '') ? strtotime($post['date_expect_receive_cod']) : 0;
//
//            if ($param['date_expect_receive_cod'] > 0 && $param['ordering_status_id'] != _DONG_Y_MUA_) {
//                $result['success'] = 0;
//                $result['message'] = 'Contact đồng ý mua mới có ngày dự kiến giao hàng!';
//                echo json_encode($result);
//                die;
//            }
//            /* Kiểm tra điều kiện các trạng thái và ngày hẹn gọi lại có logic ko */
//            if (isset($post['call_status_id']) && $post['call_status_id'] == '0') {
//                $result['success'] = 0;
//                $result['message'] = 'Bạn phải cập nhật trạng thái cuộc gọi!';
//                echo json_encode($result);
//                die;
//            }
//            if (isset($post['course_code']) && $post['course_code'] == '0') {
//                $result['success'] = 0;
//                $result['message'] = 'Bạn phải chọn mã khóa học!';
//                echo json_encode($result);
//                die;
//            }
//            if (isset($post['price_purchase']) && $post['price_purchase'] == '') {
//                $result['success'] = 0;
//                $result['message'] = 'Bạn phải cập nhật giá tiền mua!';
//                echo json_encode($result);
//                die;
//            }
//            if (isset($post['note_cod']) && $post['note_cod'] != '' && $post['ordering_status_id'] != _DONG_Y_MUA_) {
//                $result['success'] = 0;
//                $result['message'] = 'Chỉ contact nào đồng ý mua mới có ghi chú khi giao hàng!';
//                echo json_encode($result);
//                die;
//            }
////            if (isset($post['provider_id'])) {
////                if ($post['provider_id'] > 0 && $post['ordering_status_id'] != _DONG_Y_MUA_) {
////                    $result['success'] = 0;
////                    $result['message'] = 'Chỉ contact đồng ý mua mới có đơn vị giao hàng!';
////                    echo json_encode($result);
////                    die;
////                } else if ($post['provider_id'] == 0 && $post['ordering_status_id'] == _DONG_Y_MUA_) {
////                    $result['success'] = 0;
////                    $result['message'] = 'Bạn cần chọn đơn vị giao hàng!';
////                    echo json_encode($result);
////                    die;
////                } else {
////                    $param['provider_id'] = $post['provider_id'];
////                }
////            }
//
//            $check_rule = $this->_check_rule($param['call_status_id'], $param['ordering_status_id'], $param['date_recall']);
//
//            if ($check_rule == false) {
//                $result['success'] = 0;
//                $result['message'] = 'Trạng thái gọi và trạng thái đơn hàng không logic!';
//                echo json_encode($result);
//                die;
//            }
//
//            if ($post['ordering_status_id'] == _DONG_Y_MUA_) {
//                $param['date_confirm'] = time();
//                if ($post['date_expect_receive_cod'] != '' && strtotime($post['date_expect_receive_cod']) < time()) {
//                    $result['success'] = 0;
//                    $result['message'] = 'Ngày dự kiến giao hàng không thể là quá khứ! Mã lỗi 69874514';
//                    echo json_encode($result);
//                    die;
//                }
//
//				 //Tạo tài khoản tự động cho học viên
////                    $acc = $this->create_new_account_student(trim($id));
//
//            } else {
//                $param['date_confirm'] = 0;
//            }
//
//			$cod_status_id = $post['cod_status_id'];
//            if ($cod_status_id > 1) {
//                if(($cod_status_id == 2 || $cod_status_id == 3)){
//                    $input = array();
//                    $input['select'] = 'customer_care_staff_id';
//                    $input['where']['id'] = $id;
//                    $da_phan_cham_soc = $this->contacts_model->load_all($input);
//                    if($da_phan_cham_soc[0]['customer_care_staff_id'] != ''){
//                        $param['customer_care_staff_id'] = $this->_get_customer_care_id_auto();
//                        $param['date_customer_care_handover'] = time();
//
//                    }
//                }
//                switch ($cod_status_id) {
//                    case 2:
//                        //đã thu COD
//                        //$receiveCOD[] = $rows[0]['contact_id'];
//                        $param['date_receive_cod'] = time();
//                        $param['date_expect_receive_cod'] = '0';
//                        $param['date_recall'] = 0;
//                        break;
//                    case 3:
//                        //dã thu lakita
//                        // $receiveCOD[] = $rows[0]['contact_id'];
//                        $param['date_receive_lakita'] = time();
//                        $param['date_expect_receive_cod'] = '0';
//                        $param['date_recall'] = 0;
//                        break;
//                    case 4:
//                        //hủy đơn
//                        $param['date_receive_cancel_cod'] = time();
//                        $param['date_expect_receive_cod'] = '0';
//                        $param['date_recall'] = 0;
//                        break;
//                }
//            } else {
//                $param['date_receive_cod'] = 0;
//                $param['date_receive_lakita'] = 0;
//                $param['date_receive_cancel_cod'] = 0;
//            }
//
//            $param['last_activity'] = time();
//            $where = array('id' => $id);
//            $this->contacts_model->update($where, $param);
//
//            if ($post['note'] != '') {
//                $param2 = array(
//                    'contact_id' => $id,
//                    'content' => $post['note'],
//                    'time_created' => time(),
//                    'sale_id' => $this->user_id,
//                    'contact_code' => $this->contacts_model->get_contact_code($id)
//                );
//                $this->load->model('notes_model');
//                $this->notes_model->insert($param2);
//            }
//
//            $this->_set_call_log($id, $post, $rows);
//
//			/*
//			if (($post['ordering_status_id'] != _DONG_Y_MUA_ && $post['call_status_id'] != PAYMENT_METHOD_COD) || ($post['ordering_status_id'] == _DONG_Y_MUA_ && $post['call_status_id'] != PAYMENT_METHOD_COD)) {
//
//                $result['success'] = 1;
//                $result['role'] = 1;
//                $result['message'] = 'Chăm sóc thành công contact!';
//                echo json_encode($result);
//            } */
//
//            $result['success'] = 1;
//            $result['role'] = 13;
//            $result['message'] = 'Chăm sóc thành công contact!';
//            echo json_encode($result);
//
//            die;
//        }
//    }

    private function _action_edit_by_customer_care($id, $rows) {
        $result = array();
        $edited_contact = $this->_can_edit_by_customer_care($rows[0]['cod_status_id']);
        if (!$edited_contact) {
            $result['success'] = 0;
            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
            echo json_encode($result);
            die;
        }
        if (!empty($this->input->post())) {

            /*
             * Thông báo số L6 gọi đc
             */
            $dataPush = [];
            $dataPush['title'] = 'Lịch sử trang web (beta)';
            $dataPush['message'] = $this->staffs_model->find_staff_name($this->user_id) . ' đã cập nhật cuộc gọi';
            $dataPush['success'] = '0';

            $post = $this->input->post();
            $param = array();
            $post_arr = array('note_cod','customer_care_call_id','cod_status_id','course_code');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }
			
            $input = array();
            $input['select'] = 'date_customer_care_call';
            $input['where']['id'] = $id;
            $date_customer_care_call = $this->contacts_model->load_all($input);
            if($date_customer_care_call[0]['date_customer_care_call'] == '0'){
                $param['date_customer_care_call'] = time();
            }

            $param['last_activity'] = time();
            $where = array('id' => $id);
            $this->contacts_model->update($where, $param);
            if ($post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time_created' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id)
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);
            $result['success'] = 1;
            $result['role'] = 10;

//            if ($rows[0]['id_lakita'] != 0) {
//                $result['hide'] = 1;
//            } else {
//                $result['hide'] = 0;
//            }

			$result['hide'] = 1;
            
            $result['message'] = 'Chăm sóc thành công contact!';
            echo json_encode($result);

            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true,
				'useTLS' => true
            );

//            $pusher = new Pusher(
//                    '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
//            );

			$pusher = new Pusher(
				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
			);

            $dataPush['image'] = $this->staffs_model->GetStaffImage($this->user_id);
            $pusher->trigger('my-channel', 'callLog', $dataPush);

            die;
        }
    }

    private function _check_rule($call_status_id, $level_contact_id, $date_recall) {
        if ($call_status_id == '0' || $call_status_id == _SO_MAY_SAI_ || $call_status_id == _KHONG_NGHE_MAY_ || $call_status_id == _NHAM_MAY_ || $call_status_id == _KHONG_LIEN_LAC_DUOC_) {
            if ($level_contact_id != '') {
                return false;
            }
        }

        if ($call_status_id == _DA_LIEN_LAC_DUOC_) {
        	if ($level_contact_id == '') {
				return false;
			}
        }

        if ($date_recall != 0 && $date_recall < time()) {
            $result = [];
            $result['success'] = 0;
            $result['message'] = 'Ngày hẹn gọi lại không thể là ngày trong quá khứ!';
            echo json_encode($result);
            die;
            return false;
        }

        if ($this->_can_edit_true($call_status_id, $level_contact_id) == false && $date_recall > time()) {
            return false;
        }

        return true;
    }

    private function _can_edit_true($call_stt, $level_contact) {
        $this->load->model("call_status_model");
        $stop_care_call_stt_where = array();
        $stop_care_call_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->call_status_model->load_all($stop_care_call_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                if ($value['id'] == $call_stt)
                    return false;
            }
        }

		$stop_care_call_level_id = array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5');
		if (in_array($level_contact, $stop_care_call_level_id)) {
			return false;
		}

//        $this->load->model("ordering_status_model");
//        $stop_care_call_order_where = array();
//        $stop_care_call_order_where['where'] = array('stop_care' => 1);
//        $stop_care_call_order_id = $this->ordering_status_model->load_all($stop_care_call_order_where);
//        if (!empty($stop_care_call_order_id)) {
//            foreach ($stop_care_call_order_id as $value) {
//                if ($value['id'] == $ordering_stt)
//                    return false;
//            }
//        }

        return true;
    }

    /* ================== Chăm sóc 1 contact =========================== */

    function action_edit_multi_cod_contact() {
        $post = $this->input->post();
        $result = array();
        if (!isset($post['contact_id']) || empty($post['contact_id'])) {
            show_error_and_redirect('Bạn cần chọn contact!', '', FALSE);
        }
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
            $this->_action_edit_by_cod($value, $rows, true);
        }
        $result['success'] = 1;
        $result['message'] = 'Chăm sóc thành công contact!';
        echo json_encode($result);
        die;
    }

    private function _action_edit_by_cod($id, $rows, $multi = false) {
        $result = array();
        // print_arr($rows);
        $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
        if (!$edited_contact) {
            $result['success'] = 0;
            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
            echo json_encode($result);
            die;
        }
        if (!empty($this->input->post())) {
            $post = $this->input->post();
            $param = array();
            //$param['cod_staff_id'] = $this->user_id;
            $post_arr = array('address', 'payment_method_rgt', 'provider_id', 'cod_status_id', 'code_cross_check', 'phone', 'note_cod', 'weight_envelope', 'cod_fee', 'fee_resend', 'date_expect_receive_cod', 'price_purchase', 'is_black');
            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }
            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;
            if ($param['date_recall'] > 0 && $param['date_recall'] < time()) {
                $result['success'] = 0;
                $result['message'] = 'Ngày hẹn gọi lại không thể là ngày trong quá khứ!';
                echo json_encode($result);
                die;
            }
            if (isset($post['date_expect_receive_cod']) && $post['date_expect_receive_cod'] != '') {
                if (strtotime($post['date_expect_receive_cod']) < time()) {
                    $result['success'] = 0;
                    $result['message'] = 'Ngày dự kiến giao hàng không thể là quá khứ!';
                    echo json_encode($result);
                    die;
                } else {
                    $param['date_expect_receive_cod'] = strtotime($post['date_expect_receive_cod']);
                }
            }

            $cur_cod_status_id = $rows[0]['cod_status_id'];
            $cod_status_id = $post['cod_status_id'];
            // $this->_check_cod_stt_avalid($cod_status_id, $cur_cod_status_id);
            //nếu trạng thái là đang giao hàng và không có mã vận đơn (không phải tạo bằng tay) thì tạo mã vận đơn
            if ($cur_cod_status_id == 0 && $cod_status_id == 1) {
                if (!isset($post['code_cross_check']) || $post['code_cross_check'] == '') {
                    if (isset($post['provider_id']) && $post['provider_id'] != '' && $post['provider_id'] != 0) {
                        $param['code_cross_check'] = $this->_gen_code_cross_check($post, $id);
                        $param['date_print_cod'] = time();
                    } else {
                        $result['success'] = 0;
                        $result['message'] = 'Bạn cần chọn đơn vị giao hàng!';
                        echo json_encode($result);
                        die;
                    }
                } else {
                    $param['date_print_cod'] = time();
                }
            }
            //hạ cấp
//            if ($cod_status_id == 0) {
//                $this->load->model('cod_cross_check_model');
//                $where = array('contact_id' => $id);
//                $curr = $this->cod_cross_check_model->load_all(array('where' => $where));
//                if (!empty($curr)) {
//
//                    /*
//                     * Xóa contact đang xóa ở bảng tạm và cập nhật lại mã bill bằng rỗng
//                     */
//                    $this->cod_cross_check_model->delete($where);
//                    $this->contacts_model->update(array('id' => $id), array('code_cross_check' => NULL));
//                    /*
//                     * Lấy toàn bộ contact có số thứ tự lớn hơn STT contact dang xóa
//                     */
//                    $condition = array(
//                        'where' => array(
//                            'date_print_cod' => $curr[0]['date_print_cod'],
//                            'provider_id' => $curr[0]['provider_id'],
//                            'number >' => $curr[0]['number']
//                        )
//                    );
//                    $upper = $this->cod_cross_check_model->load_all($condition);
//
//                    /*
//                     * Cập nhật lại các contact đằng sau đúng số thứ tự (STT = STT - 1)
//                     */
//                    $this->load->model('providers_model');
//                    $input_provider = array();
//                    $input_provider['where'] = array('id' => $curr[0]['provider_id']);
//                    $provider = $this->providers_model->load_all($input_provider);
//                    $provider_prefix = $provider[0]['prefix'];
//                    if (!empty($upper)) {
//                        foreach ($upper as $value) {
//                            $u_num = $value['number'] - 1;
//                            if ($u_num < 10) {
//                                $u_num = '0' . $u_num;
//                            }
//                            $this->cod_cross_check_model->update(array('id' => $value['id']), array('number' => $u_num));
//                            $u_code = $provider_prefix . $value['date_print_cod'] . $u_num;
//                            $this->contacts_model->update(array('id' => $value['contact_id']), array('code_cross_check' => $u_code));
//                        }
//                    }
//                }
//                $param['code_cross_check'] = '';
//                $param['provider_id'] = '0';
//            }
            //nếu trạng thái đã thu COD, hủy đơn, đã thu Lakita thì cập nhật time
            // $receiveCOD = array();
            if ($cod_status_id > 1) {
                if(($cod_status_id == 2 || $cod_status_id == 3)&& $rows[0]['id_lakita'] == 0){
                    $input = array();
                    $input['select'] = 'customer_care_staff_id';
                    $input['where']['id'] = $id;
                    $da_phan_cham_soc = $this->contacts_model->load_all($input);
                    if($da_phan_cham_soc[0]['customer_care_staff_id'] != ''){
                        $param['customer_care_staff_id'] = $this->_get_customer_care_id_auto();
                        $param['date_customer_care_handover'] = time();
                    }
                }
                switch ($cod_status_id) {
                    case 2:
                        //đã thu COD
                        //$receiveCOD[] = $rows[0]['contact_id'];
                        $param['date_receive_cod'] = time();
                        $param['date_expect_receive_cod'] = '0';
                        $param['date_recall'] = 0;
                        break;
                    case 3:
                        //dã thu lakita
                        // $receiveCOD[] = $rows[0]['contact_id'];
                        $param['date_receive_lakita'] = time();
                        $param['date_expect_receive_cod'] = '0';
                        $param['date_recall'] = 0;
                        break;
                    case 4:
                        //hủy đơn
                        $param['date_receive_cancel_cod'] = time();
                        $param['date_expect_receive_cod'] = '0';
                        $param['date_recall'] = 0;
                        break;
                }
            } else {
                $param['date_receive_cod'] = 0;
                $param['date_receive_lakita'] = 0;
                $param['date_receive_cancel_cod'] = 0;
            }

            $where = array('id' => $id);
            $param['last_activity'] = time();
            $this->contacts_model->update($where, $param);

            if (isset($post['note']) && $post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time_created' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id)
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);

            if ($multi == false) {
                $result['success'] = 1;
                $result['role'] = 2;
                $result['message'] = 'Chăm sóc thành công contact!';
                echo json_encode($result);
                die;
            }
        }
    }

//    private function _check_cod_stt_avalid($cod_status_id, $cur_cod_status_id) {
//        if ($cur_cod_status_id == 1 && $cod_status_id < 1) {
//            $error = 'Vui lòng cập nhật trạng thái giao COD';
//            show_error_and_redirect($error, base_url('error'));
//        }
//        if ($cur_cod_status_id == 0 && $cod_status_id > 1) {
//            $error = 'Contact đang ở trạng thái chưa giao hàng, nên không thể cập nhật thành đã thu COD, đã thu Lakita hoặc Hủy đơn được!';
//            show_error_and_redirect($error, base_url('error'));
//        }
//        if (($cur_cod_status_id == 2 || $cur_cod_status_id == 3) && ($cod_status_id == 4 || $cod_status_id <= 1)) {
//            $error = 'Contact đang ở trạng thái đã thu COD/ đã thu Lakita thì không thể cập nhật thành Hủy đơn hoặc Đang giao hàng được!';
//            show_error_and_redirect($error, base_url('error'));
//        }
//    }

//    private function _gen_code_cross_check($post, $id) {
//        $code_cross_check = '';
//        $this->load->model('providers_model');
//        $input_provider = array();
//        $input_provider['where'] = array('id' => $post['provider_id']);
//        $provider = $this->providers_model->load_all($input_provider);
//        $provider_prefix = $provider[0]['prefix'];
//
//        $this->load->model('cod_cross_check_model');
//        $today = date('dmy'); //lấy định dạng ngày_tháng để ghép vào mã bill
//        $input_cod_cross_check = array();
//        $input_cod_cross_check['where'] = array('date_print_cod' => $today, 'provider_id' => $post['provider_id']);
//        $input_cod_cross_check['order'] = array('id' => 'DESC');
//        /* Kiểm tra trong bảng tạo mã Bill có contact tạo ngày hôm nay chưa, */
//        $cod_cross_check = $this->cod_cross_check_model->load_all($input_cod_cross_check);
//
//        if (empty($cod_cross_check)) { // nếu chưa thì gán STT = 01,
//            $code_cross_check = $provider_prefix . $today . '01';
//            $this->cod_cross_check_model->insert(array('contact_id' => $id, 'date_print_cod' => $today,
//                'provider_id' => $post['provider_id'], 'number' => 1,
//                'phone' => $this->contacts_model->get_contact_phone($id), 'code' => $code_cross_check, 'time' => date('Y/m/d H:i:s', time())));
//        } else {
//            //kiểm tra 1 khách hàng (cùng số đt) mua nhiều khóa học thì ko tạo mã vận đơn mới, mà dùng mã vận đơn cũ
//            $input_duplicate = array();
//            $input_duplicate['where'] = array('date_print_cod' => $today,
//                'phone' => $this->contacts_model->get_contact_phone($id), 'provider_id' => $post['provider_id']);
//            $contact_duplicate = $this->cod_cross_check_model->load_all($input_duplicate);
//            if (!empty($contact_duplicate)) {
//                $code_cross_check = $contact_duplicate[0]['code'];
//            } else {
//                // nếu có rồi thì gán STT = STT + 1 (tăng lên 1 đơn vị)
//                $number = $cod_cross_check[0]['number'] + 1;
//                if ($number < 10) {
//                    $number = '0' . $number;
//                }
//                $code_cross_check = $provider_prefix . $today . '' . $number;
//                $this->cod_cross_check_model->insert(array('contact_id' => $id, 'date_print_cod' => $today,
//                    'provider_id' => $post['provider_id'], 'number' => $number,
//                    'phone' => $this->contacts_model->get_contact_phone($id), 'code' => $code_cross_check, 'time' => date('Y/m/d H:i:s', time())));
//            }
//        }
//        return $code_cross_check;
//    }

    private function _set_call_log($id, $post, $rows) {
        $data = array();
        $data['contact_id'] = $id;
        $data['staff_id'] = $this->user_id;
		
		if (isset($post['level_contact_id_child']) && !empty($post['level_contact_id_child']) && $post['level_contact_id_child'] != '') {
			$post['level_contact_id'] = $post['level_contact_id_child'];
		}
		
        $statusArr = array('call_status_id', 'level_contact_id');
        foreach ($statusArr as $value) {
            if (isset($post[$value])) {
                $data[$value] = $post[$value];
            } else {
                $data[$value] = "-1";
            }
        }
		
        $data['time_created'] = time();
        $diffArr = array(
            '[Họ tên]: ' => 'name',
            '[Email]: ' => 'email',
            '[Địa chỉ]: ' => 'address',
//            '[Mã lớp học]: ' => 'class_study_id',
//            '[Khóa học]: ' => 'level_language_id',
            '[Giá học phí]: ' => 'fee',
            '[Đã thanh toán]: ' => 'paid',
        );
        $strDiff = '';
        foreach ($diffArr as $key => $value) {
            if (isset($post[$value])) {
                if (is_string($rows[0][$value])) {
                    $rows[0][$value] = trim($rows[0][$value]);
                    $post[$value] = trim($post[$value]);
                }
                if ($post[$value] !== $rows[0][$value]) {
                    $strDiff .= $key . $rows[0][$value] . ' ==> ' . $post[$value] . '<br>';
                }
            }
        }

        $data['content_change'] = $strDiff;
        $this->load->model('call_log_model');
        $this->call_log_model->insert($data);
    }

    function real_search() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
            'call_status' => array(),
//            'ordering_status' => array(),
        );
        $data = $this->_get_require_data($require_model);
        $post = $this->input->post();
        if (!empty($post)) {
            $input = array();
            $input['like'] = array($post['type'] => $post['value']);
            $input['oder'] = array('id' => 'DESC');
            $input['limit'] = array(10, 0);
            $data['contacts'] = $this->contacts_model->load_all($input);
            $total_row = count($data['contacts']);
            $this->begin_paging = ($total_row == 0) ? 0 : 1;
            $this->end_paging = ($total_row == 0) ? 0 : $total_row;
            $this->total_paging = $total_row;
            $data['controller'] = 'manager';
        }
        switch ($this->role_id) {
            case 1: $data['controller'] = 'sale';
                break;
            case 2: $data['controller'] = 'cod';
                break;
            case 3: $data['controller'] = 'manager';
                break;
        }

        $this->table .= 'date_rgt date_last_calling call_stt level_contact action';
        $data['table'] = explode(' ', $this->table);
        $this->load->view('common/real_search', $data);
    }

    function ViewAllContactCourse() {
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
                )
            ),
            'call_status' => array(),
            'ordering_status' => array(),
            'level_contact' => array(),
			'level_language' => array(),
			'branch' => array()
        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $contact_id = $this->input->post('contact_id', true);
        $contact_phone = $this->contacts_model->get_contact_phone($contact_id);
        //$contact_course_code = $this->input->post('contact_course_code', true);

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */
        $conditional['where'] = array('phone' => $contact_phone);
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, 0, 0);

        /*
         * Lấy link phân trang và danh sách contacts
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        //print_arr( $data['contacts']);

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'date_rgt call_stt level_contact';
        $data['table'] = explode(' ', $this->table);
        $data['controller'] = $this->input->post('controller', true);
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_all_contact_course', $data, true);
        echo json_encode($result);
        die;
    }
	
	/*
    function find_course_name() {
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('course_code' => $post['course_code']);
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        if (!empty($courses)) {
			$url = "https://lakita.vn/api/get_course_url?course_code=".$post['course_code'];
            echo json_encode(array('name' =>  html_entity_decode($courses[0]['name_course']),'url' => json_decode(file_get_contents($url), true) ));
        }else{
			echo json_encode(array('name' => 'Không tìm thấy khóa học!','url' => json_decode(file_get_contents($url), true) ));
		}
    }
	*/

    function send_phone_to_mobile() {
        $post = $this->input->post();
        $where = array('user_id' => $this->user_id);
        $data = array('phone' => $post['contact_phone'], 'name' => $post['contact_name']);
        $this->load->model('get_mobile_phone_model');
        $this->get_mobile_phone_model->update($where, $data);
    }

    function get_phone_to_mobile() {
        $this->load->model('get_mobile_phone_model');
        $input = array();
        $input['where'] = array('user_id' => $this->user_id);
        $rs = $this->get_mobile_phone_model->load_all($input);
        echo json_encode($rs[0]);
    }

    public function ExportToExcel() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
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
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:R200")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);


        //set tên các cột cần in
        $columnName = 'A';
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Họ tên');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Số điện thoại');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Mã khóa học');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày đăng ký');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'TVTS');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Giá tiền mua');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Nguồn contact');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái gọi');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái đơn hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Đơn vị giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName . $rowCount, 'Ghi chú cuộc gọi');
        $rowCount++;

        //đổ dữ liệu ra file excel
        $i = 1;
        $this->load->model('sources_model');
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('providers_model');
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);

            $this->load->model('notes_model');
            $input2 = array();
            $input2['where'] = array('contact_id' => $value);
            $input2['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input2);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . ' ------ ';
                }
            }
            $notes = html_entity_decode($notes);

            $columnName = 'A';

            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['course_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, date('d/m/Y', $contact[0]['date_rgt']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->staffs_model->find_staff_name($contact[0]['sale_staff_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['price_purchase']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->sources_model->find_source_name($contact[0]['source_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->call_status_model->find_call_status_desc($contact[0]['call_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->ordering_status_model->find_ordering_status_desc($contact[0]['ordering_status_id']));
//            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->cod_status_model->find_cod_status_desc($contact[0]['cod_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->providers_model->find_provider_name($contact[0]['provider_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName . $rowCount, $notes);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':' . $columnName . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }
        foreach (range('A', $columnName) as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    public function ExportL7ToExcel() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
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
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:R200")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);


        //set tên các cột cần in
        $columnName = 'A';
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Họ tên');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Số điện thoại');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Mã khóa học');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Ngày đăng ký');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'TVTS');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Giá tiền mua');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Nguồn contact');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái gọi');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái đơn hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 'Trạng thái giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue($columnName . $rowCount, 'Ghi chú cuộc gọi');
        $rowCount++;

        //đổ dữ liệu ra file excel
        $i = 1;
        $this->load->model('sources_model');
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
//        $this->load->model('cod_status_model');
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);

            $this->load->model('notes_model');
            $input2 = array();
            $input2['where'] = array('contact_id' => $value);
            $input2['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input2);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . ' ------ ';
                }
            }
            $notes = html_entity_decode($notes);

            $columnName = 'A';

            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['course_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, date('d/m/Y', $contact[0]['date_rgt']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->staffs_model->find_staff_name($contact[0]['sale_staff_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['price_purchase']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->sources_model->find_source_name($contact[0]['source_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->call_status_model->find_call_status_desc($contact[0]['call_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->ordering_status_model->find_ordering_status_desc($contact[0]['ordering_status_id']));
//            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $this->cod_status_model->find_cod_status_desc($contact[0]['cod_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName . $rowCount, $notes);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':R' . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }

        foreach (range('A', 'R') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

//die;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    // </editor-fold>
    
      function check_is_one_email(){
        
        $post = $this->input->post();
        
        $input = array();
        $input['select'] = 'email';
        $input['where_in']['id'] = $post['contact'];
        $contact = $this->contacts_model->load_all($input);
        
        $email_list = array();
        foreach ($contact as $value){
            $email_list[] = $value['email'];
        }
        $email_list = array_unique($email_list);
        
        $result['num_email'] = count($email_list);
        $result['email'] = $email_list[0];
        echo json_encode($result); 
    }
	
	function restore_infor(){
        $this->load->model('contacts_model');
        $this->load->model('contacts_backup_model');
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact', '', 0);
        }

        $contact_export = $this->_contact_export($post['contact_id']);
        
        foreach ($contact_export as $value){
            $input = array();
            $input['select'] = 'name,address,phone,course_code,price_purchase';
            $input['where']['id'] = $value['id'];
            $restore_infor = $this->contacts_backup_model->load_all($input);
            $this->contacts_model->update(array('id' => $value['id']),$restore_infor[0]);
        }
        show_error_and_redirect('Khôi phục thông tin thành công', '', 0);
    }

    private function _contact_export($ids) {
        $this->load->model('Courses_model');
        $contacts = array();
        $i = 0;
        foreach ($ids as $value) {
            $input = array();
            $input['select'] = 'id, phone, name, address, price_purchase, note_cod, provider_id';
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);
            //tìm xem số đt của contact có trong mảng contacts hay chưa, 
            //nếu chưa thì thêm vào, nếu có thì cộng tiền
            $position = found_position_in_array($contact[0]['phone'], $contacts);
            if ($position == -1) {
                $contacts[$i] = array(
                    'id' => $contact[0]['id'],
                    'code_cross_check' => $contact[0]['code_cross_check'],
                    'course_code' => $contact[0]['course_code'],
                    'course_name' => $this->Courses_model->find_course_name($contact[0]['course_code']),
                    'name' => $contact[0]['name'],
                    'phone' => $contact[0]['phone'],
                    'address' => $contact[0]['address'],
                    'price_purchase' => $contact[0]['price_purchase'],
                    'note_cod' => $contact[0]['note_cod'],
                    'cb' => 1,
                    'provider_id' => $contact[0]['provider_id']
                );
                $i++;
            } else {
                $contacts[$position]['price_purchase'] += $contact[0]['price_purchase'];
                $contacts[$position]['course_name'] = 'Khóa học combo';
                $contacts[$position]['cb'] += 1;
            }
        }
        return $contacts;
    }

    public function get_level_contact() {
    	$post = $this->input->post();

    	$this->load->model('level_contact_model');
    	$input['where'] = array(
    		'parent_id' => $post['level_id'],
		);
    	$chil_level = $this->level_contact_model->load_all($input);
//		print_arr($chil_level);
    	if (isset($chil_level) && !empty($chil_level)) {
			 $str = '<td class="text-right">
					Trạng thái chi tiết
				</td>
				<td>
					<select class="form-control selectpicker" name="level_contact_id_child">
						<option value=""> Trạng thái chi tiết </option>';
						foreach ($chil_level as $value) {
							$str .= "<option value='{$value['level_id']}'> {$value['level_id']} - {$value['name']} </option>";
						}
			$str .= '</select>
				</td>';
			echo $str;
		} else {
    		echo '';
		}
	}

}
