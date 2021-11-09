<?php
/**

 * Description of MY_Controller

 *

 * @author CHUYEN

 */

class MY_Controller extends CI_Controller {

    var $data = array();

    var $user_id = '';

    var $per_page = 0;

    var $controller = '';

    var $method = '';

    public $initGetVariable;

    public $begin_paging = 0;

    public $end_paging = 0;

    public $total_paging = 0;

    protected $table = '';

    public $role_id = 0;

    public $branch_id = 0;

    public $sale_study_abroad = 0;

    public $can_view_contact = 0;

    public $can_edit_contact = 0;


    function __construct() {

        parent::__construct();

        date_default_timezone_set('Asia/Ho_Chi_Minh'); //setup lai timezone

        $this->controller = $this->router->fetch_class(); // lấy controller hiện tại

        $this->method = $this->router->fetch_method(); // lấy phương thức hiên tại

        $this->_check_login();

        $this->_set_default_variable();

        $this->_check_permission();

        $this->_check_permission_edit_view();

        $this->_slogan();

        if ($this->config->item('show_profiler') === TRUE) {

            // $this->output->enable_profiler(TRUE);

        }

        $this->load->vars($this->data);

//         phpinfo();

        require_once APPPATH . 'libraries/Pusher.php';

        $input = array();

        $input['select'] = 'id';

        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0');

        $this->L['L1'] = count($this->contacts_model->load_all($input));

        $input = array();

        $input['select'] = 'id';

        $this->L['all'] = count($this->contacts_model->load_all($input));

        $this->_loadCountListContact();

        $data['time_remaining'] = 0;

        $input = array();

        $input['select'] = 'date_recall';

        $input['where']['date_recall >'] = time();

        $input['order']['date_recall'] = 'ASC';

        $input['limit'] = array('1', '0');

        $noti_contact = $this->contacts_model->load_all($input);

        if (!empty($noti_contact)) {

            $time_remaining = $noti_contact[0]['date_recall'] - time();

            $data['time_remaining'] = ($time_remaining < 3600 * 3) ? $time_remaining : 0;

        }

        $this->load->vars($data);

    }


    private function _check_login() {

        /* Kiểm tra xem người dùng đã đăng nhập chưa*/

        if ($this->controller == 'report') {

            return true;

        }

        $user_id = $this->session->userdata('user_id');

        if (!isset($user_id)) {

            $this->session->set_userdata('last_page', current_url());

            redirect(base_url('dang-nhap.html'));

            die;

        }

    }

    private function _set_default_variable() {

        $this->user_id = $this->session->userdata('user_id');

        $this->role_id = $this->session->userdata('role_id');

        $this->branch_id = $this->session->userdata('branch_id');

        $this->sale_study_abroad = $this->session->userdata('sale_study_abroad');

        /* Lấy controller và action */

        $this->data['controller'] = $this->controller;

        $this->data['action'] = $this->method;

        /* lấy thành phần chung là slide_menu và top_nav */

        //$this->data['slide_menu'] = $this->controller . '/common/slide-menu';

        $this->data['top_nav'] = 'manager/common/top-nav';

        /* Lấy số contact trên 1 trang, nếu người dùng nhập vào số contact

         * thì lấy số đó, nếu không để mặc định là 1 hằng số */

        if (isset($_GET['filter_number_records']) && $_GET['filter_number_records'] != '') {

            $this->per_page = $_GET['filter_number_records'];

        } else {

            $this->per_page = _PER_PAGE_;

        }

        /* Lấy tên chức vụ và id của người dùng hệ thống */

        $this->load->model('role_model');

        $input = array();

        $role = $this->role_model->load_all($input);

        foreach ($role as $value) {

            if ($value['id'] == $this->session->userdata('role_id')) {

                $this->data['role_name'] = $value['position'];

                break;

            }

        }

        /*Gán trường cần hiện của bảng contact*/

        if ($this->role_id == 1) {

    	    $this->table = 'selection name phone branch language level_language ';

        } else if ($this->role_id == 2) {
    		
    		$this->table = 'selection name phone branch language level_language ';

    	} else {
            $this->table = 'selection name phone branch language level_language ';
        }

    }


