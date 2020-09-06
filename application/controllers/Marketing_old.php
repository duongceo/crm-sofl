<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

/**

 * Description of Marketing

 *

 * @author phong

 */
class Marketing extends MY_Table {

    public function __construct() {

        parent::__construct();

        $this->init();
    }

    public function init() {

        $this->controller_path = 'Marketing';

        $this->view_path = 'marketing';

        $this->sub_folder = '';

        /*

         * Liệt kê các trường trong bảng

         * - nếu type = text thì không cần khai báo

         * - nếu không muốn hiển thị ra ngoài thì dùng display = none

         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom

         */

        $list_item = array(
            //         'id' => array(
            //           'name_display' => 'ID'
            //      ),

            'name' => array(
                'name_display' => 'Họ tên',
                'order' => '1'
            ),
            'phone' => array(
                'name_display' => 'Số đt'
            ),
            // 'email' => array(
            //     'name_display' => 'Email'
            // ),
            // 'address' => array(
            //     'name_display' => 'Địa chỉ'
            // ),
            // 'course_code' => array(
            //     'name_display' => 'Mã khóa học'
            // ),

            'date_rgt' => array(
                'type' => 'datetime',
                'name_display' => 'Ngày đăng ký',
                'order' => '1'
            ),
            'channel' => array(
                'name_display' => 'Kênh',
                'order' => '1'
            ),
            'marketer' => array(
                'name_display' => 'Marketer',
                'order' => '1'
            ),
            'duplicate_id' => array(
                'name_display' => 'Contact trùng',
                'display' => 'none'
            ),
            // 'course' => array(
            //     'name_display' => 'Mã khóa học',
            //     'display' => 'none'
            // ),
            'landingpage' => array(
                'name_display' => 'Landing Page',
                'display' => 'none'
            ),
            'is_hide' => array(
                'name_display' => 'Đã xóa',
                'display' => 'none'
            )
        );

        // print_arr($list_item);

        $this->set_list_view($list_item);

        $this->set_model('contacts_model');
    }

    /*

     * override lại hàm show_table của lớp cha

     */

    protected function show_table() {

        parent::show_table();

        $this->load->model('channel_model');

//        $this->load->model('campaign_model');
//        $this->load->model('adset_model');
//        $this->load->model('ad_model');

        $this->load->model('staffs_model');

        foreach ($this->data['rows'] as &$value) {

            $class = '';

            if ($value['is_hide'] == 1) {

                $class .= ' is_hide';
            }

            if ($value['duplicate_id'] > 0) {

                $class .= ' duplicate';
            }

            if ($class != '') {

                $value['warning_class'] = $class;
            }

            $value['channel'] = $this->channel_model->find_channel_name($value['channel_id']);

//            $value['campaign'] = $this->campaign_model->find_campaign_name($value['campaign_id']);
//            $value['adset'] = $this->adset_model->find_adset_name($value['adset_id']);
//            $value['ad'] = $this->ad_model->find_ad_name($value['ad_id']);

            $value['marketer'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }

        unset($value);
    }

    function delete_item() {

        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');
    }

    function delete_multi_item() {

        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);
    }

