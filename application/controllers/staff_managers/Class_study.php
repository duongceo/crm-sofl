<?php

//require_once("application/core/MY_Table.php");

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
		parent::delete_item();
	}

	public function delete_multi_item(){
		redirect_and_die('Không được xóa!');
	}

	public function init() {
		$this->controller_path = 'staff_managers/class_study';
		$this->view_path = 'staff_managers/class_study';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'priority' => array(
				'type' => 'custom',
				'name_display' => 'Ưu tiên'
			),
			'class_study_id' => array(
				'name_display' => 'Mã lớp học',
			),
			'branch' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('branch'),
				'name_display' => 'Cơ sở',
				'display' => 'none'
			),
			'classroom_id' => array(
				'name_display' => 'Phòng học',
				'display' => 'none'
			),
			'time_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('time'),
				'name_display' => 'Giờ học',
			),
			'day_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('day'),
				'name_display' => 'Ngày học',
			),
			'level_language' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('level_language'),
				'name_display' => 'Trình độ',
				//'display' => 'none'
			),
			'teacher_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('teacher'),
				'name_display' => 'Giảng viên',
			),
			'language' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('language_study'),
				'name_display' => 'Ngoại ngữ',
				'display' => 'none'
			),
			'number_student_max' => array(
				'name_display' => 'Sĩ số tối đa',
				'display' => 'none'
			),
			'number_student' => array(
				'name_display' => 'Sĩ số hiện tại',
			),
			'total_lesson' => array(
				'name_display' => 'Tổng số buổi',
			),
			'lesson_learned' => array(
				'type' => 'custom',
				'name_display' => 'Số buổi đã học',
			),
			'lecture' => array(
				'type' => 'custom',
				'name_display' => 'Tiến độ bài giảng',
			),
			'salary_teacher' => array(
				'type' => 'custom',
				'name_display' => 'Lương giảng viên',
			),
			'salary_per_day' => array(
				'type' => 'custom',
				'name_display' => 'Lương/Buổi',
				'display' => 'none'
			),
			'time_start' => array(
				'type' => 'datetime',
				'name_display' => 'Ngày khai giảng',
			),
			'time_end_expected' => array(
				'type' => 'datetime',
				'name_display' => 'Ngày dự kiến kết thúc',
			),
			'time_end_real' => array(
				'type' => 'datetime',
				'name_display' => 'Ngày kết thúc thực',
				'display' => 'none'
			),
			'character_class' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('character_class'),
				'name_display' => 'Đặc điểm lớp',
				'display' => 'none'
			),
			'status' => array(
				'type' => 'custom',
				'name_display' => 'Trạng thái',
				'display' => 'none'
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động ?',
				'display' => 'none'
			),
			'notes' => array(
				'type' => 'custom',
				'name_display' => 'Ghi chú'
			),
			'date_last_update' => array(
				'type' => 'custom',
				'name_display' => 'Cập nhật cuối'
			),
			
		);
		
		if(in_array($this->role_id, [1, 3, 6])) {
			$list_view = array(
				'priority' => array(
					'type' => 'custom',
					'name_display' => 'Ưu tiên'
				),
				'class_study_id' => array(
					'name_display' => 'Mã lớp học',
				),
				'branch' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('branch'),
					'name_display' => 'Cơ sở',
					'display' => 'none'
				),
				'classroom_id' => array(
					'name_display' => 'Phòng học',
					'display' => 'none'
				),
				'time_id' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('time'),
					'name_display' => 'Giờ học',
				),
				'day_id' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('day'),
					'name_display' => 'Ngày học',
				),
				'level_language' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('level_language'),
					'name_display' => 'Trình độ',
					//'display' => 'none'
				),
				'time_start' => array(
					'type' => 'datetime',
					'name_display' => 'Ngày khai giảng',
				),
				'number_student' => array(
					'name_display' => 'Sĩ số hiện tại',
				),
				'total_lesson' => array(
					'name_display' => 'Tổng số buổi',
				),
				'lesson_learned' => array(
					'type' => 'custom',
					'name_display' => 'Số buổi đã học',
				),
				'lecture' => array(
					'type' => 'custom',
					'name_display' => 'Tiến độ bài giảng',
				),
				'notes' => array(
					'type' => 'custom',
					'name_display' => 'Ghi chú'
				),
			);
		}
		//print_arr($list_view);
		$this->set_list_view($list_view);
		$this->set_model('class_study_model');
		$this->load->model('class_study_model');
	}

	public function index($offset = 0) {
		$require_model = array(
			'branch' => array(),
			'language_study' => array(
				'where' => array(
					'out_report' => '0'
				)
			),
			'level_language' => array(),
			'character_class' => array(),
		);

		$this->data = $this->_get_require_data($require_model);

//		$this->data['branch'] = $this->get_data_from_model('branch');

		$this->data['language'] = $this->get_data_from_model('language_study');

		$this->list_filter = array(
			'right_filter' => array(
				'branch' => array(
					'type' => 'arr_multi'
				),
				'language' => array(
					'type' => 'arr_multi'
				),
				'level_language' => array(
					'type' => 'arr_multi'
				),
			),

			'left_filter' => array(
				'character_class' => array(
					'type' => 'arr_multi'
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
				'class_id' => array(
					'type' => 'custom'
				)
			)
		);

		$conditional = array();
		
		if($this->role_id == 1) {
			$conditional = array(
				'where' => array(
					'character_class_id' => 1,
					'priority_id !=' => '0'
				)
			);
		}
		
		if ($this->session->userdata('role_id') == 12 && $_GET['filter_class_id'] == '') {
			$conditional['where']['branch_id'] = $this->branch_id;
		}

		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();

		$data = $this->data;

		$data['list_title'] = 'Lớp học';
		$data['edit_title'] = 'Sửa thông tin lớp học';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		if ($this->role_id == 6) {
			echo '<script> alert("Bạn ko có quyền thực hiện việc này");</script>';
			die();
		}

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->list_add = array(
			'left_table' => array(
				'class_study_id' => array(),
				'branch_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('branch'),
				),
				'classroom_id' => array(
					'type' => 'custom'
				),
				'time_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('time')
				),
				'day_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('day')
				),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
				'level_language_id' => array(
					'type' => 'custom'
				),
				'number_student_max' => array(),
				'number_student' => array(),
				'total_lesson' => array(),
				'lesson_learned' => array(),
				'lecture' => array(),
			),

			'right_table' => array(
				'teacher_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('teacher')
				),
				'salary_per_day' => array(
					'type' => 'custom'
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
				'character_class_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('character_class')
				),
				'priority' => array(
					'type' => 'custom'
				),
				'status' => array(
					'type' => 'custom'
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

			$paramArr = array('class_study_id', 'classroom_id', 'branch_id', 'level_language_id', 'language_id', 'day_id', 'time_id', 'priority_id',
				'number_student', 'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'teacher_id', 'character_class_id', 'status', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];

				}
			}

			if ($post['add_salary_per_day'] != 0) {
				$param['salary_per_day'] = str_replace(',', '', $post['add_salary_per_day']);
			}

			$param_time = array('time_start', 'time_end_expected', 'time_end_real');
			foreach ($param_time as $v_time) {
				if (isset($post['add_' . $v_time])) {
					$param[$v_time] = strtotime($post['add_' . $v_time]);
				}
			}

			if (isset($param['time_end_real']) || isset($param['time_end_expected'])) {
				if ($param['time_end_real'] <= $param['time_start'] && $param['time_end_expected'] <= $param['time_start']) {
					redirect_and_die('Ngày kết thúc ko thể trước ngày khai giảng');
				}
			}

			$param['time_created'] = time();
			$param['date_last_update'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm lớp học thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		if ($this->role_id == 6) {
			echo '<script> alert("Bạn ko có quyền thực hiện việc này");</script>';
			die();
		}

		$this->load->model('notes_model');

		$this->list_edit = array(
			'left_table' => array(
				'class_study_id' => array(),
				'branch_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('branch')
				),
				'classroom_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('classroom')
				),
				'time_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('time')
				),
				'day_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('day')
				),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
				'level_language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('level_language')
				),
				'number_student_max' => array(),
