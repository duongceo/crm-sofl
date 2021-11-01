<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Book extends MY_Table {

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
		$this->controller_path = 'staff_managers/book';
		$this->view_path = 'staff_managers/book';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'name' => array(
				'name_display' => 'Tên',
			),
            'price' => array(
                'type' => 'custom',
                'name_display' => 'Giá',
            ),
            'language' => array(
                'type' => 'custom',
                'value' => $this->get_data_from_model('language_study'),
                'name_display' => 'Ngoại ngữ',
//                'display' => 'none'
            ),
            'level_language' => array(
                'type' => 'custom',
                'value' => $this->get_data_from_model('level_language'),
                'name_display' => 'Trình độ',
                //'display' => 'none'
            ),
            'branch' => array(
                'type' => 'custom',
                'value' => $this->get_data_from_model('branch'),
                'name_display' => 'Cơ sở',
//                'display' => 'none'
            ),
            'quantity' => array(
                'name_display' => 'Số lượng',
            ),
			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('book_model');
		$this->load->model('book_model');
	}

	public function index($offset = 0) {
		$conditional = array();
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;

		$data['list_title'] = 'Sách';
		$data['edit_title'] = 'Sửa thông tin sách';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {
		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/
		$this->list_add = array(
			'left_table' => array(
				'name' => array(),
                'price' => array(
                    'type' => 'custom'
                ),
                'language_id' => array(
                    'type' => 'array',
                    'value' => $this->get_data_from_model('language_study')
                ),
                'level_language_id' => array(
                    'type' => 'custom'
                ),
			),
			'right_table' => array(
			    'quantity' => array(),
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
	}

	function action_add_item() {

		$post = $this->input->post();

		if (!empty($post)) {


			if ($post['add_active'] != '0' && $post['add_active'] != '1') {

				redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
			}

			$paramArr = array('name', 'branch_id', 'level_language_id', 'language_id', 'quantity', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

            if ($post['add_price'] != 0) {
                $param['price'] = str_replace(',', '', $post['add_price']);
            }

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm sách mới thành công!');
		}
	}

	function show_edit_item($inputData = []) {
		$this->list_edit = array(
            'left_table' => array(
                'name' => array(),
                'price' => array(
                    'type' => 'custom'
                ),
                'language_id' => array(
                    'type' => 'array',
                    'value' => $this->get_data_from_model('language_study')
                ),
                'level_language_id' => array(
                    'type' => 'array',
                    'value' => $this->get_data_from_model('level_language')
                ),
            ),
            'right_table' => array(
                'quantity' => array(),
                'branch_id' => array(
                    'type' => 'array',
                    'value' => $this->get_data_from_model('branch'),
                ),
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

			$where = array('id' => $id);

            $paramArr = array('name', 'branch_id', 'level_language_id', 'language_id', 'quantity', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];

				}
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

			$this->{$this->model}->update($where, $param);
		}

		show_error_and_redirect('Sửa thông tin sách thành công!');
	}

}
