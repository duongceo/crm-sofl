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

	        $input = array();
	        $input['select'] = 'id';
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
	        $data['progress'] = $this->GetProccessToday();
	        $data['progressType'] = 'Tiến độ các team ngày hôm nay';

	        $data['total_contact'] = $data_pagination['total_row'];
	        /*
	         * Lấy link phân trang
	         */
	        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
	        /*
	         * Filter ở cột trái và cột phải
	         */
	        $data['left_col'] = array('duplicate', 'date_rgt');
	        $data['right_col'] = array('tv_dk');

	        /*
	         * Các trường cần hiện của bảng contact (đã có default)
	         */
	        $this->table .= 'class_study_id date_rgt matrix';
	        $data['table'] = explode(' ', $this->table);

	        $data['titleListContact'] = 'Danh sách contact mới không trùng';
	        $data['actionForm'] = 'manager/divide_contact';
	        $informModal = 'manager/modal/divide_contact';
	        $data['informModal'] = explode(' ', $informModal);
	        $outformModal = 'manager/modal/divide_one_contact';
	        $data['outformModal'] = explode(' ', $outformModal);
	        /*
	         * Các file js cần load
	         */

	//        $data['load_js'] = array(
	//            'common_view_detail_contact', 'common_real_filter_contact',
	//            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
	//        );
	        $data['content'] = 'common/list_contact';
	        $this->load->view(_MAIN_LAYOUT_, $data);
	    }

	    private function get_all_require_data() {
	        $require_model = array(
	            'staffs' => array(
	                'where' => array(
	                    'role_id' => 1,
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