    function index($offset = 0) {

        $this->load->model('channel_model');

        $input = array();

        $input['where'] = array('active' => '1');

        $channels = $this->channel_model->load_all($input);

        $this->data['channel'] = $channels;

        $input = array();

        $input['where'] = array('role_id' => '6', 'active' => '1');

        $this->data['marketer'] = $this->staffs_model->load_all($input);

        $this->list_filter = array(
            'left_filter' => array(
                'marketer' => array(
                    'type' => 'arr_multi'
                ),
                'channel' => array(
                    'type' => 'arr_multi'
                ),
            ),

            'right_filter' => array(
                'duplicate_id' => array(
                    'type' => 'binary',
                ),
            )
        );

        $conditional = array();

        $conditional['where']['date_rgt >'] = strtotime(date('d-m-Y'));
        $conditional['where']['affiliate_id'] = '0';


        $this->set_conditional($conditional);

        $this->set_offset($offset);

        $this->show_table();

        $data = $this->data;


        // $progress = $this->GetProccessMarketerToday();

		//lấy tổng kpi
        // $val = 0;
        // $data['marketers'] = $progress['marketers'];
        // foreach ($data['marketers'] as $value) {
        //     $val += $value['targets'];
        // }

        // $data['marketers'] = $progress['marketers'];

        // $data['C3Team'] = $progress['C3Team'];

        // $data['C3Total'] = $val;

        $data['progressType'] = 'Tiến độ của team hôm nay';

        $data['list_title'] = 'Danh sách contact ngày hôm nay';

        $data['content'] = 'marketing/index';

        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_all($offset = 0) {

        $this->load->model('channel_model');

        $input = array();

        $input['where'] = array('active' => '1');

        $channels = $this->channel_model->load_all($input);

        $this->data['channel'] = $channels;


        $input = array();

        $input['where'] = array('role_id' => '6', 'active' => '1');

        $this->data['marketer'] = $this->staffs_model->load_all($input);


        $this->load->model('courses_model');

        $input = array();

        $input['where'] = array('active' => '1');

        $this->data['course'] = $this->courses_model->load_all($input);


        $this->load->model('landingpage_model');

        $input = array();

        $input['where'] = array('active' => '1');

        $this->data['landingpage'] = $this->landingpage_model->load_all($input);

        $this->list_filter = array(
            'left_filter' => array(
                'date_rgt' => array(
                    'type' => 'datetime',
                ),
                'marketer' => array(
                    'type' => 'arr_multi'
                ),
                'channel' => array(
                    'type' => 'arr_multi'
                ),
            ),
            'right_filter' => array(
                'course' => array(
                    'type' => 'arr_multi',
                    'field_name' => 'course_code',
                    'field' => 'course_code',
                    'table_id' => 'course_code'
                ),
                'landingpage' => array(
                    'type' => 'arr_multi',
                    'field_name' => 'url',
                ),
                'duplicate_id' => array(
                    'type' => 'binary',
                ),
                'is_hide' => array(
                    'type' => 'binary',
                )
            )
        );

        $conditional = array();

        //  $conditional['where']['source_id'] = '1';

        $this->set_conditional($conditional);

        $this->set_offset($offset);

        $this->show_table();

        //echoQuery();

        $data = $this->data;

        $progress = $this->GetProccessMarketerThisMonth();
		
		// Tổng kpi theo tháng
        $pro = $this->GetProccessMarketerToday();
        $dt['marketers'] = $pro['marketers'];
        $val = 0;
        foreach ($dt['marketers'] as $value) {
            $val += $value['targets'];
        }

        $data['marketers'] = $progress['marketers'];
		
        $data['C3Team'] = $progress['C3Team'];

        //$data['C3Total'] = MARKETING_KPI_PER_DAY * 30;
		$data['C3Total'] = $val * 30;

        $data['progressType'] = 'Tiến độ của team tháng này';

        $data['list_title'] = 'Danh sách toàn bộ contact';

        $data['content'] = 'marketing/index';

        $this->load->view(_MAIN_LAYOUT_, $data);
    }


    function view_report_operation() {
        $this->load->model('campaign_cost_model');
        $this->load->model('cost_warehouse_model');
        $this->load->model('Cost_GA_campaign_model');
        $this->load->model('campaign_model');
        $this->load->helper('manager_helper');
		$this->load->model('courses_model');
		$this->load->model('campaign_spend_model');
        $get = $this->input->get();
        //echo '<pre>'; print_r($get);die;
        if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
            $time = $get['filter_date_date_happen'];
        } else {
            $time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
        }
        $dateArr = explode('-', $time);
        $startDate = trim($dateArr[0]);
        $startDate = strtotime(str_replace("/", "-", $startDate));
        $endDate = trim($dateArr[1]);
        $endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24;
        
        /*if ((!isset($get['filter_date_happen_from']) && !isset($get['filter_date_happen_end'])) || (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] == '' && $get['filter_date_happen_end'] == '')) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $startDate = strtotime(date('1-m-Y'));

            $endDate = strtotime(date('d-m-Y'));
        } else {

            $startDate = strtotime($get['filter_date_happen_from']);

            $endDate = strtotime($get['filter_date_happen_end']);
        }*/

        $dateArray = h_get_time_range($startDate, $endDate);

        $input_campaign = array();
        $input_campaign['select'] = 'id';

        if (isset($get['filter_marketer_id'])) {
            $input_campaign['where_in']['marketer_id'] = $get['filter_marketer_id'];
        }
		
		if (isset($get['filter_brand_id'])) {
			//echo $get['filter_brand_id'][0];die;
			$input_brand['where'] = array('brand_id' => $get['filter_brand_id'][0]);
			$c = $this->courses_model->load_all($input_brand);
			$course_id_list = array();
			foreach ($c as $vc) {
				$course_id_list[] = $vc['id'];
			}
			//echo '<pre>';print_r($course_id_list); die;
		}

        //campaign FB
        $input_campaign['where']['channel_id'] = 2;
        $campaign_fb = $this->campaign_model->load_all($input_campaign);
        $campaign_fb_list = array();
        foreach ($campaign_fb as $value) {
            $campaign_fb_list[] = $value['id'];
        }
		
		//echo '<pre>';print_r($campaign_fb_list); die;

        //campaign GA
        $input_campaign['where']['channel_id'] = 3;
        $campaign_ga = $this->campaign_model->load_all($input_campaign);
        $campaign_ga_list = array();
        foreach ($campaign_ga as $value) {
            $campaign_ga_list[] = $value['id'];
        }

		//echo '<pre>'; print_r($course_id_list);die;

        $perday = array();
        $total_spend = 0;

        $total_l1 = 0;
        $total_l6 = 0;
        $total_doanh_thu_du_kien = 0;
        $total_revenue = 0;
        $date_luy_ke = 0;
        foreach ($dateArray as $d_key => $d_value) {
            $date_luy_ke++;
            // lấy chi fb
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $d_value;
            $input['where']['time <='] = $d_value + 24 * 3600 - 1;
            $input['where_in']['campaign_id'] = $campaign_fb_list;
            $spend_fb1 = $this->campaign_cost_model->load_all($input);
			//$spend_fb1 = $this->campaign_spend_model->load_all($input);
            $spend_fb = (empty($spend_fb1)) ? 0 : (int) $spend_fb1[0]['spend'];

            //lấy chi ga
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $d_value;
            $input['where']['time <='] = $d_value + 24 * 3600 - 1;
            $input['where_in']['campaign_id'] = $campaign_ga_list;
            $spend_ga1 = $this->Cost_GA_campaign_model->load_all($input);
            $spend_ga = (empty($spend_ga1)) ? 0 : (int) $spend_ga1[0]['spend'];

            //lấy chi email
            $input = array();
            $input['select'] = 'spend';
            $input['where']['time >='] = $d_value;
            $input['where']['time <='] = $d_value + 24 * 3600 - 1;
            $spend_em1 = $this->cost_warehouse_model->load_all($input);
            $spend_em = (empty($spend_em1)) ? 0 : (int) $spend_em1[0]['spend'];

            //Tổng chi marketing
            $sum_perday_spend = $spend_fb + $spend_ga + $spend_em;

            //Lấy số L1
            $input = array();
            $input['select'] = 'id';
            $input['where']['date_rgt >'] = $d_value;
            $input['where']['date_rgt <'] = $d_value + 24 * 3600;
            $input['where']['duplicate_id'] = '';
            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }
            if (isset($get['filter_marketer_id'])) {
                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }
			if (isset($get['filter_brand_id'])) {
				$input['where_in'] = array('brand_id'=> $get['filter_brand_id']);
			}
            $l1 = count($this->contacts_model->load_all($input));
            $total_l1 += $l1;
            //Lấy số L6
            $input = array();
            $input['select'] = 'id';
            $input['where']['date_confirm >'] = $d_value;
            $input['where']['date_confirm <'] = $d_value + 24 * 3600;
            $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }
            if (isset($get['filter_marketer_id'])) {
                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }
			if (isset($get['filter_brand_id'])) {
				$input['where_in'] = array('brand_id'=> $get['filter_brand_id']);
			}
            $l6 = count($this->contacts_model->load_all($input));
            $total_l6 += $l6;

