<?php

class Test1 extends CI_Controller {

    function index($day = '0') {

        if ($day == '0') {

            $day = "-1 days";
        }

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        // echo $today_fb_format .'--'. $today;die();
        $this->load->model('campaign_spend_model');

        $this->load->model('account_fb_model');

        $accountFBADS = $this->account_fb_model->load_all();
		
		$url = 'https://graph.facebook.com/v4.0/act_2580696332214816/insights?fields=spend,campaign_id,campaign_name,reach,outbound_clicks&level=campaign&limit=5000&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
		$acc = get_fb_request($url);
		$spend = json_decode(json_encode($acc->data), true);
//        echo "<pre>";print_r($spend);die();

		foreach ($spend as $key => $value1) {
            	$input['where'] = $where = array(
            		'campaign_id' => $this->find_campaign_id($value1['campaign_id']), 
            		'time' => $today
            	);
            	// echo $value1['campaign_id'].'<br>';
            	// echo "<pre>";print_r($input['where']);die();
            	if (!empty($this->campaign_spend_model->load_all($input))) {
                	$this->campaign_spend_model->delete($where);
            	} 

            	if ($value1['spend'] > 0) {
                    $param['spend'] = $value1['spend'];
            		$param['time'] = $today;
            		$param['campaign_id'] = $this->find_campaign_id($value1['campaign_id']);
            		$param['campaign_id_fb'] = $value1['campaign_id'];
            		$param['total_C1'] = $value1['reach'];
            		$param['total_C2'] = $value1['outbound_clicks'][0]['value'];
                    $param['date_spend'] = date('Y-m-d H:i:s', strtotime($day));
            		// echo "<pre>";print_r($param);
            		$this->campaign_spend_model->insert($param);
            	}
            }

		/*
        foreach ($accountFBADS as $key => $value) {
            $url = 'https://graph.facebook.com/v4.0/act_'.$value['fb_id_account'].'/insights?fields=spend,campaign_id,campaign_name,reach,outbound_clicks&level=campaign&limit=5000&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

            // $url = 'https://graph.facebook.com/v3.2/act_'.$value['fb_id_account'].'/insights?fields=spend,reach,outbound_clicks&level=account'. '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

            $acc = get_fb_request($url);
            // $spend = (array) $acc->data;
            $spend = json_decode(json_encode($acc->data), true);
            usort($spend, function($a, $b) {
                return $b['spend'] - $a['spend'];
            });
            echo "<hr>".$value['name'].'<br>';
            echo "<pre>";print_r($spend);

            // foreach ($spend as $key => $value1) {
            // 	$input['where'] = $where = array(
            // 		'campaign_id' => $this->find_campaign_id($value1['campaign_id']), 
            // 		'time' => $today
            // 	);
            // 	// echo $value1['campaign_id'].'<br>';
            // 	// echo "<pre>";print_r($input['where']);die();
            // 	if (!empty($this->campaign_spend_model->load_all($input))) {
            //     	$this->campaign_spend_model->delete($where);
            // 	} 

            // 	if ($value1['spend'] > 0) {
            //         if ($value['USD'] == 1) {
            //             $param['spend'] = $value1['spend'] * 23200;
            //         } else {
            // 		    $param['spend'] = $value1['spend'];
            //         }

            // 		$param['time'] = $today;
            // 		$param['campaign_id'] = $this->find_campaign_id($value1['campaign_id']);
            // 		$param['campaign_id_fb'] = $value1['campaign_id'];
            // 		$param['total_C1'] = $value1['reach'];
            // 		$param['total_C2'] = $value1['outbond_clicks'][0]['value'];
            //         $param['date_spend'] = date('Y-m-d H:i:s', strtotime($day));
            // 		// echo "<pre>";print_r($param);
            // 		$this->campaign_spend_model->insert($param);
            // 	}
            // }
        }
		*/
        echo "success";

    }
	
