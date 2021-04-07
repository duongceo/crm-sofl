<?php

/**
 *
 */
class Marketing extends MY_Controller {

	public $L = array();

	function __construct() {
		parent::__construct();

		$input = array();
		$input['select'] = 'id';
		$input['where'] = array('call_status_id' => '0', 'level_contact_id' => '', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id' => '0');
		$this->L['L1'] = count($this->contacts_model->load_all($input));

		$input['where'] = array('is_hide' => '0');
		$this->L['all'] = count($this->contacts_model->load_all($input));
	}

	function index($offset = 0) {
		$data = $this->get_all_require_data();

		$get = $this->input->get();
		/*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

		$conditional['where'] = array('call_status_id' => '0', 'level_contact_id' => '', 'sale_staff_id' => '0', 'is_hide' => '0', 'duplicate_id' => '0');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		/*
         * Lấy danh sách contacts
         */
		$contacts = $data_pagination['data'];
		foreach ($contacts as &$value) {
			$value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
		}
		unset($value);

		$data['contacts'] = $contacts;

		$data['progressType_mkt'] = 'Tiến độ ngày hôm nay';
		$data['progress'] = $this->GetProccessMarketerToday();
		$data['marketers'] = $data['progress']['marketers'];
		$data['C3Team'] = $data['progress']['C3Team'];
		$data['C3Total'] = $data['progress']['total_kpi_mkt'];
		$data['titleListContact_mkt'] = 'Danh sách contact mới hôm nay';

		$data['total_contact'] = $data_pagination['total_row'];
		/*
         * Lấy link phân trang
         */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('duplicate', 'date_rgt');
//	        $data['right_col'] = array('tv_dk');

		$data['progress'] = $this->GetProccessToday();
		$data['progressType'] = 'Doanh thu ngày hôm nay';
		
		//print_arr($data['progress']);

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table .= 'class_study_id date_rgt link matrix';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact mới hôm nay';
		$data['actionForm'] = '';

		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function view_all($offset = 0) {
		$data = $this->get_all_require_data();
		$get = $this->input->get();
		$conditional['where'] = array('is_hide' => '0');
		$conditional['order'] = array('date_rgt' => 'DESC');
		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['total_contact'] = $data_pagination['total_row'];

		$contact = $data_pagination['data'];

//		$this->load->model('call_log_model');
//		foreach ($contact as &$value) {
//			$input['where'] = array('contact_id' => $value['id']);
//			$value['care_number'] = count($this->call_log_model->load_all($input));
//		}
		$input['where'] = array(
			'parent_id !=' => ''
		);

		$this->load->model('level_contact_model');
		$this->load->model('level_student_model');
		$data['level_contact_detail'] = $this->level_contact_model->load_all($input);
		$data['level_student_detail'] = $this->level_student_model->load_all($input);

		$data['contacts'] = $contact;

		$data['left_col'] = array('care_number', 'language', 'level_language', 'sale', 'marketer', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
        $data['right_col'] = array('branch', 'is_old', 'complete_fee', 'source', 'call_status', 'level_contact', 'level_contact_detail', 'level_student', 'level_student_detail');

		$this->table .= 'fee paid call_stt level_contact date_rgt link';
		$data['table'] = explode(' ', $this->table);

		$progress = $this->GetProccessMarketerThisMonth();
		$data['marketers'] = $progress['marketers'];
		$data['C3Team'] = $progress['C3Team'];
		$data['C3Total'] = $progress['total_kpi_mkt'];
		$data['progressType_mkt'] = 'Tiến độ của team tháng này';

		$data['progress'] = $this->GetProccessThisMonth();
		$data['progressType'] = 'Doanh thu tháng';

		$outformModal = 'marketer/modal/view_note_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['actionForm'] = 'marketer/note_contact';
		$data['titleListContact_mkt'] = 'Danh sách toàn bộ contact';
		$data['content'] = 'common/list_contact';

		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	public function view_report_quality_contact() {
		//echo $this->role_id;die;
		$this->load->model('language_study_model');
		$this->load->model('spending_model');
		$this->load->model('paid_model');
		$get = $this->input->get();

		$input = array();
		$language = $this->language_study_model->load_all($input);

		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);
		$date_from = trim($dateArr[0]);
		$date_from = strtotime(str_replace("/", "-", $date_from));
		$date_end = trim($dateArr[1]);
		$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;

		// echo '<pre>'; print_r($date_from); die;
		// echo $date_from.'--'.$date_end;die();

		if (isset($get['tic_report'])) {
			$typeReport = array(
				'C3' => array(
					'where' => array('is_hide' => '0', 'is_old' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $date_from, 'date_rgt <=' => $date_end),
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'is_old' => '0', 'level_contact_id' => 'L5', 'date_rgt >=' => $date_from, 'date_rgt <=' => $date_end),
				),
			);
		} else {
			$typeReport = array(
				'C3' => array(
					'where' => array('is_hide' => '0', 'is_old' => '0', 'duplicate_id' => '0', 'call_status_id NOT IN (1, 3, 5)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE', 'date_rgt >=' => $date_from, 'date_rgt <=' => $date_end),
				),
				'L5' => array(
					'where' => array('is_hide' => '0', 'is_old' => '0', 'level_contact_id' => 'L5', 'date_rgt_study >=' => $date_from, 'date_rgt_study <=' => $date_end),
				),
			);
		}

		unset($get['filter_date_date_happen']);

		$Report = array();
		foreach ($language as $v_language) {
			foreach ($typeReport as $report_type => $value) {
				$condition = array('where' => array_merge($value['where'], array('language_id' => $v_language['id'])));
				$condition['where_in']['source_id'] = array(1, 2, 8);
				$condition['where_not_in']['sale_staff_id'] = array(5, 18);
				if ($report_type == 'L5') {
					$condition['where_in']['source_id'] = array_merge($condition['where_in']['source_id'], array(6));
				}
				$Report[$v_language['id']][$report_type] = $this->_query_for_report($get, $condition);
			}
		}

		$total_C3 = 0;
		$total_L5 = 0;
		$total_spend_fb = 0;
		$total_spend_gg = 0;
		$total_spend_hn = 0;
		$total_spend_hcm = 0;
		$total_spend = 0;
		$total_RE = 0;

		foreach ($Report as $key => $value) {
			// lấy chi phí
			$input = array();
			$input['select'] = 'SUM(spend) as spending';
			$input['where']['day_spend >='] = $date_from;
			$input['where']['day_spend <='] = $date_end;
			$input['where']['language_id'] = $key;
			if ($this->role_id == 6) {
				$input['where']['marketer_id'] = $this->user_id;
			} elseif (isset($get['filter_marketer_id'])) {
				$input['where_in']['marketer_id'] = $get['filter_marketer_id'];
			}
//				chi phí fb
			$input_fb = array_merge_recursive($input, array('where' => array('channel_id' => 2)));
			$spend_fb = (int)$this->spending_model->load_all($input_fb)[0]['spending'];

//				chi phí gg
			$input_gg = array_merge_recursive($input, array('where' => array('channel_id' => 3)));
			$spend_gg = (int)$this->spending_model->load_all($input_gg)[0]['spending'];
//				print_arr($input_gg);

			// Chi phi tại Hà Nội
			$input_hn = array_merge_recursive($input, array('where' => array('location_id' => 1)));
			$spend_hn = (int)$this->spending_model->load_all($input_hn)[0]['spending'];

//				Chi phí tại HCM
			$input_hcm = array_merge_recursive($input, array('where' => array('location_id' => 2)));
			$spend_hcm = (int)$this->spending_model->load_all($input_hcm)[0]['spending'];

			$spend = (int)$this->spending_model->load_all($input)[0]['spending'];

			$input_re['select'] = 'SUM(paid) as paiding';
			$input_re['where'] = array(
				'student_old' => '0',
				'time_created >=' => $date_from,
				'time_created <=' => $date_end,
				'language_id' => $key
			);

			$input_re['where_not_in']['source_id'] = array(11);

			if (isset($get['filter_branch_id'])) {
				$input_re['where_in']['branch_id'] = $get['filter_branch_id'];
			}

			if (isset($get['filter_is_old'])) {
				$input_re['where']['student_old'] = $get['filter_is_old'];
			}

			$re = (int)$this->paid_model->load_all($input_re)[0]['paiding'];

			$Report[$key]['RE'] = $re;
			$Report[$key]['Ma_Re_thuc_te'] = ($Report[$key]['RE'] == 0) ? '0' : round($spend / $Report[$key]['RE'], 4) * 100;
			$Report[$key]['Re_thuc_te'] = str_replace(',', '.', number_format($Report[$key]['RE']));
			$Report[$key]['Ma_FB'] = str_replace(',', '.', number_format($spend_fb));
			$Report[$key]['Ma_GG'] = str_replace(',', '.', number_format($spend_gg));
			$Report[$key]['Ma_HN'] = str_replace(',', '.', number_format($spend_hn));
			$Report[$key]['Ma_HCM'] = str_replace(',', '.', number_format($spend_hcm));
			$Report[$key]['Ma_mkt'] = str_replace(',', '.', number_format($spend));
			$Report[$key]['Gia_So'] = ($Report[$key]['C3'] == 0) ? '0' : str_replace(',', '.', number_format(round($spend / $Report[$key]['C3'])));
			$Report[$key]['L5/C3'] = ($Report[$key]['C3'] == 0) ? '0' : round($Report[$key]['L5'] / $Report[$key]['C3'], 4) * 100;

			$total_C3 += $Report[$key]['C3'];
			$total_L5 += $Report[$key]['L5'];
			$total_RE += $Report[$key]['RE'];
			$total_spend_fb += $spend_fb;
			$total_spend_gg += $spend_gg;
			$total_spend_hn += $spend_hn;
			$total_spend_hcm += $spend_hcm;
			if (in_array($key, array(1,2,3))) {
				$total_spend += $spend;
			}

			$Report[$key]['language_name'] = $this->language_study_model->find_language_name($key);

		}

		$Report['Tổng'] = array(
			'C3' => $total_C3,
			'L5' => $total_L5,
			'L5/C3' => ($total_C3 == 0) ? '0' : round($total_L5 / $total_C3, 4) * 100,
			'Ma_FB' => str_replace(',', '.', number_format($total_spend_fb)),
			'Ma_GG' => str_replace(',', '.', number_format($total_spend_gg)),
			'Ma_mkt' => str_replace(',', '.', number_format($total_spend)),
			'Ma_HN' => str_replace(',', '.', number_format($total_spend_hn)),
			'Ma_HCM' => str_replace(',', '.', number_format($total_spend_hcm)),
			'Gia_So' => ($total_C3 == 0) ? '0' : str_replace(',', '.', number_format(round($total_spend / $total_C3, 2) * 100)),
			'Ma_Re_thuc_te' => ($total_RE == 0) ? '0' : round($total_spend / $total_RE, 2) * 100,
			'Re_thuc_te' => str_replace(',', '.', number_format($total_RE)),
			'language_name' => 'Tổng'
		);

		$input_mkt['where'] = array('role_id' => 6, 'active' => 1);
		$marketer = $this->staffs_model->load_all($input_mkt);

		$Report_mkt = array();
		foreach ($marketer as $v_mkt) {
			foreach ($typeReport as $report_type => $value) {
				if ($this->role_id == 6) {
					$condition = array('where' => array_merge($value['where'], array('marketer_id' => $this->user_id)));
				} else {
					$condition = array('where' => array_merge($value['where'], array('marketer_id' => $v_mkt['id'])));
				}
				$Report_mkt[$v_mkt['id']][$report_type] = $this->_query_for_report($get, $condition);
			}
		}

		$total_mkt_L5 = 0;
		$total_mkt_C3 = 0;
		$total_mkt_spend_fb = 0;
		$total_mkt_spend_gg = 0;
		$total_mkt_spend_hn = 0;
		$total_mkt_spend_hcm = 0;
		$total_spend_mkt = 0;

		foreach ($Report_mkt as $key => $value) {
			// lấy chi phí
			$input = array();
			$input['select'] = 'SUM(spend) as spending';
			$input['where']['day_spend >='] = $date_from;
			$input['where']['day_spend <='] = $date_end;
			$input['where']['marketer_id'] = $key;

			if ($this->role_id == 6) {
				$input['where']['marketer_id'] = $this->user_id;
			}

//				chi phí fb
			$input_fb = array_merge_recursive($input, array('where' => array('channel_id' => 2)));
			$spend_mkt_fb = (int)$this->spending_model->load_all($input_fb)[0]['spending'];

//				chi phí gg
			$input_gg = array_merge_recursive($input, array('where' => array('channel_id' => 3)));
			$spend_mkt_gg = (int)$this->spending_model->load_all($input_gg)[0]['spending'];
//				print_arr($input_gg);

			//				Chi phi tại Hà Nội
			$input_hn = array_merge_recursive($input, array('where' => array('location_id' => 1)));
			$spend_mkt_hn = (int)$this->spending_model->load_all($input_hn)[0]['spending'];

//				Chi phí tại HCM
			$input_hcm = array_merge_recursive($input, array('where' => array('location_id' => 2)));
			$spend_mkt_hcm = (int)$this->spending_model->load_all($input_hcm)[0]['spending'];

			$spend_mkt = (int)$this->spending_model->load_all($input)[0]['spending'];
//				 echo '<pre>'; print_r($spend); die;

			$Report_mkt[$key]['L5/C3'] = ($Report_mkt[$key]['C3'] == 0) ? '0' :round($Report_mkt[$key]['L5'] / $Report_mkt[$key]['C3'], 4) * 100;
			$Report_mkt[$key]['Gia_So'] = ($Report_mkt[$key]['C3'] == 0) ? '0' : str_replace(',', '.', number_format(round($spend_mkt / $Report_mkt[$key]['C3'])));
			$Report_mkt[$key]['Ma_mkt'] = str_replace(',', '.', number_format($spend_mkt));
			$Report_mkt[$key]['Ma_mkt_FB'] = str_replace(',', '.', number_format($spend_mkt_fb));
			$Report_mkt[$key]['Ma_mkt_GG'] = str_replace(',', '.', number_format($spend_mkt_gg));
			$Report_mkt[$key]['Ma_mkt_HN'] = str_replace(',', '.', number_format($spend_mkt_hn));
			$Report_mkt[$key]['Ma_mkt_HCM'] = str_replace(',', '.', number_format($spend_mkt_hcm));

			$total_mkt_C3 += $Report_mkt[$key]['C3'];
			$total_mkt_L5 += $Report_mkt[$key]['L5'];
			$total_mkt_spend_fb += $spend_mkt_fb;
			$total_mkt_spend_gg += $spend_mkt_gg;
			$total_mkt_spend_hn += $spend_mkt_hn;
			$total_mkt_spend_hcm += $spend_mkt_hcm;
			$total_spend_mkt += $spend_mkt;

			$Report_mkt[$key]['mkt_name'] = $this->staffs_model->find_staff_name($key);
		}

		usort($Report_mkt, function ($a, $b) {
			return $b['C3'] - $a['C3'];
		});

		$Report_mkt['Tổng'] = array(
			'C3' => $total_mkt_C3,
			'L5' => $total_mkt_L5,
			'L5/C3' => ($total_mkt_C3 == 0) ? '0' : round($total_mkt_L5/ $total_mkt_C3, 4) * 100,
			'Ma_mkt_FB' => str_replace(',', '.', number_format($total_mkt_spend_fb)),
			'Ma_mkt_GG' => str_replace(',', '.', number_format($total_mkt_spend_gg)),
			'Ma_mkt_HN' => str_replace(',', '.', number_format($total_mkt_spend_hn)),
			'Ma_mkt_HCM' => str_replace(',', '.', number_format($total_mkt_spend_hcm)),
			'Ma_mkt' => str_replace(',', '.', number_format($total_spend_mkt)),
			'Gia_So' => ($total_mkt_C3 == 0) ? '0' : str_replace(',', '.', number_format(round($total_spend_mkt / $total_mkt_C3, 2) * 100)),
			'mkt_name' => 'Tổng'
		);

		//echo '<pre>'; print_r($Report_mkt); die;

		$this->load->model('channel_model');
		$data['channel'] = $this->channel_model->load_all(array('where' => array('active' => 1)));

		$this->load->model('branch_model');
		$data['branch'] = $this->branch_model->load_all();

		$data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1)));

