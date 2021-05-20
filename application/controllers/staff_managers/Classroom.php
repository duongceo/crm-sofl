<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Classroom extends MY_Table {

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
		$this->controller_path = 'staff_managers/classroom';
		$this->view_path = 'staff_managers/classroom';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'classroom_id' => array(
				'name_display' => 'Mã phòng học',
//				'order' => '1'
			),
			'branch' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('branch'),
				'name_display' => 'Cơ sở - chi nhánh',
			),
			'number_student_max' => array(
				'name_display' => 'Sĩ số tối đa',
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('classroom_model');
		$this->load->model('classroom_model');
	}

	public function index($offset = 0) {

		$this->data['branch'] = $this->get_data_from_model('branch');

		$this->list_filter = array(
			'left_filter' => array(
				'branch' => array(
					'type' => 'arr_multi'
				)
			)
		);

		$conditional = array();
		if ($this->session->userdata('role_id') == 12) {
			$conditional['where']['branch_id'] = $this->session->userdata('branch_id');
		}
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;

//		echo '<pre>';print_r($data);die();

		$data['slide_menu'] = 'cod/common/slide-menu';
//		if($this->role_id == 1){
//			$data['top_nav'] = 'sale/common/top-nav';
//			$data['slide_menu'] = 'sale/common/slide-menu';
//		}
		$data['list_title'] = 'Phòng học';
		$data['edit_title'] = 'Sửa thông tin phòng học';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->load->model('branch_model');

		$input = array();

		$input['where'] = array('active' => 1);

		$branch = $this->branch_model->load_all($input);

		$this->list_add = array(
			'left_table' => array(
				'classroom_id' => array(),
				'branch_id' => array('type' => 'array', 'value' => $branch)
			),
			'right_table' => array(
				'number_student_max' => array(),
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

			$post['add_classroom_id'] = $this->replace_str_to_url($post['add_classroom_id']);

			if ($this->{$this->model}->check_exists(array('classroom_id' => $post['add_classroom_id']))) {
				redirect_and_die('Mã lớp này đã tồn tại!');
			}

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('classroom_id', 'branch_id', 'number_student_max', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm phòng học thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->load->model('branch_model');

		$input = array();

		$input['where'] = array('active' => 1);

		$branch = $this->branch_model->load_all($input);

		$this->list_edit = array(
			'left_table' => array(
				'classroom_id' => array(),
				'branch_id' => array('type' => 'array', 'value' => $branch)
			),
			'right_table' => array(
				'number_student_max' => array(),
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

			$classroom = $this->{$this->model}->load_all($input);

			$post['edit_classroom_id'] = $this->replace_str_to_url($post['edit_classroom_id']);

			if ($post['edit_classroom_id'] != $classroom[0]['classroom_id'] && $this->{$this->model}->check_exists(array('classroom_id' => $post['edit_classroom_id']))) {
				redirect_and_die('Mã phòng học này đã tồn tại!');
			}

			$paramArr = array('classroom_id', 'branch_id', 'number_student_max', 'active');

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

		show_error_and_redirect('Sửa thông tin phòng học thành công!');
	}

}
