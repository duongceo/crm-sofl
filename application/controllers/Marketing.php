
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
	        $input['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
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

	        $conditional['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
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

			$data['left_col'] = array('channel', 'date_rgt', 'date_handover');
			$data['right_col'] = array('call_status');
			$this->table .= 'channel campaign call_stt level_contact date_rgt';
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
				'level_contact' => array()
			);
			return array_merge($this->data, $this->_get_require_data($require_model));
		}


	}
?>