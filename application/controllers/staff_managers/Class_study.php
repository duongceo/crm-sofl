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
			'day_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('day'),
				'name_display' => 'Ngày học',
			),
			'time_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('time'),
				'name_display' => 'Giờ học',
			),
			'language' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('language_study'),
				'name_display' => 'Ngoại ngữ',
			),
			'level_language' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('level_language'),
				'name_display' => 'Trình độ',
				'display' => 'none'
			),
			'number_student_max' => array(
				'name_display' => 'Sĩ số tối đa',
			),
			'number_student' => array(
				'name_display' => 'Sĩ số hiện tại',
			),
			'total_lesson' => array(
				'name_display' => 'Tổng số buổi',
			),
			'lesson_learned' => array(
				'name_display' => 'Số buổi đã học',
			),
			'lecture' => array(
				'name_display' => 'Tiến độ bài giảng',
			),
			'salary_per_hour' => array(
				'type' => 'custom',
				'name_display' => 'Lương/Giờ',
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
			),
			'teacher_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('teacher'),
				'name_display' => 'Giảng viên',
				'display' => 'none'
			),
			'character_class' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('character_class'),
				'name_display' => 'Đặc điểm lớp',
			),
			'status' => array(
				'type' => 'custom',
				'name_display' => 'Trạng thái'
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động ?',
				'display' => 'none'
			),
			'notes' => array(
				'type' => 'custom',
				'name_display' => 'Ghi chú'
			)
		);
		$this->set_list_view($list_view);
		$this->set_model('class_study_model');
		$this->load->model('class_study_model');
	}

	public function index($offset = 0) {

		$require_model = array(
			'branch' => array(),
			'level_language' => array(),
			'language_study' => array(
				'where' => array(
					'no_report' => '0'
				)
			),
			'character_class' => array(),
		);

		$this->data = $this->_get_require_data($require_model);
		
//		$this->data['branch'] = $this->get_data_from_model('branch');
//		$this->data['language'] = $this->get_data_from_model('language_study');
//		$this->data['level_language'] = $this->get_data_from_model('level_language');
//		$this->data['character_class'] = $this->get_data_from_model('character_class');

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
		if ($this->session->userdata('role_id') == 12) {
			$conditional['where']['branch_id'] = $this->branch_id;
		}

		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();

		$data = $this->data;

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
				'salary_per_hour' => array(),
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

			$paramArr = array('class_study_id', 'classroom_id', 'branch_id', 'level_language_id', 'language_id', 'day_id', 'time_id',
				'number_student', 'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'salary_per_hour', 'teacher_id', 'character_class_id', 'status', 'active');

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
				'salary_per_hour' => array(),
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

			$paramArr = array('class_study_id', 'branch_id', 'classroom_id', 'level_language_id', 'language_id', 'day_id', 'time_id',
				'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'salary_per_hour', 'teacher_id', 'character_class_id', 'active', 'status');

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
					'time_created' => time(),
					'class_study_id' => $id,
				);
				$this->notes_model->insert($notes);
			}

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
		);

        $data = $this->_get_require_data($require_model);

		$data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

		$this->table .= 'fee paid level_contact date_rgt date_rgt_study';
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
		 $key = array_keys($post);
		 if ($key[0] == 'branch_id') {
			 $this->load->model('classroom_model');
			 $input['where'] = array(
				 'branch_id' => $post['branch_id']
			 );

			 $data= $this->classroom_model->load_all($input);
			 $title = 'Phòng học';
			 $name = 'add_classroom_id';
		 } elseif ($key[0] == 'language_id') {
			 $this->load->model('level_language_model');
			 $input['where'] = array(
				 'language_id' => $post['language_id']
			 );

			 $data= $this->level_language_model->load_all($input);
			 $title = 'Trình độ';
			 $name = 'add_level_language_id';
		 }

		 if (isset($data)) {
			 $context = '<td class="text-right"> '.$title. '</td>

				<td>';

					 $context .= "<select class='form-control selectpicker' name='{$name}'>";

					 $context .= '<option value="">'.$title.'</option>';

					 foreach ($data as $value) {
						 if ($key[0] == 'branch_id') {
							 $context .= "<option value='{$value['classroom_id']}'> {$value['classroom_id']} </option>";
						 } elseif ($key[0] == 'language_id') {
							 $context .= "<option value='{$value['id']}'> {$value['name']} </option>";
						 }
					 }

					 $context .= '</select>
				
				</td>';

			 echo $context;die();
		 } else echo '';
	 }

//	public function search($offset = 0) {
////		$get = $this->input->get();
////		print_arr($get);
//		parent::search($offset); // TODO: Change the autogenerated stub
//	}

}
