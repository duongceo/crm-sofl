<?php

require_once("application/core/MY_Table.php");

/**
 * Description of Course
 *
 * @author QuangNV
 */

class Staff extends MY_Table {

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
		$this->controller_path = 'staff_managers/staff';
		$this->view_path = 'staff_managers/staff';
		$this->sub_folder = 'staff_managers';
		$list_view = array(
			'name' => array(
				'name_display' => 'Tên',
			),

			'user_name' => array(
				'name_display' => 'Tên đăng nhâp',
			),

			'phone' => array(
				'name_display' => 'Số ĐT',
			),

			'role' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('role'),
				'name_display' => 'Vị trí',
			),

			'branch_id' => array(
				'type' => 'custom',
				'value' => $this->get_data_from_model('branch'),
				'name_display' => 'Thuộc cơ sở',
			),

			'email' => array(
				'name_display' => 'Email',
			),

			'active' => array(
				'type' => 'active',
				'name_display' => 'Hoạt động'
			),
		);
		$this->set_list_view($list_view);
		$this->set_model('staffs_model');
		$this->load->model('staffs_model');
	}

	public function index($offset = 0) {
		$conditional = array();
		$this->set_conditional($conditional);
		$this->set_offset($offset);
		$this->show_table();
		$data = $this->data;
        $data['role'] = $this->get_data_from_model('role');
        $this->list_filter = array(
            'left_filter' => array(
                'role' => array(
                    'type' => 'arr_multi'
                ),
            )
        );

		$data['list_title'] = 'nhân viên';
		$data['edit_title'] = 'Sửa thông tin nhân viên';
		$data['content'] = 'base/index';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function show_add_item() {

		/*type mặc định là text nên nếu là text sẽ không cần khai báo*/

		$this->list_add = array(
			'left_table' => array(
				'name' => array(),
				'user_name' => array(),
				'password' => array(
					'type' => 'custom'
				),
				'phone' => array(),
			),
			'right_table' => array(
				'role_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('role')
				),
                'ipphone_user_name' => array(
                    'type' => 'custom'
                ),
                'ipphone_password' => array(
                    'type' => 'custom'
                ),
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

			$paramArr = array('user_name', 'phone', 'email', 'name', 'role_id', 'branch_id', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['add_' . $value])) {

					$param[$value] = $post['add_' . $value];
				}
			}

			if (isset($post['add_password'])) {
				$param['password'] = md5(md5($post['add_password']));
			}

			if (isset($post['add_max_contact'])) {
				$param['max_contact'] = md5(md5($post['add_max_contact']));
			}
			if (isset($post['add_targets'])) {
				$param['targets'] = md5(md5($post['add_targets']));
			}

            $param['ipphone_user_name'] = trim($post['ipphone_user_name']);
            $param['ipphone_password'] = trim($post['ipphone_password']);

			$param['time_created'] = time();

			$this->{$this->model}->insert($param);

			show_error_and_redirect('Thêm nhân viên thành công!');
		}
	}

	function show_edit_item($inputData = []) {

		$this->list_edit = array(
			'left_table' => array(
				'name' => array(),
				'user_name' => array(),
				'password' => array(
					'type' => 'custom'
				),
				'phone' => array(),
			),
			'right_table' => array(
				'role_id' => array(
					'type' => 'array',
					'value' => $this->get_data_from_model('role')
				),
                'ipphone_user_name' => array(
                    'type' => 'custom'
                ),
                'ipphone_password' => array(
                    'type' => 'custom'
                ),
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

			$staff = $this->{$this->model}->load_all($input);

			if ($post['edit_user_name'] != $staff[0]['user_name'] && $this->{$this->model}->check_exists(array('user_name' => $post['edit_user_name']))) {
				redirect_and_die('Tên đăng nhập này đã tồn tại!');
			}

			$paramArr = array('user_name', 'phone', 'email', 'name', 'role_id', 'branch_id', 'active');

			foreach ($paramArr as $value) {

				if (isset($post['edit_' . $value])) {

					$param[$value] = $post['edit_' . $value];
				}
			}

			if (isset($post['edit_password']) && $post['edit_password'] != '') {
				$param['password'] = md5(md5($post['edit_password']));
			}

			if (!isset($post['edit_active']) && empty($post['edit_active'])) {
				$param['active'] = 0;
			}

            $param['ipphone_user_name'] = trim($post['ipphone_user_name']);
            $param['ipphone_password'] = trim($post['ipphone_password']);

			$this->{$this->model}->update($input['where'], $param);
		}

		show_error_and_redirect('Sửa thông tin nhân viên thành công!');
	}

	public function get_kpi() {
		$post = $this->input->post();

		if ($post['role_id'] == 1) {
			echo '<td class="text-right"> Số lượng contact nhận tối đa</td>
				<td>
					<input type="text" name="add_max_contact" class="form-control" value="" />
				</td>';
		} elseif ($post['role_id'] == 6) {
			echo '<td class="text-right"> KPI </td>
				<td>
					<input type="text" name="add_targets" class="form-control" value="" />
				</td>';
		}
	}

}
