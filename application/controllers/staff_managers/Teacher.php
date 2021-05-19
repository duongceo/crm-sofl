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

	public function delete_item(){
		redirect_and_die('Không được xóa!');
	}

	public function delete_multi_item(){
		redirect_and_die('Không được xóa!');
	}

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
		);

		$data['list_title'] = 'Giảng viên';
		$data['edit_title'] = 'Sửa thông tin giảng viên';
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

//		 echo "<pre>";print_r($post);die();

		if (!empty($post)) {

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('phone', 'branch_id', 'language_id', 'email', 'bank', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm giảng viên thành công!');
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

//			$post['edit_language_id'] = $this->replace_str_to_url($post['edit_language_id']);
//
//			if ($post['edit_language_id'] != $classroom[0]['language_id'] && $this->{$this->model}->check_exists(array('language_id' => $post['edit_language_id']))) {
//				redirect_and_die('Mã ngôn ngữ này đã tồn tại!');
//			}

			$paramArr = array('phone', 'email', 'branch_id', 'language_id', 'bank', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];
				}
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin giảng viên thành công!');
	}

}