	function test(){
		phpinfo();
	}

//    function test_3() {
//
//        $input['select'] = 'phone,email,course_code';
//
//        $input['where'] = array(
//
//            'date_rgt >' => 1519862400,
//
//            'date_rgt <' => 1522454400,
//
//            'is_hide' => '0',
//
//            'duplicate_id' => '',
//
//            'ordering_status_id' => 4
//
//        );
//
//        $input['group_by'] = array('phone');
//
//        $input['having'] = array('count(id) >' => 1);
//
//        $input['order'] = array('id' => 'desc');
//
//        $contact_list_buy = $this->contacts_model->load_all($input);
//
//        $contact_re_buy = array();
//
//        foreach ($contact_list_buy as $value) {
//
//            $input = '';
//
//            $input['select'] = 'phone,email,course_code,date_rgt';
//
//            $input['where']['phone'] = $value['phone'];
//
//            $input['where']['is_hide'] = '0';
//
//            $input['where']['duplicate_id'] = '';
//
//            $input['where']['ordering_status_id'] = 4;
//
//            $input['order'] = array('id' => 'desc');
//
//            $contact = '';
//
//            $contact = $this->contacts_model->load_all($input);
//
//            $count = count($contact);
//
//            if ($count > 1) {
//
//                for ($i = 0; $i < $count - 1; $i++) {
//
//                    if ($contact[$i]['date_rgt'] - $contact[$i + 1]['date_rgt'] < 172800) {
//
//                        $contact_re_buy[] = $contact[$i];
//
//                    }
//
//                }
//
//            }
//
//        }
//
//        echo '<pre>';
//        print_r($contact_re_buy);
//
//    }

//    function test_url($day = '0') {
//        if ($day == '0') {
//            $day = "-1 days";
//        }
//
//        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ
//
//        $today_fb_format = date('Y-m-d', strtotime($day));
//
//        // $url = 'https://graph.facebook.com/v4.0/act_2341952402735054/insights?fields=spend,campaign_id,campaign_name,reach,outbound_clicks&level=account&limit=5000&date_preset=yesterday&access_token=' . ACCESS_TOKEN;
//
//        $url = 'https://graph.facebook.com/v4.0/23843563207830758/insights?fields=spend,reach,outbound_clicks&level=account'.'&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
//
//        $acc = get_fb_request($url);
//        echo "<pre>";print_r($acc);
//    }

//    function find_campaign_id($campaign_id) {
//    	$this->load->model('campaign_model');
//    	$input['select'] = 'id, name';
//		$input['where']['campaign_id_facebook'] = $campaign_id;
//		$c = $this->campaign_model->load_all($input);
//		return $c[0]['id'];
//		// echo'<pre>';print_r($c);die();
//	}

//    public function test_spend_fb() {
//        $this->load->model('staffs_model');
//        $this->load->model('campaign_model');
//        $this->load->model('campaign_spend_model');
//        $this->load->model('courses_model');
//
//        $input_staff['select'] = 'id, name';
//        $input_staff['where'] = array('role_id' => 6, 'active' => 1);
//        $staff = $this->staffs_model->load_all($input_staff);
//        // echo "<pre>";print_r($staff);
//
//        foreach ($staff as $value) {
//            //echo $value['id'].'--';
//            $input_camp['select'] = 'id, name';
//            $input_camp['where'] = array('marketer_id' => $value['id'], 'channel_id' => 2);
//            $camp = $this->campaign_model->load_all($input_camp);
//            $campaign_fb_list = array();
//            foreach ($camp as $value1) {
//                $campaign_fb_list[] = $value1['id'];
//            }
//
//            $input_spend['select'] = 'SUM(spend) as spend';
//            $input_spend['where'] = array(
//                'time >=' => 1569862800,
//                'time <' => 1572566400
//                // 'date_spend >=' => '2019-10-01',
//                // 'date_spend <=' => '2019-10-31'
//            );
//            // 1568592000 - 7*3600
//            $input_spend['where_in'] = array('campaign_id' => $campaign_fb_list);
//
//            if (empty($campaign_fb_list)) {
//                $spend_fb = 0;
//            } else {
//                $spend_fb = (int) $this->campaign_spend_model->load_all($input_spend)[0]['spend'];
//            }
//			if ($spend_fb > 0) {
//				echo $value['name'].' -- '.number_format($spend_fb).'<hr>';
//			}
//
//            // echo "<pre>";print_r($spend_fb);
//
//        }
//
//    }

    /*
    function update_active_account_post() {
        $post = $this->input->post();
        $where = $input['where'] = array(
            'id_lakita' => $post['id_lakita']
            //'course_code' => $post['course_code']
        );
        
        $data = array(
            'date_active' => time(),
            'account_active' => '1'
        );
        
        $contact_active = $this->contacts_model->load_all($input);
        if (!empty($contact_active)) {
            $this->contacts_model->update($where, $data);
        } else {
            $where = array(
                'phone' => $post['phone']
                //'course_code' => $post['course_code']
            );
            
            $this->contacts_model->update($where, $data);
        }
        
        $this->response('success', 200);
    }
    */
	
