<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marketer extends MY_Controller {

    public $L = array();

    public function __construct() {

        parent::__construct();

        $this->_loadCountListContact();

    }

    function delete_item() {

        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');

    }

    function delete_multi_item() {

        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);

    }

    function index($offset = 0) {

		$data = $this->_get_all_require_data();
		$get = $this->input->get();
		//echo '<pre>'; print_r($data['ad']);die;
		
		/*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact đăng kí trong ngày hôm nay
         */
		$conditional['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'marketer_id' => $this->user_id, 'is_hide' => '0');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		//echo '<pre>'; print_r($data_pagination);die

		/*
         * Lấy link phân trang và danh sách contacts
         */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('tv_dk', 'date_rgt', 'channel');
//		$data['right_col'] = array();

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table .= 'adset ads channel date_rgt ordering_stt';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;
		/*
         * Các file js cần load
         */

//		$data['load_js'] = array(
//			'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//			's_check_edit_contact', 's_transfer_contact', 's_show_script', 'm_view_duplicate'
//		);

		$data['progressType_mkt'] = 'Tiến độ các Team ngày hôm nay';
		$data['progress'] = $this->GetProccessMarketerToday();
//		$progress = $this->GetProccessMarketerToday();
		$data['marketers'] = $data['progress']['marketers'];
		$data['C3Team'] = $data['progress']['C3Team'];
		$data['C3Total'] = $data['progress']['total_kpi_mkt'];
		
		$outformModal = 'marketer/modal/view_note_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['titleListContact_mkt'] = 'Danh sách contact mới hôm nay';
		$data['actionForm'] = 'marketer/note_contact';
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);

    }

    function view_all($offset = 0) {

		$data = $this->_get_all_require_data();
		$get = $this->input->get();
		$conditional['where'] = array('marketer_id' => $this->user_id, 'is_hide' => '0');
//		$conditional['order'] = array('date_last_calling' => 'DESC');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['total_contact'] = $data_pagination['total_row'];

		$contact = $data_pagination['data'];

		$this->load->model('call_log_model');
		foreach ($contact as &$value) {
			$input['where'] = array('contact_id' => $value['id']);
			$value['care_number'] = count($this->call_log_model->load_all($input));
		}

		$data['contacts'] = $contact;
		
		$data['left_col'] = array('channel', 'tv_dk', 'date_rgt', 'date_handover');
		$data['right_col'] = array('call_status');
		$this->table .= 'campaign channel date_rgt call_stt level_contact';
		$data['table'] = explode(' ', $this->table);

		/*
         * Các file js cần load
         */

//		$data['load_js'] = array(
//			'common_view_detail_contact', 'common_real_filter_contact', 'common_edit_contact',
//			's_check_edit_contact', 's_transfer_contact', 's_show_script', 'm_view_duplicate'
//		);

		$progress = $this->GetProccessMarketerThisMonth();
		$data['marketers'] = $progress['marketers'];
		$data['C3Team'] = $progress['C3Team'];
		$data['C3Total'] = $progress['total_kpi_mkt'];
		$data['progressType_mkt'] = 'Tiến độ của team tháng này';

		
		$outformModal = 'marketer/modal/view_note_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['actionForm'] = 'marketer/note_contact';
        $data['titleListContact_mkt'] = 'Danh sách toàn bộ contact';
		$data['content'] = 'common/list_contact';

        $this->load->view(_MAIN_LAYOUT_, $data);

    }

	private function _get_all_require_data() {
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 1,
					'active' => 1
				)
			),
//			'courses' => array(
//				'where' => array('active' => '1'),
//				'order' => array(
//					'course_code' => 'ASC'
//				)
//			),
//			'transfer_logs' => array(),
			'call_status' => array('order' => array('sort' => 'ASC')),
