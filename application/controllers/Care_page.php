<?php

class Care_page extends MY_Controller {

	public $L = array();

	public function __construct() {
		parent::__construct();
	}

	function index($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['care_page_staff_id !='] = '0';
		$conditional['where']['date_handover >='] = strtotime(date('d-m-Y'));
		$conditional['order'] = array('date_handover' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/*
         * Lấy link phân trang và danh sách contacts
         */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('date_rgt');
//        $data['right_col'] = array('');

		/* Các trường cần hiện của bảng contact (đã có default) */
		$this->table = 'selection name phone branch language level_language date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);

        $data['progressType_mkt'] = 'Tiến độ các Team ngày hôm nay';
        $data['progress'] = $this->GetProccessMarketerToday();
        $data['marketers'] = $data['progress']['marketers'];
        $data['C3Team'] = $data['progress']['C3Team'];
        $data['C3Total'] = $data['progress']['total_kpi_mkt'];

		$data['titleListContact_mkt'] = 'Danh sách contact đã nhập vào hôm nay';
		$data['actionForm'] = 'manager/divide_contact';
		$informModal = 'manager/modal/divide_contact';
		$data['informModal'] = explode(' ', $informModal);
		$outformModal = 'manager/modal/divide_one_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function contact_have_not_yet_been_divided($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

		$conditional['where']['call_status_id'] = '0';
		$conditional['where']['duplicate_id'] = '0';
		$conditional['where']['sale_staff_id'] = '0';
//		$conditional['where']['date_rgt >='] = strtotime(date('d-m-Y'));
		$conditional['order'] = array('date_rgt' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/* Lấy link phân trang và danh sách contacts */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/*
         * Filter ở cột trái và cột phải
         */
		$data['left_col'] = array('date_rgt');
//        $data['right_col'] = array('');

		/*
         * Các trường cần hiện của bảng contact (đã có default)
         */
		$this->table = 'selection name phone branch language level_language date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào hôm nay';
		$data['actionForm'] = 'manager/divide_contact';
		$informModal = 'manager/modal/divide_contact';
		$data['informModal'] = explode(' ', $informModal);
		$outformModal = 'manager/modal/divide_one_contact';
		$data['outformModal'] = explode(' ', $outformModal);
		$data['content'] = 'common/list_contact';
		$this->load->view(_MAIN_LAYOUT_, $data);
	}

	function view_all_contact($offset = 0) {
		$data = $this->_get_all_require_data();
		$get = $this->input->get();

        $data['care_page_staff'] = $this->staffs_model->load_all(array('where' => array('role_id' => 11, 'active' => 1)));

        $conditional['where']['care_page_staff_id !='] = '0';
		$conditional['order'] = array('date_handover' => 'DESC');

		$data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

		/* Lấy link phân trang và danh sách contacts */
		$data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
		$data['contacts'] = $data_pagination['data'];
		$data['total_contact'] = $data_pagination['total_row'];

		/* Filter ở cột trái và cột phải */
		$data['left_col'] = array('date_rgt', 'source', 'branch');
        $data['right_col'] = array('language', 'care_page_staff');

		/* Các trường cần hiện của bảng contact (đã có default) */
		$this->table = 'selection name phone branch language level_language date_rgt date_handover';
		$data['table'] = explode(' ', $this->table);

		$data['titleListContact'] = 'Danh sách contact đã nhập vào';

		$data['actionForm'] = 'manager/divide_contact';
		$informModal = 'manager/modal/divide_contact';
		$data['informModal'] = explode(' ', $informModal);
		$outformModal = 'manager/modal/divide_one_contact';
		$data['outformModal'] = explode(' ', $outformModal);
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
            'sources' => array(),
			'branch' => array(),
			'language_study' => array(),
			'level_language' => array(),
		);
		return array_merge($this->data, $this->_get_require_data($require_model));
	}

    protected function GetProccessMarketerToday() {

        $carepage_staff = $this->staffs_model->load_all(array('where' => array('role_id' => 11, 'active' => 1)));

        $total_kpi_mkt = 0;

        foreach ($carepage_staff as $key => &$marketer) {

            $marketer['targets'] = round($marketer['targets'] / 30, 1);

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

        return array('marketers' => $carepage_staff, 'C3Team' => $C3Team, 'total_kpi_mkt' => $total_kpi_mkt);
    }
}
