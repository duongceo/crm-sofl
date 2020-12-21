<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Language_study extends MY_Table {

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
		$this->controller_path = 'staff_managers/language_study';
		$this->view_path = 'staff_managers/language_study';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'language_id' => array(
				'name_display' => 'Mã ngôn ngữ',
//				'order' => '1'
			),
			'name' => array(
				'name_display' => 'Tên',
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('language_study_model');
		$this->load->model('language_study_model');
	}

	public function index($offset = 0) {
		$conditional = array();
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;

//		echo '<pre>';print_r($data);die();

//		$data['slide_menu'] = 'cod/common/slide-menu';
//		if($this->role_id == 1){
//			$data['top_nav'] = 'sale/common/top-nav';
//			$data['slide_menu'] = 'sale/common/slide-menu';
//		}
		$data['list_title'] = 'Ngôn ngữ';
		$data['edit_title'] = 'Sửa thông tin ngôn ngữ';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->list_add = array(
			'left_table' => array(
				'language_id' => array(),
				'name' => array()
			),
			'right_table' => array(
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

			$post['add_language_id'] = $this->replace_str_to_url($post['add_language_id']);

			if ($this->{$this->model}->check_exists(array('language_id' => $post['add_language_id']))) {
				redirect_and_die('Mã lớp này đã tồn tại!');
			}

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('language_id', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm ngôn ngữ thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->list_edit = array(
			'left_table' => array(
				'language_id' => array(),
				'name' => array()
			),
			'right_table' => array(
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

			$post['edit_language_id'] = $this->replace_str_to_url($post['edit_language_id']);

			if ($post['edit_language_id'] != $classroom[0]['language_id'] && $this->{$this->model}->check_exists(array('language_id' => $post['edit_language_id']))) {
				redirect_and_die('Mã ngôn ngữ này đã tồn tại!');
			}

			$paramArr = array('language_id', 'name', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];
				}
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

//			echo '<pre>'; print_r($param); die();

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin ngôn ngữ thành công!');
	}

}
