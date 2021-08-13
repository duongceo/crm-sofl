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
			'level_language' => array(),
			'language_study' => array(),
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
			'character_class' => array()
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

		$data['left_col'] = array('date_rgt', 'date_confirm', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
		$data['right_col'] = array('language', 'class_study', 'is_old', 'complete_fee', 'payment_method_rgt');

		$this->table .= 'class_study_id fee paid level_contact level_student date_rgt date_rgt_study';
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

		$conditional['where']['level_student_id'] = 'L6';
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
		
		$data['progress'] = $this->GetProccessThisMonth();
		$data['progressType'] = 'Doanh thu tại cơ sở tháng này';

        $data['left_col'] = array('is_old', 'date_rgt', 'date_handover', 'date_recall', 'date_confirm', 'date_rgt_study', 'date_paid', 'study_date_start', 'study_date_end');
        $data['right_col'] = array('language', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail', 'payment_method_rgt');

        $this->table .= 'fee paid call_stt level_contact date_rgt date_last_calling';
        $data['table'] = explode(' ', $this->table);
		
        $data['titleListContact'] = 'Danh sách toàn bộ contact';
		$data['actionForm'] = '';

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function merge_contact() {
		$post = $this->input->post();
		print_arr($post);

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

//		if (isset($get['filter_number_records'])) {
//			$input['limit'] = array($get['filter_number_records']);
//		} else {
//			$input['limit'] = array(10);
//		}
		if ($this->role_id != 12) {
			unset($input['where']['branch_id']);
			if (isset($get['filter_branch_id'])) {
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
			$total_cost += $item['cost'];
		}
		unset($item);

		$post = $this->input->post();
		if (isset($post) && !empty($post)) {
			$param['cost'] = $post['cost'];
			$param['content_cost'] = $post['content_cost'];
			$param['revenue_cost'] = (isset($post['revenue_cost'])) ? $post['revenue_cost'] : 0;
			$param['day_cost'] = strtotime(str_replace("/", "-", $post['day_cost']));
			$param['time_created'] = time();
			$param['branch_id'] = $this->branch_id;
			$param['user_id'] = $this->user_id;
			$param['day'] = date('d-m-Y', strtotime($post['day_cost']));
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
				$input_revenue = array_merge_recursive($input_report, array('where' => array('revenue_cost' => 1)));

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
		$post = $this->input->post();
		$this->load->model('class_study_model');
		$this->load->model('teacher_model');
		$this->load->model('level_language_model');
		$input['where'] = array(
			'active' => 1,
			'branch_id' => $get['branch_id'],
			'language_id' => $get['language_id'],
			'character_class_id' => 2
		);

		if (isset($post) && $post['search_class'] != '') {
			$input['where']['(class_study_id LIKE "%'.$post['search_class'].'%")'] = 'NO-VALUE';
			$input['where']['branch_id'] = $post['branch_id'];
			$input['where']['language_id'] = $post['language_id'];
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
			'level_contact_id' => 'L5',
		);

		$input['where_not_in']['level_study_detail'] = array('L7.1', 'L7.2', 'L7.3', 'L7.4', 'L7.5');
		$input['where_not_in']['level_study_id'] = array('L7.1', 'L7.2', 'L7.3', 'L7.4', 'L7.5');
		$data['contact'] = $this->contacts_model->load_all($input);

		$input_class['where'] = array('class_study_id' => $get['class_study_id']);
		$class = $this->class_study_model->load_all($input_class);

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
				}
			}
			unset($value);
		}

		$data['class'] = $get['class_study_id'];
		$data['lesson_learned'] = $class[0]['lesson_learned'];
		$data['content'] = 'student/attendance_class';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function action_attendance() {
		$this->load->model('attendance_model');
		$this->load->model('class_study_model');
		$post = $this->input->post();
		$result = array();

//		print_arr($post);
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
					'time_update' => time(),
					'note' => $item->note,
					'lesson_learned' => $post['lesson_learned']
				);

				if (empty($contact_attend)) {
					$param['time_created'] = time();
					$this->attendance_model->insert($param);
				} else {
					$this->attendance_model->update($input_attend['where'], $param);
				}

				$class_id = $item->class_id;
			}

			$where_class = array('class_study_id' => $class_id);
			$data_class['lesson_learned'] = $post['lesson_learned'];

			$this->class_study_model->update($where_class, $data_class);

			$result['good'] = 1;
			$result['message'] = 'Điểm danh thành công';

		} else {
			$result['good'] = 0;
			$result['message'] = 'Điểm Không thành công';
		}

		echo json_encode($result);
		die();
	}

	public function check_diligence() {
		$post = $this->input->post();
	}

}