    private function _check_permission() {

        if ($this->controller == 'report') {

            return true;

        }

        $input = array();

        $input['where'] = array('role_id' => $this->role_id);

        $this->load->model('permission_model');

        $permissions = $this->permission_model->load_all($input);

        $input = array();

        $input['where'] = array('id' => $this->user_id);

        $user = $this->staffs_model->load_all($input);

        if ($user[0]['active'] == 0) {

            redirect(base_url('no_access'));

            die;

        }

        if (empty($permissions)) {

            redirect(base_url('no_access'));

            die;

        } else {

            $perArr = explode(';', $permissions[0]['permission']);

            if (empty($perArr)) {

                redirect(base_url('no_access'));

                die;

            } else {

                $flag = false;

                foreach ($perArr as $value) {

                    $perClass = explode('.', $value)[0];

                    $perMethod = explode('.', $value)[1];

                    if (($perClass == '*' && $perMethod == '*') || ($perClass == $this->controller && $perMethod == '*') || ($perClass == '*' && $perMethod == $this->method) || ($perClass == $this->controller && $perMethod == $this->method)) {

                        $flag = true;

                        break;

                    }

                }

                if (!$flag) {

                    redirect(base_url('no_access'));

                    die;

                }

            }

        }

    }

    private function _check_permission_edit_view() {

        $this->load->model('permission_edit_view');

        $input = array();

        $input['where'] = array('controller' => $this->controller, 'method' => $this->method);

        $edit_view = $this->permission_edit_view->load_all($input);

        if (!empty($edit_view)) {

            $this->can_edit_contact = $edit_view[0]['can_edit'];

            $this->can_view_contact = $edit_view[0]['can_view'];

        }

    }

    /*Lấy các data cần thiết (để truyền sang view)*/

    protected function _get_require_data($require_model) {

        $data = array();

        foreach ($require_model as $key => $value) {

            $model = $key . '_model';

            if ($key != 'staffs' && $key != 'contacts') { // 2 model load tự động

                $this->load->model($model);

            }

            $data[$key] = $this->{$model}->load_all($value);

        }

        return $data;

    }

    /*

     * Hàm tạo data phân trang

     * @param: url trang hiện tại, tổng số dòng 

     * @return: link phân trang

     */

    protected function _create_pagination_link($total_contact, $baseurl = '', $uri_segment = 3) {

        $this->load->library("pagination");

        $config = array();

        $baseURL = ($baseurl == '') ? $this->controller . '/' . $this->method : $baseurl;

        $config['base_url'] = base_url($baseURL);

        if (count($_GET) > 0) {

            $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        }

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $config['total_rows'] = $total_contact;

        $config['per_page'] = $this->per_page;

        $config['uri_segment'] = $uri_segment;

        $this->pagination->initialize($config);

        return $this->pagination->create_links();

    }

    /*

     * Query theo các điều kiện như filter, order, search

     * @param: biến get từ client gửi lên, điều kiện lọc thêm vói từng trường hợp, limit, offset

     * @return: mảng chứa thông tin các contact và tổng số contact thỏa điều kiện

     */

    protected function _query_all_from_get($get, $condition = [], $limit = 0, $offset = 0, $viewContactStar = 1) {

        if (count($get)) {

            $result = array();

        }

        $input_get_arr = $this->_get_query_condition_arr($get);

//        print_arr($input_get_arr);

        $input_get = $input_get_arr['input_get'];

        $has_user_order = $input_get_arr['has_user_order'];

        $input_init = array();

        if (!empty($condition)) {

            foreach ($condition as $key => $value) {

                if ($key == 'order' && $has_user_order == 1) {

                    continue;

                }

                if ($key == 'order') {

                    $has_user_order = 1;

                }

                $input_init[$key] = $value;

            }

        }

        $input = array_merge_recursive($input_init, $input_get);

        if (!$has_user_order) {

            $input['order']['id'] = 'DESC';

        }

//		print_arr($input);

        $total_row = $this->contacts_model->m_count_all_result_from_get($input);
//		echoQuery(); die();
        $result['total_row'] = $total_row; //lấy tổng dòng

        //lấy data sau khi phân trang

        $offset_max = intval($total_row / $limit) * $limit;  //vị trí tối đa

        $offset1 = ($offset > $offset_max) ? $offset_max : ((($offset < 0) ? 0 : $offset));

        if ($limit != 0 || $offset != 0) {

            $input['limit'] = array($limit, $offset1);

        }

        $result['data'] = $this->contacts_model->load_all($input);

		$this->load->model('paid_model');
		foreach ($result['data'] as &$item) {
			$input_paid = array();
			$input_paid['select'] = 'SUM(paid) as paiding';
			$input_paid['where'] = array('contact_id' => $item['id']);
			$item['paid'] = $this->paid_model->load_all($input_paid)[0]['paiding'];
		}
		unset($item);
		
//		print_arr($result['data']);
        // echoQuery();

        /*Lấy thông tin 1 contact đăng ký nhiều khóa học*/

        if ($viewContactStar) {

            if ((isset($condition['select']) && strpos($condition['select'], "phone") !== FALSE) || !isset($condition['select'])) {

                foreach ($result['data'] as &$value) {

                    $input = array();

                    $input['select'] = 'id';

                    $input['where'] = array('phone' => $value['phone']);

                    $courses = $this->contacts_model->load_all($input);

                    $value['star'] = count($courses);

                }

                unset($value);

            }

        }

        //lấy thông tin hiển thị contact đầu, contact cuối và tổng contact

        $this->begin_paging = ($total_row == 0) ? 0 : $offset + 1;

        $this->end_paging = (($offset + $this->per_page) < $total_row) ? ($offset + $this->per_page) : $total_row;

        $this->total_paging = $total_row;

        return $result;

    }

