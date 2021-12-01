<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Teacher extends MY_Table {

	public function __construct() {
		parent::__construct();
		$this->init();
	}

//	public function delete_item(){
//		redirect_and_die('Không được xóa!');
//	}
//
//	public function delete_multi_item(){
//		redirect_and_die('Không được xóa!');
//	}

	public function init() {
		$this->controller_path = 'staff_managers/teacher';
		$this->view_path = 'staff_managers/teacher';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'name' => array(
				'name_display' => 'Tên',
			),
			'phone' => array(
				'name_display' => 'Số ĐT',
//				'order' => '1'
			),
			'email' => array(
				'name_display' => 'Email',
			),
			'bank' => array(
				'name_display' => 'Số tài khoản',
			),
			'branch' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('branch'),
				'name_display' => 'Cơ sở',
			),
			'language' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('language_study'),
				'name_display' => 'Ngoại ngữ',
			),
//			'profit' => array(
//				'name_display' => 'Lợi nhuận',
//			),
            'teacher' => array(
                'name_display' => 'Tên giáo viên',
                'display' => 'none',
            ),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('teacher_model');
		$this->load->model('teacher_model');
	}

	public function index($offset = 0) {
		$require_model = array(
			'branch' => array(),
            'teacher' => array()
		);

		$this->data = $this->_get_require_data($require_model);
		$this->data['language'] = $this->get_data_from_model('language_study');

		$conditional = array();
//		if ($this->role_id == 12) {
//			$conditional['where']['branch_id'] = $this->branch_id;
//		}
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;

//		echo '<pre>';print_r($data);die();

		$this->list_filter = array(
			'left_filter' => array(
				'branch' => array(
					'type' => 'arr_multi'
				),
				'language' => array(
					'type' => 'arr_multi'
				),
			),
            'right_filter' => array(
                'teacher' => array(
                    'type' => 'arr_multi'
                ),
            )
		);

		$data['list_title'] = 'giáo viên';
		$data['edit_title'] = 'Sửa thông tin giáo viên';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {
		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/
		$this->list_add = array(
			'left_table' => array(
				'name' => array(),
				'phone' => array(),
				'bank' => array(),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
			),
			'right_table' => array(
				'email' => array(),
				'branch_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('branch'),
				),
				'active' => array(
					'type' => 'active'
				)
			),
		);

		parent::show_add_item();
//		$this->load->view('base/add_item/ajax_content');
	}

	function action_add_item() {

		$post = $this->input->post();

		if (!empty($post)) {

            if ($this->{$this->model}->check_exists(array('phone' => trim($post['add_phone'])))) {
                redirect_and_die('Giáo viên này đã tồn tại!');
            }

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');

			}

			$paramArr = array('phone', 'branch_id', 'language_id', 'email', 'bank', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = trim($post['add_' . $value]);

				}
			}

			$param['time_created'] = time();

			$id = $this->{$this->model}->insert_return_id($param, 'id');

			$this->create_account($param, $id);

			show_error_and_redirect('Thêm giáo viên thành công!');
		}
	}

	function show_edit_item($inputData = []) {
		$this->list_edit = array(
			'left_table' => array(
				'name' => array(),
				'phone' => array(),
				'bank' => array(),
				'language_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('language_study')
				),
			),
			'right_table' => array(
				'branch_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('branch')
				),
				'email' => array(),
				'active' => array(
					'type' => 'active'
				)
			),
		);

		parent::show_edit_item();

	}

	function action_edit_item($id) {

		$post = $this->input->post();

		if (!empty($post)) {

			$input = array();

			$input['where'] = array('id' => $id);

            $teacher = $this->{$this->model}->load_all($input);

			if ($post['edit_phone'] != $teacher[0]['phone'] && $this->{$this->model}->check_exists(array('phone' => $post['edit_phone']))) {
				redirect_and_die('Giáo viên này đã tồn tại!');
			}

			$paramArr = array('phone', 'email', 'branch_id', 'language_id', 'bank', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = trim($post['edit_' . $value]);

				}
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

			$this->{$this->model}->update($input['where'], $param);

            $this->create_account($param, $id);
		}

		show_error_and_redirect('Sửa thông tin giáo viên thành công!');
	}

	public function statistical_salary_teacher() {
        $this->load->model('attendance_model');
        $this->load->model('class_study_model');
        $this->load->model('mechanism_model');

        $require_model = array(
            'class_study' => array(
                'where' => array(
                    'character_class_id !=' => 1,
                    'teacher_id !=' => '0'
                ),
                'order' => array(
                    'class_study_id' => 'ASC'
                )
            ),
            'branch' => array(),
            'language_study' => array(
                'where' => array(
                    'active' => 1
                ),
            ),
            'teacher' => array(
                'where' => array(
                    'active' => 1
                ),
            ),

        );

        $data = $this->_get_require_data($require_model);

        $get = $this->input->get();

        $input_teacher['where'] = array('active' => 1);
        $input_teacher['order'] = array('id' => 'DESC');
        if (isset($get['filter_language_id']) && !empty($get['filter_language_id'])) {
            $input_teacher['where_in']['language_id'] = $get['filter_language_id'];
        }
        if (isset($get['filter_branch_id']) && !empty($get['filter_branch_id'])) {
            $input_teacher['where_in']['branch_id'] = $get['filter_branch_id'];
        }

        $data['rows'] = $this->{$this->model}->load_all($input_teacher);

        /* Mảng chứa các ngày lẻ */
        if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
            $time = $get['filter_date_date_happen'];
        } else {
            $time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
        }
        $dateArr = explode('-', $time);
        $startDate = trim($dateArr[0]);
        $startDate = strtotime(str_replace("/", "-", $startDate));
        $endDate = trim($dateArr[1]);
        $endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24 - 1;

        $data['total_salary'] = 0;
        foreach ($data['rows'] as $key => &$item_teacher) {
            $input_class['where'] = array(
                'teacher_id' => $item_teacher['id'],
                'lesson_learned !=' => '0'
            );
            $input_class['where_in']['character_class_id'] = array(2, 3);
            $class_teacher_owner = $this->class_study_model->load_all($input_class);

            $total_paid = 0;
            if (!empty($class_teacher_owner)) {
                foreach ($class_teacher_owner as $item_class) {
                    $input_lesson_learned['select'] = 'DISTINCT(lesson_learned)';
                    $input_lesson_learned['where'] = array(
                        'class_study_id' => $item_class['class_study_id'],
                        'speaker' => 1,
                        'time_update >=' => $startDate,
                        'time_update <=' => $endDate
                    );
                    if (isset($get['filter_speaker']) && $get['filter_speaker'] != '') {
                        $input_lesson_learned['where']['speaker'] = $get['filter_speaker'];
                    }
                    $total_lesson = count($this->attendance_model->load_all($input_lesson_learned));

                    if ($total_lesson) {
                        $input_mechanism['select'] = 'SUM(money) as money, reason';
                        $input_mechanism['where'] = array(
                            'class_study_id' => $item_class['class_study_id'],
                            'teacher_id' => $item_teacher['id'],
                            'time_created >=' => $startDate,
                            'time_created <=' => $endDate
                        );
                        $bonus = $this->mechanism_model->load_all(array_merge_recursive($input_mechanism, array('where' => array('mechanism' => 1))));
                        $bonus = ($bonus[0]['money'] != '') ? $bonus[0]['money'] : 0;
                        $fine = $this->mechanism_model->load_all(array_merge_recursive($input_mechanism, array('where' => array('mechanism' => '0'))));
                        $fine = ($fine[0]['money'] != '') ? $fine[0]['money'] : 0;
                        unset($input_mechanism['select']);
                        $paid_salary = $this->mechanism_model->load_all(array_merge_recursive($input_mechanism, array('where' => array('send_mail_salary' => 1))));

                        $item_teacher['attendance'][] = array(
                            'class_study_id' => $item_class['class_study_id'],
                            'time_start' => $item_class['time_start'],
                            'time_end_real' => $item_class['time_end_real'],
                            'language' => $this->language_study_model->find_language_name($item_class['language_id']),
                            'salary_per_day' => $item_class['salary_per_day'],
                            'lesson_learned' => $total_lesson,
                            'reason' => $this->mechanism_model->load_all($input_mechanism)[0]['reason'],
                            'bonus' => $bonus,
                            'fine' => $fine,
                            'paid_salary' => (!empty($paid_salary)) ? $paid_salary[0]['reason'] : ''
                        );

                        $data['total_salary'] += ($total_lesson * $item_class['salary_per_day']);
                        $total_paid += ($item_class['salary_per_day'] * $total_lesson) + $bonus - $fine;
                    }

                    $item_teacher['total_paid'] = $total_paid;
                }
                if (!isset($item_teacher['attendance'])) {
                    unset($data['rows'][$key]);
                }
            } else {
                unset($data['rows'][$key]);
            }
        }

