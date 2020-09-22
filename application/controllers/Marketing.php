
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
			//echo "string"; die;
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

	        /*
	         * Các trường cần hiện của bảng contact (đã có default)
	         */
	        $this->table .= 'class_study_id date_rgt matrix';
	        $data['table'] = explode(' ', $this->table);

	        $data['titleListContact'] = 'Danh sách contact mới hôm nay';

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

			$data['contacts'] = $contact;

			$data['left_col'] = array('language', 'sale', 'marketer', 'date_rgt', 'date_handover', 'date_confirm', 'date_rgt_study', 'date_last_calling');
			$data['right_col'] = array('branch', 'source', 'call_status', 'level_contact', 'level_student');
			$this->table .= 'fee paid channel call_stt level_contact date_rgt';
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
			$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24;

			// echo '<pre>'; print_r($date_from); die;
			// echo $date_from.'--'.$date_end;die();

			if (isset($get['tic_report'])) {
				$typeReport = array(
					'C3' => array(
						'where' => array(),
						'time' => 'filter_date_date_rgt'
					),
					/*
					'L1' => array(
						'where' => array('is_hide' => '0', 'duplicate_id' => '0'),
						'time' => 'filter_date_date_rgt'
					),
					'L2' => array(
						'where' => array('is_hide' => '0', 'duplicate_id' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_),
						'time' => 'filter_date_date_rgt'
					),
					'L6' => array(
						'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_),
						'time' => 'filter_date_date_rgt'
					),
					'L8' => array(
						'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'cod_status_id' => _DA_THU_LAKITA_),
						'time' => 'filter_date_date_rgt'
					),
					*/
					'RE' => array(
						'where' => array('is_hide' => '0', 'paid !=' => '0'),
						'time' => 'filter_date_date_rgt'
					)
				);
			} else {
				$typeReport = array(
					'C3' => array(
						'where' => array(),
						'time' => 'filter_date_date_rgt'
					),
					/*
					'L1' => array(
						'where' => array('is_hide' => '0','duplicate_id' => '0'),
						'time' => 'filter_date_date_handover'
					),
					'L2' => array(
						'where' => array('is_hide' => '0', 'duplicate_id' => '0', 'call_status_id' => _DA_LIEN_LAC_DUOC_),
						'time' => 'filter_date_date_handover'
					),
					'L6' => array(
						'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_),
						'time' => 'filter_date_date_confirm'
					),
					'L8' => array(
						'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'cod_status_id' => _DA_THU_LAKITA_),
						'time' => 'filter_date_date_receive_lakita'
					),
					*/
					'RE' => array(
						'where' => array('is_hide' => '0', 'paid !=' => '0'),
						'time' => 'date_paid'
					)
				);
			}

			//echo '(`brand_id` in (' . $brand .'))';die;
			//echo '<pre>'; print_r($course); die;
			
			$conditionnal_2 = array();

			$Report = array();

			foreach ($language as $v_language) {
				foreach ($typeReport as $report_type => $value) {
					
					$typeTime = array($value['time'] => $time);
				  
					if ($this->role_id == 6) {
						$condition = array('where' => array_merge($value['where'], array('language_id' => $v_language['id'])));
					} else {
						if (isset($get['filter_marketer_id']) && $get['filter_marketer_id'] != '') {
							$condition = array('where' => array_merge($value['where'], array('language_id' => $v_language['id'])));
//							$fillter_marketer_id['where_in']['marketer_id'] = $get['filter_marketer_id'];
//							$condition = array_merge($condition, $fillter_marketer_id);
							// echo '<pre>'; print_r($condition); die;
						} else {
							$condition = array('where' => array_merge($value['where'], array('language_id' => $v_language['id'])));
						}
					}
					$condition = array_merge_recursive($condition, $conditionnal_2);
					//echo '<pre>'; print_r($condition); die;
					$Report[$v_language['id']][$report_type] = $this->_query_for_report($typeTime, $condition);
					$Report[$v_language['id']]['RE'] = $this->_query_for_report_re($typeTime, $condition);
					// $Report[$v_course['course_code']]['RE'] = str_replace(',', '.', number_format($this->_query_for_report_re($typeTime, $condition)));
				}
				
				/*
				if ($Report[$v_language['language_id']]['C3'] == 0 && $Report[$v_language['language_id']]['L1'] == 0 && $Report[$v_language['language_id']]['L6'] == 0 && $Report[$v_course['language_id']]['L8'] == 0) {
					unset($Report[$v_language['language_id']]);
				}
				*/
				
//				if ($Report[$v_language['language_id']]['C3'] == 0) {
//					unset($Report[$v_language['language_id']]);
//				}
			}

//			echo '<pre>'; print_r($Report); die;

			$total_C3 = 0;