    /*

     * Query theo điều kiện filter để lấy số liệu báo cáo

     * @param: biến get từ client gửi lên

     * @return: số dòng query được

     */

    protected function _query_for_report($get = [], $condition = []) {

    	unset($condition['sum']);
//    	print_arr($condition);

        $input = array();

        $input['select'] = 'id';

        if (!empty($condition)) {

            foreach ($condition as $key => $value) {

                $input[$key] = $value;

            }

        }

        $input_get_arr = $this->_get_query_condition_arr($get);
		
        $input = array_merge_recursive($input, $input_get_arr['input_get']);

        $total_row = count($this->contacts_model->load_all($input));
        return $total_row;

    }

    protected function _query_for_report_re($get = [], $condition = []) {
		
        $input = array();

        $input['select'] = 'SUM(paid) AS st_paid';

        if (!empty($condition)) {

            foreach ($condition as $key => $value) {

                $input[$key] = $value;

            }

        }

        $input_get_arr = $this->_get_query_condition_arr($get);

        $input = array_merge_recursive($input, $input_get_arr['input_get']);
		//print_arr($input);

        $total_contact = $this->contacts_model->load_all($input);
		//print_arr($total_contact);
		return $total_contact[0]['st_paid'];
		
    }

    /*

     * Hàm lấy data tìm kiếm

     * @param: biến get từ client gửi lên, điều kiện (với từng user cụ thể)

     * @return: dữ liệu ocntact tìm kiếm đc

     */

	/*
    protected function _common_find_all($get, $conditional = '') {

        $data = array();

        $require_model = array(

            'staffs' => array(

                'where' => array(

                    'role_id' => 1

                )

            ),

            'courses' => array(),

            'call_status' => array(),

          //  'ordering_status' => array(),

//            'cod_status' => array()

        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));

        if (count($get) > 0) {

            $data['contacts'] = $this->_query_find_contact($get, $conditional);

            $data['total_contact'] = count($data['contacts']);

            $total_row = $data['total_contact'];

            $this->begin_paging = ($total_row == 0) ? 0 : 1;

            $this->end_paging = ($total_row == 0) ? 0 : $total_row;

            $this->total_paging = $total_row;

        }

        return $data;

    }
	*/

    /*

     * Hàm lấy data tìm kiếm từ điều kiện get 

     * @param: biến get từ client gửi lên, điều kiện (với từng user cụ thể)

     * @return: dữ liệu oontact tìm kiếm đc

     */

    private function _query_find_contact($get, $condition = '') {

        $data = array();

        if (!empty($get)) {

            $query = 'SELECT * FROM `tbl_contact`';

            if ($get['name'] != '') {

                $query .= " WHERE (`name` like '%" . $get['name'] . "%'";

            } else {

                $query .= " WHERE (`name` like '/'";

            }

            if ($get['email'] != '') {

                $query .= " OR `email` like '%" . $get['email'] . "%'";

            }

            if ($get['phone'] != '') {

                $query .= " OR `phone` like '%" . $get['phone'] . "%'";

            }

            if ($get['id_contact'] != '') {

                $query .= " OR `id` =" . $get['id_contact'];

            }

            if ($get['name'] == '' && $get['email'] == '' && $get['phone'] == '' && $get['id_contact'] == '') {

                $query = 'SELECT * FROM `tbl_contact`';

                $query .= " WHERE (`name` like '/'";

            }

            $query .= ')' . $condition . ' ORDER BY `id` DESC LIMIT 10 OFFSET 0';

        }

        $data = $this->contacts_model->query2($query);

        return $data;

    }

