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
			if (isset($post['targets'])) {
				$param['targets'] = $post['targets'];
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
				'targets' => array(
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

            if (isset($post['targets'])) {
                $param['targets'] = $post['targets'];
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
		} elseif ($post['role_id'] == 6 || $post['role_id'] == 11) {
			echo '<td class="text-right"> KPI </td>
				<td>
					<input type="text" name="targets" class="form-control" value="" />
				</td>';
		}
	}

	public function view_salary_staff() {
		$this->load->model('salary_staff_model');

		$data = $this->data;

		$get = $this->input->get();

		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$date_from_arr = trim($dateArr[0]);
		$date_from = strtotime(str_replace("/", "-", $date_from_arr));
		$date_end_arr = trim($dateArr[1]);
		$date_end = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24 - 1;

		$input = array();
		$input['where'] = array(
			'day_salary >=' => $date_from,
			'day_salary <=' => $date_end,
		);
		$input['limit'] = array(100, 0);

		if (isset($get['filter_search_name']) && !empty($get['filter_search_name'])) {
			$input['like']['name'] = $get['filter_search_name'];
		}

		$input['order']['day_salary'] = 'desc';

		$salary = $this->salary_staff_model->load_all($input);

		$post = $this->input->post();
		if (isset($post) && !empty($post)) {
			$param['name'] = $post['name'];
			$param['email'] = trim($post['email']);
			$param['salary_basic'] = str_replace(',', '', $post['salary_basic']);
			$param['work_per_month'] = $post['work_per_month'];
			$param['work_diligence'] = $post['work_diligence'];
			$param['work_OT'] = $post['work_OT'];
			$param['punish_late'] = str_replace(',', '', $post['punish_late']);
			$param['com'] = str_replace(',', '', $post['com']);
			$param['kpi_per_kol'] = str_replace(',', '', $post['kpi_per_kol']);
			$param['federation'] = str_replace(',', '', $post['federation']);
			$param['cost_other'] = str_replace(',', '', $post['cost_other']);
			$param['insurance'] = str_replace(',', '', $post['insurance']);
			$param['allowance'] = str_replace(',', '', $post['allowance']);
			$param['salary_other'] = str_replace(',', '', $post['salary_other']);
			$param['day_salary'] = strtotime(str_replace("/", "-", $post['day_salary']));
			$param['time_created'] = time();
			$param['user_id'] = $this->user_id;
			$param['day'] = date('d-m-Y', strtotime($post['day_salary']));
			$param['on_leave'] = $post['on_leave'];

			$this->salary_staff_model->insert($param);
			redirect(base_url('staff_managers/staff/view_salary_staff'));
		}

		$data['salary'] = $salary;
		$data['startDate'] = isset($date_from) ? $date_from : '0';
		$data['endDate'] = isset($date_end) ? $date_end : '0';
		$data['left_col'] = array('date_happen_1');
		$data['content'] = 'staff_managers/staff/salary/view_salary_staff';

		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function send_mail_salary_staff() {
		$this->load->model('salary_staff_model');

		$post = $this->input->post();

		$input['where'] = array(
			'id' => $post['salary_id']
		);

		$salary_staff = $this->salary_staff_model->load_all($input);
		$data['salary'] = $salary_staff ? $salary_staff[0] : array();

		if (!empty($salary_staff[0]['email'])) {
			$this->load->library('email');
			$this->email->from('minhduc.sofl@gmail.com', 'TRUNG TÂM NGOẠI NGỮ SOFL');
			$mail_teacher = trim($salary_staff[0]['email']);
			$this->email->to($mail_teacher);
//          $this->email->to('ngovanquang281997@gmail.com');
			$subject = '[SOFL] GỬI BẢNG KÊ LƯƠNG';
			$this->email->subject($subject);
			$message = $this->load->view('staff_managers/staff/salary/email_salary_staff', $data, true);
			$this->email->message($message);

			if ($this->email->send()) {
				$param['day_send_mail'] = time();
				$this->salary_staff_model->update(array('id' => $salary_staff[0]['id']), $param);

				$result['success'] = true;
				$result['message'] =  'Đã gửi mail thành công';
			} else {
				$result['success'] = false;
				$result['message'] =  'Có gì đó ko đúng, chưa gửi đc mail';
				show_error($this->email->print_debugger());
			}
		} else {
			$result['success'] = false;
			$result['message'] =  'Chưa có email';
		}

		echo json_encode($result);
		die();
	}

}
