<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Branch extends MY_Table {

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
		$this->controller_path = 'staff_managers/branch';
		$this->view_path = 'staff_managers/branch';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'branch_id' => array(
				'name_display' => 'Mã cơ sở',
//				'order' => '1'
			),
			'name' => array(
				'name_display' => 'Tên cơ sở',
			),
			'address' => array(
//				'type' => 'currency',
				'name_display' => 'Địa chỉ',
			),
			'hotline' => array(
//				'type' => 'custom',
				'name_display' => 'Số đt hotline',
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),

		);
		$this->set_list_view($list_view);
		$this->set_model('branch_model');
		$this->load->model('branch_model');
	}

	public function index($offset = 0) {
		$conditional = array();
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;

//		echo '<pre>';print_r($data);die();

		$data['slide_menu'] = 'cod/common/slide-menu';
		if($this->role_id == 1){
			$data['top_nav'] = 'sale/common/top-nav';
			$data['slide_menu'] = 'sale/common/slide-menu';
		}
		$data['list_title'] = 'cơ sở - chi nhánh';
		$data['edit_title'] = 'Sửa thông tin cơ sở - chi nhánh';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

//	function edit_item() {
//		/*
//         * type mặc định là text nên nếu là text sẽ không cần khai báo
//         */
//		$this->list_edit = array(
//			'left_table' => array(
//				'id' => array(
//					'type' => 'disable'
//				),
//				'course_code' => array(),
//				'name_course' => array()
//			),
//			'right_table' => array(
//				'course_code' => array(),
//				'active' => array(),
//			),
//		);
//		parent::edit_item();
//	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->load->model('branch_model');

		$this->list_add = array(
			'left_table' => array(
				'name' => array(),
				'branch_id' => array()
			),
			'right_table' => array(
				'hotline' => array(),
				'address' => array(),
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

		// echo "<pre>";print_r($post);die();

		if (!empty($post)) {

			$post['add_branch_id'] = $this->replace_str_to_url($post['add_branch_id']);

			if ($this->{$this->model}->check_exists(array('branch_id' => $post['add_branch_id']))) {

				redirect_and_die('Mã cơ sở này đã tồn tại!');
			}

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('name', 'branch_id', 'active', 'address', 'hotline');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm cơ sở - chi nhánh thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->load->model('branch_model');

//		$input = array();
//
//		$input['where'] = array('active' => 1);
//
//		$branch = $this->branch_model->load_all($input);

		$this->list_edit = array(
			'left_table' => array(
				'name' => array(),
				'branch_id' => array()
			),
			'right_table' => array(
				'hotline' => array(),
				'address' => array(),
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

			$branch = $this->{$this->model}->load_all($input);

			$post['edit_branch_id'] = $this->replace_str_to_url($post['edit_branch_id']);

			if ($post['edit_branch_id'] != $branch[0]['branch_id'] && $this->{$this->model}->check_exists(array('branch_id' => $post['edit_branch_id']))) {
				redirect_and_die('Mã cơ sở này đã tồn tại!');
			}

			$paramArr = array('name','address', 'branch_id', 'active', 'hotline');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];
				}
			}

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin cơ sở thành công!');
	}

}