    protected function _find_dupliacte_contact($email = '', $phone = '', $language_id = '') {

//        $phone = substr($phone, -9, 9);

        $dulicate = 0;

        $input = array();

        $input['select'] = 'id, date_rgt';

        $input['where'] = array('phone' => $phone, 'language_id' => $language_id);
        
        $input['order'] = array('id', 'ASC');
		
//		print_arr($input);

        $rs = $this->contacts_model->load_all($input);
		
        
        if (count($rs) > 0) {
        	if (time() - $rs[0]['date_rgt'] < 3*30*24*60*60) {
				$dulicate = $rs[0]['id'];
			}
		}

        return $dulicate;

    }

    /*

     * Hàm ghi lại lịch sử chăm sóc của 1 contact 

     * @param: ID của contact, nội dung thay đổi

     * @return: void

     */

//    protected function _set_call_log_common($contact_id, $content_change) {
//
//        $this->load->model('call_log_model');
//
//        $param['contact_id'] = $contact_id;
//
//        $param['staff_id'] = $this->user_id;
//
//        $param['content_change'] = $content_change;
//
//        $param['time_created'] = time();
//
//        $this->call_log_model->insert($param);
//
//    }

    /*

     * Hàm bắn contact L8 sang MOL khi đối soát COD

     * @param: mảng ID contact

     * @return: void

     */

//    protected function _put_L8_to_MOL($receiveCOD) {
//
//        if (!empty($receiveCOD)) {
//
//            $this->load->library('REST');
//
//            $config = array(
//
//            	'server' => 'http://mol.lakita.vn/',
//
//                'api_key' => 'SSeKfm7RXCJZxnFUleFsPf63o2ymZ93fWuCmvCjq',
//
//                'api_name' => 'key'
//
//            );
//
//            $this->rest->initialize($config);
//
//            foreach ($receiveCOD as $value) {
//
//                $param['contact_id'] = $value;
//
//                $this->rest->post('contact_collection_api/C3L8', $param);
//
//            }
//
//        }
//
//    }

    /*

     * Hàm lấy điều kiện để query khi có biến get từ client truyền lên

     * @param: biến GET

     * @return: mảng điều kiện query trong hàm load_all (được viết theo quy tắc ở MY_Model)

     */