            //Lấy số L8
            $input = array();
            $input['select'] = 'id,price_purchase';
            $input['where']['date_receive_lakita >'] = $d_value;
            $input['where']['date_receive_lakita <'] = $d_value + 24 * 3600;
            $input['where']['ordering_status_id'] = _DONG_Y_MUA_;
            $input['where']['cod_status_id'] = _DA_THU_LAKITA_;
            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }
            if (isset($get['filter_marketer_id'])) {
                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }
			if (isset($get['filter_brand_id'])) {
				$input['where_in'] = array('brand_id'=> $get['filter_brand_id']);
			}
            $l8 = $this->contacts_model->load_all($input);
            $total_revenue += sum_L8($l8);
            
            $perday[$d_key]['fb'] = $spend_fb;
            $perday[$d_key]['ga'] = $spend_ga;
            $perday[$d_key]['em'] = $spend_em;
            $perday[$d_key]['sum_perday_spend'] = $sum_perday_spend;
            $total_spend += $sum_perday_spend;
            $perday[$d_key]['spend_luy_ke_trung_binh'] = round($total_spend/$date_luy_ke);
            
            $perday[$d_key]['l1'] = $l1;
            $perday[$d_key]['l1_luy_ke_trung_binh'] = round($total_l1/$date_luy_ke);
            
            $perday[$d_key]['price_l1'] = ($l1 == 0) ? 0 : round($sum_perday_spend / $l1);
            $perday[$d_key]['price_l1_luy_ke_trung_binh'] = ($total_l1 == 0) ? 0 : round($total_spend / $total_l1);
            
            $perday[$d_key]['l6'] = $l6;
            
            $Ma_Re = ($l6 == 0) ? '0' : round($sum_perday_spend / ($l6 * 90 / 100 * 350000), 4) * 100;
            $Ma_Re_luy_ke_trung_binh = ($total_l6 == 0) ? '0' : round($total_spend / ($total_l6 * 90 / 100 * 350000), 4) * 100;
            
            $perday[$d_key]['Ma_Re'] = ($Ma_Re > 100) ? 100 : $Ma_Re;
            $perday[$d_key]['Ma_Re_luy_ke_trung_binh'] = ($Ma_Re_luy_ke_trung_binh > 100) ? 100 : $Ma_Re_luy_ke_trung_binh;
            $perday[$d_key]['doanh_thu_du_kien'] = $l6 * 90 / 100 * 350000;

        }

        //tính doanh thu dự kiến
        //công thức : doanh thu dự kiến = tổng L6 * (L8/L6) * arpu
        // L8/L6: thường đạt: tính thường là 90%
        // arpu: doanh thu trung bình trên từng khách hàng: tính tay ra khoảng 350k

        $total = array();

        $total['total_l1'] = $total_l1;
        $total['total_l6'] = $total_l6;
        $total['total_spend'] = $total_spend;
        $total['total_price_L1'] = ($total_l1 == 0) ? 0 : round($total_spend / $total_l1);
        $total['duanh_thu_du_kien'] = $total_l6 * 90 / 100 * 350000;
        $total['revenue'] = $total_revenue;

        $this->load->model('staffs_model');
        $data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1)));
        $this->load->model('Channel_model');
        $data['channel'] = $this->Channel_model->load_all(array('where' => array('active' => 1)));
		$this->load->model('brand_model');
        $data['brand'] = $this->brand_model->load_all(array('where' => array('active' => 1)));
      //  $data['left_col'] = array('date_happen_1', 'marketer');
     //   $data['right_col'] = array('channel');
		$data['left_col'] = array('date_happen_1', 'marketer', 'brand');
        $data['right_col'] = array('channel');
        $data['total'] = $total;
        $data['startDate'] = isset($startDate) ? $startDate : '0';
        $data['endDate'] = isset($endDate) ? $endDate : '0';
        $data['per_day'] = $perday;
        $data['slide_menu'] = 'manager/common/menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['content'] = 'marketing/report_operation/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

   
	function view_report_operation2() {

		$this->load->model('Cost_warehouse_model');
        $this->load->helper('manager_helper');

        $this->load->helper('common_helper');

        $this->load->model('campaign_cost_model');

        $this->load->model('account_fb_model');

        $this->load->model('campaign_model');
        $this->load->model('c2_model');

        $get = $this->input->get();

        $data = '';

        if ((!isset($get['filter_date_happen_from']) && !isset($get['filter_date_happen_end'])) || (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] == '' && $get['filter_date_happen_end'] == '')) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $startDate = strtotime(date('1-m-Y'));

            $endDate = strtotime(date('d-m-Y'));
        } else {

            $startDate = strtotime($get['filter_date_happen_from']);

            $endDate = strtotime($get['filter_date_happen_end']);
        }

        $input_campaign = array();

        if (isset($get['filter_channel_id'])) {
            $input_campaign['where_in'] = array(
                'channel_id' => $get['filter_channel_id']
            );

            $data['channel_id'] = $get['filter_channel_id'];
        }



        $dateArray = h_get_time_range($startDate, $endDate);


        $Report = array();



        $account = $this->account_fb_model->getAccountArr();

        if (isset($get['filter_marketer_id'])) {

            $input_campaign['where_in']['marketer_id'] = $get['filter_marketer_id'];
        }

        $campaign = $this->campaign_model->load_all($input_campaign);



        foreach ($dateArray as $d_key => $d_value) {

            $perday = array();

            $each_spend = array(
                'fb' => 0,
                'ga' => 0,
                'em' => 0
            );

            $spend = '';

            $c1 = '';

            $c2 = '';

            $c3 = '';


            foreach ($campaign as $value) {

                $input = array();

                $input['where'] = array(
                    'campaign_id' => $value['id'],
                    'time >=' => $d_value,
                    'time <=' => $d_value + 24 * 3600 - 1,
                    'spend >' => '0'
                );

                // Facebook thì dựa trên Campaign_cost cập nhật hằng ngày
                // GA dựa trên dữ liệu trong Cost_GA_campaign nhập thủ công hằng ngày
                // Email getreponse dự trên dữ liệu nhập phí kho email hàng tháng
                // Social chưa giải quyết
                // lakita.vn chưa giải quyết
                // Nếu là facebook
                if ($value['channel_id'] == 2) {

                    $campaign_cost = $this->campaign_cost_model->load_all($input);
					//locnt fix lay tien` tu` campaign sang lay tien tu` channel
					//$this->load->model('channel_cost_model');
                    //$input['select'] = 'id,spend';
                    //$input['where']['channel'] = 2;
                    //$input['where']['time >='] = $d_value;
                    //$input['where']['time <='] = $d_value + 24 * 3600 - 1;
                    //$campaign_cost = $this->channel_cost_model->load_all($input);
					//het fix
					
                    if (!empty($campaign_cost)) {
                        $campaign_cost = h_caculate_channel_cost($campaign_cost);

                        $c1 += $campaign_cost['total_C1'];

//                        $c2 += $campaign_cost['total_C2'];

                        $spend += $campaign_cost['spend'];

                        $each_spend['fb'] += $campaign_cost['spend'];
                    }
                }

                // Nếu là Email getreponse
                if ($value['channel_id'] == 5) {
                    if ($value['warehouse_id'] != 0) {
						
						$campaign_cost = $this->Cost_warehouse_model->load_all($input);
						//locnt fix lay tien` tu` campaign sang lay tien tu` channel
						//$this->load->model('channel_cost_model');
						//$input['select'] = 'id,spend';
						//$input['where']['channel'] = 2;
						//$input['where']['time >='] = $d_value;
						//$input['where']['time <='] = $d_value + 24 * 3600 - 1;
						//$campaign_cost = $this->channel_cost_model->load_all($input);
						//het fix
						
						if (!empty($campaign_cost)) {
							$campaign_cost = h_caculate_channel_cost($campaign_cost);

						//	$c1 += $campaign_cost['total_C1'];

	//                        $c2 += $campaign_cost['total_C2'];

							$spend += $campaign_cost['spend'];

							$each_spend['em'] += $campaign_cost['spend'];
						}else{
							$spend += 0;

							$each_spend['em'] += 0;
						}
                    }
                }

                // Nếu là Google Adword
                if ($value['channel_id'] == 3) {
					$campaign_cost = $this->Cost_GA_campaign_model->load_all($input);
						//locnt fix lay tien` tu` campaign sang lay tien tu` channel
						//$this->load->model('channel_cost_model');
						//$input['select'] = 'id,spend';
						//$input['where']['channel'] = 2;
						//$input['where']['time >='] = $d_value;
						//$input['where']['time <='] = $d_value + 24 * 3600 - 1;
						//$campaign_cost = $this->channel_cost_model->load_all($input);
						//het fix
						
						if (!empty($campaign_cost)) {
							$campaign_cost = h_caculate_channel_cost($campaign_cost);

						//	$c1 += $campaign_cost['total_C1'];

	//                        $c2 += $campaign_cost['total_C2'];

							$spend += $campaign_cost['spend'];

							$each_spend['ga'] += $campaign_cost['spend'];
						}else{
							$spend += 0;

							$each_spend['ga'] += 0;
						}
                    
                }
            }



            //get c2
            $input = [];

            $input['select'] = 'id';

            $input['where'] = array('date_rgt >' => $d_value, 'date_rgt <' => $d_value + 24 * 3600);

            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }

            if (isset($get['filter_marketer_id'])) {

                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }

            $c2 = count($this->c2_model->load_all($input));

            // Get C3
            $input = [];

            $input['select'] = 'id';

            $input['where'] = array('date_rgt >' => $d_value, 'date_rgt <' => $d_value + 24 * 3600);

            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }

            if (isset($get['filter_marketer_id'])) {

                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }

            $c3 = count($this->contacts_model->load_all($input));


            $input = [];

            $input['select'] = 'id';

            $input['where'] = array('date_rgt >' => $d_value, 'date_rgt <' => $d_value + 24 * 3600, 'duplicate_id' => '');

            if (isset($get['filter_channel_id'])) {
                $input['where_in'] = array(
                    'channel_id' => $get['filter_channel_id']
                );
            }

            if (isset($get['filter_marketer_id'])) {

                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }

            $l1 = count($this->contacts_model->load_all($input));


            $perday['c1'] = $c1;

            $perday['c2'] = $c2;

            $perday['c3'] = $c3;

            $perday['spend'] = $spend;

            $perday['each_spend'] = $each_spend;

            // $perday['c2/c1'] = ($c1 == '0' || $c1 == '') ? '0' : round($c2 / $c1, 3) * 100;
            $perday['c2/c1'] = 'N/A';

            $perday['c3/c2'] = ($c2 == '0' || $c2 == '' ) ? '0' : round($c3 / $c2, 3) * 100;

            $perday['priceC3'] = ($c3 != '0') ? round($spend / $c3) : '0';

            $perday['l1'] = $l1;

            $arr_per_day[(string) $d_key] = $perday;
        }


        $total['total_C1'] = '';

        $total['total_C2'] = '';

        $total['total_C3'] = '';

        $total['total_Spend'] = '';


        foreach ($arr_per_day as $key => $value) {

            $total['total_C1'] += $value['c1'];

            $total['total_C2'] += $value['c2'];

            $total['total_C3'] += $value['c3'];

            $total['total_Spend'] += $value['spend'];
        }

        $total['total_Spend'] = round($total['total_Spend']);

        $total['total_C3/C2'] = ($total['total_C2'] != '0') ? round($total['total_C3'] / $total['total_C2'], 4) * 100 . '%' : 'N/A';

        // $total['total_C2/C1'] = ($total['total_C1'] != '0') ? round($total['total_C2'] / $total['total_C1'], 2) * 100 . '%' : 'N/A';

        $total['total_C2/C1'] = 'N/A';

        $total['total_price_C3'] = ($total['total_C3'] != '0') ? round($total['total_Spend'] / $total['total_C3']) : 0;



        $this->load->model('staffs_model');

        $data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1)));

        $this->load->model('Channel_model');

        $data['channel'] = $this->Channel_model->load_all(array('where' => array('active' => 1)));

        $data['left_col'] = array('date_happen', 'marketer');

        $data['right_col'] = array('channel');

        $data['total'] = $total;

        $data['startDate'] = isset($startDate) ? $startDate : '0';

        $data['endDate'] = isset($endDate) ? $endDate : '0';

        $data['per_day'] = $arr_per_day;

        $data['slide_menu'] = 'manager/common/menu';

        $data['top_nav'] = 'manager/common/top-nav';

        $data['content'] = 'marketing/report_operation/index';

        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function view_report_courses() {
        $this->load->helper('manager_helper');
        $this->load->helper('common_helper');
        $this->load->model('contacts_model');

        $get = $this->input->get();


        $data = '';

        $courses = file_get_contents(APPPATH . '../public/json/course.json');
        $courses = json_decode($courses, TRUE);
        $courses = $courses['course'];

        foreach ($courses as $key => $value) {
            if ($value['active'] == 0) {
                unset($courses[$key]);
            }
        }

        if ((isset($get['filter_course_code']) && isset($get['filter_course_code']))) {
            foreach ($courses as $key => $value) {
                if (!in_array($value['course_code'], $get['filter_course_code'])) {
                    unset($courses[$key]);
                }
            }
        }

        if ((!isset($get['filter_date_happen_from']) && !isset($get['filter_date_happen_end'])) || (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] == '' && $get['filter_date_happen_end'] == '')) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $startDate = strtotime(date('1-m-Y'));
            $endDate = strtotime(date('d-m-Y'));
        } else {
            $startDate = strtotime($get['filter_date_happen_from']);
            $endDate = strtotime($get['filter_date_happen_end']);
        }
        $dateArray = h_get_time_range($startDate, $endDate);

        $Report = array();

        $input = array();

        $input['where']['is_hide'] = '0';
        $input['where']['cod_status_id >'] = 1;
        $input['where']['cod_status_id <'] = 4;
        foreach ($courses as $c_key => $c_value) {
            $input['where']['course_code'] = $c_value['course_code'];

            foreach ($dateArray as $d_key => $d_value) {
                $input['where']['date_rgt >='] = $d_value;
                $input['where']['date_rgt <='] = $d_value + 86400 - 1;
                $Report[$c_value['course_code']][$d_key] = $this->contacts_model->m_count_all_result_from_get($input);
            }
        }