		$data['report'] = $Report;
		$data['report_mkt'] = $Report_mkt;
//		print_arr($data['report']);
		$data['startDate'] = isset($date_from) ? $date_from : '0';
		$data['endDate'] = isset($date_end) ? $date_end : '0';

		if ($this->role_id == 6) {
			$data['left_col'] = array('date_happen_1', 'tic_report');
//			$data['right_col'] = array('is_old');
		} else {
			$data['left_col'] = array('date_happen_1', 'tic_report', 'marketer');
			$data['right_col'] = array('branch');
		}

		$data['content'] = 'marketing/view_report_quality_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);

	}

	public function view_table_compare() {
		$this->load->model('language_study_model');
		$this->load->model('spending_model');
		$this->load->model('paid_model');
		$get = $this->input->get();

		if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
			$time = $get['filter_date_date_happen'];
		} else {
			$time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
		}

		$dateArr = explode('-', $time);

//			$date_from = trim($dateArr[0]);
//			$date_from = strtotime(str_replace("/", "-", $date_from));
//			$date_end = trim($dateArr[1]);
//			$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;

		$time_before_1_month = str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[0])))))) . ' - ' . str_replace("-", "/", date("d-m-Y", strtotime("-1 month", strtotime(str_replace("/", "-", trim($dateArr[1]))))));
		$time_before_2_month = str_replace("-", "/", date("d-m-Y", strtotime("-2 month", strtotime(str_replace("/", "-", trim($dateArr[0])))))) . ' - ' . str_replace("-", "/", date("d-m-Y", strtotime("-2 month", strtotime(str_replace("/", "-", trim($dateArr[1]))))));

		$date_array = array($time_before_2_month, $time_before_1_month, $time);

		$typeReport = array(
			'L1' => array(
				'where' => array('is_old' => '0', 'duplicate_id' => '0', 'source_id IN (1, 2, 6, 8)' => 'NO-VALUE', 'call_status_id NOT IN (1, 3)' => 'NO-VALUE', 'level_contact_detail NOT IN ("L1.1", "L1.2", "L1.3")' => 'NO-VALUE'),
				'time' => 'filter_date_date_rgt'
			),
			'L5' => array(
				'where' => array('is_hide' => '0', 'duplicate_id' => '0', 'level_contact_id' => 'L5', 'is_old' => '0', 'source_id IN (1, 2, 6, 8)' => 'NO-VALUE'),
				'time' => 'filter_date_date_rgt_study'
			),
			'L8' => array(
				'where' => array('is_hide' => '0', 'duplicate_id' => '0', 'level_contact_id' => 'L5', 'is_old' => 1),
				'time' => 'filter_date_date_rgt_study'
			),
		);