	function get_contact() {
		
		$input['select'] = 'name, phone, level_contact_id, language_id';
		$input['where'] = array(
			'is_hide' => '0',
			'level_contact_id' => 'L5'
		);
		$cts = $this->contacts_model->load_all($input);
		//print_arr($cts);
		
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
//		$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
//		$template_file_print = $this->config->item('template_file_print');
//		$objPHPExcel = $objPHPExcel->load($template_file_print);
		$objPHPExcel->setActiveSheetIndex(0);
//		$contact_export = $this->_contact_export($post['contact_id']);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SDT');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TT');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã ngoại ngữ');

		$rowCount = 2;
		foreach ($cts as $key => $val) {
			$columnName = 'A';
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $val['phone']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $val['name']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $val['level_contact_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $val['language_id']);
			$rowCount++;
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Contact_' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}

//    public function create_account_student() {
//        $input['select'] = 'id, name, phone, level_language_id, sent_account_online';
//        $input['where'] = array(
//            'sent_account_online' => '0',
//            'date_rgt_study >=' => 1598918400,
//            'level_language_id !=' => '0',
//        );
//
//        $contact = $this->contacts_model->load_all($input);
//        print_arr($contact);
//
//        foreach ($contact as $value) {
//            $student = $this->create_new_account_student($value);
//            if ($student->success != 0) {
//                $where = array('id' => $value['id']);
//                $param['sent_account_online'] = 1;
//                $param['date_active'] = time();
//                $this->contacts_model->update($where, $param);
//                echo "OK";
//            }
//        }
//    }
//
//    private function create_new_account_student($contact) {
//        $this->load->model('level_language_model');
//        $contact['course_code'] = $this->level_language_model->find_course_combo($contact['level_language_id']);
//        $contact['type'] = 'offline';
//        // echo "<pre>"; print_r($contact); die;
//
//        require_once APPPATH . "libraries/Rest_Client.php";
//        $config = array(
//            'server' => 'http://sofl.edu.vn',
//            'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
//            'api_name' => 'sofl-key'
//        );
//        $restClient = new Rest_Client($config);
//        $uri = "account_api/create_new_account";
//        $student = $restClient->post($uri, $contact);
//        //echo json_decode($student);
//        return $student;
//    }

	function delete_contact_test(){
		$this->contacts_model->call_pr();
	}

	public function call_ipphone(){
		$from_date = strtotime(date('d-m-Y')) * 1000;
		$to_date = (strtotime(date('d-m-Y')) + 24*60*60 - 1) * 1000;

		$url = 'https://public-v1-stg.omicall.com/api/auth?apiKey=B3B818D0-6902-45BF-A999-697CA91D85F5-XFOLXW4S';
		$data = $this->request_api_call($url);
		$access_token = $data->payload->access_token;

		if ($access_token != '') {
			$page = 1;
//			$page_size = 50;
			while(true){
				$url_2 = 'https://public-v1-stg.omicall.com/api/call_transaction/list?from_date='.$from_date.'&to_date='.$to_date.'&size=50&page='.$page;
				$call_detail = $this->request_api_call($url_2, $access_token);
				$data_call = $call_detail->payload->items;
//				print_arr($data_call);

				if (isset($data_call) && !empty($data_call)) {
					$this->load->model('missed_call_model');
					foreach ($data_call as $item) {
						if ($item->disposition == 'cancelled' && $item->direction == 'inbound') {
							$missed_call = 1;
						} else {
							$missed_call = 0;
						}

						$param = array(
							'source_number' => $item->source_number,
							'destination_number' => $item->destination_number,
							'transaction_id' => $item->transaction_id,
							'missed_call' => $missed_call,
							'sale_recall' => 0,
							'time_created' => $item->time_start_to_answer,
							'link_conversation' => $item->recording_file,
							'sale_id' => $this->staffs_model->get_sale_id($item->sip_user),
							'fee_call' => (int)$item->call_out_price,
							'time_call' => $item->bill_sec,
							'day' => date('Y-m-d', ($item->time_start_to_answer))
						);

						$this->missed_call_model->insert($param);
//						echo '<pre>'; print_r($item->source_number);
					}
				} else {
					break;
				}

				if ($call_detail->payload->has_next != 1) {
					break;
				}
				++$page;
			}
		}
	}

	function request_api_call($url, $token='') {

		$options = array(

			CURLOPT_URL => $url,

			CURLOPT_CUSTOMREQUEST => "GET",

			CURLOPT_RETURNTRANSFER => TRUE,

			CURLOPT_HEADER => FALSE,

			CURLOPT_FOLLOWLOCATION => TRUE,

			CURLOPT_ENCODING => '',

			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',

			CURLOPT_AUTOREFERER => TRUE,

			CURLOPT_CONNECTTIMEOUT => 150,

			CURLOPT_TIMEOUT => 150,

			CURLOPT_MAXREDIRS => 5,

			CURLOPT_SSL_VERIFYHOST => 2,

			CURLOPT_SSL_VERIFYPEER => 0,

			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer {$token}"
			)
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

			unset($options);

		return $http_code === 200 ? json_decode($response) : FALSE;

	}

}