//        foreach ($dateArray as $d_key => $d_value) {
//            $input = array();
//            $input['where']['date_rgt >='] = $d_value;
//            $input['where']['date_rgt <='] = $d_value + 86400 - 1;
//            $input['where']['is_hide'] = '0';
//            $input['where']['cod_status_id >'] = 1;
//            $input['where']['cod_status_id <'] = 4;
//            foreach ($courses as $c_key => $c_value) {
//                $input['where']['course_code'] = $c_value['course_code'];
//                $Report[$c_value['course_code']][$c_value['course_code']] = $this->contacts_model->m_count_all_result_from_get($input);
//            }
//        }
//        echo '<pre>';
//        print_r($Report);
//        die;
        $data['courses'] = $courses;
        $data['left_col'] = array('date_happen', 'course_code');
        $data['date'] = $dateArray;
        $data['Report'] = $Report;
        $data['startDate'] = isset($startDate) ? $startDate : '0';
        $data['endDate'] = isset($endDate) ? $endDate : '0';
        $data['content'] = 'marketing/view_report_courses';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
	
	public function view_report_quality_contact() {
		//echo $this->role_id;die;
        $this->load->model('courses_model');
        $this->load->model('campaign_cost_model');
        $this->load->model('campaign_spend_model');
        $this->load->model('cost_warehouse_model');
        $this->load->model('Cost_GA_campaign_model');
        $this->load->model('campaign_model');
        $get = $this->input->get();
        $data = '';
		
        $input = array();
        $input['select'] = 'course_code';
        $input['where']['active'] = 1;
        $input['order'] = array('course_code' => 'asc');
        $course = $this->courses_model->load_all($input);

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
                'RE' => array(
                	'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'cod_status_id' => _DA_THU_LAKITA_),
                    'time' => 'filter_date_date_rgt'
                )
            );
        } else {
            $typeReport = array(
                'C3' => array(
                    'where' => array(),
                    'time' => 'filter_date_date_rgt'
                ),
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
                'RE' => array(
                	'where' => array('is_hide' => '0', 'ordering_status_id' => _DONG_Y_MUA_, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'cod_status_id' => _DA_THU_LAKITA_),
                    'time' => 'filter_date_date_receive_lakita'
                )
            );
        }

		//echo '(`brand_id` in (' . $brand .'))';die;
		//echo '<pre>'; print_r($course); die;
		
		$conditionnal_2 = array();
		
		if (isset($get['filter_brand_id']) && $get['filter_brand_id'] != '') {
			$brand = $get['filter_brand_id'][0];
			if ($brand == 1) {
				$ty_le_brand = 88/100;
			} else if ($brand == 2) {
				$ty_le_brand = 75/100;
			}
			
			$conditionnal_2['where'] = array('brand_id' => $brand);
		} else {
			$ty_le_brand = 82/100;
		}
		
		if (isset($get['filter_channel_id'])) {
			foreach ($get['filter_channel_id'] as $key => $value) {
                $channel[] = $value;
            }
			$conditionnal_2['where_in'] = array('channel_id' => $channel);
		}
		
		if (isset($get['filter_brand_id']) && isset($get['filter_channel_id'])) {
			$conditionnal_2['where']['brand_id'] = $brand;
			$conditionnal_2['where_in']['channel_id'] = $channel;
		}
		
		//echo $ty_le_brand;die;
		//echo '<pre>'; print_r($conditionnal_2); die;

        $Report = array();

        foreach ($course as $k_course => $v_course) {
            foreach ($typeReport as $report_type => $value) {
                $typeTime = array($value['time'] => $time);
              
                if ($this->role_id == 6) {
                    $condition = array('where' => array_merge($value['where'], array('course_code' => $v_course['course_code'], 'marketer_id' => $this->user_id)));
                } else {
                    if (isset($get['filter_marketer_id']) && $get['filter_marketer_id'] != '') {
                        $condition = array('where' => array_merge($value['where'], array('course_code' => $v_course['course_code'])));
                        $fillter_marketer_id['where_in']['marketer_id'] = $get['filter_marketer_id'];
                        $condition = array_merge($condition, $fillter_marketer_id);
                        // echo '<pre>'; print_r($condition); die;
                    } else {
                        $condition = array('where' => array_merge($value['where'], array('course_code' => $v_course['course_code'])));
                    }
                }
				$condition = array_merge_recursive($condition, $conditionnal_2);
				 //echo '<pre>'; print_r($condition); die;
                $Report[$v_course['course_code']][$report_type] = $this->_query_for_report($typeTime, $condition);
                $Report[$v_course['course_code']]['RE'] = $this->_query_for_report_re($typeTime, $condition);
                // $Report[$v_course['course_code']]['RE'] = str_replace(',', '.', number_format($this->_query_for_report_re($typeTime, $condition)));
                                
            }

            if ($Report[$v_course['course_code']]['C3'] == 0 && $Report[$v_course['course_code']]['L1'] == 0 && $Report[$v_course['course_code']]['L6'] == 0 && $Report[$v_course['course_code']]['L8'] == 0) {
                unset($Report[$v_course['course_code']]);
            }

        }

		// echo '<pre>'; print_r($Report); die;

        //lấy chi email, tính tổng chi rồi chia đều cho các khóa có ra contact
        $input = array();
        $input['select'] = 'SUM(spend) as spend';
        $input['where']['time >='] = $date_from;
        $input['where']['time <='] = $date_end;
        $em = $this->cost_warehouse_model->load_all($input);
        $spend_em = (empty($em)) ? 0 : (int) $em[0]['spend'];
        $spend_em_per_course = round($spend_em / count($Report));
		//echo ($spend_em) .'-'. $spend_em_per_course;die;

        $total_C3 = 0;
        $total_L1 = 0;
        $total_L2 = 0;
        $total_L6 = 0;
        $total_L8 = 0;
        $total_spend = 0;

        foreach ($Report as $key => $value) {
            $input_campaign = array();
            $input_campaign['select'] = 'id';
            $input_campaign['where']['course_id'] = $this->courses_model->find_id_by_course_code($key);

            if (isset($get['filter_marketer_id'])) {
                $input_campaign['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }

            if ($this->role_id == 6) {
                $input_campaign['where']['marketer_id'] = $this->user_id;
            }

            //campaign FB
            $input_campaign['where']['channel_id'] = 2;
            $campaign_fb = $this->campaign_model->load_all($input_campaign);
            $campaign_fb_list = array();
            foreach ($campaign_fb as $value) {
                $campaign_fb_list[] = $value['id'];
            }
			
			//echo '<pre>'; print_r($input_campaign); die;
            //campaign GA
            $input_campaign['where']['channel_id'] = 3;
            $campaign_ga = $this->campaign_model->load_all($input_campaign);
            $campaign_ga_list = array();
            foreach ($campaign_ga as $value) {
                $campaign_ga_list[] = $value['id'];
            }
			//echo '<pre>'; print_r($input_campaign); die;

            // lấy chi fb
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $date_from;
            $input['where']['time <='] = $date_end;
            $input['where_in']['campaign_id'] = $campaign_fb_list;
            if (empty($campaign_fb_list)) {
                $spend_fb = 0;
            } else {
                // $spend_fb = (int) $this->campaign_cost_model->load_all($input)[0]['spend'];
                $spend_fb = (int) $this->campaign_spend_model->load_all($input)[0]['spend'];
            }
			// echo '<pre>'; print_r($spend_fb); die;

            //lấy chi ga
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $date_from;
            $input['where']['time <='] = $date_end;
            $input['where_in']['campaign_id'] = $campaign_ga_list;
            if (empty($campaign_ga_list)) {
                $spend_ga = 0;
            } else {
                $spend_ga = (int) $this->Cost_GA_campaign_model->load_all($input)[0]['spend'];
            }

			//echo $price_course;die;
			$price_course = 370000;
            //Tổng chi marketing
			if (($this->user_id == 66) || ($this->role_id == 5) || ($get['filter_marketer_id'][0] == 66)) {
				$sum_spend = $spend_fb + $spend_ga + $spend_em_per_course;
			} else {
				$sum_spend = $spend_fb + $spend_ga;
			}

			$Report[$key]['Gia_L8'] = ($Report[$key]['L8'] == 0) ? '0' : str_replace(',', '.', number_format(round($sum_spend / $Report[$key]['L8'])));
            $Report[$key]['Ma_Re_du_kien'] = ($Report[$key]['L6'] == 0) ? '0' : round($sum_spend / ($Report[$key]['L6'] * $ty_le_brand * $price_course), 4) * 100;
            $Report[$key]['Ma_Re_thuc_te'] = ($Report[$key]['L8'] == 0) ? '0' : round($sum_spend / ($Report[$key]['RE']), 4) * 100;
            $Report[$key]['Re_du_kien'] = str_replace(',', '.', number_format(($Report[$key]['L6'] * $price_course) * $ty_le_brand));
            // $Report[$key]['Re_thuc_te'] = str_replace(',', '.', number_format($Report[$key]['L8'] * $price_course));
            $Report[$key]['Re_thuc_te'] = str_replace(',', '.', number_format($Report[$key]['RE']));
			$Report[$key]['Ma_mkt'] = str_replace(',', '.', number_format($sum_spend));

            $total_C3 += $Report[$key]['C3'];
            $total_L1 += $Report[$key]['L1'];
            $total_L2 += $Report[$key]['L2'];
            $total_L6 += $Report[$key]['L6'];
            $total_L8 += $Report[$key]['L8'];
            $total_RE += $Report[$key]['RE'];
            $total_spend += $sum_spend;

			$Report[$key]['L1/C3'] = ($Report[$key]['C3'] == 0) ? '0' : round($Report[$key]['L1'] / $Report[$key]['C3'], 4) * 100;
			$Report[$key]['L2/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L2'] / $Report[$key]['L1'], 4) * 100;
			$Report[$key]['L6/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L6'] / $Report[$key]['L1'], 4) * 100;
			$Report[$key]['L6/L2'] = ($Report[$key]['L2'] == 0) ? '0' : round($Report[$key]['L6'] / $Report[$key]['L2'], 4) * 100;
			$Report[$key]['L8/L6'] = ($Report[$key]['L6'] == 0) ? '0' : round($Report[$key]['L8'] / $Report[$key]['L6'], 4) * 100;
			$Report[$key]['L8/L1'] = ($Report[$key]['L1'] == 0) ? '0' : round($Report[$key]['L8'] / $Report[$key]['L1'], 4) * 100;
            // $Report[$key]['tong'] = $total_L1.'-'.$total_L2.'-'.$total_L6.'-'.$total_L8;

			$Report[$key]['course_code'] = $key;
        }

        $Report['Tổng'] = array(
            'C3' => $total_C3,
            'L1' => $total_L1,
            'L2' => $total_L2,
            'L6' => $total_L6,
            'L8' => $total_L8,
            // 'RE' => str_replace(',', '.', number_format($total_RE)),
			'Gia_L8' => str_replace(',', '.', number_format(round($total_spend / $total_L8))),
			'L1/C3' => round(($total_L1 / $total_C3), 4) * 100,
			'L2/L1' => round(($total_L2 / $total_L1), 4) * 100,
			'L6/L1' => round(($total_L6 / $total_L1), 4) * 100,
			'L6/L2' => round(($total_L6 / $total_L2), 4) * 100,
			'L8/L6' => round(($total_L8 / $total_L6), 4) * 100,
			'L8/L1' => round(($total_L8 / $total_L1), 4) * 100,
			'Ma_mkt' => str_replace(',', '.', number_format($total_spend)),
            'Ma_Re_du_kien' => ($total_L6 == 0) ? '0' : round($total_spend / ($total_L6 * $ty_le_brand * 395000), 4) * 100,
            'Ma_Re_thuc_te' => ($total_L6 == 0) ? '0' : round($total_spend / $total_RE, 4) * 100,
            // 'Ma_Re_thuc_te' => str_replace(',', '.', number_format($total_RE)),
			'Re_du_kien' => str_replace(',', '.', number_format($total_L6 * 395000 * $ty_le_brand)),
			'Re_thuc_te' => str_replace(',', '.', number_format($total_RE)),
			'course_code' => 'Tổng'
        );

		usort($Report, function($a, $b) {
			return $b['L1'] - $a['L1'];
		});

		// echo '<pre>'; print_r($Report); die;

		$this->load->model('brand_model');
		$data['brand'] = $this->brand_model->load_all(array('where' => array('active' => 1)));

		$this->load->model('channel_model');
		$data['channel'] = $this->channel_model->load_all(array('where' => array('active' => 1)));
		
        $this->load->model('staffs_model');
        $data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1), 'order' => array('name' => 'asc')));

        $data['report'] = $Report;
        $data['startDate'] = isset($date_from) ? $date_from : '0';
        $data['endDate'] = isset($date_end) ? $date_end : '0';

        if ($this->role_id == 6) {
            $data['left_col'] = array('date_happen_1', 'tic_report', 'brand');
			$data['right_col'] = array('channel');
        } else {
            $data['left_col'] = array('date_happen_1', 'marketer', 'tic_report');
			$data['right_col'] = array('brand', 'channel');
        }

        $data['content'] = 'marketing/view_report_quality_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
        
    }
	

	public function view_report_com_marketer(){
        $this->load->model('contacts_model');
        $this->load->model('staffs_model');
        $this->load->model('lever_marketer_model');
        $this->load->model('percent_com_marketer_model');
        
        $this->load->model('channel_model');
        $this->load->model('campaign_model');
        $this->load->model('campaign_cost_model');
        $this->load->model('cost_warehouse_model');
        $this->load->model('Cost_GA_campaign_model');
        
        $this->load->helper('manager_helper');
        
        if (isset($get['filter_date_date_happen']) && $get['filter_date_date_happen'] != '') {
            $time = $get['filter_date_date_happen'];
        } else {
            $time = '01' . '/' . date('m') . '/' . date('Y') . ' - ' . date('d') . '/' . date('m') . '/' . date('Y');
        }
        $dateArr = explode('-', $time);
        $startDate = trim($dateArr[0]);
        $startDate = strtotime(str_replace("/", "-", $startDate));
        $endDate = trim($dateArr[1]);
        $endDate = strtotime(str_replace("/", "-", $endDate)) + 3600 * 24;
        
        echo $startDate .' - '.$endDate;
        
        /*
         * - Lấy chi từng marketer
         * - Lấy thu từng marketer
         * - Tính PL1A ( lãi ) = thu - chi
         * - Tính % Me/Re = chi/thu
         * - Tính % com
         * - Com thực nhận = PL1A * %com
         */

        $input = array();
        $input['select'] = 'id,name,lever';
        $input['where']['role_id'] = 6;
        $input['where']['active'] = 1;
        $marketer = $this->staffs_model->load_all($input);
        
        foreach($marketer as $m_key => $m_value){
            //lấy thu
            //chia làm 3 loại : social, email, và khác
            $input = array();
            $input['select'] = 'sum(price_purchase) as revenue';
            $input['where']['date_rgt >='] = $startDate;
            $input['where']['date_rgt <='] = $endDate;
            $input['where']['channel_id'] = 5; //email
            $input['where']['marketer_id'] = $m_value['id'];
            $input['where_in']['cod_status_id'] = array(_DA_THU_COD_,_DA_THU_LAKITA_);
            $marketer[$m_key]['revenue_by_channel']['email'] = $this->contacts_model->load_all($input)[0]['revenue'];
            
            $input = array();
            $input['select'] = 'sum(price_purchase) as revenue';
            $input['where']['date_rgt >='] = $startDate;
            $input['where']['date_rgt <='] = $endDate;
            $input['where']['channel_id'] = 8; //social
            $input['where']['marketer_id'] = $m_value['id'];
            $input['where_in']['cod_status_id'] = array(_DA_THU_COD_,_DA_THU_LAKITA_);
            $marketer[$m_key]['revenue_by_channel']['social'] = $this->contacts_model->load_all($input)[0]['revenue'];
            
            $input = array();
            $input['select'] = 'sum(price_purchase) as revenue';
            $input['where']['date_rgt >='] = $startDate;
            $input['where']['date_rgt <='] = $endDate;
            $input['where']['channel_id'] = 2; //fb
            $input['where']['marketer_id'] = $m_value['id'];
            $input['where_in']['cod_status_id'] = array(_DA_THU_COD_,_DA_THU_LAKITA_);
            $marketer[$m_key]['revenue_by_channel']['fb'] = $this->contacts_model->load_all($input)[0]['revenue'];
            
            $input = array();
            $input['select'] = 'sum(price_purchase) as revenue';
            $input['where']['date_rgt >='] = $startDate;
            $input['where']['date_rgt <='] = $endDate;
            $input['where']['channel_id'] = 3; //ga
            $input['where']['marketer_id'] = $m_value['id'];
            $input['where_in']['cod_status_id'] = array(_DA_THU_COD_,_DA_THU_LAKITA_);
            $marketer[$m_key]['revenue_by_channel']['ga'] = $this->contacts_model->load_all($input)[0]['revenue'];
            
            $input = array();
            $input['select'] = 'sum(price_purchase) as revenue';
            $input['where']['date_rgt >='] = $startDate;
            $input['where']['date_rgt <='] = $endDate;
            $input['where_not_in']['channel_id'] = array(8,5,2,3); //khác
            $input['where']['marketer_id'] = $m_value['id'];
            $input['where_in']['cod_status_id'] = array(_DA_THU_COD_,_DA_THU_LAKITA_);
            $marketer[$m_key]['revenue_by_channel']['khac'] = $this->contacts_model->load_all($input)[0]['revenue'];
            
            
            //lấy chi email
            
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $startDate;
            $input['where']['time <='] = $endDate - 1;
            $spend_em1 = $this->cost_warehouse_model->load_all($input);
            $spend_em = (empty($spend_em1))?0: (int) $spend_em1[0]['spend'];
            $marketer[$m_key]['spend_by_channel']['email'] = $spend_em;
            $marketer[$m_key]['spend_by_channel']['social'] = '0';
            
            
            //lấy chi 
            //campaign FB
            $input_campaign['where']['channel_id'] = 2;
            $input_campaign['where']['marketer_id'] = $m_value['id'];
            $campaign_fb = $this->campaign_model->load_all($input_campaign);
            $campaign_fb_list = array();
            foreach ($campaign_fb as $value) {
                $campaign_fb_list[] = $value['id'];
            }
            $spend_fb = 0;
            if(!empty($campaign_fb_list)){
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $startDate;
            $input['where']['time <='] = $endDate - 1;
            $input['where_in']['campaign_id'] = $campaign_fb_list;
            $spend_fb1 = $this->campaign_cost_model->load_all($input);
            $spend_fb = (empty($spend_fb1))?0: (int) $spend_fb1[0]['spend'];
            }
            //campaign GA
            $input_campaign['where']['channel_id'] = 3;
            $input_campaign['where']['marketer_id'] = $m_value['id'];
            $campaign_ga = $this->campaign_model->load_all($input_campaign);
            $campaign_ga_list = array();
            foreach ($campaign_ga as $value) {
                $campaign_ga_list[] = $value['id'];
            }
            $spend_ga = 0;
            if(!empty($campaign_ga_list)){
            $input = array();
            $input['select'] = 'SUM(spend) as spend';
            $input['where']['time >='] = $startDate;
            $input['where']['time <='] = $endDate - 1;
            $input['where_in']['campaign_id'] = $campaign_ga_list;
            $spend_ga1 = $this->Cost_GA_campaign_model->load_all($input);
            $spend_ga = (empty($spend_ga1)) ? 0 : (int) $spend_ga1[0]['spend'];
            }
            $marketer[$m_key]['spend_by_channel']['fb'] = $spend_fb;
            $marketer[$m_key]['spend_by_channel']['ga'] = $spend_ga;
            
        }
        
        //tính PL1A = thu - chi
        
		foreach ($marketer as $m_key => $m_value){
		    foreach ($marketer[$m_key]['spend_by_channel'] as $key => $value){
		        $marketer[$m_key]['PL1A_by_channel'][$key] = (int)$marketer[$m_key]['revenue_by_channel'][$key] - (int)$value;
		    }
		}
		 
		//tính ma/re
		foreach ($marketer as $m_key => $m_value){
		    foreach ($m_value['spend_by_channel'] as $key => $value){
		        $marketer[$m_key]['MARE_by_channel'][$key] = (int)$value/(((int)$m_value['revenue_by_channel'][$key] == 0)?'1':(int)$m_value['revenue_by_channel'][$key]);
		    }
		}

		//%com
		foreach ($marketer as $m_key => $m_value){
		    if($m_value['lever'] != 0){
		        foreach ($m_value['MARE_by_channel'] as $key => $value){
		            if($marketer[$m_key]['PL1A_by_channel'][$key] != 0){
		            $input = array();
		            $input['where']['lever_marketer'] = $m_value['lever'];
		            $input['where']['revenue_from <='] = $marketer[$m_key]['PL1A_by_channel'][$key];
		            $input['where']['revenue_to >='] = $marketer[$m_key]['PL1A_by_channel'][$key];
		            switch ($key){
		                case 'email':
		                    $input['where']['channel_id'] = 5;
		                    break;
		                case 'social':
		                    $input['where']['channel_id'] = 8;
		                    break;
		                case 'fb':
		                    $input['where']['channel_id'] = 2;
		                    break;
		                case 'ga':
		                    $input['where']['channel_id'] = 3;
		                    break;
		            }
		             $marketer[$m_key]['%com_by_channel'][$key] = $this->percent_com_marketer_model->load_all($input)[0]['percent_com'];
		            }
		        }
		    }
		}


         echo '<pre>';print_r($marketer);
    }
	
	function test() {
      $this->load->model('campaign_model');
      $this->load->model('courses_model');
      $this->load->model('contacts_model');
      $input = array();
      $input['select'] = 'id,course_code';
      $input['where_in']['course_code'] = array('CBSK3002-PC1006','SK3004','KT220-250-1105','CBSK3005','KT1203','CBKT210-400','PC1002-1006','KT7001','CBKT220-250','KT1104');
      $course = $this->courses_model->load_all($input);
      echo '<pre>';
      
      $start_date = 1551373200;
      $end_date = 1554051600;
      
      $typeReport = array(
                'L1' => 'date_rgt',
                'L2' => 'date_rgt',
                'L6' => 'date_confirm',
                'L8' => 'date_receive_lakita',
                'huy_don' => 'date_receive_cancel_cod'
            );
      $Report = array();
      foreach ($course as $c_key => $c_value) {
      foreach ($typeReport as $report_type => $typeDate) {
          $input = array();
                $input['where']['course_code'] = $c_value['course_code'];
                $input['where'][$typeDate . ' >='] = $start_date;
                $input['where'][$typeDate . ' <='] = $end_date;
                if ($report_type == 'L1') {
                    $contact = '';
                    $input['select'] = 'id';
                    $input['where']['duplicate_id'] = '';

                
                    $Report[$c_value['course_code']][$report_type] = count($this->contacts_model->load_all($input));
                }
                if ($report_type == 'L2') {
                    $input['select'] = 'id';
                    $input['where']['duplicate_id'] = '';
                    $input['where']['call_status_id'] = _DA_LIEN_LAC_DUOC_;

                    $Report[$c_value['course_code']][$report_type] = count($this->contacts_model->load_all($input));
                }

                if ($report_type == 'L6') {
                    $input['select'] = 'id';
                    $input['where']['ordering_status_id'] = _DONG_Y_MUA_;

                    $Report[$c_value['course_code']][$report_type] = count($this->contacts_model->load_all($input));
                }
                
                if ($report_type == 'L8') {
                    $input['select'] = 'id';
                    $input['where']['cod_status_id'] = _DA_THU_LAKITA_;

                    $Report[$c_value['course_code']][$report_type] = count($this->contacts_model->load_all($input));
                }
                
                if ($report_type == 'huy_don') {                
                    $input['select'] = 'id';                
                    $input['where']['cod_status_id'] = _HUY_DON_;  
                    
                    $Report[$c_value['course_code']][$report_type] = count($this->contacts_model->load_all($input));
                }
      }
      }
      
      foreach ($Report as $key => $value){
          $Report[$key]['L2/L1'] = round($value['L2']/$value['L1']*100,2);
          $Report[$key]['L6/L2'] = round($value['L6']/$value['L2']*100,2);
          $Report[$key]['huy_don/L6'] = round($value['huy_don']/$value['L6']*100,2);
          $Report[$key]['L8/L1'] = round($value['L8']/$value['L1']*100,2);
      }
      
      
      print_r($Report);
      
      echo '<table>';
      echo '<tr>';
      echo '<td> ten </td><td> L1</td><td> huy_don </td><td> L8</td><td> l2/l1</td><td>l6/l2 </td><td>huydon/l6 </td><td>l8/l1 </td>';
      echo '</tr>';
      
      foreach ($Report as $key => $value){
          echo '<tr><td>'.$key.'</td>'.'<td>'.$value['L1'].'</td>'.'<td>'.$value['huy_don'].'</td>'.'<td>'.$value['L8'].'</td>'.'<td>'.$value['L2/L1'].'</td>'.'<td>'.$value['L6/L2'].'</td>'.'<td>'.$value['huy_don/L6'].'</td>'.'<td>'.$value['L8/L1'].'</td></tr>';
      }
      
      
      echo '</table>';
      
    }
	
	public function test2(){
      $this->load->model('campaign_model');
      $this->load->model('courses_model');
      $this->load->model('contacts_model');
      
      $this->load->model('campaign_cost_model');
        $this->load->model('cost_warehouse_model');
        $this->load->model('Cost_GA_campaign_model');
        
      $input = array();
      $input['select'] = 'id,course_code';
      $input['where_in']['course_code'] = array('CBSK3002-PC1006','SK3004','KT220-250-1105','CBSK3005','KT1203','CBKT210-400','PC1002-1006','KT7001','CBKT220-250','KT1104');
      $course = $this->courses_model->load_all($input);
      echo '<pre>';
      
      $start_date = 1551373200;
      $end_date = 1554051600;
      
	     //lấy những campaign ra số kênh email
      $input = array();
      $input['select'] = 'DISTINCT(campaign_id)';
      $input['where']['channel_id'] = 5;
      $input['where']['date_rgt >='] = $start_date;
      $input['where']['date_rgt <='] = $end_date;
      $cp_email = $this->contacts_model->load_all($input);
      //chi phí cho 1 campaign email trong 1 tháng
      $spend_email = round(8000000/count($cp_email));
	  
      foreach ($course as $key => $value){
          $input = array();
          $input['select'] = 'id,name,campaign_id_facebook,campaign_id_google,channel_id,marketer_id';
          $input['where']['course_id'] = $value['id'];
          $course[$key]['spend'] = 0;
          $campaign = $this->campaign_model->load_all($input);
          foreach($campaign as $key1 => $value1){
              if($value1['campaign_id_facebook'] != ''){
                    $input = array();
                    $input['select'] = 'SUM(spend) as spend';
                    $input['where']['time >='] = $start_date;
                    $input['where']['time <='] = $end_date - 1;
                    $input['where']['campaign_id'] = $value1['id'];
                    $spend_fb1 = $this->campaign_cost_model->load_all($input);
                    $course[$key]['spend'] += (empty($spend_fb1)) ? 0 : (int) $spend_fb1[0]['spend'];
              }
              if($value1['campaign_id_google'] != ''){
                    $input = array();
                    $input['select'] = 'SUM(spend) as spend';
                    $input['where']['time >='] = $start_date;
                    $input['where']['time <='] = $end_date - 1;
                    $input['where_in']['campaign_id'] = $value1['id'];
                    $spend_ga1 = $this->Cost_GA_campaign_model->load_all($input);
                    $course[$key]['spend'] += (empty($spend_ga1)) ? 0 : (int) $spend_ga1[0]['spend'];
                }
				foreach($cp_email as $value2){
					if($value2['campaign_id'] == $value1['id']){
						$course[$key]['spend'] += $spend_email;
					}
				}
          }
      }
      
      print_r($course);
    }
	
	
	public function test3() {
		ini_set('max_execution_time', 3000);
//		echo ini_set('max_execution_time');
        $this->load->model('contacts_model');
        $this->load->model('landingpage_model');
        $this->load->model('courses_model');
		$this->load->model('contacts_backup_model');
        
		echo '<pre>';
        //thang 1/3 : 1551373200
        //1/4 : 1554051600
        // 1/5 : 1556643600
        // 1/6 : 1559322000
        $input = array();
		$input['select'] = 'id,course_code,landingpage_id';
        $input['where']['date_rgt >'] = 1551373200;
        $input['where']['date_rgt <'] = 1559322000;
		$input['where']['landingpage_id !='] = '';
//$input['where']['course_code'] = 'CBSK3002-PC1006';$input['where']['landingpage_id !='] = 248;
        $contact = $this->contacts_model->load_all($input);
		print_r($contact);
		
		
		foreach($contact as $c_key => $c_value){
			//lấy khóa từ landingpage
			/*$input = array();
			$input['where']['id'] = $c_value['landingpage_id'];
			$landingpage = array();
			$landingpage = $this->landingpage_model->load_all($input);
			echo '-------------';
			print_r($landingpage);
			if($landingpage[0]['course_code'] != 0){
				$this->contacts_model->update(array('id'=>$c_value['id']), array('course_code' => $landingpage[0]['course_code']));
			}*/			
			
			$input = array();
			$input['where']['id'] = $c_value['id'];
			$contact_backup = $this->contacts_backup_model->load_all($input);
			$this->contacts_model->update(array('id'=>$c_value['id']), array('course_code' => $contact_backup[0]['course_code']));
			
		}
		
		echo 'xong!!';
    }
	
}
