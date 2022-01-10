<?php

class Student extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}

	private function get_all_require_data() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1,
					'transfer_contact' => 1
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
            'language_study' => array(),
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
            'character_class' => array(),
            'status_for_lecture' => array(),
            'status_for_teacher' => array(),
            'status_end_student' => array(),
            'customer_call_status' => array()
		);
		return array_merge($this->data, $this->_get_require_data($require_model));
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

		$data['left_col'] = array('date_rgt', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
		$data['right_col'] = array('language', 'level_language', 'class_study', 'is_old', 'complete_fee', 'payment_method_rgt');

		$this->table .= 'class_study_id fee paid level_contact level_student date_rgt date_rgt_study';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['titleListContact'] = 'Danh sách học viên';
		$data['actionForm'] = '';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

    public function contact_reserve($offset=0) {
        $data = $this->get_all_require_data();

        $get = $this->input->get();

        if ($this->role_id == 12) {
            $conditional['where']['branch_id'] = $this->branch_id;
        }

        $conditional['where']['level_study_id'] = 'L7.1';
        $conditional['or_where']['level_study_detail'] = 'L7.1';
        $conditional['order'] = array('date_action_of_study' => 'DESC');

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $data['left_col'] = array('date_rgt', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
        $data['right_col'] = array('language', 'class_study', 'complete_fee');

        $this->table .= 'class_study_id fee paid date_rgt date_rgt_study date_action_of_study';
        $data['table'] = explode(' ', $this->table);
        //echo '<pre>'; print_r($data['table']);die;

        $data['titleListContact'] = 'Danh sách học viên';
        $data['actionForm'] = '';

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function contact_refund($offset=0) {
        $data = $this->get_all_require_data();

        $get = $this->input->get();

        if ($this->role_id == 12) {
            $conditional['where']['branch_id'] = $this->branch_id;
        }

        $conditional['where']['level_contact_detail'] = 'L5.4';
        $conditional['order'] = array('date_rgt_study' => 'DESC');

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $data['left_col'] = array('date_rgt', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
        $data['right_col'] = array('language', 'class_study', 'is_old', 'complete_fee');

        $this->table .= 'class_study_id fee paid date_rgt date_rgt_study';
        $data['table'] = explode(' ', $this->table);
        //echo '<pre>'; print_r($data['table']);die;

        $data['titleListContact'] = 'Danh sách học viên';
        $data['actionForm'] = '';

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

	function contact_sort_class($offset = 0) {
		$data = $this->get_all_require_data();
		$branch_id = $this->session->userdata('branch_id');
		$role_id =  $this->session->userdata('role_id');

		$get = $this->input->get();

		if ($role_id == 12) {
			$conditional['where']['branch_id'] = $branch_id;
		}

		$conditional['where']['level_contact_id'] = 'L5';
		$conditional['where']['level_contact_detail '] = 'L5.4';
		$conditional['where']['class_study_id !='] = '';
		$conditional['order'] = array('date_rgt_study' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$data['left_col'] = array('character_class', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
		$data['right_col'] = array('language', 'class_study', 'is_old', 'complete_fee');

		$this->table .= 'class_study_id fee paid level_contact level_student date_rgt_study';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['titleListContact'] = 'Danh sách học viên';
		$data['actionForm'] = '';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function contact_unsort_class($offset = 0) {
		$data = $this->get_all_require_data();
		$branch_id = $this->session->userdata('branch_id');
		$role_id =  $this->session->userdata('role_id');

		$get = $this->input->get();

		if ($role_id == 12) {
			$conditional['where']['branch_id'] = $branch_id;
		}

		$conditional['where']['level_contact_id'] = 'L5';
		$conditional['where']['level_contact_detail !='] = 'L5.4';
		$conditional['where']['class_study_id'] = '';
		$conditional['order'] = array('date_rgt_study' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$data['left_col'] = array('date_recall', 'date_rgt_study', 'study_date_start', 'study_date_end');
		$data['right_col'] = array('language', 'is_old', 'complete_fee');

		$this->table .= 'class_study_id fee paid level_contact level_student date_rgt_study';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

		$data['titleListContact'] = 'Danh sách học viên';
		$data['actionForm'] = '';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

    public function contact_truant($offset=0) {
        $this->load->model('attendance_model');

        $data = $this->get_all_require_data();

        $get = $this->input->get();

        $input['select'] = 'DISTINCT(contact_id)';
        $input['where'] = array('presence_id' => 3);
        if (isset($get['filter_date_date_happen']) && !empty($get['filter_date_date_happen'])) {
            $time = $get['filter_date_date_happen'];
            $dateArr = explode('-', $time);
            $date_from_arr = trim($dateArr[0]);
            $date_from = strtotime(str_replace("/", "-", $date_from_arr));
            $date_end_arr = trim($dateArr[1]);
            $date_end = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24 - 1;

            $input['where']['time_created >='] = $date_from;
            $input['where']['time_created <='] = $date_end;
        }

        $contact_id_arr = $this->attendance_model->load_all($input);
        foreach ($contact_id_arr as $item) {
            $contact_id[] = $item['contact_id'];
        }
        unset($get['filter_date_date_happen']);
        $conditional['where_in']['id'] = $contact_id;
        if ($this->role_id == 12) {
            $conditional['where']['branch_id'] = $this->branch_id;
        }
        $conditional['order'] = array('date_rgt_study' => 'DESC');

        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        $data['left_col'] = array('date_happen_1', 'date_rgt', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
        $data['right_col'] = array('language', 'class_study', 'is_old', 'complete_fee');

        $this->table .= 'class_study_id fee paid date_rgt date_rgt_study';
        $data['table'] = explode(' ', $this->table);
        //echo '<pre>'; print_r($data['table']);die;

        $data['titleListContact'] = 'Danh sách học viên';
        $data['actionForm'] = '';

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
	
	function view_all_contact($offset = 0) {
        $data = $this->get_all_require_data();
		
        $get = $this->input->get();
        $conditional['where'] = array('branch_id' => $this->session->userdata('branch_id'));
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

		$data['staff_care_branch'] = $this->staffs_model->load_all(array('where'=>array('role' => 12, 'active' => 1)));
		
		$data['progress'] = $this->GetProccessThisMonth();
		$data['progressType'] = 'Doanh thu tại cơ sở tháng này';

        $data['left_col'] = array('is_old', 'staff_care_branch', 'date_rgt', 'date_handover', 'date_recall', 'date_confirm', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end', 'date_recall_customer_care', 'date_customer_care_call');
        $data['right_col'] = array('language', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_study', 'payment_method_rgt', 'customer_care_call_stt', 'status_lecture', 'status_teacher', 'status_end_student');

        $this->table .= 'fee paid call_stt level_contact date_rgt date_last_calling';
        $data['table'] = explode(' ', $this->table);
		
        $data['titleListContact'] = 'Danh sách toàn bộ contact';
		$data['actionForm'] = '';

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function merge_contact() {
		$post = $this->input->post();
		$input = array();
		$input['select'] = 'id, phone';
		$input['where'] = array('phone' => trim($post['phone_merger']));
		$contact_merger = $this->contacts_model->load_all($input);

		$input_contact['where'] = array('id' => trim($post['contact_id']));
		$contact = $this->contacts_model->load_all($input_contact);

		if (!empty($contact_merger)) {
			if ($post['keep_contact'] == 0) {
				$where_infor = array('contact_id' => $contact_merger[0]['id']);
				$data = array('contact_id' => $post['contact_id']);

				$this->load->model('paid_model');
				$this->paid_model->update($where_infor, $data);
				$this->load->model('notes_model');
				$this->notes_model->update($where_infor, $data);

				$this->contacts_model->update(array('id' => $post['contact_id']), array('phone_foreign' => $post['phone_merger']));
				$this->contacts_model->delete(array('id' => $contact_merger[0]['id']));
			} elseif ($post['keep_contact'] == 1) {
				$where_infor = array('contact_id' => $post['contact_id']);
				$data = array('contact_id' => $contact_merger[0]['id']);

				$this->load->model('paid_model');
				$this->paid_model->update($where_infor, $data);
				$this->load->model('notes_model');
				$this->notes_model->update($where_infor, $data);

				$this->contacts_model->update(array('id' => $post['contact_id']), array('phone_foreign' => $contact[0]['phone']));

				$this->contacts_model->delete(array('id' => $post['contact_id']));
			}

			$param = array();
			$param['contact_id'] = $post['contact_id'];
			$param['staff_id'] = $this->user_id;
			$param['content_change'] = 'Ghép contact - ' . $post['phone_merger'];
			$param['time_created'] = time();
			$this->load->model('call_log_model');
			$this->call_log_model->insert($param);

			$msg = 'Đã ghép contact thành công contact với sđt - ' . $post['phone_merger'];
		} else {
			$msg = 'SĐT được ghép ko tồn tại thông tin nào';
		}

		show_error_and_redirect($msg, $_SERVER['HTTP_REFERER'], false);
	}

	public function cost_branch() {
		$this->load->model('branch_model');
		$this->load->model('cost_branch_model');

		$require_model = array(
		    'branch' => array()
        );
		$data = $this->_get_require_data($require_model);

		$get = $this->input->get();

		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$date_from_arr = trim($dateArr[0]);
		$date_from = strtotime(str_replace("/", "-", $date_from_arr));
		$date_end_arr = trim($dateArr[1]);
		$date_end = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24 - 1;

		$input = array();
		$input['where'] = array(
			'day_cost >=' => $date_from,
			'day_cost <=' => $date_end,
			'branch_id' => $this->branch_id
		);
        $input['limit'] = array(60, 0);

//		if (isset($get['filter_number_records'])) {
//			$input['limit'] = array($get['filter_number_records']);
//		} else {
//			$input['limit'] = array(10);
//		}

		if ($this->role_id != 12) {
			unset($input['where']['branch_id']);
			if (isset($get['filter_branch_id']) && !empty($get['filter_branch_id'])) {
				$input['where_in']['branch_id'] = $get['filter_branch_id'];
			}
			$branch = $this->branch_model->load_all();
			unset($branch[8]);
			$data['branch'] = $branch;
		} else {
			$branch[] = array('id' => $this->branch_id, 'name' => $this->branch_model->find_branch_name($this->branch_id));
		}
		$input['order']['day_cost'] = 'desc';

		$cost = $this->cost_branch_model->load_all($input);

		$total_cost = 0;
		foreach ($cost as &$item) {
			$item['branch_name'] = $this->branch_model->find_branch_name($item['branch_id']);
			$item['user_name'] = $this->staffs_model->find_staff_name($item['user_id']);
			$total_cost += $item['cost'];
		}
		unset($item);

		$post = $this->input->post();
		if (isset($post) && !empty($post)) {
			$param['cost'] = str_replace(',', '', $post['cost']);
			$param['content_cost'] = $post['content_cost'];
			$param['revenue_cost'] = (isset($post['revenue_cost'])) ? $post['revenue_cost'] : 0;
			$param['paid_status'] = (isset($post['paid_status'])) ? $post['paid_status'] : 0;
			$param['day_cost'] = strtotime(str_replace("/", "-", $post['day_cost']));
			$param['time_created'] = time();
			$param['branch_id'] = (empty($post['branch_id'])) ? $this->branch_id : $post['branch_id'];
			$param['user_id'] = $this->user_id;
			$param['day'] = date('d-m-Y', strtotime($post['day_cost']));
			$param['bank'] = $post['bank'];

			$this->cost_branch_model->insert($param);
			redirect(base_url('student/cost_branch'));
		}

		$date_for_report = $this->display_date($date_from_arr, $date_end_arr);

		$report_cost = array();
		$report_revenue = array();
		foreach ($date_for_report as $value_date) {
			foreach ($branch as $value_branch) {
				$input_report['select'] = 'SUM(cost) AS COST';
				$input_report['where'] = array(
					'day' => $value_date,
					'branch_id' => $value_branch['id'],
				);
				if (isset($input['where_in'])) {
					$input_report['where_in'] = $input['where_in'];
				}

				$input_cost = array_merge_recursive($input_report, array('where' => array('revenue_cost' => '0')));
				$input_revenue = array_merge_recursive($input_report, array('where' => array('revenue_cost' => 1, 'paid_status' => 1)));

				$cost_day = $this->cost_branch_model->load_all($input_cost);
				if (!empty($cost_day)) {
					$report_cost[$value_branch['name']]['total'] += $cost_day[0]['COST'];
					$report_cost[$value_branch['name']][$value_date] = $cost_day[0]['COST'];
				}

				$revenue_day = $this->cost_branch_model->load_all($input_revenue);
				if (!empty($revenue_day)) {
					$report_revenue[$value_branch['name']]['total'] += $revenue_day[0]['COST'];
					$report_revenue[$value_branch['name']][$value_date] = $revenue_day[0]['COST'];
				}
			}
		}

		$data['cost'] = $cost;
		$data['report_cost'] = $report_cost;
		$data['report_revenue'] = $report_revenue;
		$data['date'] = array_reverse($date_for_report);
		$data['total_cost'] = str_replace(',', '.', number_format($total_cost));
		$data['startDate'] = isset($date_from) ? $date_from : '0';
		$data['endDate'] = isset($date_end) ? $date_end : '0';
		$data['left_col'] = array('date_happen_1', 'branch');
		$data['content'] = 'student/cost_branch';
		//echo '<pre>';print_r($data);die();

		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function paid_cost_branch() {
	    $this->load->model('cost_branch_model');
	    $post = $this->input->post();
        $result = array();

        if (!empty($post)) {
	        $where = array('id' => $post['cost_id']);
	        $param['paid_status'] = 1;

	        $this->cost_branch_model->update($where, $param);

            $result['success'] = true;
        } else {
	        $result['success'] = false;
	        $result['message'] = 'Có lỗi xảy ra';
        }

        echo json_encode($result);
    }

	public function chose_branch() {
		$data = $this->data;
		$this->load->model('branch_model');
		$data['branch'] = $this->branch_model->load_all();
		unset($data['branch'][8]);
//		print_arr($data);
		$data['content'] = 'student/chose_branch';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function chose_language() {
		$get = $this->input->get();
		$data = $this->data;
		$this->load->model('language_study_model');
		$input['where'] = array(
			'active' => 1,
			'out_report' => '0'
		);
		$data['language'] = $this->language_study_model->load_all($input);
		$data['branch_id'] = $get['branch_id'];
		$data['content'] = 'student/chose_language';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function get_class_attendance() {
		$get = $this->input->get();
		$this->load->model('class_study_model');
		$this->load->model('teacher_model');
		$this->load->model('level_language_model');
//		$input['where'] = array(
//			'branch_id' => $get['branch_id'],
//			'language_id' => $get['language_id'],
//			'character_class_id' => 2
//		);

        $input['where']['teacher_id'] = $this->session->userdata('teacher_id');
        $input['or_where']['teacher_id_2'] =  $this->session->userdata('teacher_id');
        $input['where']['character_class_id'] = 2;

        if (isset($get['search_class']) && $get['search_class'] != '') {
            $input = array();
            $input['like']['class_study_id'] = trim($get['search_class']);
        }

		$data['class'] = $this->class_study_model->load_all($input);
		foreach ($data['class'] as &$value) {
			$value['teacher_name'] = $this->teacher_model->find_teacher_name($value['teacher_id']);
			$value['level_language_name'] = $this->level_language_model->get_name_level_language($value['level_language_id']);
		}
		unset($value);

		$data['branch_id'] = $get['branch_id'];
		$data['language_id'] = $get['language_id'];
		$data['content'] = 'student/get_class_attendance';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function attendance_class() {
		$this->load->model('attendance_model');
		$this->load->model('class_study_model');
		$get = $this->input->get();
		$input['select'] = 'id, name, class_study_id';
		$input['where'] = array(
			'class_study_id' => $get['class_study_id'],
            '(level_contact_id = "L5" OR level_student_id = "L8.1")' => 'NO-VALUE',
			'level_contact_detail !=' => 'L5.4',
		);
        $input['where_not_in']['level_study_id'] = array('L7.1', 'L7.2', 'L7.3');

        $data['contact'] = $this->contacts_model->load_all($input);
		$input_class['select'] = 'lesson_learned';
		$input_class['where'] = array('class_study_id' => $get['class_study_id']);
        $class = $this->class_study_model->load_all($input_class);
        $lesson_learned = $class[0]['lesson_learned'] + 1;

        $lecture = '';
		if (!empty($data['contact'])) {
			foreach ($data['contact'] as &$value) {
				$input_attend = array();
				$input_attend['where'] = array(
					'contact_id' => $value['id'],
					'time_update >=' => strtotime(date('d-m-Y'))
				);
				$contact_attend = $this->attendance_model->load_all($input_attend);
				if (!empty($contact_attend)) {
					$value['presence_id'] = $contact_attend[0]['presence_id'];
					$value['time_update'] = $contact_attend[0]['time_update'];
					$value['note'] = $contact_attend[0]['note'];
					$lesson_learned = $contact_attend[0]['lesson_learned'];
					$lecture = $contact_attend[0]['lecture'];
				}
			}
			unset($value);
		}

		$data['class'] = $get['class_study_id'];
		$data['lesson_learned'] = $lesson_learned;
		$data['lecture'] = $lecture;
		$data['content'] = 'student/attendance_class';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function action_attendance() {
		$this->load->model('attendance_model');
		$this->load->model('class_study_model');
		$post = $this->input->post();
		$result = array();

        $input_class['where'] = array('class_study_id' => $post['class_study_id']);
        $class = $this->class_study_model->load_all($input_class);

        if (empty($class)) {
            $result['good'] = 0;
            $result['message'] = 'không có mã lớp';
            echo json_encode($result);
            die();
        } else {
            if ($post['lesson_learned'] > $class[0]['lesson_learned']) {
                $data_class['lesson_learned'] = $post['lesson_learned'];
                $data_class['lecture'] = $post['lecture'];
                $this->class_study_model->update($input_class['where'], $data_class);
            }
            if ($post['lesson_learned'] > $class[0]['total_lesson']) {
                $result['good'] = 0;
                $result['message'] = 'Số buổi học đã quá tổng số buổi của khóa học';
                echo json_encode($result);
                die();
            } elseif ($post['lesson_learned'] == $class[0]['total_lesson']) {
                $data_class = array();
                $data_class['time_end_real'] = strtotime(date('d-m-Y'));
                $data_class['character_class_id'] = 3;
                $this->class_study_model->update($input_class['where'], $data_class);

                $data = json_decode($post['data_attendance']);
                if (!empty($data)) {
                    foreach ($data as $item) {
                        $where_contact = array('id' => $item->contact_id);
                        $param_contact = array(
                            'level_study_id' => 'L7.4',
                            'date_action_of_study' => time()
                        );
                        $this->contacts_model->update($where_contact, $param_contact);
                    }
                }
            }
        }

		$data = json_decode($post['data_attendance']);
		if (!empty($data)) {
			foreach ($data as $item) {
				$input_attend = array();
				$input_attend['where'] = array(
					'contact_id' => $item->contact_id,
					'time_update >=' => strtotime(date('d-m-Y'))
				);

				$contact_attend = $this->attendance_model->load_all($input_attend);

				$param = array(
					'class_study_id' => $item->class_id,
					'contact_id' => $item->contact_id,
					'presence_id' => $item->presence_id,
					'time_update' => strtotime(date("d-m-Y H:i")),
					'note' => $item->note,
					'lesson_learned' => trim($post['lesson_learned']),
					'lecture' => $post['lecture'],
					'score' => $post['score'],
                    'speaker' => $post['speaker'],
                    'teacher_id' => $this->session->userdata('teacher_id')
				);

//				$param['time_update'] = $param['time_created'] = (isset($post['date_diligence']) && $post['date_diligence'] != '') ? strtotime($post['date_diligence']) : strtotime(date("d-m-Y H:i"));
//				$this->attendance_model->insert($param);

                if (empty($contact_attend)) {
                    $param['time_created'] = (isset($post['date_diligence']) && $post['date_diligence'] != '') ? strtotime($post['date_diligence']) : strtotime(date("d-m-Y H:i"));
                    $this->attendance_model->insert($param);
				} else {
					$this->attendance_model->update($input_attend['where'], $param);
				}
			}

			$result['good'] = true;
			$result['message'] = 'Điểm danh thành công';

		} else {
			$result['good'] = false;
			$result['message'] = 'Chưa chọn trạng thái học viên đi học hay nghỉ';
		}

		echo json_encode($result);
		die();
	}

	public function check_diligence() {
		$this->load->model('attendance_model');
		$this->load->model('presence_model');
		$post = $this->input->post();

		$data['presence'] = $this->presence_model->load_all(array());

		$input['select'] = 'name, phone, class_study_id';
		$input['where'] = array('id' => $post['contact_id']);
		$input_diligence['where'] = array('contact_id' => $post['contact_id']);
		$data['diligence'] = $this->attendance_model->load_all($input_diligence);

		$data_pagination = $this->_query_all_from_get(array(), $input, 50, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['total_contact'] = $data_pagination['total_row'];

		$contact_arr = [];
		if (!empty($data['diligence'])) {
			foreach ($data['diligence'] as $item) {
				$contact_arr[] = array_merge($data_pagination['data'][0], $item);
			}
		}

		$data['contacts'] = $contact_arr;

		$this->table = 'name phone presence lesson_learned time_created';
		$data['table'] = explode(' ', $this->table);
		$this->load->view('common/content/tbl_contact', $data);
	}
	
	public function manager_diligence() {
		$this->load->model('attendance_model');
		$this->load->model('class_study_model');

		$data['class_study'] = $this->class_study_model->load_all(array('where_in'=>array('character_class_id' => array(2, 3))));
		$get = $this->input->get();
		$input['select'] = 'DISTINCT(lesson_learned), class_study_id, lecture, time_update, speaker';
        $input['where'] = array();
		$input['order'] = array('lesson_learned' => 'DESC');
        $input['limit'] = array(60, 0);

        if (isset($get['class_study_id']) && $get['class_study_id'] != '') {
            $input['where'] = array('class_study_id' => $get['class_study_id']);
        }
        if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
            $dateArr = explode('-', $get['filter_date_date_happen']);
            $date_from_arr = trim($dateArr[0]);
            $date_from = strtotime(str_replace("/", "-", $date_from_arr));
            $date_end_arr = trim($dateArr[1]);
            $date_end = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24 - 1;

            $input['where']['time_update >='] = $date_from;
            $input['where']['time_update <='] = $date_end;
        }
        if (isset($get['filter_class_study_id']) && $get['filter_class_study_id'] != '') {
            $input['where_in'] = array('class_study_id' => $get['filter_class_study_id']);
        }

        $data['list_diligence'] = $this->attendance_model->load_all($input);
//        echoQuery(); die();
        $data['left_col'] = array('date_happen_1', 'class_study');
        $data['content'] = 'student/manager_diligence';
		$this->load->view(_MAIN_LAYOUT_, $data);

	}
	
	public function check_diligence_class() {
		$this->load->model('attendance_model');
		$this->load->model('presence_model');
		$data['presence'] = $this->presence_model->load_all(array());
		
		$get = $this->input->get();
		$input['where'] = array(
			'class_study_id' => $get['class_study_id'],
			'time_update' => $get['time_update']
		);
		$data['list_diligence_detail'] = $this->attendance_model->load_all($input);
		foreach($data['list_diligence_detail'] as &$item) {
			$item['contact_name'] = $this->contacts_model->get_contact_name($item['contact_id']);
		}

        $data['content'] = 'student/check_diligence_class';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

}
