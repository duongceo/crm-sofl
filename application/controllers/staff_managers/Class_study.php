<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Class_study extends MY_Table {

	public function __construct() {
		parent::__construct();
		$this->init();
	}

	public function delete_item(){
		redirect_and_die('Không được xóa!');
	}

	public function delete_multi_item(){
		redirect_and_die('Không được xóa!');
	}

	public function init() {
		$this->controller_path = 'staff_managers/class_study';
		$this->view_path = 'staff_managers/class_study';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'class_study_id' => array(
				'name_display' => 'Mã lớp học',
			),

//			'class_time_id' => array(
//				'type' => 'custom',
//				'value' => $this->get_data_from_model('class_time', 'show'),
//				'name_display' => 'Phòng & Ca học',
//			),
			'classroom_id' => array(
				'name_display' => 'Phòng học',
			),
			'language_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('language_study'),
				'name_display' => 'Ngoại ngữ',
			),
//			'fee' => array(
//				'type' => 'currency',
//				'name_display' => 'Học phí',
//			),

			'level_language_id' => array(
				'type' => 'custom',
				'name_display' => 'Trình độ',
			),

			'number_student_max' => array(
				'name_display' => 'Số lượng học viên tối đa',
			),
			'number_student' => array(
				'name_display' => 'Số lượng học viên hiện tại',
			),
			'time_start' => array(
				'type' => 'datetime',
				'name_display' => 'Thời gian bắt đầu',
			),
			'time_end_expected' => array(
				'type' => 'datetime',
				'name_display' => 'Thời gian dự kiến kết thúc',
			),
			'time_end_real' => array(
				'type' => 'datetime',
				'name_display' => 'Thời gian kết thúc thật',
			),
			'teacher_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('teacher'),
				'name_display' => 'Giảng viên'
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động ?'
			)
		);
		$this->set_list_view($list_view);
		$this->set_model('class_study_model');
		$this->load->model('class_study_model');
	}

	public function index($offset = 0) {
		$conditional = array();
		if ($this->session->userdata('role_id') == 12) {
			$branh_id = $this->session->userdata('branch_id');
			$this->load->model('classroom_model');
			$input['where'] = array(
				'branch_id' => $branh_id,
				'active' => 1
			);
			$classroom = $this->classroom_model->load_all($input);
			if (isset($classroom)) {
				foreach ($classroom as $value) {
					$classroom_id[] = $value['classroom_id'];
				}
			}
			$conditional['where_in']['classroom_id'] = $classroom_id;
		}
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();

		$data = $this->data;

//		$data = $this->_get_all_require_data();
//		echo '<pre>';print_r($data);die();


//		$data['slide_menu'] = 'cod/common/slide-menu';
//		if($this->role_id == 1){
//			$data['top_nav'] = 'sale/common/top-nav';
//			$data['slide_menu'] = 'sale/common/slide-menu';
//		}

		$data['list_title'] = 'Lớp học';
		$data['edit_title'] = 'Sửa thông tin lớp học';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->list_add = array(
			'left_table' => array(
				'class_study_id' => array(),
				'classroom_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('classroom')
				),
//				'fee' => array(),
//				'class_time_id' => array(
//					'type' => 'array',
//					'value' => $this->get_data_from_model('class_time')
//				),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
				'level_language_id' => array(
					'type' => 'custom'
				),
				'number_student_max' => array(),
				'number_student' => array(),
			),

			'right_table' => array(
				'teacher_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('teacher')
				),
				'time_start' => array(
					'type' => 'datetime'
				),
				'time_end_expected' => array(
					'type' => 'datetime'
				),
				'time_end_real' => array(
					'type' => 'datetime'
				),
				'active' => array(
					'type' => 'active'
				),
			),
		);

		parent::show_add_item();