//				'number_student' => array(),
				'total_lesson' => array(),
				'lesson_learned' => array(),
				'lecture' => array(),
			),

			'right_table' => array(
				'teacher_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('teacher')
				),
				'salary_per_day' => array(
					'type' => 'custom'
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
				'notes' => array(
					'type' => 'custom'
				),
				'character_class_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('character_class')
				),
				'priority' => array(
					'type' => 'custom'
				),
				'status' => array(
					'type' => 'custom'
				),
				'active' => array(
					'type' => 'active'
				),
				'date_last_update' => array(
					'type' => 'custom'
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

			$paramArr = array('class_study_id', 'branch_id', 'classroom_id', 'level_language_id', 'language_id', 'day_id', 'time_id', 'priority_id',
				'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'teacher_id', 'active', 'character_class_id', 'status');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];

				}

			}

			if ($post['edit_salary_per_day'] != 0) {
				$param['salary_per_day'] = str_replace(',', '', $post['edit_salary_per_day']);
			}

			$param_time = array('time_start', 'time_end_expected', 'time_end_real');
			foreach ($param_time as $v_time) {
				if (isset($post['edit_' . $v_time])) {
					$param[$v_time] = strtotime($post['edit_' . $v_time]);
				}
			}

//			print_arr($param);

			if (isset($param['time_end_real']) || isset($param['time_end_expected'])) {
				if ($param['time_end_real'] <= $param['time_start'] && $param['time_end_expected'] <= $param['time_start']) {
					redirect_and_die('Ngày kết thúc ko thể trước ngày khai giảng');
				}
			}

			if ((!isset($post['edit_active']) && empty($post['edit_active'])) || $post['edit_character_class_id'] == 3) {
				$param['active'] = 0;
			}

			if (!isset($post['edit_status']) && empty($post['edit_status'])) {
				$param['status'] = 0;
			}

			if (isset($post['note']) && $post['note'] != '') {
				$this->load->model('notes_model');
				$notes = array(
					'contact_id' => 0,
					'content' => $post['note'],
					'sale_id' => $this->user_id,
					'role_id' => $this->role_id,
					'time_created' => time(),
					'class_study_id' => $id,
				);
				$this->notes_model->insert($notes);
			}

