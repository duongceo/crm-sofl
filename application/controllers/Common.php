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
            //'class_study' => array(),
            'notes' => array(
				'where' => array('contact_id' => $contact_id),
                'order' => array('time_created' => 'ASC')
            ),
            'transfer_logs' => array(
                'where' => array('contact_id' => $id)
            ),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
			'level_contact' => array(
				'order' => array('level_id' => 'ASC')
			),
			'level_student' => array(
				'order' => array('level_id' => 'ASC')
			),
			'level_study' => array(
				'order' => array('level_id' => 'ASC')
			),
            'payment_method_rgt' => array(),
            'sources' => array(),
            'link_site' => array(),
			'branch' => array(),
			'language_study' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
		
        $left_view = array(
            'contact_id' => 'view',
            'name' => 'view',
//            'email' => 'view',
            'phone' => 'view',
            'phone_foreign' => 'view',
            'branch' => 'view',
            'language' => 'view',
            //'class_study_id' => 'view',
            'fee' => 'view',
//            'paid' => 'view',
            'sale' => 'view',
            'is_old' => 'view',
            'source' => 'view',
			'link_site' => 'view'
        );
        $right_view = array(
            'transfer_log' => 'view',
			'date_rgt' => 'view',
			'date_handover' => 'view',
            'call_stt' => 'view',
			'level_contact' => 'view',
			'level_student' => 'view',
			'level_study' => 'view',
            //'payment_method_rgt' => 'view',
            'note' => 'view',
			'date_last_calling' => 'view',
			'date_confirm' => 'view',
			'date_recall' => 'view',
			'date_rgt_study' => 'view',
			//'date_receive_cost' => 'view'
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

        $input_paid_log = array();
        $input_paid_log['where'] = array('contact_id' => $id);
        $input_paid_log['order'] = array('time_created' => 'ASC');
        $this->load->model('paid_model');
        $data['paid_log'] = $this->paid_model->load_all_paid_log($input_paid_log);
//		print_arr($data);

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
                'phone_foreign' => 'edit',
				'branch' => 'edit',
				'language' => 'edit',
//				'level_language' => 'edit',
//                'class_study_id' => 'edit',
                'fee' => 'edit',
                'paid' => 'view',
                'paid_log' => 'view',
                'paid_today' => 'edit',
                'complete_fee' => 'edit',
                'date_paid' => 'edit',
            );
            $right_edit = array(
                'payment_method_rgt' => 'edit',
                'call_stt' => 'edit',
                'level_contact' => 'edit',
				'level_student' => 'edit',
				'level_study' => 'edit',
				'date_rgt_study' => 'edit',
				'is_old' => 'edit',
                'date_recall' => 'edit',
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
				'branch' => 'view',
				'language' => 'view',
                'class_study_id' => 'view',
				'date_rgt_study' => 'view',
            );
            $right_edit = array(
            	'customer_care_call_id' => 'edit',
                'status_sale_id' => 'edit',
                'status_lecture_id' => 'edit',
                'status_teacher_id' => 'edit',
                'status_end_student_id' => 'edit',
                'date_recall_customer_care' => 'edit',
                'note' => 'edit',
				'date_customer_care_call' => 'view',
            );
        }
		
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

        if ($this->role_id == 1 && $rows[0]['sale_staff_id'] != $this->user_id && $this->user_id != 18) {
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
				'where' => array('branch_id' => $rows[0]['branch_id']),
                'order' => array('class_study_id' => 'ASC')
            ),
            'branch' => array(),
            'notes' => array(
                //'where' => array('contact_code' => $contact_code),
				'where' => array('contact_id' => $contact_id),
                'order' => array('time_created' => 'ASC')
            ),
            'transfer_logs' => array(
                'where' => array('contact_id' => $id)
            ),
			'paid' => array(
				'where' => array('contact_id' => $id),
				'order' => array('time_created' => 'ASC')
			),
			'level_contact' => array(
				'order' => array('level_id' => 'ASC'),
				'where' => array(
					'parent_id' => '',
					'active' => 1
				),
			),
			'level_student' => array(
				'order' => array('level_id' => 'ASC'),
				'where' => array(
					'parent_id' => '',
					'active' => 1
				),
			),
			'level_study' => array(
				'order' => array('level_id' => 'ASC'),
				'where' => array(
					'parent_id' => '',
					'active' => 1
				),
			),
            'level_language' => array(
            	'where' => array('language_id' => $rows[0]['language_id'])
			),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
            'payment_method_rgt' => array(),
			'language_study' => array(),
        );

		if ($this->role_id == 10) {
			$require_model = array(
				'branch' => array(),
				'language_study' => array(),
				'customer_call_status' => array(),
				'status_for_sale' => array(),
				'status_for_lecture' => array(),
				'status_for_teacher' => array(),
				'status_end_student' => array(),
				'notes' => array(
					'where' => array('contact_id' => $contact_id, 'role_id' => $this->role_id),
					'order' => array('time_created' => 'ASC')
				),
			);
		}

		$this->load->model('level_contact_model');
		if ($rows[0]['level_contact_detail'] != '') {
			$rows[0]['level_contact_name'] = $this->level_contact_model->get_name_from_level($rows[0]['level_contact_detail']);
		} else {
			$rows[0]['level_contact_name'] = $this->level_contact_model->get_name_from_level($rows[0]['level_contact_id']);
		}

