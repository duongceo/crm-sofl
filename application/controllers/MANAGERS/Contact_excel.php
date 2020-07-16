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

			'address' => array(

				'name_display' => 'Địa chỉ'

			),

			'course_code' => array(

				'name_display' => 'Khóa học'

			),

			'price_purchase' => array(

				'type' => 'currency',

				'name_display' => 'Giá mua',

			),

		);

		$this->set_list_view($list_item);

		$this->set_model('contacts_model');

		$this->load->model('contacts_model');

	}

	public function upload_file() {
		$data = $this->data;

		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];

			$fileName = $_FILES['file']['name'];

			$okExtensions = array('xls', 'xlsx');

			$fileParts = explode('.', $fileName);

			if (!in_array(strtolower(end($fileParts)), $okExtensions)) {

				echo 'Vui lòng chọn file đúng định dạng!';
				die;

			}

			$targetFile = APPPATH . '../public/upload/contact_excel/' . date('Y-m-d-H-i') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

			move_uploaded_file($tempFile, $targetFile);

//			var_dump($targetFile);die();
			$this->_import_contact($targetFile);

		} else {

//			$data['slide_menu'] = 'cod/check_L7/slide-menu';

			$data['top_nav'] = 'manager/common/top-nav';

			$data['content'] = 'manager/contact_excel/upload';

			$this->load->view(_MAIN_LAYOUT_, $data);

		}
	}

	private function _import_contact($file_path) {
//		var_dump($file_path);die();
		$this->load->library('PHPExcel');

		$objPHPExcel = PHPExcel_IOFactory::load($file_path);

		$sheet = $objPHPExcel->getActiveSheet();

		$data1 = $sheet->rangeToArray('A1:F1000');
//		echo '<pre>'; print_r($data1);die();
		$receive_contact = array();

		foreach ($data1 as $row) {

			$stt = $row[0];

			if ($stt != '') {

				$receive_contact[] = array(
					'name' => $row[0],
					'email' => $row[1],
					'phone' => $row[2],
					'address' => $row[3],
					'course_code' => $row[4],
					'price_purchase' => $row[5]
				);
			}
		}

		unset($receive_contact[0]);
//		echo '<pre>';print_r($receive_contact);die();

		foreach ($receive_contact as $value) {

			$data = array(
				'name' => $value['name'],
				'email' => $value['email'],
				'phone' => $value['phone'],
				'address' => $value['address'],
				'course_code' => $value['course_code'],
				'price_purchase' => $value['price_purchase'],
				'date_rgt' => time(),
				'last_activity' => time(),
				'duplicate_id' => $this->_find_dupliacte_contact_excel($value['email'], $value['phone'], $value['course_code'])
			);

			$this->contacts_model->insert_from_mol($data);
			$this->contacts_backup_model->insert_from_mol($data);
		}

	}

	private function _find_dupliacte_contact_excel($email = '', $phone = '', $course_code = '') {

		$dulicate = 0;

		$input = array();

		$input['select'] = 'id';

		$input['where'] = array(

			'phone' => $phone,

			'course_code' => $course_code,

			 'is_hide' => '0'
		);

		$input['order'] = array('id', 'ASC');

		$rs = $this->contacts_model->load_all($input);

		if (count($rs) > 0) {

			$dulicate = $rs[0]['id'];

		}

		return $dulicate;

	}

}
?>