//		$this->load->view('base/add_item/ajax_content');
	}

	function action_add_item() {

		$post = $this->input->post();

		if (!empty($post)) {

			$post['add_class_study_id'] = $this->replace_str_to_url($post['add_class_study_id']);

			if ($this->{$this->model}->check_exists(array('class_study_id' => $post['add_class_study_id']))) {
				redirect_and_die('Mã lớp học này đã tồn tại!');
			}

//			if ($post['add_active'] != '0' && $post['add_active'] != '1') {
//				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
//			}

			$paramArr = array('class_study_id', 'classroom_id', 'level_language_id', 'language_id', 'class_time_id', 'number_student', 'number_student_max', 'slot_id', 'teacher_id');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];

				}
			}

			$param_time = array('time_start', 'time_end_expected', 'time_end_real');
			foreach ($param_time as $v_time) {
				if (isset($post['add_' . $v_time])) {
					$param[$v_time] = strtotime($post['add_' . $v_time]);
				}
			}

			$this->load->model('classroom_model');
			$input['where'] = array('classroom_id' => $param['classroom_id']);
			$classroom = $this->classroom_model->load_all($input);
			if (isset($classroom)) {
				$param['branch_id'] = $classroom[0]['branch_id'];
			} else {
				$param['branch_id'] = 0;
			}

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm lớp học thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->list_edit = array(
			'left_table' => array(
				'class_study_id' => array(),
				'classroom_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('classroom')
				),
//				'fee' => array(),
//				'class_time_id' => array(
//					'type' => 'array',
//					'value' => $this->get_data_from_model('class_time')
//				),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
				'level_language_id' => array(
					'type' => 'custom'
				),
				'number_student_max' => array(),
				'number_student' => array(),
			),

			'right_table' => array(
				'teacher_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('teacher')
				),
				'time_start' => array(
					'type' => 'datetime'
				),
				'time_end_expected' => array(
					'type' => 'datetime'
				),
				'time_end_real' => array(
					'type' => 'datetime'
				),
				'active' => array(
					'type' => 'active'
				),
			),
		);

		parent::show_edit_item();

	}

	function action_edit_item($id) {

		$post = $this->input->post();

		if (!empty($post)) {

			$input = array();

			$input['where'] = array('id' => $id);

			$class_study = $this->{$this->model}->load_all($input);

			$post['edit_class_study_id'] = $this->replace_str_to_url($post['edit_class_study_id']);

			if ($post['edit_class_study_id'] != $class_study[0]['class_study_id'] && $this->{$this->model}->check_exists(array('class_study_id' => $post['edit_class_study_id']))) {
				redirect_and_die('Mã lớp học này đã tồn tại!');
			}

			$paramArr = array('class_study_id', 'classroom_id', 'level_language_id', 'language_id', 'class_time_id',
				'number_student', 'number_student_max', 'slot_id', 'teacher_id', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];
				}
			}

			$param_time = array('time_start', 'time_end_expected', 'time_end_real');
			foreach ($param_time as $v_time) {
				if (isset($post['edit_' . $v_time])) {
					$param[$v_time] = strtotime($post['edit_' . $v_time]);
				}
			}

			$this->load->model('classroom_model');
			$input_classroom['where'] = array('classroom_id' => $param['classroom_id']);
			$classroom = $this->classroom_model->load_all($input_classroom);
			if (isset($classroom)) {
				$param['branch_id'] = $classroom[0]['branch_id'];
			} else {
				$param['branch_id'] = 0;
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin lớp học thành công!');
	}

	public function show_student(){
		$post = $this->input->post();
		$class_study_code = $this->{$this->model}->get_class_code($post['class_study_id']);
		$input['where'] = array(
			'class_study_id' => $class_study_code[0]['class_study_id'],
		);
		$input['where_in']['level_contact_id'] = array('L5', 'L5.1', 'L5.2', 'L5.3');

//		$student = $this->contacts_model->load_all($input);

		$data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

		$this->table .= 'date_rgt';
		$data['table'] = explode(' ', $this->table);
		echo $this->load->view('common/content/tbl_contact', $data);
	}

}
