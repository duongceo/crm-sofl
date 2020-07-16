<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Class_time extends MY_Table {

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
		$this->controller_path = 'staff_managers/class_time';
		$this->view_path = 'staff_managers/class_time';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'classroom_id' => array(
				'name_display' => 'Mã phòng học',
			),
			'time' => array(
				'name_display' => 'Ca học',
			),
			'days' => array(
				'name_display' => 'Thứ ngày',
			),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động ko ?',
			),
			'empty' => array(
				'type' => 'custom',
				'name_display' => 'Còn trống ko ?',
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('class_time_model');
		$this->load->model('class_time_model');
	}

	public function index($offset = 0) {

		$this->list_filter = array(
			'left_filter' => array(
				'empty' => array(
					'type' => 'binary',
				),
				'active' => array(
					'type' => 'binary',
				),
				'classroom_id' => array(
					'type' => 'custom',
					'value' => $this->get_data_from_model('classroom'),
				),
			)
		);

		$conditional = array();
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

		$data['list_title'] = 'Phòng & Ca học';
		$data['edit_title'] = 'Sửa thông tin phòng & ca học';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->list_add = array(
			'left_table' => array(
				'classroom_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('classroom')
				),
				'time' => array(
					'type' => 'custom'
				),
				'days' => array(
					'type' => 'custom'
				),
			),

			'right_table' => array(
				'active' => array(
					'type' => 'active'
				),
//				'empty' => array(
//					'type' => 'empty'
//				),
			),
		);

		parent::show_add_item();
//		$this->load->view('base/add_item/ajax_content');
	}

	function action_add_item() {

		$post = $this->input->post();

		if (!empty($post)) {

			if ($post['add_active'] != '0' && $post['add_active'] != '1') {
				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('classroom_id', 'time', 'days');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];

				}
			}

			if ($this->{$this->model}->check_exists($param)) {
				redirect_and_die('Phòng học và ca học này đã tồn tại!');
			}

			$param['active'] = (isset($post['add_active'])) ? $post['add_active'] : 0;
			$param['empty'] = (isset($post['add_empty'])) ? $post['add_empty'] : 0;

//			$param['time_created'] = time();

//			echo '<pre>';print_r($param);die();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm phòng và ca học thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->list_edit = array(
			'left_table' => array(
				'classroom_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('classroom')
				),
				'time' => array(
					'type' => 'custom'
				),
				'days' => array(
					'type' => 'custom'
				),
			),

			'right_table' => array(
				'active' => array(
					'type' => 'active'
				),
				'empty' => array(
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

//			$class_time = $this->{$this->model}->load_all($input);

			if ($post['edit_active'] != '0' && $post['edit_active'] != '1') {
				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('classroom_id', 'time', 'days');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];

				}
			}

//			if ($this->{$this->model}->check_exists($param)) {
//				redirect_and_die('Phòng học và ca học này đã tồn tại!');
//			}

			$param['active'] = (isset($post['edit_active'])) ? $post['edit_active'] : 0;
			$param['empty'] = (isset($post['edit_empty'])) ? $post['edit_empty'] : 0;

//			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
//				$param['active'] = 0;
//			}

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin lớp học thành công!');
	}

}