//		$this->load->model('level_student_model');
//		if ($rows[0]['level_student_detail'] != '') {
//			$rows[0]['level_student_name'] = $this->level_student_model->get_name_from_level($rows[0]['level_student_detail']);
//		} else {
//			$rows[0]['level_student_name'] = $this->level_student_model->get_name_from_level($rows[0]['level_student_id']);
//		}

		$this->load->model('level_study_model');
		if ($rows[0]['level_study_detail'] != '') {
			$rows[0]['level_study_name'] = $this->level_study_model->get_name_from_level($rows[0]['level_study_detail']);
		} else {
			$rows[0]['level_study_name'] = $this->level_study_model->get_name_from_level($rows[0]['level_study_id']);
		}

        $data = $this->_get_require_data($require_model);

        $data['view_edit_left'] = $left_edit;
        $data['view_edit_right'] = $right_edit;

        if ($this->role_id == 1 || $this->role_id == 12) {
            $edited_contact = $this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['level_contact_id']);
//			$data['action_url'] = 'common/update_before_edit_contact/' . $id;
        }
//        if ($this->role_id == 12) {
//			$edited_contact = $this->_can_edit_by_branch($rows[0]['branch_id']);
//		}

//        if ($this->role_id == 2) {
//            if ($rows[0]['call_status_id'] != _DA_LIEN_LAC_DUOC_ || $rows[0]['ordering_status_id'] != _DONG_Y_MUA_) {
//                $edited_contact = false;
//            } else {
//                $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
//            }
//
//			$data['action_url'] = 'common/action_edit_contact/' . $id;
//        }

        if ($this->role_id == 10) {
			$edited_contact = true;
//			$data['action_url'] = 'common/action_edit_contact/' . $id;
        }
		
        $data['contact_id'] = $id;
        $data['edited_contact'] = $edited_contact;

        $input_call_log = array();
        $input_call_log['where'] = array('contact_id' => $id);
        $input_call_log['order'] = array('time_created' => 'ASC');
        $this->load->model('call_log_model');
        $data['call_logs'] = $this->call_log_model->load_all_call_log($input_call_log);

		$input_paid_log = array();
		$input_paid_log['select'] = 'SUM(paid) as paiding';
		$input_paid_log['where'] = array('contact_id' => $id);
//		$input_paid_log['order'] = array('time_created' => 'ASC');
		$this->load->model('paid_model');
//		$rows[0]['paid'] = $this->paid_model->load_all_paid_log($input_paid_log)[0]['paiding'];

        $data['rows'] = $rows[0];
		$data['action_url'] = 'common/action_edit_contact/' . $id;
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