    protected function _get_query_condition_arr($get) {

        $input_get = array();

        $this->load->model('setting_filter_sort_model');

        $setting_filter_sort = $this->setting_filter_sort_model->load_all();

        $has_user_order = 0; //cờ kiểm tra nếu người dùng chọn order rồi thì ko order mặc định là id nữa

        foreach ($setting_filter_sort as $value) {

            $valueArr = array();

            foreach ($value as $value2) {

                $valueArr[] = $value2;

            }

            list($id, $operator, $get_name, $equal_value, $case_equal, $type_query, $column_name, $specific_value) = $valueArr;

            if (($operator == 'equal' && isset($get[$get_name]) && $get[$get_name] == $equal_value) || ($operator == 'not_equal' && isset($get[$get_name]) && $get[$get_name] != $equal_value) || ($operator == 'array' && isset($get[$get_name]))) {

                switch ($case_equal) {

                    case 'get': {

                            $condition_value = $get[$get_name];

                            break;

                        }

                    case 'specific_value': {

                            $condition_value = $specific_value;

                            break;

                        }

                    case 'date_from': {

                            $condition_value = strtotime($get[$get_name]);

                            break;

                        }

                    case 'date_end': {

                            $condition_value = strtotime($get[$get_name]) + 3600 * 24;

                            break;

                        }

                }

                $input_get[$type_query][$column_name] = $condition_value;

                if ($type_query == 'order') {

                    $has_user_order = 1;

                }

            }

        }

        /*

         * Các trường hợp đặc biệt

         * 1. Báo đỏ, báo vàng sau khi giao đơn cho đơn vị giao hàng

         * lớn hơn 3, 5 ngày mà vẫn chưa thu đc tiền

         */

//        if (isset($get['filter_warning_cod']) && $get['filter_warning_cod'] != 'empty') {
//
//            if ($get['filter_warning_cod'] == 'red') {
//
//                $query = '((FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) > 5 ' .
//
//                        'AND `cod_status_id` = 1)'
//
//                        . ' OR `weight_envelope` > 50)';
//
//                $input_get['where'][$query] = 'NO-VALUE';
//
//            }
//
//            if ($get['filter_warning_cod'] == 'yellow') {
//
//                $query = '(FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) <= 5 AND '
//
//                        . 'FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) >= 3 '
//
//                        . 'AND `cod_status_id` = 1)';
//
//                $input_get['where'][$query] = 'NO-VALUE';
//
//            }
//
//        }

        /*

         * Filter date

         */

        foreach ($get as $key => $value) {

            if (strpos($key, "filter_date_") !== FALSE && $value != '') {

                $dateArr = explode('-', $value);

                $date_from = trim($dateArr[0]);

                $date_from = strtotime(str_replace("/", "-", $date_from));

                $date_end = trim($dateArr[1]);

                $date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24;

                $column_name = substr($key, strlen("filter_date_"));

                $input_get['where'][$column_name . '>='] = $date_from;

                $input_get['where'][$column_name . '<='] = $date_end;

            }

        }

        /* search every where */

        if (isset($get['search_all']) && trim($get['search_all']) != '') {

            $searchStr = trim($get['search_all']);

            $input_get['group_start_like']['phone'] = $searchStr;

            $input_get['or_like']['phone_foreign'] = $searchStr;

            $input_get['or_like']['name'] = $searchStr;

            $input_get['or_like']['email'] = $searchStr;

//            $input_get['or_like']['matrix'] = $searchStr;

            $input_get['group_end_or_like']['id'] = $searchStr;

        }

        if (isset($get['filter_care_number']) && $get['filter_care_number'] != '') {
			$this->load->model('call_log_model');
			$input = array();
			$input['select'] = 'distinct(contact_id)';
			$input['where']['role_id'] = 1;
			$input['group_by'] = array('contact_id');
			$input['having'] = array('count(contact_id)' => $get['filter_care_number']);
			$called = $this->call_log_model->load_all($input);

			if ($this->role_id == 1) {
				$input['where'] = array('staff_id' => $this->user_id);
			}

			$array_contact_id = array();
			foreach ($called as $value) {
				$array_contact_id[] = $value['contact_id'];
			}
			if (!empty($array_contact_id)) {
				$input_get['where_in']['id'] = $array_contact_id;
			}
		}

        if (isset($get['filter_study_date_start']) && !empty($get['filter_study_date_start'])) {
        	$this->load->model('class_study_model');
			$dateArr = explode('-', $get['filter_study_date_start']);
			$date_from = trim($dateArr[0]);
			$date_from = strtotime(str_replace("/", "-", $date_from));
			$date_end = trim($dateArr[1]);
			$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;

			$input_class = array();
			$input_class['where'] = array(
				'time_start >=' => $date_from,
				'time_start <=' => $date_end,
			);

			$class = $this->class_study_model->load_all($input_class);

			if (!empty($class)) {
				$class_array = array();
				foreach ($class as $value) {
					$class_array[] = $value['class_study_id'];
				}
				$input_get['where_in']['class_study_id'] = $class_array;
			} else $input_get['where']['class_study_id'] = 'NONE';
		}

		if (isset($get['filter_study_date_end']) && !empty($get['filter_study_date_end'])) {
			$this->load->model('class_study_model');
			$dateArr = explode('-', $get['filter_study_date_end']);
			$date_from = trim($dateArr[0]);
			$date_from = strtotime(str_replace("/", "-", $date_from));
			$date_end = trim($dateArr[1]);
			$date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24 - 1;

			$input_class = array();
			$input_class['where'] = array(
				'time_end_real >=' => $date_from,
				'time_end_real <=' => $date_end,
			);

			$class = $this->class_study_model->load_all($input_class);

			if (!empty($class)) {
				$class_array = array();
				foreach ($class as $value) {
					$class_array[] = $value['class_study_id'];
				}
				$input_get['where_in']['class_study_id'] = $class_array;
			} else $input_get['where']['class_study_id'] = 'NONE';
		}

        return array(

            'input_get' => $input_get,

            'has_user_order' => $has_user_order

        );

    }

