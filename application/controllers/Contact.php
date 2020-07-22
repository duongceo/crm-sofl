<?php



/**

 * Description of Contact

 *

 * @author CHUYEN

 */

class Contact extends CI_Controller {

    public function __construct() {

        parent::__construct();

    }

    public function add_contact() {

        $input = $this->input->post();

        // print_arr($input);

        if (!empty($input)) {

            /* Lọc thông tin contact */

            $param['name'] = isset($input['name']) ? $input['name'] : '';

            $param['phone'] = isset($input['phone']) ? trim($input['phone']) : '';

            if ($param['name'] == '' || trim($param['phone']) == '') {

                echo 'không có tên hoặc số điện thoại';die;

            }

            $param['email'] = isset($input['email']) ? $input['email'] : '';

            $address = isset($input['dia_chi']) ? $input['dia_chi'] : '';

            $address .= ' ';

            $address .= isset($input['quan']) ? $input['quan'] : '';

            $address .= ' ';

            $address .= isset($input['tinh']) ? $input['tinh'] : '';

            $param['address'] = str_replace('NO_PARAM', '', $address);

            $param['is_consultant'] = (stripos($param['address'], 'tv') !== false) ? 1 : 0;

            $param['class_study_id'] = $this->get_class_study($input['code_landingpage']);

            $param['branch_id'] = $this->get_branch_id($param['class_study_id']);

            $param['payment_method_rgt'] = isset($input['payment_method_rgt']) ? $input['payment_method_rgt'] : 1;

            $param['date_rgt'] = time();

            if (isset($input['call_status_id'])) {
                $param['call_status_id'] = $input['call_status_id'];
                if($input['call_status_id'] == '4'){
                    $param['date_last_calling'] = time();
                }
            }

            if (isset($input['ordering_status_id'])) {
                $param['ordering_status_id'] = $input['ordering_status_id'];
                if($input['ordering_status_id'] == '4'){
                    $param['date_confirm'] = time();
                }
            }

            if (isset($input['link_id'])) {

                $this->load->model('link_model');

                $input_link = array();

                $input_link['where'] = array('id' => $input['link_id']);

                $links = $this->link_model->load_all($input_link);

                if (!empty($links)) {

                    $param['marketer_id'] = $links[0]['marketer_id'];

                    $param['channel_id'] = $links[0]['channel_id'];

                    $param['campaign_id'] = $links[0]['campaign_id'];

                    $param['adset_id'] = $links[0]['adset_id'];

                    $param['ad_id'] = $links[0]['ad_id'];

                    $param['landingpage_id'] = $links[0]['landingpage_id'];

                    $param['link_id'] = $links[0]['id'];

                }

            } else {
                $param['channel_id'] = (isset($input['channel_id']) && !empty($input['channel_id'])) ? $input['channel_id'] : '';
            }

            $param['source_id'] = (isset($input['source_id']) && !empty($input['source_id'])) ? $input['source_id'] : 1;

            $param['last_activity'] = time();

            /* ======= Lọc trùng contact ============ */

            $param['duplicate_id'] = $this->_find_dupliacte_contact($param['phone'], $param['class_study_id']);

            // print_arr($param);

            $this->contacts_model->insert_from_mol($param);
            $this->contacts_backup_model->insert_from_mol($param);

            // $this->load->view('landingpage/popup_dangky');

            $marketerId = isset($param['marketer_id']) ? $param['marketer_id'] : '0';

            $data2 = [];

            $title = 'Có 1 contact mới đăng ký';

            $message = 'Click để xem ngay';

            require_once APPPATH . 'libraries/Pusher.php';

            $options = array(

                'cluster' => 'ap1',

                'encrypted' => true,

				'useTLS' => true

            );

//            $pusher = new Pusher(
//
//                '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
//
//            );

			$pusher = new Pusher(

				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options

			);

			$inputMkt = [];

            $inputMkt['where'] = array('id' => $marketerId);

            $marketer = $this->staffs_model->load_all($inputMkt);

            if ($marketer[0]['targets'] != '') {

                $inputToday = [];

                $inputToday['select'] = 'id';

                $inputToday['where'] = array('marketer_id' => $marketerId, 'date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');

                $today = $this->contacts_model->load_all($inputToday);

                $totalC3 = count($today);

                $data2['title'] = "C3 số " . $totalC3 . " của " . $marketer[0]['short_name'] . " hôm nay";


                if ($totalC3 < $marketer[0]['targets']) {

                    $data2['message'] = "Bạn còn " . ($marketer[0]['targets'] - $totalC3) . " C3 nữa là đạt mục tiêu hôm nay!";

                } else if ($totalC3 == $marketer[0]['targets']) {

                    $data2['message'] = "Xin chúc mừng, bạn đã đạt mục tiêu hôm nay. Cố gắng phát huy bạn nhé <3 <3 <3";

                } else {

                    $data2['message'] = "Xin chúc mừng, bạn đã vượt mục tiêu hôm nay. Cố gắng phát huy bạn nhé <3 <3 <3";

                }

                $title = $data2['title'];

                $message = $data2['message'];

            } else {

                $data2['title'] = 'Có contact mới đăng ký';

                $data2['message'] = 'Click để xem ngay';

            }

            $data2['image'] = $this->staffs_model->GetStaffImage($marketerId);

            $pusher->trigger('my-channel', 'notice', $data2);

        }

        $this->load->view('landingpage/popup_dangky');

    }

	private function _find_dupliacte_contact($phone = '', $class_study_id = '') {

        $dulicate = 0;

        $input = array();

        $input['select'] = 'id';

        $input['where'] = array(

            'phone' => $phone,

            'class_study_id' => $class_study_id,

            'is_hide' => '0'

        );

        $input['order'] = array('id', 'ASC');

        $input['limit'] = array('1', '0');

        $rs = $this->contacts_model->load_all($input);

        if (count($rs) > 0) {

            $dulicate = $rs[0]['id'];

        }

        return $dulicate;

    }

    private function get_class_study($code_lp) {
        $this->load->model('landingpage_model');

        $input['where'] = array(
            'code' => $code_lp
        );

        $class_study = $this->landingpage_model->load_all($input);
        if (isset($class_study) && !empty($class_study)) {
            return $class_study[0]['class_study_id'];
        } else {
            return 'ERROR';
        }

    }

    private function get_branch_id($class_id) {
    	$this->load->model('class_study_model');

    	$input['where'] = array('class_study_id' => $class_id);
    	$branch_id = $this->class_study_model->load_all($input);
    	if (isset($branch_id)) {
    		return $branch_id['branch_id'];
		} else {
    		return 'ERROR';
		}
	}



}

