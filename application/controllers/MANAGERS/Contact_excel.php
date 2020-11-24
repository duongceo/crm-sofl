<?php

require 'application/core/MY_Table.php';

class Contact_excel extends MY_Table {

	public function __construct() {
		parent::__construct();
		$this->init();
	}

	public function init() {

		$this->controller_path = 'MANAGERS/contact_excel';

		$this->view_path = 'manager/contact_excel';

		$this->sub_folder = 'MANAGERS';

		/*

         * Liệt kê các trường trong bảng

         * - nếu type = text thì không cần khai báo

         * - nếu không muốn hiển thị ra ngoài thì dùng display = none

         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom

         */

		$list_item = array(

//			'id' => array(
//
//				'name_display' => 'ID đối soát'
//
//			),

			'name' => array(

				'name_display' => 'Họ Tên',

//				'order' => '1'

			),

			'email' => array(

//				'type' => 'custom',

				'name_display' => 'Email',

			),

			'phone' => array(

				'name_display' => 'Số điện thoại',

//				'display' => 'none'

			),

//			'address' => array(
//
//				'name_display' => 'Địa chỉ'
//
//			),

//			'course_code' => array(
//
//				'name_display' => 'Khóa học'
//
//			),

//			'price_purchase' => array(
//
//				'type' => 'currency',
//
//				'name_display' => 'Giá mua',
//
//			),

		);

		$this->set_list_view($list_item);

		$this->set_model('contacts_model');

		$this->load->model('contacts_model');

	}

	public function upload_file() {
		$data = $this->data;

		if (!empty($_FILES)) {
			// print_arr($_FILES);

			$tempFile = $_FILES['file']['tmp_name'];

			$fileName = $_FILES['file']['name'];

			$okExtensions = array('xls', 'xlsx');

			$fileParts = explode('.', $fileName);

			if (!in_array(strtolower(end($fileParts)), $okExtensions)) {

				echo 'Vui lòng chọn file đúng định dạng!';
				die;

			}

			// $targetFile = APPPATH . '../public/upload/contact_excel/' . date('Y-m-d-H-i') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

			$targetFile = APPPATH . '/public/upload/contact_excel/' . date('Y-m-d-H-i') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

			// print_arr($tempFile);
			
			if (move_uploaded_file($tempFile, $targetFile)) {
				$this->_import_contact($targetFile);
			} else {
				echo "Tải tệp thất bại";
			}

		} else {

//			$data['slide_menu'] = 'cod/check_L7/slide-menu';

			$data['top_nav'] = 'manager/common/top-nav';

			$data['content'] = 'manager/contact_excel/upload';

			$this->load->view(_MAIN_LAYOUT_, $data);

		}
	}

	private function _import_contact($file_path) {
		// var_dump($file_path);die();

		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);

		$sheet = $objPHPExcel->getActiveSheet();

		$data1 = $sheet->rangeToArray('A1:J700');
		// echo '<pre>'; print_r($data1);die();

		$receive_contact = array();

		foreach ($data1 as $row) {
			$stt = $row[0];
			if ($stt != '') {
				if (in_array($row[7], array(10))) {
					$is_old = 1;
				} else $is_old = 0;

				$receive_contact[] = array(
					'name' => $row[0],
//					'email' => $row[1],
					'phone' => $row[2],
					'branch_id' => $row[3],
					'language_id' => $row[4],
					'date_rgt' => strtotime($row[5]),
					'note' => $row[6],
					'source_id' => $row[7],
					'is_old' => $is_old,
				);
			}
		}

		unset($receive_contact[0]);
//		echo '<pre>';print_r($receive_contact);die();

		foreach ($receive_contact as $value) {
			$data = array(
				'name' => $value['name'],
//				'email' => $value['email'],
				'phone' => $value['phone'],
				'branch_id' => $value['branch_id'],
				'language_id' => $value['language_id'],
				'date_rgt' => $value['date_rgt'],
				'duplicate_id' => $this->_find_dupliacte_contact_excel($value['phone']),
				'source_id' => $value['source_id']
			);

			$id = $this->contacts_model->insert_return_id($data, 'id');
//			$id_backup = $this->contacts_backup_model->insert_return_id($data, 'id');

			if ($value['note'] != '') {
				$param2 = array(
					'contact_id' => $id,
					'content' => $value['note'],
					'time_created' => time(),
					'sale_id' => $this->user_id,
					'contact_code' => $this->contacts_model->get_contact_code($id),
					'class_study_id' => 0
				);

				//print_arr($param2);
				$this->load->model('notes_model');
				$this->notes_model->insert($param2);
			}
		}

	}

	private function _find_dupliacte_contact_excel($phone = '') {

		$dulicate = 0;

		$input = array();

		$input['select'] = 'id';

		$input['like'] = array('phone' => $phone);

		$input['order'] = array('id', 'ASC');

		$rs = $this->contacts_model->load_all($input);

		if (count($rs) > 0) {

			$dulicate = $rs[0]['id'];

		}

		return $dulicate;

	}

}
?>