//        print_arr($data);

        $data['left_col'] = array('date_happen_1', 'language', 'branch');
        $data['right_col'] = array('speaker');
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['content'] = 'staff_managers/teacher/statistical_salary_teacher';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function action_mechanism() {
        $this->load->model('mechanism_model');
        $this->load->model('class_study_model');

        $post = $this->input->post();
        $post['time_created'] = ($post['time_created'] != '') ? strtotime($post['time_created']) : time();

        $input_class['where'] = array(
            'class_study_id' => $post['class_study_id']
        );
        $class = $this->class_study_model->load_all($input_class);
        $post['teacher_id'] = $class[0]['teacher_id'];

        $this->mechanism_model->insert($post);

        show_error_and_redirect('Thêm thành công!');
    }

    public function send_mail_salary_teacher() {
	    $this->load->model('class_study_model');
	    $this->load->model('mechanism_model');
	    $this->load->model('attendance_model');
	    $this->load->model('teacher_model');

	    $post = $this->input->post();

	    if (empty($post['class_study_id'] || empty($post['teacher_id']))) {
            $result['success'] = false;
            $result['message'] =  'Không có thông tin giáo viên hoặc thông tin lớp';
            echo json_encode($result);
            die();
        }

        $input_class['where'] = array(
            'class_study_id' => $post['class_study_id']
        );
        $class = $this->class_study_model->load_all($input_class);

        $input_teacher['where'] = array(
            'id' => $post['teacher_id']
        );

        $teacher = $this->teacher_model->load_all($input_teacher);

        if ($teacher[0]['email'] != '') {
            $input_lesson_learned['select'] = 'DISTINCT(lesson_learned)';
            $input_lesson_learned['where'] = array(
                'class_study_id' => $post['class_study_id'],
                'time_update >=' => strtotime($post['start_date']),
                'time_update <=' => strtotime($post['end_date']) + 3600 * 24 - 1
            );

            $input_mechanism['select'] = 'SUM(money) as money, reason';
            $input_mechanism['where'] = array(
                'class_study_id' => $post['class_study_id'],
                'teacher_id' => $post['teacher_id'],
                'speaker' => 1,
                'time_update >=' => strtotime($post['start_date']),
                'time_update <=' => strtotime($post['end_date']) + 3600 * 24 - 1
            );
            $bonus = $this->mechanism_model->load_all(array_merge_recursive($input_mechanism, array('where' => array('mechanism' => 1))));
            $fine = $this->mechanism_model->load_all(array_merge_recursive($input_mechanism, array('where' => array('mechanism' => '0'))));

            $data['teacher'] = array(
                'name' => $teacher[0]['name'],
                'phone' => $teacher[0]['phone'],
                'bank' => $teacher[0]['bank'],
                'class_study_id' => $post['class_study_id'],
                'time_start' => $class[0]['time_start'],
                'time_end_expected' => $class[0]['time_end_expected'],
                'language' => $this->language_study_model->find_language_name($class[0]['language_id']),
                'salary_per_day' => $class[0]['salary_per_day'],
                'lesson_learned' => count($this->attendance_model->load_all($input_lesson_learned)),
                'bonus' => ($bonus[0]['money'] != '') ? $bonus[0]['money'] : 0,
                'fine' => ($fine[0]['money'] != '') ? $fine[0]['money'] : 0,
            );

            $this->load->library('email');
            $this->email->from('minhduc.sofl@gmail.com', 'TRUNG TÂM NGOẠI NGỮ SOFL');
            $mail_teacher = trim($teacher[0]['email']);
            $this->email->to($mail_teacher);
//          $this->email->to('ngovanquang281997@gmail.com');
            $subject = 'SOFL GỬI BẢNG KÊ LƯƠNG THÁNG ' . date('m/Y', strtotime($post['start_date'])) . ' - Mã lớp ' . $post['class_study_id'];
            $this->email->subject($subject);
            $message = $this->load->view('staff_managers/teacher/email_salary', $data, true);
            $this->email->message($message);

            if ($this->email->send()) {
                $param['class_study_id'] = $post['class_study_id'];
                $param['teacher_id'] = $post['teacher_id'];
                $param['reason'] = 'Đã gửi mail bảng lương';
                $param['send_mail_salary'] = 1;
                $param['time_created'] = time() - 25*24*3600;
                $this->mechanism_model->insert($param);

                $result['success'] = true;
                $result['message'] =  'Đã gửi mail thành công';
            } else {
                $result['success'] = false;
                $result['message'] =  'Có gì đó ko đúng, chưa gửi đc mail';
                show_error($this->email->print_debugger());
            }
        } else {
            $result['success'] = false;
            $result['message'] =  'Giáo viên này chưa có email';
        }

        echo json_encode($result);
        die();
    }

    public function show_class_own_teacher() {
	    $this->load->model('class_study_model');
	    $this->load->model('level_language_model');
	    $post = $this->input->post();
	    $input = array('where'=> array('teacher_id' => $post['teacher_id']));
        $data['class'] = $this->class_study_model->load_all($input);

        foreach ($data['class'] as $class) {
            $class['level_study_class'] = $this->level_language_model->get_name_level_language($class['level_language_id']);
            $class['number_student'] = $this->get_student_current($class['level_language_id']);
        }

        $this->load->view('staff_managers/teacher/show_class_own_teacher', $data);
	}

	private function create_account($item, $id) {
	    if (!$this->staffs_model->check_exists(array('user_name' => $item['phone']))) {
            $param['name'] = $item['name'];
            $param['phone'] = $item['phone'];
            $param['email'] = $item['email'];
            $param['user_name'] = $item['phone'];
            $number_first_phone = substr($item['phone'], 0, 1);
            if ($number_first_phone != '0') {
                $param['user_name'] = '0'.$item['phone'];
            }
            $param['password'] = md5(md5($param['user_name']));
            $param['teacher_id'] = $id;
            $param['branch_id'] = $item['branch_id'];
            $param['language_id'] = $item['language_id'];
            $param['active'] = 1;
            $param['role_id'] = 8;
            $this->staffs_model->insert($param);
        }
    }

}