//			update trạng thái tham gia học cho các học viên tham gia lớp học này
			if ($post['edit_character_class_id'] == 2) {
				$where_contact = array('class_study_id' => $class_study[0]['class_study_id']);
				$data_contact = array('level_study_id' => 'L7', 'last_activity' => time());
				$this->contacts_model->update($where_contact, $data_contact);
			}
			//echoQuery(); die();

			$param['date_last_update'] = time();

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
		$input['where']['level_contact_id'] = 'L5';
//		$student = $this->contacts_model->load_all($input);

		$require_model = array(
			'class_study' => array(
				'branch_id' => $this->branch_id,
				'order' => array(
					'class_study_id' => 'ASC'
				)
			),
			'branch' => array(),
			'level_language' => array(),
			'language_study' => array(),
		);

        $data = $this->_get_require_data($require_model);

		$data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

		$this->table = 'name phone address level_language fee paid fee_missing level_study_detail date_rgt_study';
		$data['table'] = explode(' ', $this->table);
		$this->load->view('common/content/tbl_contact', $data);
	}

//	 public function get_classroom() {
//		$post = $this->input->post();
//
//		$this->load->model('classroom_model');
//		$input['where'] = array(
//			'branch_id' => $post['branch_id']
//		);
//
//		 $classroom= $this->classroom_model->load_all($input);
//
//		if (isset($classroom)) {
//			$context = '<td class="text-right"> Phòng học </td>
//
//			<td>';
//
//			$context .= "<select class='form-control selectpicker' name='add_classroom_id'>";
//
//					$context .= '<option value="">Phòng học</option>';
//
//				foreach ($classroom as $value) {
//
//					$context .= "<option value='{$value['id']}'> {$value['classroom_id']} </option>";
//
//				}
//
//				$context .= '</select>
//
//			</td>';
//
//				echo $context;
//		} else echo '';
//
//	 }

	 public function get_data_ajax() {
		 $post = $this->input->post();

		 if ($post['type'] == 'branch') {
			 $this->load->model('classroom_model');
			 $input['where'] = array(
				 'branch_id' => $post['data_id']
			 );

			 $data = $this->classroom_model->load_all($input);
			 $title = 'Phòng học';
			 $name = 'add_classroom_id';
		 } elseif ($post['type'] == 'language') {
			 $this->load->model('level_language_model');
			 $input['where'] = array(
				 'language_id' => $post['data_id']
			 );

			 $data = $this->level_language_model->load_all($input);
			 $title = 'Trình độ';
			 $name = 'add_level_language_id';
		 }

		 if (isset($data)) {
			 $context = '<td class="text-right"> '.$title. '</td>

				<td>';

					 $context .= "<select class='form-control selectpicker' name='{$name}'>";

					 $context .= '<option value="">'.$title.'</option>';

					 foreach ($data as $value) {
						 if ($post['type'] == 'branch') {
							 $context .= "<option value='{$value['classroom_id']}'> {$value['classroom_id']} </option>";
						 } elseif ($post['type'] == 'language') {
							 $context .= "<option value='{$value['id']}'> {$value['name']} </option>";
						 }
					 }

					 $context .= '</select>
				
				</td>';

			 echo $context;die();
		 } else echo '';
	 }

	 function update_data_inline() {
		 $post = $this->input->post();
		 $response = array();

		 if (!empty($post['data_now'])) {
			 $where = array('id' => $post['class_id']);
			 if ($post['column'] == 'lesson_learned') {
				 $param['lesson_learned'] = $post['data_now'];
			 } else if ($post['column'] == 'lecture') {
				 $param['lecture'] = $post['data_now'];
			 }
			 $param['date_last_update'] = time();

			 if ($this->{$this->model}->update($where, $param)) {
				 $response['success'] = 1;
			 } else {
				 $response['success'] = 0;
			 }
		 } else {
			 $response['success'] = 0;
		 }

		 echo json_encode($response);
		 die;
	 }
	 
//	function get_class_from_web() {
//		$post = $this->input->post();
//
//	}

}
