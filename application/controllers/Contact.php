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

           // $address = isset($input['dia_chi']) ? $input['dia_chi'] : '';

           // $param['address'] = str_replace('NO_PARAM', '', $address);

           	$param['class_study_id'] = isset($input['class_study_id']) ? $input['class_study_id'] : '';

            $param['branch_id'] = isset($input['branch_id']) ? $input['branch_id'] : 0;

            if (isset($input['code_landingpage'])) {
				$param['language_id'] = $this->get_language_id($input['code_landingpage']);
				$param['source_id'] = 2;
			} else {
            	$param['language_id'] = $input['language_id'];
				$param['source_id'] = 3;
			}

            $param['level_language_id'] = isset($input['level_language_id']) ? $input['level_language_id'] : 0;

            $param['payment_method_rgt'] = isset($input['payment_method_rgt']) ? $input['payment_method_rgt'] : 1;

            $param['date_rgt'] = time();

           // if (isset($input['call_status_id'])) {
           //     $param['call_status_id'] = $input['call_status_id'];
           //     if($input['call_status_id'] == '4'){
           //         $param['date_last_calling'] = time();
           //     }
           // }

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
                $param['channel_id'] = (isset($input['channel_id'])) ? $input['channel_id'] : '';
            }

           	if (isset($input['source_id']) && strripos($input['source_id'], 'ib') != false) {
           		$param['source_id'] = 1;
           	}

            // $param['source_id'] = (isset($input['source_id'])) ? $input['source_id'] : 1;

            $param['last_activity'] = time();

            /* ======= Lọc trùng contact ============ */

            $param['duplicate_id'] = $this->_find_dupliacte_contact($param['phone'], $param['level_language_id']);

            // print_arrs($param);

           // $this->contacts_model->insert_from_mol($param);
           // $this->contacts_backup_model->insert_from_mol($param);

			$id = $this->contacts_model->insert_return_id($param, 'id');
			// $id_backup = $this->contacts_backup_model->insert_return_id($param, 'id');

			if (isset($input['lop'])) {
				$param2 = array(
					'contact_id' => $id,
					'content' => $input['lop'],
					'time_created' => time(),
					'sale_id' => 0,
					'contact_code' => $this->contacts_model->get_contact_code($id),
					'class_study_id' => 0
				);
				//print_arr($param2);
				$this->load->model('notes_model');
				$this->notes_model->insert($param2);
			}

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

           // $pusher = new Pusher(

           //     '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options

           // );

			$pusher = new Pusher(

				'f3c70a5a0960d7b811c9', '2fb574e3cce59e4659ac', '1042224', $options

			);

			$inputMkt = [];

            $inputMkt['where'] = array('id' => $marketerId);

            $marketer = $this->staffs_model->load_all($inputMkt);

            if ($marketer[0]['targets'] != 0) {

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

	private function _find_dupliacte_contact($phone = '', $level_language_id = '') {

        $dulicate = 0;

        $input = array();

        $input['select'] = 'id';

        $input['where'] = array(

            'phone' => $phone,

            'level_language_id' => $level_language_id,

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

   private function get_language_id($code_lp) {
       $this->load->model('landingpage_model');

       $input['where'] = array(
           'code' => $code_lp
       );

       $class_study = $this->landingpage_model->load_all($input);
       if (isset($class_study) && !empty($class_study)) {
           return $class_study[0]['language_id'];
       } else {
           return 'ERROR';
       }

   }

//    private function get_branch_id($class_id) {
//    	$this->load->model('class_study_model');
//
//    	$input['where'] = array('class_study_id' => $class_id);
//    	$branch_id = $this->class_study_model->load_all($input);
//    	if (isset($branch_id)) {
//    		return $branch_id['branch_id'];
//		} else {
//    		return 'ERROR';
//		}
//	}


}