	protected function display_date($date1, $date2, $format = 'd-m-Y' ) {
		$dates = array();
		$current = strtotime(str_replace("/", "-", $date1));
		$date2 = strtotime(str_replace("/", "-", $date2));
		$stepVal = '+1 day';
		while($current <= $date2) {
			$dates[] = date($format, $current);
			$current = strtotime($stepVal, $current);
		}
		return $dates;
	}

    protected function _ajax_redirect($location = '') {

        $location = empty($location) ? '/' : $location;

        if (strpos($location, '/') !== 0 || strpos($location, '://') !== FALSE) {

            if (!function_exists('site_url')) {

                $this->load->helper('url');

            }

            $location = site_url($location);

        }

        $script = "window.location='{$location}';";

        $this->output->enable_profiler(FALSE)

                ->set_content_type('application/x-javascript')

                ->set_output($script);

    }

    protected function renderJSON($json) {

        // Resources are one of the few things that the json

        // encoder will refuse to handle.

        if (is_resource($json)) {

            throw new \RuntimeException('Unable to encode and output the JSON data.');

        }

        $this->output->enable_profiler(FALSE)

                ->set_content_type('application/json')

                ->set_output(json_encode($json));

    }

    public function search($offset = 0) {
        if ($this->role_id == 8 || $this->role_id == 14) {
            echo '<script> alert("Không có quyền truy cập"); </script>';
            die();
        }

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
                )
            ),

            'call_status' => array(),
            'sources' => array(),
			'channel' => array(),
			'campaign' => array(),
			'branch' => array(),
			'level_language' => array(),
			'language_study' => array()
        );

        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $get = $this->input->get();

        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         */

        $conditional['order'] = ['last_activity' => 'DESC'];
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);

        /*Lấy danh sách contacts*/
        $contacts = $data_pagination['data'];
		if ($this->role_id == 1) {
            $value['marketer_name'] = "";
        } else {
			foreach ($contacts as &$value) {
				$value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
			}
		}
        unset($value);
        $data['contacts'] = $contacts;
        $data['total_contact'] = $data_pagination['total_row'];
        /*Lấy link phân trang*/
        $data['pagination'] = $this->_create_pagination_link($this->controller . '/' . $this->method, $data_pagination['total_row']);
        /*Filter ở cột trái và cột phải*/
        $data['left_col'] = array('duplicate', 'date_rgt');
//        $data['right_col'] = array('course_code');
        /*Các trường cần hiện của bảng contact (đã có default)*/
        $this->table .= 'class_study_id fee paid fee_missing call_stt level_contact';
        if ($this->role_id == 1 || $this->role_id == 12) {
            /*  nếu là nhân viên sale thì thêm nút thêm contact khi tìm kiếm */
            $this->table .= ' add_contact';
        }

//		if($this->role_id == 3){
//			$this->table .= ' matrix';
//		}
		
        if ($this->role_id == 10) {
            $this->table = 'selection name phone fee paid date_rgt_study';
        }

        $data['table'] = explode(' ', $this->table);
        $data['search_all'] = $get['search_all'];
        $this->load->view('common/modal/search_all', $data);
    }

    private function _slogan() {
        $slogan = array(

            'Không có gì là không thể với một người luôn biết cố gắng',

            'Không bao giờ, không bao giờ, không bao giờ từ bỏ',

        );

        $sloganNumber = rand(0, count($slogan) - 1);

        $this->data['mySlogan'] = $slogan[$sloganNumber];

    }

    private function _loadCountListContact() {

        $this->L['has_callback'] = 'Tùy từng TVTS';

        $this->L['can_save'] = 'Tùy từng TVTS';

        $input = array();

        $input['select'] = 'id';

        $input['where'] = array(
        	'level_contact_id' => 'L5',
		);

        $this->L['L6'] = count($this->contacts_model->load_all($input));
    }

