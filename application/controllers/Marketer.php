<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marketer extends MY_Controller {

    public $L = array();

    public function __construct() {

        parent::__construct();

        $this->_loadCountListContact();

    }

    function index($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		/* Điều kiện lấy contact : contact ở trang chủ là contact đăng kí trong ngày hôm nay */
		$conditional['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'marketer_id' => $this->user_id);

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/* Lấy link phân trang và danh sách contacts */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/* Filter ở cột trái và cột phải */
		$data['left_col'] = array('date_rgt', 'channel');
//		$data['right_col'] = array();

		/* Các trường cần hiện của bảng contact (đã có default) */
		$this->table .= 'channel campaign call_stt level_contact';
		$data['table'] = explode(' ', $this->table);
		//echo '<pre>'; print_r($data['table']);die;

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

    public function contact_sale_handle($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['(call_status_id IN (1, 3, 5) OR level_contact_detail IN ("L1.1", "L1.2", "L1.3", "L1.6"))'] = 'NO-VALUE';
		$conditional['where']['check_contact'] = '0';
//		$conditional['where_in']['call_status_id'] = array(1, 3, 5);
//		$conditional['where_in']['level_contact_detail'] = array("L1.1", "L1.2", "L1.3");
//		print_arr($conditional);
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		$this->load->model('notes_model');
		foreach ($data['contacts'] as &$value) {
			$input = array();
			$input['where'] = array('contact_id' => $value['id']);
			$input['order'] = array('id' => 'DESC');
			$last_note = $this->notes_model->load_all($input);
			$notes = '';
			if (!empty($last_note)) {
				foreach ($last_note as $value2) {
					$notes .= '<p>' . date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . '</p>';
				}
				$value['last_note'] = $notes;
			} else {
				$value['last_note'] = $notes;
			}
		}
		unset($value);

		$data['left_col'] = array('date_rgt', 'date_last_calling', 'language');
		$data['right_col'] = array('branch', 'source');

		$this->table .= 'last_note call_stt level_contact';
		$data['table'] = explode(' ', $this->table);

		$outformModal = 'marketer/modal/view_note_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['actionForm'] = 'marketer/note_contact';
		$data['titleListContact'] = 'Danh sách contact Sale xử lý';
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

    function view_all($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();
		$conditional['where'] = array('marketer_id' => $this->user_id);
//		$conditional['order'] = array('date_last_calling' => 'DESC');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['total_contact'] = $data_pagination['total_row'];

		$contact = $data_pagination['data'];
        $data['contacts'] = $contact;

//		$this->load->model('call_log_model');
//		foreach ($contact as &$value) {
//			$input['where'] = array('contact_id' => $value['id']);
//			$value['care_number'] = count($this->call_log_model->load_all($input));
//		}

        $data['care_page_staff'] = $this->staffs_model->load_all(array('where' => array('role_id' => 11, 'active' => 1)));

		$data['left_col'] = array('channel', 'date_rgt', 'date_handover');
		$data['right_col'] = array('call_status', 'care_page_staff');
		$this->table .= 'channel campaign date_rgt call_stt level_contact';
		$data['table'] = explode(' ', $this->table);

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
			'call_status' => array('order' => array('sort' => 'ASC')),
			'level_language' => array(),
			'language_study' => array(),
			'branch' => array(),
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

        $input['where']['date_rgt >'] = strtotime(date('d-m-Y'));

        $this->L['C3'] = count($this->contacts_model->load_all($input));


//        $input = array();
//
//        $input['select'] = 'id';
//
//        $input['where']['marketer_id'] = $this->user_id;
//
//        $input['where']['date_confirm >'] = strtotime(date('d-m-Y'));
//
//        $this->L['L6'] = count($this->contacts_model->load_all($input));

//
//        $input = array();
//
//        $input['select'] = 'id';
//
//        $input['where']['marketer_id'] = $this->user_id;
//
//        $input['where']['date_confirm >'] = strtotime(date('1-m-Y'));
//
//        $this->L['L6All'] = count($this->contacts_model->load_all($input));


        $input = array();

        $input['select'] = 'id';

        $input['where']['marketer_id'] = $this->user_id;

        $this->L['all'] = count($this->contacts_model->load_all($input));

    }

	protected function GetProccessMarketerToday() {

		$marketers = $this->staffs_model->load_all(array('where' => array('role_id' => 11, 'active' => 1)));

		$total_kpi_mkt = 0;

		foreach ($marketers as $key => &$marketer) {

			$total_kpi_mkt += $marketer['targets'];

			$inputContact = array();

			$inputContact['select'] = 'id';

			$inputContact['where'] = array(

				'care_page_staff_id' => $marketer['id'],

				'date_rgt >=' => strtotime(date('d-m-Y'))

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

		$inputContact['where'] = array('date_rgt >' => strtotime(date('d-m-Y')));

		$today = $this->contacts_model->load_all($inputContact);

		$C3Team = count($today);

//		 print_arr($marketers);

		return array('marketers' => $marketers, 'C3Team' => $C3Team, 'total_kpi_mkt' => $total_kpi_mkt);
	}

	protected function GetProccessMarketerThisMonth() {

		$marketers = $this->staffs_model->load_all(array('where' => array('role_id' => 11, 'active' => 1)));

		$total_kpi_mkt = 0;

		foreach ($marketers as $key => &$marketer) {

			$total_kpi_mkt += $marketer['targets'] * 30;

			$inputContact = array();

			$inputContact['select'] = 'id';

			$inputContact['where'] = array('care_page_staff_id' => $marketer['id'], 'date_rgt >' => strtotime(date('01-m-Y')));

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

		$inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')));

		$today = $this->contacts_model->load_all($inputContact);

		$C3Team = count($today);

		// print_arr($marketers);

		return array('marketers' => $marketers, 'C3Team' => $C3Team, 'total_kpi_mkt' => $total_kpi_mkt);
	}
	
	public function get_ma_mkt() {
		$this->load->model('spending_model');
		$this->load->model('language_study_model');
		$this->load->model('channel_model');
		$this->load->model('location_model');

		$require_model = array(
			'language_study' => array(),
			'channel' => array(),
			'location' => array(),
		);
		
		$data = $this->_get_require_data($require_model);

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
		$date_end = strtotime(str_replace("/", "-", $date_end_arr)) + 3600 * 24;
		
		$input = array();
		$input['where'] = array(
			'day_spend >=' => $date_from,
			'day_spend <' => $date_end,
			'marketer_id' => $this->user_id
		);

		if (isset($get['filter_language_id'])) {
			$input['where_in']['language_id'] = $get['filter_language_id'];
		}
		if (isset($get['filter_channel_id'])) {
			$input['where_in']['channel_id'] = $get['filter_channel_id'];
		}
		if (isset($get['filter_marketer_id'])) {
			$input['where_in']['marketer_id'] = $get['filter_marketer_id'];
		}

//		if (isset($get['filter_number_records'])) {
//			$input['limit'] = array($get['filter_number_records']);
//		} else {
//			$input['limit'] = array(31);
//		}
		if ($this->role_id != 6) {
			unset($input['where']['marketer_id']);
			$marketer = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1)));
			$data['marketers'] = $marketer;
		} else {
			$marketer[] = array('id' => $this->user_id);
		}
		$input['order']['day_spend'] = 'desc';
	
		$spend = $this->spending_model->load_all($input);

		$spend_fb = 0;
		if (isset($spend)) {
			foreach ($spend as $value) {
				$data['spend'][] = array(
					'channel_name' => $this->channel_model->find_channel_name($value['channel_id']),
					'language_name' => $this->language_study_model->find_language_name($value['language_id']),
					'location' => $this->location_model->find_location_name($value['location_id']),
					'spend' => str_replace(',', '.', number_format($value['spend'])),
					'day_spend' => $value['day_spend'],
					'time_created' => $value['time_created'],
				);
				$spend_fb = $spend_fb + $value['spend'];
			}
		}

		$post = $this->input->post();
		if (isset($post) && !empty($post)) {
			$param['channel_id'] = $post['channel_id'];
			$param['language_id'] = $post['language_id'];
			$param['location_id'] = $post['location_id'];
			$param['spend'] = $post['spend'];
			$param['day_spend'] = strtotime(str_replace("/", "-", $post['day_spend']));
			$param['time_created'] = time();
			$param['marketer_id'] = $this->user_id;
			$param['time'] = date('Y-m-d', strtotime($post['day_spend']));
			//print_arr($param);
			$this->spending_model->insert($param);
			redirect(base_url('marketer/get_ma_mkt'));
		}

		$date_for_report = $this->display_date($date_from_arr, $date_end_arr);
		$report = array();
		foreach ($date_for_report as $value_date) {
			foreach ($marketer as $value_marketer) {
				$input_report['select'] = 'SUM(spend) AS COST';
				$input_report['where'] = array(
					'day_spend' => strtotime(str_replace("/", "-", $value_date)),
					'marketer_id' => $value_marketer['id'],
				);
				if (isset($input['where_in'])) {
					$input_report['where_in'] = $input['where_in'];
				}
				$cost_day = $this->spending_model->load_all($input_report);
				if (!empty($cost_day)) {
					$report[$value_marketer['name']]['total'] += $cost_day[0]['COST'];
					$report[$value_marketer['name']][$value_date] = $cost_day[0]['COST'];
				}
			}
		}
//		print_arr($report);

		$data['report'] = $report;
		$data['date'] = array_reverse($date_for_report);
//		$data['marketers'] = $data['staffs'];
		$data['total_spend'] = str_replace(',', '.', number_format($spend_fb));
		$data['startDate'] = isset($date_from) ? $date_from : '0';
		$data['endDate'] = isset($date_end) ? $date_end : '0';
		$data['left_col'] = array('date_happen_1', 'language', 'marketer');
		$data['right_col'] = array('channel');
		$data['content'] = 'marketer/upload_spend';
		//echo '<pre>';print_r($data);die();

		$this->load->view(_MAIN_LAYOUT_, $data);
	
	}
	
	public function note_contact() {
		$post = $this->input->post();
//		echo '<pre>';print_r($post);die();
		$results = array();

		if ($post['check_contact'] == 1) {
			$param = array('check_contact' => 1);
		} else if ($post['check_contact'] == 0) {
			$param = array(
				'call_status_id' => 0,
                'level_contact_detail' => ''
			);
		} else if ($post['check_contact'] == 2) {
			$param = array(
				'check_contact' => 1,
				'sale_staff_id' => 5,
				'level_contact_detail' => ''
			);
		}

		$where = array('id' => $post['contact_id']);
		$this->contacts_model->update($where, $param);

		if ($post['note'] != '') {
			$param2 = array(
				'contact_id' => $post['contact_id'],
				'content' => $post['note'],
				'time_created' => time(),
				'sale_id' => $this->user_id,
				'contact_code' => $this->contacts_model->get_contact_code($post['contact_id']),
				'role_id' => $this->role_id
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
				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options
			);

			$dataPush['title'] = 'MKT';
			$dataPush['sale'] = $c[0]['sale_staff_id'];
			$dataPush['message'] = 'MKT "' . $mkt_name . '" đã note cho contact "' . $c[0]['phone'] . '" với nội dung "' . $post['note'] . ' "';
			$dataPush['success'] = '1';
			$pusher->trigger('my-channel', 'marketer_note', $dataPush);
			
			die;
		}

		$result['success'] = 1;
		$result['message'] = 'duyệt contact thành công';
		echo json_encode($result);
		die();
	}

}