//        $stop_care_call_order_id = array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5');
//        if (in_array($level_contact, $stop_care_call_order_id)) {
//			return false;
//		}

        return true;
    }

    protected function _can_edit_by_branch($branch_id) {
    	if ($branch_id == 0 || $this->branch_id == $branch_id) {
			return true;
		} else return false;
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
//	function update_before_edit_contact($id = 0){
//        $post = $this->input->post();
////        print_arr($post);die();
//        $param = array();
//        $param['class_study_id'] = $post['class_study_id'];
//        $where = array('id' => $id);
//        $this->contacts_model->update($where, $param);
//        $this->action_edit_contact($id);
//    }

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
			} else if ($rows[0]['sale_staff_id'] != $this->user_id && $this->user_id != 18) {
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
//            if ($rows[0]['cod_status_id'] != 2 && $rows[0]['cod_status_id'] != 3) {
//                $result['success'] = 0;
//                $result['message'] = "Contact chưa nhận COD, nên không thể chăm sóc!";
//                echo json_encode($result);
//                die;
//            }
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
            $dataPush = [];
            $dataPush['title'] = 'Lịch sử trang web (beta)';
            $dataPush['message'] = $this->staffs_model->find_staff_name($this->user_id) . ' đã cập nhật cuộc gọi';
            $dataPush['success'] = '0';

            $post = $this->input->post();
//			print_arr($post);
            $param = array();
            $post_arr = array('name', 'email', 'phone', 'phone_foreign', 'branch_id', 'language_id', 'class_study_id', 'level_language_id', 'payment_method_rgt', 'call_status_id', 'is_old', 'complete_fee');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }

            if ($post['fee'] != 0) {
				$param['fee'] = str_replace(',', '', $post['fee']);
			}