//			'ordering_status' => array('order' => array('sort' => 'ASC')),
//			'cod_status' => array(),
			'payment_method_rgt' => array(),
			'channel' => array(),
			'campaign' => array(),
			'sources' => array(),
			'adset' => array(),
			'ad' => array(),
		);
		return array_merge($this->data, $this->_get_require_data($require_model));
	}

    protected function _loadCountListContact() {

        $input = array();

        $input['select'] = 'id';

        $input['where']['marketer_id'] = $this->user_id;

        $input['where']['is_hide'] = '0';

        $input['where']['date_rgt >'] = strtotime(date('d-m-Y'));

        $this->L['C3'] = count($this->contacts_model->load_all($input));


        $input = array();

        $input['select'] = 'id';

        $input['where']['marketer_id'] = $this->user_id;

        $input['where']['date_confirm >'] = strtotime(date('d-m-Y'));

        $this->L['L6'] = count($this->contacts_model->load_all($input));


        $input = array();

        $input['select'] = 'id';

        $input['where']['marketer_id'] = $this->user_id;

        $input['where']['date_confirm >'] = strtotime(date('1-m-Y'));

        $this->L['L6All'] = count($this->contacts_model->load_all($input));


        $input = array();

        $input['select'] = 'id';

        $input['where']['marketer_id'] = $this->user_id;

        $input['where']['is_hide'] = '0';

        $this->L['all'] = count($this->contacts_model->load_all($input));

    }

	protected function GetProccessMarketerToday() {

		$marketers = $this->staffs_model->GetActiveMarketers();

		$total_kpi_mkt = 0;

		foreach ($marketers as $key => &$marketer) {

			$total_kpi_mkt += $marketer['targets'];

			$inputContact = array();

			$inputContact['select'] = 'id';

			$inputContact['where'] = array(
				'marketer_id' => $marketer['id'],
				'date_rgt >=' => strtotime(date('d-m-Y')),
				'is_hide' => '0'
			);

			$today = $this->contacts_model->load_all($inputContact);

			$marketer['totalC3'] = count($today);

			$marketer['progress'] = ($marketer['targets'] > 0) ? round(($marketer['totalC3'] / $marketer['targets']) * 100, 2) : 'N/A';
		}

		unset($marketer);

		usort($marketers, function($a, $b) {

			return -$a['totalC3'] + $b['totalC3'];

		});

		$inputContact = array();

		$inputContact['select'] = 'id';

		$inputContact['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');

		$today = $this->contacts_model->load_all($inputContact);

		$C3Team = count($today);

//		 print_arr($marketers);

		return array('marketers' => $marketers, 'C3Team' => $C3Team, 'total_kpi_mkt' => $total_kpi_mkt);
	}

	protected function GetProccessMarketerThisMonth() {

		$marketers = $this->staffs_model->GetActiveMarketers();

		$total_kpi_mkt = 0;

		foreach ($marketers as $key => &$marketer) {

			$total_kpi_mkt += $marketer['targets'] * 30;

			$inputContact = array();

			$inputContact['select'] = 'id';

			$inputContact['where'] = array('marketer_id' => $marketer['id'], 'date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');

			$today = $this->contacts_model->load_all($inputContact);

			$marketer['totalC3'] = count($today);

			$marketer['targets'] = $marketer['targets'] * 30;

			$marketer['progress'] = ($marketer['targets'] > 0) ? round(($marketer['totalC3'] / $marketer['targets']) * 100, 2) : 'N/A';
		}

		unset($marketer);

		usort($marketers, function($a, $b) {

			return -$a['totalC3'] + $b['totalC3'];
		});

		$inputContact = array();

		$inputContact['select'] = 'id';

		$inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');

		$today = $this->contacts_model->load_all($inputContact);

		$C3Team = count($today);

		// print_arr($marketers);

		return array('marketers' => $marketers, 'C3Team' => $C3Team, 'total_kpi_mkt' => $total_kpi_mkt);
	}
	
	public function get_ma_mkt() {
		$this->load->model('campaign_spend_model');
		$data = $this->data;
		//echo '<pre>'; print_r($data); die();

		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];

			$fileName = $_FILES['file']['name'];

			$okExtensions = array('xls', 'xlsx');

			$fileParts = explode('.', $fileName);

			if (!in_array(strtolower(end($fileParts)), $okExtensions)) {

				echo 'Vui lòng chọn file đúng định dạng!';

				die;

			}

			$targetFile = APPPATH . '../public/upload/chi_phi_mkt/' . $this->user_id . '-' . date('Y-m-d-H-i') . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

			move_uploaded_file($tempFile, $targetFile);

			$this->load->library('PHPExcel');

			$objPHPExcel = PHPExcel_IOFactory::load($targetFile);

			$sheet = $objPHPExcel->getActiveSheet();

			$data = $sheet->rangeToArray('A2:H100');

			foreach ($data as $value) {
				if ($value[3] != 0 && isset($value[3])) {
					$input1['where'] = $where = array(
						'campaign_id' => $this->campaign_model->find_campaign_id($value[3]),
						'time' => strtotime($value[0])
					);
					// echo "<pre>";print_r($input['where']);die();
					if (!empty($this->campaign_spend_model->load_all($input1))) {
						$this->campaign_spend_model->delete($where);
					}

					$param['time'] = strtotime($value[0]);
					$param['campaign_id'] = $this->campaign_model->find_campaign_id($value[3]);
					$param['campaign_id_fb'] = $value[3];
					$param['total_C1'] = $value[4];
					$param['total_C2'] = $value[5];
					$param['spend'] = $value[6];
					$param['date_create'] = time();
					$param['date_spend'] = date('Y-m-d', $param['time']);
					
					//echo "<pre>";print_r($param);die();
					
					$this->campaign_spend_model->insert($param);
				}
			}
			redirect(base_url('marketer/get_ma_mkt'));
		} else {

			$this->load->model('campaign_model');
			$this->load->model('staffs_model');

			$get = $this->input->get();
//			echo '<pre>';print_r($get);die();

			if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
				$time = $get['filter_date_date_happen'];
			} else {
				$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
			}

			$dateArr = explode('-', $time);
			$date_from = trim($dateArr[0]);
			$date_from = strtotime(str_replace("/", "-", $date_from));
			$date_end = trim($dateArr[1]);
			$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24;

			$marketer_id = $this->user_id;
			$input_fb['where'] = array(
				'marketer_id' => $marketer_id,
				'channel_id' => 2
			);
			$campaign_fb = $this->campaign_model->load_all($input_fb);
			$campaign_fb_list = array();
			foreach ($campaign_fb as $value) {
				$campaign_fb_list[] = $value['id'];
			}

			$input['where'] = array(
				'time >=' => $date_from,
				'time <' => $date_end
			);
			$input['where_in'] = array(
				'campaign_id' => $campaign_fb_list
			);
			if (isset($get['filter_number_records'])) {
				$input['limit'] = array($get['filter_number_records']);
			} else {
				$input['limit'] = array(40);
			}
			$input['order']['time'] = 'desc';
			$campaign_spend = $this->campaign_spend_model->load_all($input);
			$spend_fb = 0;
			foreach ($campaign_spend as $value) {
				$data['campaign'][] = array(
					'campaign_name' => $this->campaign_model->find_campaign_name($value['campaign_id']),
					'id_fb' => $value['campaign_id_fb'],
					'account' => $this->campaign_model->find_acc_name($value['campaign_id']),
					'spend' => str_replace(',', '.', number_format($value['spend'])),
					'time' => $value['time'],
					'date_create' => $value['date_create'],
					'user_create' => $this->staffs_model->find_staff_name($marketer_id)
				);
				$spend_fb = $spend_fb + $value['spend'];
			}

			$data['total_spend'] = str_replace(',', '.', number_format($spend_fb));
			$data['startDate'] = isset($date_from) ? $date_from : '0';
			$data['endDate'] = isset($date_end) ? $date_end : '0';
			$data['left_col'] = array('date_happen_1');
			$data['content'] = 'marketer/upload';
			//echo '<pre>';print_r($data);die();

			$this->load->view(_MAIN_LAYOUT_, $data);
		}
	}
	
	public function note_contact() {
		$post = $this->input->post();
		//echo '<pre>';print_r($post);die();
		$result = array();
		if ($post['note'] != '') {
			$param2 = array(
				'contact_id' => $post['contact_id'],
				'content' => $post['note'],
				'time' => time(),
				'sale_id' => $this->user_id,
				'contact_code' => $this->contacts_model->get_contact_code($post['contact_id'])
			);
			$this->load->model('notes_model');
			$this->notes_model->insert($param2);
			
			$input['where'] = array('id' => $post['contact_id']);
			$c = $this->contacts_model->load_all($input);
			$mkt_name = $this->staffs_model->find_staff_name($this->user_id);

			$result['success'] = 1;
			$result['message'] = 'Note contact thành công';
			echo json_encode($result);
			
			require_once APPPATH . 'libraries/Pusher.php';
			$options = array(
				'cluster' => 'ap1',
				'encrypted' => true
			);
			$pusher = new Pusher(
				'32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
			);
			
			$dataPush['title'] = 'MKT';
			$dataPush['sale'] = $c[0]['sale_staff_id'];
			$dataPush['message'] = 'MKT "' . $mkt_name . '" đã note cho contact "' . $c[0]['phone'] . '" với nội dung "' . $post['note'] . ' "';
			$dataPush['success'] = '1';
			$dataPush['image'] = $this->staffs_model->GetStaffImage($this->user_id);
			$pusher->trigger('my-channel', 'marketer_note', $dataPush);
			
			die;
		}
	}

}