//			$total_L1 = 0;
//			$total_L2 = 0;
//			$total_L6 = 0;
//			$total_L8 = 0;
			$total_spend = 0;
			$total_RE = 0;

			foreach ($Report as $key => $value) {
				$input_spend = array();
				$input_spend['select'] = 'id';
				$input_spend['where']['language_id'] = $key;

				// lấy chi fb
				$input = array();
				$input['select'] = 'SUM(spend) as spend';
				$input['where']['time_created >='] = $date_from;
				$input['where']['time_created <='] = $date_end;
				$input['where']['language_id'] = $key;

				if (isset($get['filter_marketer_id'])) {
					$input['where_in']['marketer_id'] = $get['filter_marketer_id'];
				}

				if (isset($get['filter_channel_id'])) {
					$input['where_in']['channel_id'] = $get['filter_channel_id'];
				}

				if ($this->role_id == 6) {
					$input['where']['marketer_id'] = $this->user_id;
				}

				$spend = (int) $this->spending_model->load_all($input)[0]['spend'];
//				 echo '<pre>'; print_r($spend); die;

//				$Report[$key]['Gia_L8'] = ($Report[$key]['L8'] == 0) ? '0' : str_replace(',', '.', number_format(round($sum_spend / $Report[$key]['L8'])));
				$Report[$key]['Gia_So'] = ($Report[$key]['C3'] == 0) ? '0' : str_replace(',', '.', number_format(round($spend / $Report[$key]['C3'])));
//				$Report[$key]['Ma_Re_du_kien'] = ($Report[$key]['L6'] == 0) ? '0' : round($sum_spend / ($Report[$key]['L6'] * $ty_le_brand * $price_course), 4) * 100;
				$Report[$key]['Ma_Re_thuc_te'] = ($Report[$key]['RE'] == 0) ? '0' : round($spend / ($Report[$key]['RE']), 2) * 100;
//				$Report[$key]['Re_du_kien'] = str_replace(',', '.', number_format(($Report[$key]['L6'] * $price_course) * $ty_le_brand));
			 	$Report[$key]['Re_thuc_te'] = str_replace(',', '.', number_format($Report[$key]['RE']));
				$Report[$key]['Ma_mkt'] = str_replace(',', '.', number_format($spend));

				$total_C3 += $Report[$key]['C3'];
//				$total_L1 += $Report[$key]['L1'];
//				$total_L2 += $Report[$key]['L2'];
//				$total_L6 += $Report[$key]['L6'];
//				$total_L8 += $Report[$key]['L8'];
				$total_RE += $Report[$key]['RE'];
				$total_spend += $spend;

//				$Report[$key]['L1/C3'] = ($Report[$key]['C3'] == 0) ? '0' : round($Report[$key]['L1'] / $Report[$key]['C3'], 4) * 100;
//				$Report[$key]['L2/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L2'] / $Report[$key]['L1'], 4) * 100;
//				$Report[$key]['L6/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L6'] / $Report[$key]['L1'], 4) * 100;
//				$Report[$key]['L6/L2'] = ($Report[$key]['L2'] == 0) ? '0' : round($Report[$key]['L6'] / $Report[$key]['L2'], 4) * 100;
//				$Report[$key]['L8/L6'] = ($Report[$key]['L6'] == 0) ? '0' : round($Report[$key]['L8'] / $Report[$key]['L6'], 4) * 100;
//				$Report[$key]['L8/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L8'] / $Report[$key]['L1'], 4) * 100;
				// $Report[$key]['tong'] = $total_L1.'-'.$total_L2.'-'.$total_L6.'-'.$total_L8;

				$Report[$key]['language_name'] = $this->language_study_model->find_language_name($key);;

			}

			$Report['Tổng'] = array(
				'C3' => $total_C3,
//				'L1' => $total_L1,
//				'L2' => $total_L2,
//				'L6' => $total_L6,
//				'L8' => $total_L8,
				// 'RE' => str_replace(',', '.', number_format($total_RE)),
//				'Gia_L8' => str_replace(',', '.', number_format(round($total_spend / $total_L8))),
//				'L1/C3' => round(($total_L1 / $total_C3), 4) * 100,
//				'L2/L1' => round(($total_L2 / $total_L1), 4) * 100,
//				'L6/L1' => round(($total_L6 / $total_L1), 4) * 100,
//				'L6/L2' => round(($total_L6 / $total_L2), 4) * 100,
//				'L8/L6' => round(($total_L8 / $total_L6), 4) * 100,
//				'L8/L1' => round(($total_L8 / $total_L1), 4) * 100,
				'Ma_mkt' => str_replace(',', '.', number_format($total_spend)),
				'Gia_So' => ($total_C3 == 0) ? '0' : round($total_spend / $total_C3, 2) * 100,
//				'Ma_Re_du_kien' => ($total_L6 == 0) ? '0' : round($total_spend / ($total_L6 * $ty_le_brand * 395000), 4) * 100,
				'Ma_Re_thuc_te' => ($total_RE == 0) ? '0' : round($total_spend / $total_RE, 2) * 100,
				// 'Ma_Re_thuc_te' => str_replace(',', '.', number_format($total_RE)),
//				'Re_du_kien' => str_replace(',', '.', number_format($total_L6 * 395000 * $ty_le_brand)),
				'Re_thuc_te' => str_replace(',', '.', number_format($total_RE)),
				'language_name' => 'Tổng'
			);

//			usort($Report, function($a, $b) {
//				return $b['L1'] - $a['L1'];
//			});

			// echo '<pre>'; print_r($Report); die;

			$this->load->model('channel_model');
			$data['channel'] = $this->channel_model->load_all(array('where' => array('active' => 1)));
			
			$this->load->model('staffs_model');
			$data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1), 'order' => array('name' => 'asc')));

			$data['report'] = $Report;
//			print_arr($data['report']);
			$data['startDate'] = isset($date_from) ? $date_from : '0';
			$data['endDate'] = isset($date_end) ? $date_end : '0';

			if ($this->role_id == 6) {
				$data['left_col'] = array('date_happen_1', 'tic_report');
				$data['right_col'] = array('channel');
			} else {
				$data['left_col'] = array('date_happen_1', 'marketer', 'tic_report');
				$data['right_col'] = array('channel');
			}

			$data['content'] = 'marketing/view_report_quality_contact';
			$this->load->view(_MAIN_LAYOUT_, $data);
			
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

		private function get_all_require_data() {
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
				'ordering_status' => array(),
				'payment_method_rgt' => array(),
				'sources' => array(),
				'channel' => array(),
				'branch' => array(),
				'level_language' => array(),
				'level_contact' => array(),
				'level_student' => array(),
				'language_study' => array()
			);
			return array_merge($this->data, $this->_get_require_data($require_model));
		}


	}
?>