//			unset($get['filter_date_date_happen']);
		$input['where']['no_report'] = '0';
		$language = $this->language_study_model->load_all($input);

		$Report = array();

		foreach ($language as $v_language) {
			foreach ($date_array as $value_date) {
				$dateArr_2 = explode('-', $value_date);
				$date_from = trim($dateArr_2[0]);
				$date_from = strtotime(str_replace("/", "-", $date_from));
				$date_end = trim($dateArr_2[1]);
				$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;
				foreach ($typeReport as $report_type => $value) {
					$get_time = array($value['time'] => $value_date);
					$condition = array('where' => array_merge($value['where'], array('language_id' => $v_language['id'])));
					$Report[$v_language['name']][$value_date][$report_type] = $this->_query_for_report($get_time, $condition);
				}

				$input = array();
				$input['select'] = 'SUM(spend) as spending';
				$input['where']['day_spend >='] = $date_from;
				$input['where']['day_spend <='] = $date_end;
				$input['where']['language_id'] = $v_language['id'];

//				chi phí fb
//				$input_fb = array_merge_recursive($input, array('where' => array('channel_id' => 2)));
//				$spend_fb = (int)$this->spending_model->load_all($input_fb)[0]['spending'];

//				chi phí gg
//				$input_gg = array_merge_recursive($input, array('where' => array('channel_id' => 3)));
//				$spend_gg = (int)$this->spending_model->load_all($input_gg)[0]['spending'];

				$spend = (int)$this->spending_model->load_all($input)[0]['spending'];

				$input_re['select'] = 'SUM(paid) as paiding';
				$input_re['where'] = array(
					'time_created >=' => $date_from,
					'time_created <=' => $date_end,
					'language_id' => $v_language['id']
				);
				//$input_re['where_not_in']['source_id'] = array(9, 10);

				$input_re_new = array_merge_recursive($input_re, array('where' => array('student_old' => '0')));
				$input_re_old = array_merge_recursive($input_re, array('where' => array('student_old' => 1)));

				$re_new = (int)$this->paid_model->load_all($input_re_new)[0]['paiding'];
				$re_old = (int)$this->paid_model->load_all($input_re_old)[0]['paiding'];

				//$Report[$v_language['name']][$value_date]['RE'] = $re;
				$Report[$v_language['name']][$value_date]['Re_thuc_te'] = str_replace(',', '.', number_format($re_new));
				$Report[$v_language['name']][$value_date]['Re_cu'] = str_replace(',', '.', number_format($re_old));
//				$Report[$v_language['id']][$value_date]['Ma_FB'] = str_replace(',', '.', number_format($spend_fb));
//				$Report[$v_language['id']][$value_date]['Ma_GG'] = str_replace(',', '.', number_format($spend_gg));
				$Report[$v_language['name']][$value_date]['Ma_mkt'] = str_replace(',', '.', number_format($spend));
				$Report[$v_language['name']][$value_date]['Gia_So'] = ($Report[$v_language['name']][$value_date]['L1'] == 0) ? '0' : str_replace(',', '.', number_format(round($spend / $Report[$v_language['name']][$value_date]['L1'])));
				$Report[$v_language['name']][$value_date]['Chot'] = ($Report[$v_language['name']][$value_date]['L1'] == 0) ? '0' : round($Report[$v_language['name']][$value_date]['L5'] / $Report[$v_language['name']][$value_date]['L1'], 4) * 100;

			}
		}

//		print_arr($Report);

		$data['report'] = $Report;
		$data['left_col'] = array('date_happen_1');
//		$data['right_col'] = array('branch');
		$data['content'] = 'marketing/view_table_compare';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	protected function GetProccessMarketerToday(){

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

		usort($marketers, function ($a, $b) {

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

	protected function GetProccessMarketerThisMonth()
	{

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

		usort($marketers, function ($a, $b) {

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

	private function get_all_require_data()
	{
		$require_model = array(
			'staffs' => array(
				'where' => array(
					'role_id' => 6,
					'active' => 1
				)
			),
			'class_study' => array(
				'where' => array(
					'active' => 1
				),
				'order' => array(
					'class_study_id' => 'ASC'
				)
			),
			'call_status' => array(),
			'payment_method_rgt' => array(),
			'sources' => array(),
			'channel' => array(),
			'link_site' => array(),
			'branch' => array(),
			'level_language' => array(),
			'level_contact' => array(
				'where' => array(
					'parent_id' => ''
				)
			),
			'level_student' => array(
				'where' => array(
					'parent_id' => ''
				)
			),
			'language_study' => array()
		);
		return array_merge($this->data, $this->_get_require_data($require_model));
	}

}

?>
