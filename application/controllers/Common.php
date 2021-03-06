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

		$contact_id = $rows[0]['id'];
        $require_model = array(
            'staffs' => array(),
            //'class_study' => array(),
            'notes' => array(
				'where' => array(
				    'contact_id' => $contact_id,
                    'type_note' => '0'
                ),
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
            'birthday' => 'view',
//            'email' => 'view',
            'phone' => 'view',
            'phone_foreign' => 'view',
            'address' => 'view',
            'branch' => 'view',
            'language' => 'view',
            //'class_study_id' => 'view',
            'fee' => 'view',
//            'paid' => 'view',
            'sale' => 'view',
            'staff_care_branch' => 'view',
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

        $data['staff_care_branch'] = $this->staffs_model->load_all(array('where'=>array('role_id' => 12, 'active' => 1)));
		
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

        $data['rows'] = $rows[0];
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_detail_contact', $data, true);
        echo json_encode($result);
        die;
    }

    function show_edit_contact_modal() {
        $post = $this->input->post();

        if ($this->role_id == 1 || ($this->role_id == 12 && $post['type_modal'] == 'sale')) {  //sale && nhân viên cơ sở
            $left_edit = array(
//                'contact_id' => 'view',
                'name' => 'edit',
                'email' => 'edit',
                'phone' => 'edit',
                'phone_foreign' => 'edit',
                'gender' => 'edit',
                'birthday' => 'edit',
                'address' => 'edit',
				'branch' => 'edit',
                'class_foreign_id' => 'edit',
                'language' => 'edit',
//				'level_language' => 'edit',
//                'class_study_id' => 'edit',
                'fee' => 'edit',
                'paid' => 'view',
                'paid_log' => 'view',
                'paid_today' => 'edit',
                'complete_fee' => 'edit',
                'date_paid' => 'edit',
				'payment_method_rgt' => 'edit',
            );
            $right_edit = array(
                'call_stt' => 'edit',
                'level_contact' => 'edit',
				'date_rgt_study' => 'edit',
				'level_student' => 'edit',
				'level_study' => 'edit',
				'date_action_of_study' => 'edit',
//				'status_register' => 'edit',
				'is_old' => 'edit',
                'date_recall' => 'edit',
                'note' => 'edit',
				'date_rgt' => 'view',
				'date_handover' => 'view',
				'date_last_calling' => 'view',
				'date_confirm' => 'view',
            );
        }

        if ($this->role_id == 10 || ($this->role_id == 12 && $post['type_modal'] == 'customer_care')) {  //chăm sóc khách hàng
            $left_edit = array(
                'contact_id' => 'view',
                'name' => 'view',
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

        if ($this->role_id != 1 && $this->role_id != 10 && $this->role_id != 12) {
            $result['success'] = 0;
            $result['message'] = 'Bạn không có quyền chỉnh sửa contact này!';
            echo json_encode($result);
            die;
        }

        $id = trim($post['contact_id']);
		$contact_id = $rows[0]['id'];
		if ($id != $contact_id) {
			$result['success'] = 0;
			$result['message'] = 'ID contact không đúng';
			echo json_encode($result);
			die;
		}

		$require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id !=' => 8
                )
            ),
            'class_study' => array(
				'where' => array('branch_id' => $rows[0]['branch_id']),
                'order' => array('class_study_id' => 'ASC')
            ),
            'branch' => array(),
            'notes' => array(
				'where' => array(
				    'contact_id' => $contact_id,
                    'type_note' => '0'
                ),
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
//					'parent_id' => '',
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
            'account_banking' => array()
        );

		if ($this->role_id == 10 || ($this->role_id == 12 && $post['type_modal'] == 'customer_care')) {
			$require_model = array(
				'branch' => array(),
				'language_study' => array(),
				'customer_call_status' => array(),
				'status_for_sale' => array(),
				'status_for_lecture' => array(),
				'status_for_teacher' => array(),
				'status_end_student' => array(),
				'notes' => array(
					'where' => array(
					    'contact_id' => $contact_id,
                        'role_id' => $this->role_id,
                        'type_note' => 1
                    ),
					'order' => array('time_created' => 'ASC')
				),
			);
		}

        $data = $this->_get_require_data($require_model);

        $this->load->model('level_contact_model');
        $data['level_contact_detail'] = $this->level_contact_model->load_all(array('where' => array('parent_id' => $rows[0]['level_contact_id'], 'parent_id !=' => '')));

        $data['view_edit_left'] = $left_edit;
        $data['view_edit_right'] = $right_edit;
        $edited_contact = true;

        if ($this->role_id == 1) {
            $edited_contact = $this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['level_contact_id']);
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
		$input_paid_log['where'] = array('contact_id' => $id, 'source_revenue_id !=' => 2);
//		$input_paid_log['order'] = array('time_created' => 'ASC');
		$this->load->model('paid_model');
		$paid = $this->paid_model->load_all($input_paid_log);
		if (!empty($paid)) {
			$rows[0]['paid'] = $paid[0]['paiding'];
		}

		$data['type_modal'] = $post['type_modal'];
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

        return true;
    }

    function action_edit_contact($id = 0) {
        $result = array();
        $input = array();
        $input['where'] = array('id' => trim($id));
        $rows = $this->contacts_model->load_all($input);
		
		$post = $this->input->post();

        if (empty($rows)) {
            $result['success'] = 0;
            $result['message'] = 'Không tồn tại contact này!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id == 1) { // sale && cơ sở
			if ($rows[0]['sale_staff_id'] != $this->user_id && $this->user_id != 18) {
                $result['success'] = 0;
                $result['message'] = "Contact này không được phân cho bạn, vì vậy bạn không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_sale(trim($id), $rows);
        } else if ($this->role_id == 10) { // chăm sóc khách hàng
            $this->_action_edit_by_customer_care(trim($id), $rows);
        } else if ($this->role_id == 12) {
        	if ($post['type_modal'] == 'sale') {
				$this->_action_edit_by_sale(trim($id), $rows);
			} else if ($post['type_modal'] == 'customer_care') {
				$this->_action_edit_by_customer_care(trim($id), $rows);
			}
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
            $param = array();
            $post_arr = array('name', 'phone', 'phone_foreign', 'birthday', 'email', 'gender', 'address', 'branch_id', 'language_id', 'class_study_id', 'level_student_id',
            'level_language_id', 'payment_method_rgt', 'call_status_id', 'is_old', 'complete_fee', 'level_contact_id', 'level_contact_detail');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }

            if (!empty($post['class_foreign_id'])) {
                $param['class_foreign_id'] = implode(';', $post['class_foreign_id']);
            }

            if ($post['fee'] != 0) {
				$param['fee'] = str_replace(',', '', $post['fee']);
			}

			if ($this->role_id == 12) {
				if ($param['branch_id'] == 0 || $param['language_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật cơ sở hoặc ngoại ngữ';
					echo json_encode($result);
					die;
				}
			}

			if (isset($post['level_study_id']) && !empty($post['level_study_id']) && $post['level_study_id'] != '') {
				$param['level_study_id'] = $post['level_study_id'];
				$param['date_action_of_study'] = (isset($post['date_action_of_study']) && $post['date_action_of_study'] != '') ? strtotime($post['date_action_of_study']) : '';
			}
			
			if ($post['level_student_id'] == 'L8') {
				if ($post['is_old'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Contact là học viên cũ đúng ko ?';
					echo json_encode($result);
					die;
				}
			}

            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : '';

            /* Kiểm tra điều kiện các trạng thái và ngày hẹn gọi lại có logic ko */
            if (isset($post['call_status_id']) && $post['level_student_id'] != 'L8.1') {
				if ($post['call_status_id'] == 0) {
					$result['success'] = 0;
					$result['message'] = 'Bạn phải cập nhật trạng thái cuộc gọi!';
					echo json_encode($result);
					die;
				}
				
				if ($post['call_status_id'] == _DA_LIEN_LAC_DUOC_) {
					if (isset($post['level_contact_id']) && $post['level_contact_id'] != '') {
						if ((!isset($post['level_contact_detail']) || $post['level_contact_detail'] == '') && $post['level_contact_id'] != 'L5') {
							$result['success'] = 0;
							$result['message'] = 'Bạn phải cập nhật trạng thái chi tiết contact!';
							echo json_encode($result);
							die;
						}
					}
				}
			}

            if ($this->role_id == 1 && $rows[0]['level_contact_id'] == 'L5') {
                $param['level_contact_id'] = 'L5';
                $param['level_contact_detail'] = $rows[0]['level_contact_detail'];
            }

            $check_rule = $this->_check_rule($param['call_status_id'], $param['level_contact_id'], $param['level_student_id'],  $param['date_recall']);

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

//				if (isset($post['level_student_id']) && $post['level_student_id'] == 'L6') {
//					if (!isset($post['class_study_id']) || $post['class_study_id'] == '') {
//						$result['success'] = 0;
//						$result['message'] = 'Học viên đã xếp lớp thành công thì phải có mã lớp học';
//						echo json_encode($result);
//						die;
//					}
//				}

				$dataPush['message'] = 'Yeah Yeah !!';
                $dataPush['success'] = '1';

                if ($rows[0]['sent_account_online'] == 0) {
                	$student = $this->create_new_account_student($param['name'], $param['phone'], $param['level_language_id']);
                	if ($student->success != 0) {
                		$param['sent_account_online'] = 1;
                		$param['date_active'] = time();
					}
                }

                if ($post['level_contact_detail'] != 'L5.4') {
                	$param['level_contact_detail'] = '';
				}
				
			} elseif (isset($post['date_rgt_study']) && $post['date_rgt_study'] != '' && $post['level_student_id'] != 'L8.1') {
				$result['success'] = 0;
				$result['message'] = 'Học viên đã đăng ký thì mới có ngày đăng ký học';
				echo json_encode($result);
				die;
			}

			if ($post['level_contact_id'] == 'L5' || $post['level_student_id'] == 'L8.1') {
                $param['date_rgt_study'] = (isset($post['date_rgt_study']) && $post['date_rgt_study'] != '') ? strtotime($post['date_rgt_study']) : time();
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

//			if ($this->role_id == 1) {
            $param['date_last_calling'] = time();
//			}
            $param['last_activity'] = time();
            $where = array('id' => $id);

            $this->contacts_model->update($where, $param);

			if (!empty($post['level_study_id']) && !empty($post['class_study_id']) && $post['level_study_id'] != $rows[0]['level_study_id']) {
                $this->set_log_study($id, $post['class_study_id'], $post['level_study_id'], $post['date_action_of_study']);
            }
            if ($post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time_created' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id),
					'class_study_id' => 0,
                    'type_note' => 0
                );
				
				//print_arr($param2);
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }

			if ($post['paid_today'] != 0) {
				$param_paid = array(
					'paid' => $post['paid_today'],
					'time_created' => $param['date_paid'],
					'language_id' => $post['language_id'],
					'branch_id' => $post['branch_id'],
					'day' => date('Y-m-d', $param['date_paid']),
					'student_old' => $post['is_old'],
					'source_id' => $rows[0]['source_id'],
					'payment_method_id' => $post['payment_method_rgt'],
					'account_banking_id' => (isset($post['account_banking_id'])) ? $post['account_banking_id'] : 0,
					'source_revenue_id' => 1,
				);

				$this->load->model('paid_model');
				$input_paid['where'] = array(
					'contact_id' => $id,
					'source_revenue_id' => 1,
					'time_created >=' => strtotime(date('d-m-Y'))
				);
				$paid = $this->paid_model->load_all($input_paid);

				if (empty($paid)) {
					$param_paid['contact_id'] = $id;
					$this->paid_model->insert($param_paid);
				} else {
					$this->paid_model->update($input_paid['where'], $param_paid);
				}
			}

			if ($post['paid_book'] != '') {
				$param_paid_book = array(
					'paid' => str_replace(',', '', $post['paid_book']),
					'time_created' => strtotime($post['date_paid_book']),
					'language_id' => $post['language_id'],
					'branch_id' => $post['branch_id'],
					'day' => date('Y-m-d', strtotime($post['date_paid_book'])),
					'student_old' => $post['is_old'],
					'source_id' => $rows[0]['source_id'],
					'payment_method_id' => $post['payment_method_rgt'],
					'account_banking_id' => (isset($post['account_banking_id'])) ? $post['account_banking_id'] : 0,
					'source_revenue_id' => 2,
				);

				$this->load->model('paid_model');
				$input_paid['where'] = array(
					'contact_id' => $id,
					'source_revenue_id' => 2,
					'time_created >=' => strtotime(date('d-m-Y'))
				);
				$paid = $this->paid_model->load_all($input_paid);

				if (empty($paid)) {
					$param_paid_book['contact_id'] = $id;
					$this->paid_model->insert($param_paid_book);
				} else {
					$this->paid_model->update($input_paid['where'], $param_paid_book);
				}
			}

            $this->_set_call_log($id, $post, $rows);
			
            $result['success'] = 1;
            $result['role'] = 1;
            $result['message'] = 'Chăm sóc thành công contact!';
            echo json_encode($result);

//            if (in_array($post['call_status_id'], array(1, 3, 5)) || in_array($post['level_contact_detail'], array('L1.1', 'L1.2', 'L1.3'))) {
//				$options = array(
//					'cluster' => 'ap1',
//					'encrypted' => true,
//					'useTLS' => true
//				);
//
//				$pusher = new Pusher(
//					'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
//				);
//
//				$pusher->trigger('my-channel', 'noti_to_mkt', $dataPush);
//			}
//
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
//            $pusher->trigger('my-channel', 'callLog', $dataPush);

            die;
        }
    }

    //Tạo tài khoản học viên
    public function create_new_account_student($name = '', $phone = '', $level_language_id = '') {
        $student = array();
        if ($phone != '' && $level_language_id != '') {
			$this->load->model('level_language_model');
			$contact_s = $this->level_language_model->find_course_combo($level_language_id);
			$contact = array(
				'course_code' => $contact_s,
				'name' => $name,
				'phone' => trim($phone),
				'type' => 'offline'
			);

			$student = $this->_create_account_student_offline($contact);
        }
        return $student;
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
					'role_id' => $this->role_id,
                    'type_note' => 1
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);

            $result['success'] = 1;
            $result['role'] = $this->role_id;
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
//        if ($call_status_id == '0' || $call_status_id == _SO_MAY_SAI_ || $call_status_id == _KHONG_NGHE_MAY_ || $call_status_id == _NHAM_MAY_ || $call_status_id == _KHONG_LIEN_LAC_DUOC_) {
        if (in_array($call_status_id, array(0, _SO_MAY_SAI_, _KHONG_NGHE_MAY_, _NHAM_MAY_, _KHONG_LIEN_LAC_DUOC_))) {
            if ($level_contact_id != '') {
                return false;
            }
        }

        if ($call_status_id == _DA_LIEN_LAC_DUOC_) {
        	if ($level_contact_id == '') {
				return false;
			}
        }
		
		if ($level_student != '' && $level_student != 'L8.1') {
			if (!in_array($level_contact_id, array('L5', 'L5.1', 'L5.2', 'L5.3', 'L5.4')) || $call_status_id != _DA_LIEN_LAC_DUOC_) {
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

        return true;
    }

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

		if ($this->role_id != 10) {
			$statusArr = array('call_status_id', 'level_contact_id', 'level_student_id');

		} else {
			$statusArr = array('customer_care_call_id', $rows[0]['level_contact_id'],  $rows[0]['level_student_id']);
			$strDiff = 'Chăm sóc khách hàng gọi';
		}

		foreach ($statusArr as $value) {
			if (isset($post[$value])) {
				$data[$value] = $post[$value];
			} else {
				$data[$value] = "-1";
			}
		}

        $data['content_change'] = $strDiff;
        $this->load->model('call_log_model');
        $this->call_log_model->insert($data);
    }

    protected function set_log_study($contact_id, $class_study_id, $level_study_id, $date_L7) {
        $this->load->model('log_study_model');
        $input_contact['where'] = array('contact_id' => $contact_id);
        $input['where'] = array(
            'contact_id' => $contact_id,
            'class_study_id' => $class_study_id,
            'level_study_id' => $level_study_id,
        );
        if (!count($this->log_study_model->load_all($input))) {
            $param = $input['where'];
            $param['time_created'] = strtotime($date_L7);
            $this->log_study_model->insert($param);
        }
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
            'level_contact' => array(),
			'level_language' => array(),
			'branch' => array(),
			'language_study' => array()
        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $contact_id = $this->input->post('contact_id', true);
        $contact_phone = $this->contacts_model->get_contact_phone($contact_id);

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         */
        $conditional['where'] = array('phone' => $contact_phone);
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, 0, 0);

        /*Lấy link phân trang và danh sách contacts*/
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        /*Các trường cần hiện của bảng contact (đã có default)*/
        $this->table .= 'class_study_id fee paid call_stt level_contact date_rgt';
        $data['table'] = explode(' ', $this->table);
        $data['controller'] = $this->input->post('controller', true);
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_all_contact_course', $data, true);
        echo json_encode($result);
        die;
    }
	
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
			
			$class = array();
			if ($contact[0]['class_study_id'] != '') {
				$input_class['where'] = array('class_study_id' => $contact[0]['class_study_id']);
				$class = $this->class_study_model->load_all($input_class);
				//print_arr($class);
			}
			
			$course = $this->level_language_model->get_name_level_language($contact[0]['level_language_id']);
			$day = $time = '';
			if (!empty($class)) {
				$day = $this->day_model->get_day($class[0]['day_id']);
				$time = $this->time_model->get_time($class[0]['time_id']);
			}
			//print_arr($day);
			
            $columnName = 'A';
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, html_entity_decode($contact[0]['name']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, html_entity_decode($contact[0]['address']));
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['fee']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $course);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, (!empty($class)) ? $class[0]['total_lesson'] : 0);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $contact[0]['class_study_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, 0);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $time);
            $objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $day);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, (!empty($class)) ? date('d/m/Y', $class[0]['time_start']) : 0);
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

    public function get_level_contact() {
    	$post = $this->input->post();
		$input['where'] = array(
			'parent_id' => $post['level_id'],
			'active' => 1
		);
    	if (in_array($post['level_id'], array('L1', 'L2', 'L3', 'L4', 'L5'))) {
			$this->load->model('level_contact_model');
			$chil_level = $this->level_contact_model->load_all($input);
			$name = "level_contact_detail";
		}
//    	else if ($post['level_id'] == 'L7') {
//			$this->load->model('level_study_model');
//			$chil_level = $this->level_study_model->load_all($input);
//			$name = "level_study_detail";
//		}
//    	else if (in_array($post['level_id'], array('L6', 'L8'))) {
//			$this->load->model('level_student_model');
//			$chil_level = $this->level_student_model->load_all($input);
//			$name = "level_student_detail";
//		}
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

	public function get_data_ajax() {
		$post = $this->input->post();
		if ($post['type'] == 'language') {
			$input['where']['language_id'] = $post['level_id'];
			$this->load->model('level_language_model');
			$level_language = $this->level_language_model->load_all($input);

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
						<select class="form-control class_study_select" name="class_study_id">
							<option value=""> Chọn lớp học </option>';
				foreach ($class as $value) {
					$str .= "<option value='{$value['class_study_id']}'> {$value['class_study_id']} </option>";
				}
				$str .= '</select>
						<div class="input-group-btn">
							<a style="padding: 8px;" target="_blank" href="' . base_url('staff_managers/class_study') . '" class="btn btn-success" >Tạo mã lớp</a>
						</div>
					</div>
				</td>
				<script>
						$(document).ready(function() {
							$(".class_study_select").select2({
								width: "100%",
							});
						});
					</script>
				';
				echo $str;
			} else {
				echo '<td class="text-right"></td>';
			}
		} elseif ($post['type'] == 'payment_method_rgt' && $post['level_id'] == 4) {
			$this->load->model('account_banking_model');
			$account_banking = $this->account_banking_model->load_all(array());

			if (isset($account_banking) && !empty($account_banking)) {
				$str = '<td class="text-right">
					Thông tin tài khoản
				</td>
				<td>
					<select class="form-control selectpicker" name="account_banking_id">
						<option value=""> Thông tin tài khoản </option>';
				foreach ($account_banking as $value) {
					$str .= "<option value='{$value['id']}'> {$value['infor_banking']} </option>";
				}
				$str .= '</select>
						</td>';
				echo $str;
			} else {
				echo '<td class="text-right"></td>';
			}
		}
	}

	public function delete_common() {
        $post = $this->input->post();

        $result = array();
        if (!empty($post)) {
            if ($post['type_delete'] == 'paid') {
                $this->load->model('paid_model');
                $this->paid_model->delete(array('id' => $post['delete_id']));

                $result['success'] = true;
                $result['message'] = 'Xóa thành công';
            } elseif ($post['type_delete'] == 'spend') {
                $this->load->model('spending_model');
                $this->spending_model->delete(array('id' => $post['delete_id']));

                $result['success'] = true;
                $result['message'] = 'Xóa thành công';
            } elseif ($post['type_delete'] == 'refund' || $post['type_delete'] == 'cost_branch') {
                $this->load->model('cost_branch_model');
                $this->cost_branch_model->delete(array('id' => $post['delete_id']));

                $result['success'] = true;
                $result['message'] = 'Xóa thành công';
            } elseif ($post['type_delete'] == 'order_teacher') {
                $this->load->model('order_teacher_abroad_model');
                $this->order_teacher_abroad_model->delete(array('id' => $post['delete_id']));

                $result['success'] = true;
                $result['message'] = 'Xóa thành công';
            } elseif ($post['type_delete'] == 'salary_staff') {
				$this->load->model('salary_staff_model');
				$this->salary_staff_model->delete(array('id' => $post['delete_id']));

				$result['success'] = true;
				$result['message'] = 'Xóa thành công';
			}
        } else {
            $result['success'] = false;
            $result['message'] = 'Xóa không thành công';
        }

        echo json_encode($result);
    }

}