//			print_arr($post);
			
			if ($this->role_id == 12) {
				if ($param['branch_id'] == 0 || $param['language_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật cơ sở hoặc ngoại ngữ';
					echo json_encode($result);
					die;
				}
			}
			
			if (isset($post['level_contact_id']) && !empty($post['level_contact_id']) && $post['level_contact_id'] != '') {
				$param['level_contact_id'] = $post['level_contact_id'];
			} else {
				$param['level_contact_id'] = $rows[0]['level_contact_id'];
			}
			
			if (isset($post['level_contact_detail']) && !empty($post['level_contact_detail']) && $post['level_contact_detail'] != '') {
				$param['level_contact_detail'] = $post['level_contact_detail'];
				$level_contact = $param['level_contact_detail'];
			} else {
				$level_contact = $param['level_contact_id'];
			}

			if (isset($post['level_student_id']) && !empty($post['level_student_id']) && $post['level_student_id'] != '') {
				$param['level_student_id'] = $post['level_student_id'];
			} else {
				$param['level_student_id'] = '';
			}

//			if (isset($post['level_student_detail']) && !empty($post['level_student_detail']) && $post['level_student_detail'] != '') {
//				$param['level_student_detail'] = $post['level_student_detail'];
//			}

			if (isset($post['level_study_id']) && !empty($post['level_study_id']) && $post['level_study_id'] != '') {
				$param['level_study_id'] = $post['level_study_id'];
			}

			if (isset($post['level_study_detail']) && !empty($post['level_study_detail']) && $post['level_study_detail'] != '') {
				$param['level_study_detail'] = $post['level_study_detail'];
			}
			
			if ($post['level_contact_detail'] == 'L5.2' || $post['level_student_id'] == 'L8') {
				if ($post['is_old'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Contact là học viên cũ đúng ko ?';
					echo json_encode($result);
					die;
				}
			}

			$param['date_last_calling'] = time();
            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;
			//print_arr($param);
            /* Kiểm tra điều kiện các trạng thái và ngày hẹn gọi lại có logic ko */
            if (isset($post['call_status_id'])) {
				if ($post['call_status_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật trạng thái cuộc gọi!';
					echo json_encode($result);
					die;
				}
				
				if ($post['call_status_id'] == _DA_LIEN_LAC_DUOC_) {
					if (isset($post['level_contact_id']) && $post['level_contact_id'] != '') {
						if (!isset($post['level_contact_detail']) || $post['level_contact_detail'] == '') {
							$result['success'] = 0;
							$result['message'] = 'Bạn phải cập nhật trạng thái chi tiết contact!';
							echo json_encode($result);
							die;
						}
					}
				}
			}

            $check_rule = $this->_check_rule($param['call_status_id'], $level_contact, $param['level_student_id'],  $param['date_recall']);

            if ($check_rule == false) {
                $result['success'] = 0;
                $result['message'] = 'Trạng thái gọi và trạng thái contact không logic!';
                echo json_encode($result);
                die;
            }

            if ($param['level_contact_id'] == 'L3' && $rows[0]['level_contact_id'] != 'L3') {
                $param['date_confirm'] = time();

				$dataPush['message'] = 'Yeah Yeah !!';
                $dataPush['success'] = '1';

            }

			if ($param['level_contact_id'] == 'L5') {
				if ($param['level_language_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Học viên đồng ý mua thì phải có mã khóa học hay trình độ ngôn ngữ';
					echo json_encode($result);
					die;
				}

				if ($param['branch_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Học viên đồng ý đăng ký nhưng chưa có cơ sở';
					echo json_encode($result);
					die;
				}

				if (isset($post['level_student_id']) && $post['level_student_id'] == 'L6') {
					if (!isset($post['class_study_id']) || $post['class_study_id'] == '') {
						$result['success'] = 0;
						$result['message'] = 'Học viên đã xếp lớp thành công thì phải có mã lớp học';
						echo json_encode($result);
						die;
					}
				}

				$param['date_rgt_study'] = (isset($post['date_rgt_study']) && $post['date_rgt_study'] != '') ? strtotime($post['date_rgt_study']) : time();
				$dataPush['message'] = 'Yeah Yeah !!';
                $dataPush['success'] = '1';

                if ($rows[0]['sent_account_online'] == 0) {
                	$student = $this->create_new_account_student($param['name'], $param['phone'], $param['level_language_id']);
                	if ($student->success != 0) {
                		$param['sent_account_online'] = 1;
                		$param['date_active'] = time();
					}
                }
				
			} else if (isset($post['date_rgt_study']) && $post['date_rgt_study'] != '') {
				$result['success'] = 0;
				$result['message'] = 'Học viên đã đăng ký thì mới có ngày đăng ký học';
				echo json_encode($result);
				die;
			}

			if ($post['paid_today'] != 0) {
				$post['paid_today'] = str_replace(',', '', $post['paid_today']);
				$param['paid'] = $rows[0]['paid'] + $post['paid_today'];
				if (strlen($post['paid_today']) < 5 || strlen($post['paid_today']) > 8 || ((int)$post['paid_today'] > (int)$param['fee'])) {
					$result['success'] = 0;
					$result['message'] = 'Đóng học phí chuẩn giá tiền hoặc số tiền học phí phải đúng';
					echo json_encode($result);
					die;
				}

				if ($param['level_contact_id'] != 'L5') {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật trạng thái contact là L5 hoặc phải có ngày đóng tiền';
					echo json_encode($result);
					die;
				}

				if (!isset($post['date_paid']) || $post['date_paid'] == '') {
					$result['success'] = 0;
					$result['message'] = 'Đóng học phí thì phải có ngày đóng';
					echo json_encode($result);
					die;
				} else {
					$param['date_paid'] = strtotime($post['date_paid']);
				}

			} else if (isset($post['date_paid']) && $post['date_paid'] != '') {
				$result['success'] = 0;
				$result['message'] = 'Không có số tiền đóng học phí thì ko thể có ngày đóng';
				echo json_encode($result);
				die;
			}

			//print_arr($param);
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

			if ($post['paid_today'] != 0) {
				$param3 = array(
					'paid' => $post['paid_today'],
					'time_created' => $param['date_paid'],
					'language_id' => $post['language_id'],
					'branch_id' => $post['branch_id'],
					'day' => date('Y-m-d', $param['date_paid']),
					'student_old' => $post['is_old'],
					'source_id' => $rows[0]['source_id'],
					'payment_method_id' => $post['payment_method_rgt'],
				);

				$this->load->model('paid_model');
				$input_paid['where'] = array(
					'contact_id' => $id,
					'time_created >=' => strtotime(date('d-m-Y'))
				);
				$paid = $this->paid_model->load_all($input_paid);

				if (empty($paid)) {
					$param3['contact_id'] = $id;
					$this->paid_model->insert($param3);
				} else {
					$this->paid_model->update($input_paid['where'], $param3);
				}
			}

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

			$pusher = new Pusher(
				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
			);

            //$dataPush['image'] = $this->staffs_model->GetStaffImage($this->user_id);
            $pusher->trigger('my-channel', 'callLog', $dataPush);

            die;
        }
    }

	 //Tạo tài khoản học viên
    public function create_new_account_student($name = '', $phone = '', $level_language_id = '') {
        if ($phone != '' && $level_language_id != '') {
			$this->load->model('level_language_model');
			$contact_s = $this->level_language_model->find_course_combo($level_language_id);
//			echo $contact_s;die();
			// $courseCode = explode(",", $contact_s);
			$contact = array(
				'course_code' => $contact_s,
				'name' => $name,
				'phone' => trim($phone),
				'type' => 'offline'
			);

			$student = $this->_create_account_student_offline($contact);
//			return json_encode($student); die();
			return $student;
        }
    }
    //end

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

        if (!empty($this->input->post())) {

//        	Thông báo realtime về khi đã chăm sóc contact
//            $dataPush = [];
//            $dataPush['title'] = 'Lịch sử trang web (beta)';
//            $dataPush['message'] = $this->staffs_model->find_staff_name($this->user_id) . ' đã cập nhật cuộc gọi';
//            $dataPush['success'] = '0';

            $post = $this->input->post();
//            print_arr($post);
            $param = array();
            $post_arr = array('status_sale_id', 'customer_care_call_id', 'status_lecture_id', 'status_teacher_id', 'status_end_student_id');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }
			$param['customer_care_staff_id'] = $this->user_id;
			$param['date_customer_care_call'] = time();
			$param['date_recall_customer_care'] = (isset($post['date_recall_customer_care']) && $post['date_recall_customer_care'] != '') ? strtotime($post['date_recall_customer_care']) : '';
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
					'role_id' => $this->role_id
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);

            $result['success'] = 1;
            $result['role'] = 10;
			$result['hide'] = 1;
            $result['message'] = 'Chăm sóc thành công contact!';
            echo json_encode($result);

//            $options = array(
//                'cluster' => 'ap1',
//                'encrypted' => true,
//				'useTLS' => true
//            );
//
//			$pusher = new Pusher(
//				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
//			);
//
//            $dataPush['image'] = $this->staffs_model->GetStaffImage($this->user_id);
//            $pusher->trigger('my-channel', 'callLog', $dataPush);

            die;
        }
    }

    private function _check_rule($call_status_id, $level_contact_id, $level_student, $date_recall) {
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
		
		if ($level_student != '') {
			if (!in_array($level_contact_id, array('L5', 'L5.1', 'L5.2', 'L5.3')) || $call_status_id != _DA_LIEN_LAC_DUOC_) {
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

//		$stop_care_call_level_id = array('L4', 'L4.1', 'L4.2', 'L4.3', 'L4.4', 'L4.5');
//		if (in_array($level_contact, $stop_care_call_level_id)) {
//			return false;
//		}

        return true;
    }

    /* ================== Chăm sóc 1 contact =========================== */

//    function action_edit_multi_cod_contact() {
//        $post = $this->input->post();
//        $result = array();
//        if (!isset($post['contact_id']) || empty($post['contact_id'])) {
//            show_error_and_redirect('Bạn cần chọn contact!', '', FALSE);
//        }
//        foreach ($post['contact_id'] as $value) {
//            $input = array();
//            $input['where'] = array('id' => $value);
//            $rows = $this->contacts_model->load_all($input);
//            $this->_action_edit_by_cod($value, $rows, true);
//        }
//        $result['success'] = 1;
//        $result['message'] = 'Chăm sóc thành công contact!';
//        echo json_encode($result);
//        die;
//    }


//    private function _action_edit_by_cod($id, $rows, $multi = false) {
//        $result = array();
//        // print_arr($rows);
//        $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
//        if (!$edited_contact) {
//            $result['success'] = 0;
//            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
//            echo json_encode($result);
//            die;
//        }
//        if (!empty($this->input->post())) {
//            $post = $this->input->post();
//            $param = array();
//            //$param['cod_staff_id'] = $this->user_id;
//            $post_arr = array('address', 'payment_method_rgt', 'provider_id', 'cod_status_id', 'code_cross_check', 'phone', 'note_cod', 'weight_envelope', 'cod_fee', 'fee_resend', 'date_expect_receive_cod', 'price_purchase', 'is_black');
//            foreach ($post_arr as $value) {
//                if (isset($post[$value])) {
//                    $param[$value] = $post[$value];
//                }
//            }
//            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;
//            if ($param['date_recall'] > 0 && $param['date_recall'] < time()) {
//                $result['success'] = 0;
//                $result['message'] = 'Ngày hẹn gọi lại không thể là ngày trong quá khứ!';
//                echo json_encode($result);
//                die;
//            }
//            if (isset($post['date_expect_receive_cod']) && $post['date_expect_receive_cod'] != '') {
//                if (strtotime($post['date_expect_receive_cod']) < time()) {
//                    $result['success'] = 0;
//                    $result['message'] = 'Ngày dự kiến giao hàng không thể là quá khứ!';
//                    echo json_encode($result);
//                    die;
//                } else {
//                    $param['date_expect_receive_cod'] = strtotime($post['date_expect_receive_cod']);
//                }
//            }
//
//            $cur_cod_status_id = $rows[0]['cod_status_id'];
//            $cod_status_id = $post['cod_status_id'];
//            // $this->_check_cod_stt_avalid($cod_status_id, $cur_cod_status_id);
//            //nếu trạng thái là đang giao hàng và không có mã vận đơn (không phải tạo bằng tay) thì tạo mã vận đơn
//            if ($cur_cod_status_id == 0 && $cod_status_id == 1) {
//                if (!isset($post['code_cross_check']) || $post['code_cross_check'] == '') {
//                    if (isset($post['provider_id']) && $post['provider_id'] != '' && $post['provider_id'] != 0) {
//                        $param['code_cross_check'] = $this->_gen_code_cross_check($post, $id);
//                        $param['date_print_cod'] = time();
//                    } else {
//                        $result['success'] = 0;
//                        $result['message'] = 'Bạn cần chọn đơn vị giao hàng!';
//                        echo json_encode($result);
//                        die;
//                    }
//                } else {
//                    $param['date_print_cod'] = time();
//                }
//            }
//            //hạ cấp
////            if ($cod_status_id == 0) {
////                $this->load->model('cod_cross_check_model');
////                $where = array('contact_id' => $id);
////                $curr = $this->cod_cross_check_model->load_all(array('where' => $where));
////                if (!empty($curr)) {
////
////                    /*
////                     * Xóa contact đang xóa ở bảng tạm và cập nhật lại mã bill bằng rỗng
////                     */
////                    $this->cod_cross_check_model->delete($where);
////                    $this->contacts_model->update(array('id' => $id), array('code_cross_check' => NULL));
////                    /*
////                     * Lấy toàn bộ contact có số thứ tự lớn hơn STT contact dang xóa
////                     */
////                    $condition = array(
////                        'where' => array(
////                            'date_print_cod' => $curr[0]['date_print_cod'],
////                            'provider_id' => $curr[0]['provider_id'],
////                            'number >' => $curr[0]['number']
////                        )
////                    );
////                    $upper = $this->cod_cross_check_model->load_all($condition);
////
////                    /*
////                     * Cập nhật lại các contact đằng sau đúng số thứ tự (STT = STT - 1)
////                     */
////                    $this->load->model('providers_model');
////                    $input_provider = array();
////                    $input_provider['where'] = array('id' => $curr[0]['provider_id']);
////                    $provider = $this->providers_model->load_all($input_provider);
////                    $provider_prefix = $provider[0]['prefix'];
////                    if (!empty($upper)) {
////                        foreach ($upper as $value) {
////                            $u_num = $value['number'] - 1;
////                            if ($u_num < 10) {
////                                $u_num = '0' . $u_num;
////                            }
////                            $this->cod_cross_check_model->update(array('id' => $value['id']), array('number' => $u_num));
////                            $u_code = $provider_prefix . $value['date_print_cod'] . $u_num;
////                            $this->contacts_model->update(array('id' => $value['contact_id']), array('code_cross_check' => $u_code));
////                        }
////                    }
////                }
////                $param['code_cross_check'] = '';
////                $param['provider_id'] = '0';
////            }
//            //nếu trạng thái đã thu COD, hủy đơn, đã thu Lakita thì cập nhật time
//            // $receiveCOD = array();
//            if ($cod_status_id > 1) {
//                if(($cod_status_id == 2 || $cod_status_id == 3)&& $rows[0]['id_lakita'] == 0){
//                    $input = array();
//                    $input['select'] = 'customer_care_staff_id';
//                    $input['where']['id'] = $id;
//                    $da_phan_cham_soc = $this->contacts_model->load_all($input);
//                    if($da_phan_cham_soc[0]['customer_care_staff_id'] != ''){
//                        $param['customer_care_staff_id'] = $this->_get_customer_care_id_auto();
//                        $param['date_customer_care_handover'] = time();
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
//            $where = array('id' => $id);
//            $param['last_activity'] = time();
//            $this->contacts_model->update($where, $param);
//
//            if (isset($post['note']) && $post['note'] != '') {
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
//            $this->_set_call_log($id, $post, $rows);
//
//            if ($multi == false) {
//                $result['success'] = 1;
//                $result['role'] = 2;
//                $result['message'] = 'Chăm sóc thành công contact!';
//                echo json_encode($result);
//                die;
//            }
//        }
//    }

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
        $data['role_id'] = $this->role_id;

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
        $diffArr = array(
            '[Họ tên]: ' => 'name',
//            '[Email]: ' => 'email',
            '[SĐT]: ' => 'phone',
//            '[Địa chỉ]: ' => 'address',
//            '[Mã lớp học]: ' => 'class_study_id',
//            '[Khóa học]: ' => 'level_language_id',
            '[Học phí]: ' => 'fee',
//            '[Đã thanh toán]: ' => 'paid',
        );
        $strDiff = '';
        foreach ($diffArr as $key => $value) {
            if (isset($post[$value])) {
                if (is_string($rows[0][$value])) {
                    $rows[0][$value] = trim($rows[0][$value]);
					if ($value == 'fee') {
						$rows[0][$value] = number_format($rows[0][$value]);
					}
                    $post[$value] = trim($post[$value]);
                }

                if ($post[$value] !== $rows[0][$value]) {
                    $strDiff .= $key . $rows[0][$value] . ' ==> ' . $post[$value] . '<br>';
                }
            }
        }

        if ($this->role_id == 10) {
			$strDiff = 'Chăm sóc khách hàng gọi';
		}

        $data['content_change'] = $strDiff;
        $this->load->model('call_log_model');
        $this->call_log_model->insert($data);
    }

    /*
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
    */

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
            'level_contact' => array(),
			'level_language' => array(),
			'branch' => array(),
			'language_study' => array()
        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $contact_id = $this->input->post('contact_id', true);
        $contact_phone = $this->contacts_model->get_contact_phone($contact_id);
        //$contact_course_code = $this->input->post('contact_course_code', true);

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
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
        $this->table .= 'fee paid call_stt level_contact date_rgt';
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

//    function send_phone_to_mobile() {
//        $post = $this->input->post();
//        $where = array('user_id' => $this->user_id);
//        $data = array('phone' => $post['contact_phone'], 'name' => $post['contact_name']);
//        $this->load->model('get_mobile_phone_model');
//        $this->get_mobile_phone_model->update($where, $data);
//    }

//    function get_phone_to_mobile() {
//        $this->load->model('get_mobile_phone_model');
//        $input = array();
//        $input['where'] = array('user_id' => $this->user_id);
//        $rs = $this->get_mobile_phone_model->load_all($input);
//        echo json_encode($rs[0]);
//    }

/*
    public function ExportToExcel_2() {

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

    }
*/

	public function ExportToExcel() {
		$post = $this->input->post();

		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

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

			$columnName = 'A';
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['name']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['branch_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['language_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, date('d/m/Y H:m', $contact[0]['date_rgt']));
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
			$rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Contact_' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		die;
	}

    /*
    public function ExportL7ToExcel() {

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

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
    }
    */

    // </editor-fold>
    
//	function check_is_one_email(){
//
//        $post = $this->input->post();
//
//        $input = array();
//        $input['select'] = 'email';
//        $input['where_in']['id'] = $post['contact'];
//        $contact = $this->contacts_model->load_all($input);
//
//        $email_list = array();
//        foreach ($contact as $value){
//            $email_list[] = $value['email'];
//        }
//        $email_list = array_unique($email_list);
//
//        $result['num_email'] = count($email_list);
//        $result['email'] = $email_list[0];
//        echo json_encode($result);
//    }
	
//	function restore_infor(){
//        $this->load->model('contacts_model');
//        $this->load->model('contacts_backup_model');
//        $post = $this->input->post();
//        if (empty($post['contact_id'])) {
//            show_error_and_redirect('Vui lòng chọn contact', '', 0);
//        }
//
//        $contact_export = $this->_contact_export($post['contact_id']);
//
//        foreach ($contact_export as $value){
//            $input = array();
//            $input['select'] = 'name,address,phone,course_code,price_purchase';
//            $input['where']['id'] = $value['id'];
//            $restore_infor = $this->contacts_backup_model->load_all($input);
//            $this->contacts_model->update(array('id' => $value['id']),$restore_infor[0]);
//        }
//        show_error_and_redirect('Khôi phục thông tin thành công', '', 0);
//    }

//    private function _contact_export($ids) {
//        $this->load->model('Courses_model');
//        $contacts = array();
//        $i = 0;
//        foreach ($ids as $value) {
//            $input = array();
//            $input['select'] = 'id, phone, name, address, price_purchase, note_cod, provider_id';
//            $input['where'] = array('id' => $value);
//            $contact = $this->contacts_model->load_all($input);
//            //tìm xem số đt của contact có trong mảng contacts hay chưa,
//            //nếu chưa thì thêm vào, nếu có thì cộng tiền
//            $position = found_position_in_array($contact[0]['phone'], $contacts);
//            if ($position == -1) {
//                $contacts[$i] = array(
//                    'id' => $contact[0]['id'],
//                    'code_cross_check' => $contact[0]['code_cross_check'],
//                    'course_code' => $contact[0]['course_code'],
//                    'course_name' => $this->Courses_model->find_course_name($contact[0]['course_code']),
//                    'name' => $contact[0]['name'],
//                    'phone' => $contact[0]['phone'],
//                    'address' => $contact[0]['address'],
//                    'price_purchase' => $contact[0]['price_purchase'],
//                    'note_cod' => $contact[0]['note_cod'],
//                    'cb' => 1,
//                    'provider_id' => $contact[0]['provider_id']
//                );
//                $i++;
//            } else {
//                $contacts[$position]['price_purchase'] += $contact[0]['price_purchase'];
//                $contacts[$position]['course_name'] = 'Khóa học combo';
//                $contacts[$position]['cb'] += 1;
//            }
//        }
//        return $contacts;
//    }

    public function get_level_contact() {
    	$post = $this->input->post();
		$input['where'] = array(
			'parent_id' => $post['level_id'],
		);
    	if (in_array($post['level_id'], array('L1', 'L2', 'L3', 'L4', 'L5'))) {
			$this->load->model('level_contact_model');
			$chil_level = $this->level_contact_model->load_all($input);
			$name = "level_contact_detail";
		}  else if ($post['level_id'] == 'L7') {
			$this->load->model('level_study_model');
			$chil_level = $this->level_study_model->load_all($input);
			$name = "level_study_detail";
		}
//    	else if (in_array($post['level_id'], array('L6', 'L8'))) {
//			$this->load->model('level_student_model');
//			$chil_level = $this->level_student_model->load_all($input);
//			$name = "level_student_detail";
//		}
//		print_arr($chil_level);
    	if (isset($chil_level) && !empty($chil_level)) {
			 $str = '<td class="text-right">
					Trạng thái chi tiết
				</td>
				<td>
					<select class="form-control selectpicker" name='.$name.'>
						<option value=""> Trạng thái chi tiết </option>';
						foreach ($chil_level as $value) {
							$str .= "<option value='{$value['level_id']}'> {$value['level_id']} - {$value['name']} </option>";
						}
			$str .= '</select>
				</td>';
			echo $str;
		} else {
    		echo '<td class="text-right">
				</td>';
		}
	}

	public function get_data_ajax(){
    	$post = $this->input->post();
    	if ($post['type'] == 'language') {
			$input['where']['language_id'] = $post['level_id'];
			$this->load->model('level_language_model');
			$level_language = $this->level_language_model->load_all($input);
//			print_arr($level_language);

			if (isset($level_language) && !empty($level_language)) {
				$str = '<td class="text-right">
					Khóa học
				</td>
				<td>
					<select class="form-control selectpicker" name="level_language_id">
						<option value=""> Chọn khóa học </option>';
				foreach ($level_language as $value) {
					$str .= "<option value='{$value['id']}'> {$value['name']} </option>";
				}
				$str .= '</select>
				</td>';
				echo $str;
			} else {
				echo '<td class="text-right"></td>';
			}

		} elseif ($post['type'] == 'branch') {
			$input['where']['branch_id'] = $post['level_id'];
			$this->load->model('class_study_model');
			$class = $this->class_study_model->load_all($input);

			if (isset($class) && !empty($class)) {
				$str = '<td class="text-right">
					Mã lớp
				</td>
				
				<td>
					<div class="input-group">
						<select class="form-control selectpicker" name="class_study_id">
							<option value=""> Chọn lớp học </option>';
							foreach ($class as $value) {
								$str .= "<option value='{$value['class_study_id']}'> {$value['class_study_id']} </option>";
							}
						$str .= '</select>
						<div class="input-group-btn">
							<a style="margin-top: 3px;" target="_blank" href="'.base_url('staff_managers/class_study').'" class="btn btn-success">Tạo mã lớp</a>
						</div>
					</div>
				</td>';
				echo $str;
			} else {
				echo '<td class="text-right"></td>';
			}
		}
	}

}