//    function _get_customer_care_id_auto() {
//
//        $this->load->model('staffs_model');
//
//        $this->load->model('index_model');
//
//        //tìm contact mới nhất xem cskh là ai
//
//        $input = array();
//
//        $input['where']['name'] = 'customer_care_id';
//
//        $customer_care_id_index = $this->index_model->load_all($input);
//
//        $customer_care_id_index = $customer_care_id_index[0]['value'];
//
//        $input = array();
//
//        $input['select'] = 'id';
//
//        $input['where']['role_id'] = 10;
//
//        $input['where']['active'] = 1;
//
//        $input['order']['id'] = 'asc';
//
//        $list_customer_care = $this->staffs_model->load_all($input);
//
//        $customer_care_id = 0;
//
//        for ($i = 0; $i < count($list_customer_care); $i++) {
//
//            if (($list_customer_care[$i]['id'] == $customer_care_id_index) && ($i < count($list_customer_care) - 1)) {
//
//                $customer_care_id = $list_customer_care[$i + 1]['id'];
//
//                break;
//
//            } elseif (($list_customer_care[$i]['id'] == $customer_care_id_index) && ($i == count($list_customer_care)) - 1) {
//
//                $customer_care_id = $list_customer_care[0]['id'];
//
//                break;
//
//            } else {
//
//                $customer_care_id = $list_customer_care[0]['id'];
//
//            }
//
//        }
//
//        $data = array('value' => $customer_care_id);
//
//        $where = array('name' => 'customer_care_id');
//
//        $this->index_model->update($where, $data);
//
//        return $customer_care_id;
//
//    }

	function replace_str_to_url($str){
        $str = trim(strtoupper(str_replace('  ',' ', $str)));
        $str = preg_replace('/\s+/', '_', $str);
        $str = str_replace(' ','-', $str);
        $str = preg_replace('/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/', 'a', $str);
        $str = preg_replace('/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/', 'e', $str);
        $str = preg_replace('/i|í|ì|ỉ|ĩ|ị/', 'i', $str);
        $str = preg_replace('/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/', 'o', $str);
        $str = preg_replace('/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/', 'u', $str);
        $str = preg_replace('/ý|ỳ|ỷ|ỹ|ỵ/', 'y', $str);
        $str = preg_replace('/đ/', 'd', $str);
        //Xóa các ký tự đặt biệt
        $str = preg_replace('/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/', '-', $str);
        $str = strtoupper($str);
        return $str;
    }
	
	protected function GetProccessToday() {
		$this->load->model('language_study_model');
		$this->load->model('paid_model');

        $input['where']['active'] = 1;
        $input['where']['out_report'] = '0';
		$language = $this->language_study_model->load_all($input);

		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'source_revenue_id' => 1,
				'time_created >=' => strtotime(date('d-m-Y'))
			);
			
			if ($this->role_id == 12) {
				$input_re['where']['branch_id'] = $this->session->userdata('branch_id');
			}
			//print_arr($input_re);
			
			$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
			$input_re_old = array_merge_recursive(array('where' => array('student_old' => 1)), $input_re);
			
			$progress['old'][$value['name']] = $this->paid_model->load_all($input_re_old);
			$progress['new'][$value['name']] = $this->paid_model->load_all($input_re_new);
			
			$total_new += $progress['new'][$value['name']][0]['RE'];
			$total_old += $progress['old'][$value['name']][0]['RE'];
		}
		$progress['total_new'] = $total_new;
		$progress['total_old'] = $total_old;
//		print_arr($progress);

        return $progress;
    }
	
	protected function GetProccessThisMonth() {
		$this->load->model('paid_model');
		$this->load->model('language_study_model');

		$input['where']['out_report'] = '0';
		$input['where']['active'] = 1;
		$language = $this->language_study_model->load_all($input);
		
		$total_new = 0;
		$total_old = 0;
		foreach ($language as $value) {
			$input_re['select'] = 'SUM(paid) AS RE';
			$input_re['where'] = array(
				'language_id' => $value['id'],
				'source_revenue_id' => 1,
				'time_created >=' => strtotime(date('01-m-Y'))
			);
			
			if ($this->role_id == 12) {
				$input_re['where']['branch_id'] = $this->session->userdata('branch_id');
			}
			
			$input_re_new = array_merge_recursive(array('where' => array('student_old' => '0')), $input_re);
			$input_re_old = array_merge_recursive(array('where' => array('student_old' => 1)), $input_re);
			
			$progress['old'][$value['name']] = $this->paid_model->load_all($input_re_old);
			$progress['new'][$value['name']] = $this->paid_model->load_all($input_re_new);
			
			$total_new += $progress['new'][$value['name']][0]['RE'];
			$total_old += $progress['old'][$value['name']][0]['RE'];
		}
		$progress['total_new'] = $total_new;
		$progress['total_old'] = $total_old;

        return $progress;
    }

}

