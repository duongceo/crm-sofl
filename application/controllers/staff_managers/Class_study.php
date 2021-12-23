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
			'time_start' => array(
				'type' => 'datetime',
				'name_display' => 'Ngày khai giảng',
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
			'time' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('time'),
				'name_display' => 'Giờ học',
			),
			'day' => array(
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
				'name_display' => 'Giáo viên 1',
			),
            'teacher_id_2' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('teacher'),
				'name_display' => 'Giáo viên 2',
                'display' => 'none'
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
				'name_display' => 'SS hiện tại',
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
//			'salary_teacher' => array(
//				'type' => 'custom',
//				'name_display' => 'Lương giảng viên',
//			),
			'salary_per_day' => array(
				'type' => 'custom',
				'name_display' => 'Lương/Buổi',
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
		
		if (in_array($this->role_id, [1, 6])) {
			$list_view = array(
				'priority' => array(
					'type' => 'custom',
					'name_display' => 'Ưu tiên'
				),
				'time_start' => array(
					'type' => 'datetime',
					'name_display' => 'Ngày khai giảng',
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
				'time' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('time'),
					'name_display' => 'Giờ học',
				),
				'day' => array(
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
					'out_report' => '0',
                    'active' => 1
				)
			),
			'level_language' => array(),
			'character_class' => array(),
			'time' => array(),
			'day' => array(),
		);

		$this->data = $this->_get_require_data($require_model);

//		$this->data['branch'] = $this->get_data_from_model('branch');

		$this->data['language'] = $this->get_data_from_model('language_study');

		$this->list_filter = array(
			'right_filter' => array(
                'day' => array(
                    'type' => 'custom'
                ),
                'time' => array(
                    'type' => 'custom'
                ),
                'branch' => array(
                    'type' => 'arr_multi'
                ),
				'language' => array(
					'type' => 'custom'
				),
				'level_language' => array(
					'type' => 'custom'
				),
			),

			'left_filter' => array(
				'character_class' => array(
					'type' => 'arr_multi'
				),
                'survey' => array(
                    'type' => 'custom'
                ),
                'number_care' => array(
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
				'class_id' => array(
					'type' => 'custom'
				)
			)
		);

		$conditional = array();
		
		if ($this->role_id == 12 && $_GET['filter_class_id'] == '' && empty($_GET['filter_arr_multi_branch_id'])) {
			$conditional['where']['branch_id'] = $this->branch_id;
		} else if ($this->role_id == 14) {
			$conditional['where_in']['language_id'] = explode(',', $this->session->userdata('language_id'));
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
                'teacher_id_2' => array(
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
	}

	function action_add_item() {

		$post = $this->input->post();

		if (!empty($post)) {

			$post['add_class_study_id'] = $this->replace_str_to_url($post['add_class_study_id']);

            $post['add_class_study_id'] = $this->create_class_id($post['add_class_study_id'], $post['add_branch_id']);

//			if ($post['add_active'] != '0' && $post['add_active'] != '1') {
//				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
//			}

			$paramArr = array('class_study_id', 'classroom_id', 'branch_id', 'language_id', 'day_id', 'time_id', 'priority_id',
				'number_student', 'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'teacher_id', 'teacher_id_2', 'character_class_id', 'status', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];

				}
			}

            if (isset($post['level_language_id']) && !empty($post['level_language_id'])) {
                $param['level_language_id'] = $post['level_language_id'];
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

			if (!empty($param['time_end_expected'])) {
				if ($param['time_end_real'] <= $param['time_start'] && $param['time_end_expected'] <= $param['time_start']) {
					redirect_and_die('Ngày kết thúc ko thể trước ngày khai giảng');
				}
			} else {
                $param['time_end_expected'] = $this->get_time_end_expected($param['total_lesson'], $param['day_id'], $param['time_start']);
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
                'teacher_id_2' => array(
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

//			$post['edit_class_study_id'] = $this->replace_str_to_url($post['edit_class_study_id']);

			if ($post['edit_class_study_id'] != $class_study[0]['class_study_id'] && $this->{$this->model}->check_exists(array('class_study_id' => $post['edit_class_study_id']))) {
				redirect_and_die('Mã lớp học này đã tồn tại!');
			}

			$paramArr = array('class_study_id', 'branch_id', 'classroom_id', 'level_language_id', 'language_id', 'day_id', 'time_id', 'priority_id',
				'number_student_max', 'total_lesson', 'lesson_learned', 'lecture', 'teacher_id', 'teacher_id_2', 'active', 'character_class_id', 'status');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];

				}

			}

			if (isset($post['level_language_id']) && !empty($post['level_language_id'])) {
                $param['level_language_id'] = $post['level_language_id'];
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

			if (!empty($param['time_end_real']) || !empty($param['time_end_expected'])) {
				if ($param['time_end_real'] <= $param['time_start'] && $param['time_end_expected'] <= $param['time_start']) {
					redirect_and_die('Ngày kết thúc ko thể trước ngày khai giảng');
				}
			}

            if (empty($param['time_end_expected'])) {
                $param['time_end_expected'] = $this->get_time_end_expected($param['total_lesson'], $param['day_id'], $param['time_start']);
            }

            if (!empty($param['time_end_real'])) {
                $param['character_class_id'] = 3;
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
				$data_contact = array(
				    'level_study_id' => 'L7',
                    'date_action_of_study' => time(),
                    'last_activity' => time()
                );
				$this->contacts_model->update($where_contact, $data_contact);
			}

            if ($post['edit_character_class_id'] == 3) {
                $where_contact = array('class_study_id' => $class_study[0]['class_study_id']);
                $data_contact = array(
                    'level_study_id' => 'L7.4',
                    'date_action_of_study' => time(),
                    'last_activity' => time()
                );
                $this->contacts_model->update($where_contact, $data_contact);
            }

            if ($post['edit_class_study_id'] != $class_study[0]['class_study_id']) {
                $where_contact = array('class_study_id' => $class_study[0]['class_study_id']);
                $param_contact['class_study_id'] = $post['edit_class_study_id'];
                $this->contacts_model->update($where_contact, $param_contact);
            }

			$param['date_last_update'] = time();

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin lớp học thành công!');
	}

	private function create_class_id($str, $branch_id) {
        $class_id = $str . '.' . ($branch_id - 1) . rand(000, 999);
        if (!$this->{$this->model}->check_exists(array('class_study_id' => $class_id))) {
            return $class_id;
        }
        $this->create_class_id($str, $branch_id);
    }
    
    private function get_time_end_expected($total_lesson, $day, $time_start) {
	    $this->load->model('day_model');
	    $time_end_expected = '';
	    if ($total_lesson == 0 || $day == 0 || $time_start == '') {
	        return $time_end_expected;
        }
        $weekday = $this->day_model->get_day($day);
	    $total_weekday = count(explode('-', $weekday));
        $total_day = ceil($total_lesson / $total_weekday) * 7;
        $time_end_expected = strtotime('+'.$total_day.' days', $time_start);

        return $time_end_expected;
    }

	public function show_student(){
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

		$post = $this->input->post();
		$class_study_code = $this->{$this->model}->get_class_code($post['class_study_id']);
		$input['where']['class_study_id'] = $class_study_code[0]['class_study_id'];
        $input['where']['(level_contact_id = "L5" OR level_student_id = "L8.1")'] = 'NO-VALUE';
		$input['where']['level_contact_detail !='] = 'L5.4';
//		$input['where_in']['level_study_id'] = array('L7', '', 'L7.4');

		$data_pagination = $this->_query_all_from_get(array(), $input, 40, 0);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

		$this->table = 'name phone address level_language fee paid fee_missing level_study_detail date_rgt_study add_contact';
		if ($this->role_id == 14) {
			$this->table = 'name address date_rgt_study';
		}
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
		 } elseif ($post['type'] == 'language' || $post['type'] == 'filter_language') {
			 $this->load->model('level_language_model');
			 $input['where'] = array(
				 'language_id' => $post['data_id']
			 );

			 $data = $this->level_language_model->load_all($input);
			 $title = 'Trình độ';
			 if ($post['type'] == 'language') {
                 $name = 'level_language_id';
             } elseif ($post['type'] == 'filter_language') {
                 $name = 'filter_arr_multi_level_language_id';
             }
		 }

		 if (isset($data)) {
			 $context = '<td class="text-right"> '.$title. '</td>
				<td>';
             $context .= "<select class='form-control selectpicker' name='{$name}'>";
             $context .= '<option value="">'.$title.'</option>';
             foreach ($data as $value) {
                 if ($post['type'] == 'branch') {
                     $context .= "<option value='{$value['classroom_id']}'> {$value['classroom_id']} </option>";
                 } elseif ($post['type'] == 'language' || $post['type'] == 'filter_language') {
                     $context .= "<option value='{$value['id']}'> {$value['name']} </option>";
                 }
             }
             $context .= '</select>
				</td>';

			 echo $context;die();
		 } else echo '';
	 }

	 function update_data_inline() {
	     $this->load->model('notes_model');
	     $post = $this->input->post();
		 $response = array();

		 if (!empty($post['data_now'])) {
		     if ($post['column'] != 'note') {
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
                 $param['content'] = $post['data_now'];
                 $param['class_study_id'] = $post['class_id'];
                 $param['time_created'] = time();
                 $param['sale_id'] = $this->user_id;
                 $param['role_id'] = $this->role_id;
                 $this->notes_model->insert($param);
                 $response['success'] = 1;
             }
		 } else {
			 $response['success'] = 0;
		 }

		 echo json_encode($response);
		 die;
	 }

	 function show_edit_care_class() {
         $post = $this->input->post();
         $input['where'] = array('id' => $post['item_id']);
         $data['class'] = $this->{$this->model}->load_all($input);

         $input_staff['where'] = array(
             'role_id' => 10,
             'branch_id' => $this->branch_id,
             'active' => 1
         );
         $data['staff_customer'] = $this->staffs_model->load_all($input_staff);

         $this->load->view('staff_managers/class_study/show_edit_class', $data);
     }

     function action_edit_care_class() {
	    $this->load->model('class_edit_log_model');
	    $post = $this->input->post();

	    $id = $post['id'];
	    unset($post['id']);

	    $class_care_log = array(
	        'class_study_id' => $id,
            'number_care' => $post['number_care'],
            'staff_customer_id' => (!empty($post['staff_customer_id'])) ? $post['staff_customer_id'] : $this->user_id,
            'time_created' => time()
        );

	    $post['date_last_update'] = time();

	    $this->{$this->model}->update(array('id' => $id), $post);
	    $this->class_edit_log_model->insert($class_care_log);

	    show_error_and_redirect('Chăm sóc lớp học thành công!');
     }

     function send_mail_contract() {
         $this->load->model('class_study_model');
         $this->load->model('teacher_model');
         $this->load->model('time_model');
         $this->load->model('day_model');
         $this->load->model('branch_model');

         $post = $this->input->post();

         $input_class['where'] = array('class_study_id' => $post['class_study_id']);
         $class = $this->class_study_model->load_all($input_class);

         if ($class[0]['teacher_id'] != 0) {
             $input_teacher['where'] = array('id' => $class[0]['teacher_id']);
             $teacher = $this->teacher_model->load_all($input_teacher);
             if (empty($teacher[0]['email'])) {
                 $result['success'] = false;
                 $result['message'] =  'Giáo viên chưa có mail';
                 echo json_encode($result);
                 die();
             }
             $class[0]['time'] = $this->time_model->get_time($class[0]['time_id']);
             $class[0]['day'] = $this->day_model->get_day($class[0]['day_id']);
             $class[0]['branch_name'] = $this->branch_model->find_branch_name($class[0]['branch_id']);
             $data['class'] = $class[0];
             $data['teacher'] = $teacher[0];

             $this->load->library('pdf');
             $pdf = $this->pdf->load();
             $pdf->allow_charset_conversion = true;
             $pdf->charset_in='UTF-8';
             $pdf->autoLangToFont = true;
             ini_set('memory_limit', '256M');
             $html = $this->load->view('staff_managers/class_study/contract_teacher', $data, true);
             $pdf->WriteHTML($html);
             $output = 'contract_class_' . $post['class_study_id'] . '_'. date('d_m_Y') . '_.pdf';
             $pdf->Output('public/hd_khoahoc/' . $output, "F");

             $this->load->library('email');
             $this->email->from('minhduc.sofl@gmail.com', 'TRUNG TÂM NGOẠI NGỮ SOFL');
             $this->email->to(trim($teacher[0]['email']));
             $subject = 'SOFL GỬI HỢP ĐỒNG KHÓA HỌC LỚP ' . $post['class_study_id'];
             $this->email->subject($subject);
             $message = 'SOFL gửi hợp đồng khóa học';
             $this->email->message($message);
             $this->email->attach('public/hd_khoahoc/' . $output);

             if ($this->email->send()) {
                 $result['success'] = true;
                 $result['message'] =  'Đã tạo hợp đồng và gửi mail thành công';
             } else {
                 $result['success'] = false;
                 $result['message'] =  'Có gì đó ko đúng, chưa gửi đc mail';
                 show_error($this->email->print_debugger());
             }
         } else {
             $result['success'] = false;
             $result['message'] =  'Lớp chưa có giáo viên';
         }

         echo json_encode($result);
     }

     public function show_L7() {
         $this->load->model('log_study_model');
         $post = $this->input->post();
         $input_contact['select'] = 'id';
         $input_contact['where']['(class_study_id = "'. $post['class_study_id'] .'" OR class_foreign_id LIKE "%'. $post['class_study_id'] .'%")'] = 'NO-VALUE';
         $input_contact['where']['level_contact_detail !='] = 'L5.4';
         $data['L7'] = count($this->contacts_model->load_all($input_contact));

         $input['where'] = array();
         $input['where']['class_study_id'] = $post['class_study_id'];
         $input['where']['level_study_id'] = 'L7.1';
         $data['L7_1'] = count($this->log_study_model->load_all($input));

         $input['where']['level_study_id'] = 'L7.2';
         $data['L7_2'] = count($this->log_study_model->load_all($input));

         $input['where']['level_study_id'] = 'L7.3';
         $data['L7_3'] = count($this->log_study_model->load_all($input));

         $input['where']['level_study_id'] = 'L7.4';
         $data['L7_4'] = count($this->log_study_model->load_all($input));

//         $input['where']['level_study_id'] = 'L7.5';
//         $data['L7_5'] = count($this->log_study_model->load_all($input));

//         $input['where']['level_study_id'] = 'L7.6';
//         $data['L7_6'] = count($this->log_study_model->load_all($input));
//         if (empty($data['L7_6'])) {
             $input_contact['where'] = array();
             $input_contact['where']['class_study_id'] = $post['class_study_id'];
             $input_contact['where']['level_study_id'] = 'L7.6';
             $data['L7_6'] = count($this->contacts_model->load_all($input_contact));
//         }

         echo $this->load->view('staff_managers/class_study/show_L7', $data, true);
     }

}
