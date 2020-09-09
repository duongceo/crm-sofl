<?php

//namespace Google\AdsApi\Examples\AdWords\v201809\BasicOperations;
require __DIR__ . '/../../vendor/autoload.php';

//đống này là dùng chung khi gọi đến api google
use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSession;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Google\AdsApi\AdWords\v201809\cm\SortOrder;
use Google\AdsApi\AdWords\v201809\cm\OrderBy;
use Google\AdsApi\AdWords\v201809\cm\Paging;
//đống này để lấy danh sách tài khoản con trong tài khoản ads google chính
use Google\AdsApi\AdWords\v201809\mcm\ManagedCustomer;
use Google\AdsApi\AdWords\v201809\mcm\ManagedCustomerService;
//đống này để lấy thông tin campaign ads google
use Google\AdsApi\AdWords\v201809\cm\CampaignService;
use Google\AdsApi\AdWords\Query\v201809\ServiceQueryBuilder;
//báo cáo googleads
use Google\AdsApi\AdWords\Query\v201809\ReportQueryBuilder;
use Google\AdsApi\AdWords\Reporting\v201809\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDownloader;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use Google\AdsApi\AdWords\v201809\cm\ReportDefinitionReportType;
//đống này để lấy thông tin ads(adgroup google gọi thế)
use Google\AdsApi\AdWords\v201809\cm\AdGroupService;
use Google\AdsApi\AdWords\v201809\cm\Predicate;
use Google\AdsApi\AdWords\v201809\cm\PredicateOperator;

use Google\AdsApi\AdWords\v201809\cm\AdType;

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of Cron

 *

 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>

 */

class Cron extends CI_Controller {

    public function __construct() {

        parent::__construct();

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        ini_set('max_execution_time', 259200);
		//set_time_limit(0);
       /* if (!$this->input->is_cli_request()) {

            die('Bạn không có quyền truy cập vào trang web này');

        } else {

            echo '1';

        }*/

    }


    public function index() {

        echo 'yes';

    }

    // public function reset_check() {
    //     $this->load->model('index_model');
    //     for ($i = 2; $i <= 4; $i++) { 
    //         $where = array('id' => $i);
    //         $data = array('value' => 0);
    //         $this->index_model->update($where, $data);
    //     }
    // }

    public function update_campain_cost($day = '0') {

        if ($day == '0') {

            $day = "-1 days";
        }

        $this->load->model('campaign_cost_model');

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        // echo $today_fb_format .'--'. $today;die();

        /*

         * Lấy danh sách tất cả campain

         */

        $this->load->model('campaign_model');

        $input = array();

        $input['where'] = array('channel_id' => 2, 'campaign_id_facebook !=' => '');

		$input['order']['id'] = 'desc';

		//$input['limit'] = array(1000, 1000);

        $campaigns = $this->campaign_model->load_all($input);
           
		foreach ($campaigns as $value) {

			/*

			 * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)

			 */
			
			if ($value['campaign_id_facebook'] != '') {

				$where = array('campaign_id' => $value['id'], 'time' => $today);

				$this->campaign_cost_model->delete($where);

				$url = 'https://graph.facebook.com/v4.0/' . $value['campaign_id_facebook'] .
						'/insights?fields=spend,reach,outbound_clicks&level=account'
						. '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

				// $url = 'https://graph.facebook.com/v4.0/' . $value['campaign_id_facebook'] . '/insights?fields=spend,campaign_id,ad_id&level=campaign&limit=5000&date_preset=yesterday&access_token=' . ACCESS_TOKEN;
				
			//	echo $url; echo '<br>';die;
				
				$spend = get_fb_request($url);

				// echo "<pre>"; print_r($spend);

				if (!empty($spend->data) && $spend->data[0]->spend > 0) {

					$param['time'] = $today;
					
					$param['date_spend'] = $today_fb_format;

					$param['campaign_id'] = $value['id'];

					$param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;

					$param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;

					$param['total_C2'] = isset($spend->data[0]->outbound_clicks[0]->value) ? $spend->data[0]->outbound_clicks[0]->value : 0;

					$this->campaign_cost_model->insert($param);
				}
			}
		}
    }


    public function update_channel_cost($day = '0') {

        if ($day == '0') {

            $day = "-1 days";

        }

        $this->load->model('channel_cost_model');

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        $this->load->model('channel_model');

//        $input = array();

//        $input['where'] = array('active' => 1);

//        $channels = $this->channel_model->load_all($input);

        //Kênh facebook



        /*

         * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)

         */

        $where = array('channel_id' => 2, 'time' => $today);

        $this->channel_cost_model->delete($where);

//        $accountFBADS = [

//            'Lakita_cu' => '512062118812690',

//            'Lakita_3.0' => '600208190140429',

//            'Lakita_K3' => '817360198425226'];

        $this->load->model('account_fb_model');

        $accountFBADS = $this->account_fb_model->load_all([]);

        // echo "<pre>";print_r($accountFBADS);die();

        $param['spend'] = 0;

        $param['total_C1'] = 0;

        $param['total_C2'] = 0;

        foreach ($accountFBADS as $value2) {

            $url = 'https://graph.facebook.com/v4.0/act_' . $value2['fb_id_account'] . '/' .

                    'insights?fields=spend,reach,clicks&level=account'

                    . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

            $spend = get_fb_request($url);

            $param['spend'] += isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;

            $param['total_C1'] += isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;

            $param['total_C2'] += isset($spend->data[0]->clicks) ? $spend->data[0]->clicks : 0;

        }

        $param['time'] = $today;

        $param['channel_id'] = 2;

        // echo "<pre>";print_r($param);die();

        $this->channel_cost_model->insert($param);

    }


    public function update_adset_cost($day = '0') {

        if ($day == '0') {

            $day = "-1 days";

        }


        $this->load->model('adset_cost_model');

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        /*

         * Lấy danh sách tất cả adset đang hoạt động

         */

        $this->load->model('adset_model');

        $input = array();

        $input['where'] = array('active' => 1, 'channel_id' => 2);

        $adsets = $this->adset_model->load_all($input);

        foreach ($adsets as $value) {

            /*

             * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)

             */

            if ($value['adset_id_facebook'] != '') {

                $where = array('adset_id' => $value['id'], 'time' => $today);

                $this->adset_cost_model->delete($where);

                $url = 'https://graph.facebook.com/v4.0/' . $value['adset_id_facebook'] .

                        '/insights?fields=spend,reach,outbound_clicks&level=account'

                        . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

                $spend = get_fb_request($url);

                $param['time'] = $today;

                $param['adset_id'] = $value['id'];

                $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;

                $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;

                $param['total_C2'] = isset($spend->data[0]->outbound_clicks[0]->value) ? $spend->data[0]->outbound_clicks[0]->value : 0;

                $this->adset_cost_model->insert($param);

            }

        }

    }



    public function update_ad_cost($day = '0') {

        if ($day == '0') {

            $day = "-1 days";

        }

        $this->load->model('ad_cost_model');

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        /*

         * Lấy danh sách tất cả ad đang hoạt động

         */

        $this->load->model('ad_model');

        $input = array();

        $input['where'] = array('active' => 1, 'channel_id' => 2);

        $adsets = $this->ad_model->load_all($input);

        foreach ($adsets as $value) {

            /*

             * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)

             */

            if ($value['ad_id_facebook'] != '') {

                $where = array('ad_id' => $value['id'], 'time' => $today);

                $this->ad_cost_model->delete($where);

                $url = 'https://graph.facebook.com/v4.0/' . $value['ad_id_facebook'] .

                        '/insights?fields=spend,reach,outbound_clicks&level=account'

                        . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

                $spend = get_fb_request($url);

                if (!empty($spend)) {

                    $param['time'] = $today;

                    $param['ad_id'] = $value['id'];

                    $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;

                    $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;

                    $param['total_C2'] = isset($spend->data[0]->outbound_clicks[0]->value) ? $spend->data[0]->outbound_clicks[0]->value : 0;

                    $this->ad_cost_model->insert($param);

                }

            }

        }

    }


    public function update_campain_spend($day = '0') {

        if ($day == '0') {

            $day = "-1 days";
        }

        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ

        $today_fb_format = date('Y-m-d', strtotime($day));

        // echo $today_fb_format .'--'. $today;die();
        $this->load->model('campaign_spend_model');

        $this->load->model('account_fb_model');

        $accountFBADS = $this->account_fb_model->load_all();

        foreach ($accountFBADS as $key => $value) {
            $url = 'https://graph.facebook.com/v4.0/act_'.$value['fb_id_account'].'/insights?fields=spend,campaign_id,campaign_name,reach,outbound_clicks&level=campaign&limit=5000&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

            // $url = 'https://graph.facebook.com/v3.2/act_'.$value['fb_id_account'].'/insights?fields=spend,reach,outbound_clicks&level=account'. '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;

            $acc = get_fb_request($url);
            // $spend = (array) $acc->data;
            $spend = json_decode(json_encode($acc->data), true);
            // echo "<hr>".$value['name'].'<br>';
            // echo "<pre>";print_r($acc);

            foreach ($spend as $key => $value1) {
                $input['where'] = $where = array(
                    'campaign_id' => $this->find_campaign_id($value1['campaign_id']), 
                    'time' => $today
                );
                // echo "<pre>";print_r($input['where']);die();
                if (!empty($this->campaign_spend_model->load_all($input))) {
                    $this->campaign_spend_model->delete($where);
                } 

                if ($value1['spend'] > 0) {
                    if ($value['USD'] == 1) {
                        $param['spend'] = $value1['spend'] * 23200;
                    } else {
                        $param['spend'] = $value1['spend'];
                    }
                    $param['time'] = $today;
                    $param['campaign_id'] = $this->find_campaign_id($value1['campaign_id']);
                    $param['campaign_id_fb'] = $value1['campaign_id'];
                    $param['total_C1'] = $value1['reach'];
                    $param['total_C2'] = $value1['outbound_clicks'][0]['value'];
                    //$param['date_spend'] = date('Y-m-d H:i:s', strtotime($day));
                    $param['date_spend'] = $today_fb_format;
                    //echo "<pre>";print_r($param);
                    $this->campaign_spend_model->insert($param);
                }
            }
        }
        // echo "success";

    }


    function test_cost_campaign() {
        
        for ($i = 1; $i <= 2; $i++) {

            $day = "-" . $i . " days";

            $this->update_campain_cost($day);

        }

    }



    function test_cost_channel() {

        for ($i = 1; $i <= 2; $i++) {

            $day = "-" . $i . " days";

            $this->update_channel_cost($day);

        }

    }



    function test_cost_adset() {

        for ($i = 1; $i <= 2; $i++) {

            $day = "-" . $i . " days";

            $this->update_adset_cost($day);

        }

    }



    function test_cost_ads() {

        for ($i = 1; $i <= 2; $i++) {

            $day = "-" . $i . " days";

            $this->update_ad_cost($day);

        }

    }


//    function listen() {

//        if (!$this->input->is_ajax_request()) {

//            redirect();

//        }

//        $userID = $this->session->userdata('user_id');

//        if (!isset($userID)) {

//            $location = 'dang-nhap.html';

//            if (strpos($location, '/') !== 0 || strpos($location, '://') !== FALSE) {

//                if (!function_exists('site_url')) {

//                    $this->load->helper('url');

//                }

//                $location = site_url($location);

//            }

//            $script = "window.location='{$location}';";

//            $this->output->enable_profiler(FALSE)

//                    ->set_content_type('application/x-javascript')

//                    ->set_output($script);

//        } else {

//            $this->load->helper('cookie');

//            $myfile = fopen(APPPATH . "../public/last_reg.txt", "r") or die("Unable to open file!");

//            $last_id_txt = fgets($myfile);

//            $last_id = get_cookie('last_id');

//            if (!$last_id) {

//                set_cookie('last_id', $last_id_txt, 3600 * 48);

//                echo '0';

//                die;

//            }

//            if ($last_id != $last_id_txt) {

//                echo '1';

//                set_cookie('last_id', $last_id_txt, 3600 * 48);

//            } else {

//                echo '0';

//            }

//            fclose($myfile);

//        }

//    }



    public function SyncActiveCampaign() {
        $this->load->model('account_fb_model');
        $this->load->model('campaign_model');

        $test = $this->account_fb_model->getAccountArr();
        foreach ($test as $account => $value) {
            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/campaigns?fields=["effective_status","name","account_id","created_time"]&limit=5000&access_token=' . ACCESS_TOKEN;     
            $spend = get_fb_request($url);
            foreach ($spend->data as $value) {

                if ($value->effective_status == 'ACTIVE') {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('campaign_id_facebook' => $value->id);

                    $data = array('active' => '1', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->campaign_model->update($where, $data);
                } else {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('campaign_id_facebook' => $value->id);

                    $data = array('active' => '0', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->campaign_model->update($where, $data);
                }
            }
        }
    }


    public function SyncActiveAdset() {
		
        $this->load->model('adset_model');
        $this->load->model('account_fb_model');
        $accountFBADS = $this->account_fb_model->getAccountArr();
        foreach ($accountFBADS as $account => $value) {
			echo $account;echo '<br>';
            //$url = 'https://graph.facebook.com/v3.3/act_' . $account . '/adsets?fields=["delivery_info{start_time,status}","created_time","name","account_id"]&limit=5000&access_token=' . FULL_PER_ACCESS_TOKEN;
            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/adsets?fields=["effective_status","name","account_id","created_time"]&limit=5000&access_token=' . ACCESS_TOKEN;     

            $spend = get_fb_request($url);
            foreach ($spend->data as $value) {

                if ($value->effective_status == 'ACTIVE') {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('adset_id_facebook' => $value->id);

                    $data = array('active' => '1', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->adset_model->update($where, $data);

                } else {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('adset_id_facebook' => $value->id);

                    $data = array('active' => '0', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->adset_model->update($where, $data);
                }
            }
        }
    }

    public function SyncActiveAd() {

        $this->load->model('ad_model');
        $this->load->model('account_fb_model');
        $accountFBADS = $this->account_fb_model->getAccountArr();
        foreach ($accountFBADS as $account => $value) {
			
            //$url = 'https://graph.facebook.com/v3.3/act_' . $account . '/ads?fields=["delivery_info{start_time,status}","created_time","name","account_id"]&limit=5000&access_token=' . FULL_PER_ACCESS_TOKEN;
            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/ads?fields=["effective_status","name","account_id","created_time"]&limit=5000&access_token=' . ACCESS_TOKEN;     
            $spend = get_fb_request($url);
            foreach ($spend->data as $value) {

                if ($value->effective_status == 'ACTIVE') {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('ad_id_facebook' => $value->id);

                    $data = array('active' => '1', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->ad_model->update($where, $data);
                } else {

                    $dateFbCreate = isset($value->created_time) ? strtotime($value->created_time) : 0;

                    $where = array('ad_id_facebook' => $value->id);

                    $data = array('active' => '0', 'date_fb_create' => $dateFbCreate,
                        'name' => $value->name, 'account_fb_id' => $value->account_id);

                    $this->ad_model->update($where, $data);
                }
            }
        }
    }


    public function GetAllCampaign() {

        $result = [];

        $url = 'https://graph.facebook.com/v4.0/act_512062118812690/ads?fields=id,name,created_time,status&limit=5000&access_token=' . ACCESS_TOKEN;

        $spend = get_fb_request($url);

        if (!empty($spend)) {

            $result = json_decode(json_encode($spend->data), true);

            if (isset($spend->paging->next)) {

                // $url = 'https://graph.facebook.com/v3.3/act_512062118812690/adsets?fields=id,name,created_time,status&limit=1000&access_token=' . ACCESS_TOKEN;

                $spend2 = get_fb_request($spend->paging->next);

                print_arr($spend2);

            }

        }

        print_arr($result);

    }



//    public function GetActiveAdset() {

//        $url = 'https://graph.facebook.com/v3.3/act_512062118812690/adsets?fields=id,name,created_time,status&limit=500&access_token=' . ACCESS_TOKEN;

//        $spend = get_fb_request($url);

//        $this->load->model('adset_model');

//        foreach ($spend->data as $value) {

//            if ($value->status != 'ACTIVE') {

//                $where = array('adset_id_facebook' => $value->id);

//                $data = array('active' => '0');

//                $this->adset_model->update($where, $data);

//            }

//        }

//    }

//

//    public function GetActiveAds() {

//        $url = 'https://graph.facebook.com/v3.3/act_512062118812690/ads?fields=id,name,created_time,status&limit=500&access_token=' . ACCESS_TOKEN;

//        $spend = get_fb_request($url);

//        $this->load->model('ad_model');

//        foreach ($spend->data as $value) {

//            if ($value->status != 'ACTIVE') {

//                $where = array('ad_id_facebook' => $value->id);

//                $data = array('active' => '0');

//                $this->ad_model->update($where, $data);

//            }

//        }

//    }

	function insert_campaign_exist_on_fb() {
        $this->load->model('account_fb_model');
        $this->load->model('staffs_model');
        $this->load->model('courses_model');
        $this->load->model('campaign_model');

        $input = array();
        $input['select'] = 'id,short_name';
        $input['where']['role_id'] = 6;
        $input['where']['active'] = 1;
        $staff = $this->staffs_model->load_all($input);
        foreach ($staff as $value) {
            $list_marketer[strtoupper($value['short_name'])] = $value['id'];
        }

        $input = array();
        $input['select'] = 'id,course_code,brand_id';
        $input['where']['active'] = 1;
        $input['order']['id'] = 'desc';
        $course = $this->courses_model->load_all($input);
        $list_course = array();
        foreach ($course as $value) {
            $list_course[$value['course_code']] = array('id' => $value['id'], 'brand_id' => $value['brand_id']);
        }

		// echo '<pre>'; print_r($list_marketer);die;

        $test = $this->account_fb_model->getAccountArr();
        foreach ($test as $account => $value) {

            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/campaigns?fields=["effective_status","name","account_id","created_time"]&limit=5000&access_token=' . ACCESS_TOKEN;
            $campaign = get_fb_request($url);

            foreach ($campaign->data as $key => $value) {
                if ($value->effective_status == 'ACTIVE') {
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['campaign_id_facebook'] = $value->id;
                    $campaign_fb = $this->campaign_model->load_all($input);
                    if (empty($campaign_fb)) {
                        $value->created_time = strtotime($value->created_time);
                        $value->name = strtoupper(str_replace('_', '-', preg_replace('/[^\w\s]/', '-', $value->name)));
                        //tìm tên marketer trong tên campaign
                        foreach ($list_marketer as $k_marketer => $v_marketer) {
                            $marketer_id = 0;
                            if (strlen(strstr($value->name, $k_marketer)) > 0) {
                                $marketer_id = $v_marketer;
                                break;
                            }
                        }
                        //tìm tên khóa học, combo trong tên campaign
                        foreach ($list_course as $k_course => $v_course) {
                            $course_id = 0;
							$brand_id = 0;
                            if (strlen(strstr($value->name, $k_course)) > 0) {
                                $course_id = $v_course['id'];
								$brand_id = $v_course['brand_id'];
                                break;
                            }
                        }

                        $data = array();
                        $data['name'] = $value->name;
                        $data['desc'] = $value->name;
                        $data['campaign_id_facebook'] = $value->id;
                        $data['time'] = time();
                        $data['active'] = 1;
                        $data['course_id'] = $course_id;
                        $data['channel_id'] = 2;
                        $data['brand_id'] = $brand_id;
                        $data['warehouse_id'] = 0;
                        $data['account_fb_id'] = $value->account_id;
                        $data['marketer_id'] = $marketer_id;
                        $data['date_fb_create'] = $value->created_time;
                        $this->campaign_model->insert($data);
                    }
                }
            }
        }
    }

    function insert_adset_exist_on_fb() {
        $this->load->model('account_fb_model');
        $this->load->model('campaign_model');
        $this->load->model('adset_model');

        $test = $this->account_fb_model->getAccountArr();
        foreach ($test as $account => $value) {

            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/adsets?fields=["effective_status","name","account_id","created_time","campaign_id"]&limit=5000&access_token=' . ACCESS_TOKEN;
            $adset = get_fb_request($url);

            foreach ($adset->data as $key => $value) {
                if ($value->effective_status == 'ACTIVE') {
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['adset_id_facebook'] = $value->id;
                    $adset_fb = $this->adset_model->load_all($input);
                    if (empty($adset_fb)) {
                        $value->created_time = strtotime($value->created_time);

                        $input = array();
                        $input['select'] = 'id,marketer_id';
                        $input['where']['campaign_id_facebook'] = $value->campaign_id;
                        $campaign = $this->campaign_model->load_all($input);

                        $data = array();
                        $data['name'] = $value->name;
                        $data['desc'] = $value->name;
                        $data['adset_id_facebook'] = $value->id;
                        $data['time'] = time();
                        $data['active'] = 1;
                        $data['campaign_id'] = $campaign[0]['id'];
                        $data['marketer_id'] = $campaign[0]['marketer_id'];
                        $data['date_fb_create'] = $value->created_time;
                        $data['channel_id'] = 2;
                        $data['account_fb_id'] = $value->account_id;
                        $this->adset_model->insert($data);
                    }
                }
            }
        }
    }

    function insert_ad_exist_on_fb() {
        $this->load->model('account_fb_model');
        $this->load->model('adset_model');
        $this->load->model('ad_model');

        $test = $this->account_fb_model->getAccountArr();
        foreach ($test as $account => $value) {

            $url = 'https://graph.facebook.com/v4.0/act_' . $account . '/ads?fields=["effective_status","name","account_id","created_time","adset_id"]&limit=5000&access_token=' . ACCESS_TOKEN;
            $adset = get_fb_request($url);

            foreach ($adset->data as $key => $value) {
                if ($value->effective_status == 'ACTIVE') {
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['ad_id_facebook'] = $value->id;
                    $ad_fb = $this->ad_model->load_all($input);
                    if (empty($ad_fb)) {
                        $value->created_time = strtotime($value->created_time);

                        $input = array();
                        $input['select'] = 'id,marketer_id';
                        $input['where']['adset_id_facebook'] = $value->adset_id;
                        $adset = $this->adset_model->load_all($input);

                        $data = array();
                        $data['name'] = $value->name;
                        $data['desc'] = $value->name;
                        $data['ad_id_facebook'] = $value->id;
                        $data['time'] = time();
                        $data['active'] = 1;
                        $data['adset_id'] = $adset[0]['id'];
                        $data['marketer_id'] = $adset[0]['marketer_id'];
                        $data['date_fb_create'] = $value->created_time;
                        $data['channel_id'] = 2;
                        $data['account_fb_id'] = $value->account_id;
                        $this->ad_model->insert($data);
                    }
                }
            }
        }
    }

    

	function clear_contact_duplicate() {
		//echo strtotime(date('Y-m-d 00:00:00'));
		$input = array();
		$input['select'] = 'id,duplicate_id,name,phone';
		$input['where']['duplicate_id !='] = '0';
		$input['where']['ordering_status_id'] = '0';
		$input['where']['call_status_id'] = '0';
		$input['where']['cod_status_id'] = '0';
		$input['where']['date_rgt >='] = strtotime(date('Y-m-d 00:00:00'));
		$c = $this->contacts_model->load_all($input);
		//echo '<pre>'; print_r($c);die;
		foreach($c as $value) {
			//$input_dp['select'] = 'id';
			//$input_dp['where']['duplicate_id'] = $value['duplicate_id'];
			//$dl = $this->contacts_model->load_all($input_dp);
			//echo '<pre>'; print_r($dl);
			
			$where['duplicate_id'] = $value['duplicate_id'];
			$this->contacts_model->delete($where);
			
			//echo '<pre>'; print_r($dl);
		}
	}

	//Kiểm tra tạo tài khoản lakita
    function check_account_lakita() {
        $this->load->model('contacts_model');
        $check = $this->contacts_model->check_account();
        /*echo '<pre>';
        print_r($check);
		echo '</pre>';
		die;*/
		
		if (!empty($check)) {
            foreach ($check as $value) {
				$id = $value['id'];
				//echo $id . '<br>';
                $acc = $this->create_new_account_student($id);
				//echo $acc;
				if (!$acc) {
					echo 'Lỗi tạo tài khoản';
                }
            }
        } 
    }
	
	//Tạo tài khoản học viên
    public function create_new_account_student($id)
    {   
        //$post = $this->input->post();
        
        if (isset($id)) {
            $this->db->select('name, course_code, email, phone, payment_method_rgt');
            $contacts = $this->contacts_model->find($id);
			//var_dump($contacts);die;
			 
            if (!empty($contacts)) {

                $contact = $contacts[0];
				
                switch ($contact['course_code']) {
                    case 'KT610':
                        $contact['course_code'] = 'KT240';
                        break;
                    case 'KT620':
                        $contact['course_code'] = 'KT270';
                        break;
                    case 'KT630':
                        $contact['course_code'] = 'KT280';
                        break;
                    case 'KT460':
                        $contact['course_code'] = 'KT290';
                        break;
                    default:
                        break;
                }

                $this->load->model('courses_model');
                $contact_s = $this->courses_model->find_course_combo($contact['course_code']);
                // $courseCode = explode(",", $contact_s);
                $contact['course_code'] = $contact_s; 
				//var_dump($contact);die;
				
                if ($contact['name'] == '' || $contact['phone'] == '') {
                    $result = [];
                    $result['success'] = 0;
                    $result['message'] = 'Contact đã chọn không có tên hoặc số đt hoặc địa chỉ! Vui lòng cập nhật thông tin khách hàng đầy đủ.';
                    echo json_encode($result);
                    die;
                }
//var_dump($contact);
                $student = $this->_create_account_student_lakita($contact);
                // return json_encode($student);
			  // exit;
                if ($student->success != 0) {
                    $contact['password'] = $student->password;
					
					$id_lakita = $student->id_lakita;

                    $where = array('id' => $id);

                    $data = array('id_lakita' => $id_lakita, 'date_active' => time());

                    $this->contacts_model->update($where, $data);

                    return $student;
                    // die(); 
                } else {

                    $id_lakita = $student->id_lakita;

                    $where = array('id' => $id);

                    $data = array('id_lakita' => $id_lakita);

                    $this->contacts_model->update($where, $data);

                    return $student;

                }
            }
        }
    }
	
	
	//api tạo tài khoản cho học viên
    private function _create_account_student_lakita($contact) {
		//var_dump($contact);
        require_once APPPATH . "libraries/Rest_Client.php";
        $config = array(
            'server' => 'https://lakita.vn/',
            'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
            'api_name' => 'lakita-key'
        );
        $restClient = new Rest_Client($config);
        $uri = "account_api/create_new_account";
        $student = $restClient->post($uri, $contact);
		//var_dump($student);
        return $student;
    }
    //end
	

	function test(){
		phpinfo();
	}
	
	const PAGE_LIMIT = 500;

    public function _get_list_account_google_ads() {
        $path_adsapi_php = APPPATH . '../plugin/adsapi_php.ini';

        $handle = fopen($path_adsapi_php, 'r') or die('Cannot open file:  ' . $path_adsapi_php);
        $data = fread($handle, filesize($path_adsapi_php));
        $pattern = "/\"[\d\-]{12}\"/";
        $data = preg_replace($pattern, '"423-205-8615"', $data);
        $handle = fopen($path_adsapi_php, 'w') or die('Cannot open file:  ' . $path_adsapi_php);
        fwrite($handle, $data);
        fclose($handle);

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($path_adsapi_php)->build();

        // Construct an API session configured from a properties file and the
        // OAuth2 credentials above.
        $session = (new AdWordsSessionBuilder())->fromFile($path_adsapi_php)->withOAuth2Credential($oAuth2Credential)->build();
        // self::runExample(new AdWordsServices(), $session);

        $adWordsServices = new AdWordsServices();


        $managedCustomerService = $adWordsServices->get(
                $session, ManagedCustomerService::class
        );

        // Create selector.
        $selector = new Selector();
        $selector->setFields(['CustomerId', 'Name']);
        $selector->setOrdering([new OrderBy('CustomerId', SortOrder::ASCENDING)]);
        //$selector->setPaging(new Paging(0, self::PAGE_LIMIT));
        // Maps from customer IDs to accounts and links.
        $customerIdsToAccounts = [];
        $customerIdsToChildLinks = [];
        $customerIdsToParentLinks = [];


        // Make the get request.
        $page = $managedCustomerService->get($selector);

        // Create links between manager and clients.
        if ($page->getEntries() !== null) {

            if ($page->getLinks() !== null) {
                foreach ($page->getLinks() as $link) {
                    // Cast the indexes to string to avoid the issue when 32-bit PHP
                    // automatically changes the IDs that are larger than the 32-bit max
                    // integer value to negative numbers.
                    $managerCustomerId = strval($link->getManagerCustomerId());
                    $customerIdsToChildLinks[$managerCustomerId][] = $link;
                    $clientCustomerId = strval($link->getClientCustomerId());
                    $customerIdsToParentLinks[$clientCustomerId] = $link;
                }
            }
            foreach ($page->getEntries() as $account) {
                $customerIdsToAccounts[strval($account->getCustomerId())] = $account;
            }
        }


        // Find the root account.
        $rootAccount = null;


        foreach ($customerIdsToAccounts as $account) {
            if (!array_key_exists(
                            strval($account->getCustomerId()), $customerIdsToParentLinks
                    )) {
                $rootAccount = $account;
                break;
            }
        }

        if ($rootAccount !== null) {
            // Display results.
            $customerId = strval($rootAccount->getCustomerId());
            $childAccount = array();
            foreach ($customerIdsToChildLinks[strval($customerId)] as $childLink) {
                $id = substr_replace(strval($childLink->getClientCustomerId()), '-', 3, 0);
                $id = substr_replace($id, '-', 7, 0);
                $childAccount[] = $id;
            }
            return $childAccount;
        } else {
            return array();
        }
    }

    public function update_campaign_google_cost($time = '') {
		set_time_limit(0);
        //Thời gian truyền vào có dạng dd-mm-yyyy
        if (isset($time) && !empty($time)) {
            $time = date('Ymd', $time_input = strtotime($time));
        } else {
            $time = date('Ymd', $time_input = strtotime(date('d-m-Y', strtotime('1 day ago'))));
        }

        $path_adsapi_php = APPPATH . '../plugin/adsapi_php.ini';
        $list_account_adsgoogle = $this->_get_list_account_google_ads();
        $reportFormat = DownloadFormat::CSV;

        $handle = fopen($path_adsapi_php, 'r') or die('Cannot open file:  ' . $path_adsapi_php);
        $data_config = fread($handle, filesize($path_adsapi_php));
        $pattern = "/\"[\d\-]{12}\"/";
        foreach ($list_account_adsgoogle as $acc_value) {
            $data_config = preg_replace($pattern, '"' . $acc_value . '"', $data_config);
            $handle = fopen($path_adsapi_php, 'w') or die('Cannot open file:  ' . $path_adsapi_php);
            fwrite($handle, $data_config);
            fclose($handle);

            $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($path_adsapi_php)->build();
            $session = (new AdWordsSessionBuilder())
                    ->fromFile($path_adsapi_php)
                    ->withOAuth2Credential($oAuth2Credential)
                    ->build();
            // Create report query to get the data for last 7 days.
            $query = (new ReportQueryBuilder())
                    ->select([
                        'CampaignId',
                        'CampaignName',
                        'Clicks',
                        'Cost'
                    ])
                    ->from(ReportDefinitionReportType::CAMPAIGN_PERFORMANCE_REPORT)
                    //->where('Status')->in(['ENABLED', 'PAUSED'])
                    //quét ngày hôm qua
                    //->duringDateRange(ReportDefinitionDateRangeType::YESTERDAY)
                    ->during($time, $time)
                    ->build();

            // Download report as a string.
            $reportDownloader = new ReportDownloader($session);
            // Optional: If you need to adjust report settings just for this one
            // request, you can create and supply the settings override here.
            // Otherwise, default values from the configuration
            // file (adsapi_php.ini) are used.
            $reportSettingsOverride = (new ReportSettingsBuilder())
                    ->includeZeroImpressions(false)
                    ->build();
            $reportDownloadResult = $reportDownloader->downloadReportWithAwql(
                    sprintf('%s', $query), $reportFormat, $reportSettingsOverride
            );
            $result = $reportDownloadResult->getAsString();
            $result = preg_split('/\r\n|\r|\n/', $result);

            //xóa 2 phần tủ đầu tiên và cuối cùng của mảng
            array_shift($result);
            array_shift($result);
            array_pop($result);
            array_pop($result);

            foreach ($result as $key => $value) {
                $result[$key] = explode(',', $value);
            }

            $list_campaign_spend = array();
            foreach ($result as $key => $value) {
                if (array_key_exists($value[0], $list_campaign_spend)) {
                    $list_campaign_spend[$value[0]]['click'] += $value[2];
                    $list_campaign_spend[$value[0]]['cost'] += round($value[3] / 1000000);
                } else {
                    $list_campaign_spend[$value[0]] = array(
                        'campaign_id_google' => $value[0],
                        'name' => $value[1],
                        'click' => $value[2],
                        'spend' => round($value[3] / 1000000)
                    );
                }
            }

            //đã lấy được thông tin tiền tiêu cho campaign, giờ là lưu lại
            $this->load->model('campaign_model');
            $this->load->model('Cost_GA_campaign_model');
            foreach ($list_campaign_spend as $c_key => $c_value) {
                $input = array();
                $input['select'] = 'id';
                $input['where']['campaign_id_google'] = $c_value['campaign_id_google'];
                $campaign_id_google = $this->campaign_model->load_all($input);
                if (empty($campaign_id_google)) {
                    $data = array();
                    $data['campaign_id'] = $this->_insert_campaign_google($c_key, $c_value['name'], $acc_value);
                    $data['time'] = $time_input;
                    $data['spend'] = $c_value['spend'];
					$data['date_spend'] = date('Y-m-d H:i:s', $data['time']);
                    $this->Cost_GA_campaign_model->insert($data);
                } else {
                    //xóa dữ liệu chi của campaign trong ngày nếu đã được thêm trước đó
                    $where = array('campaign_id' => $campaign_id_google[0]['id'], 'time' => $time_input);
                    $this->Cost_GA_campaign_model->delete($where);

                    //lưu thông tin mới
                    $data = array();
                    $data['campaign_id'] = $campaign_id_google[0]['id'];
                    $data['time'] = $time_input;
                    $data['spend'] = $c_value['spend'];
					$data['date_spend'] = date('Y-m-d H:i:s', $data['time']);
                    $this->Cost_GA_campaign_model->insert($data);
                }
            }
//            echo '<pre>';
//            print_r($list_campaign_spend);
        }
    }

    public function insert_campaign_exist_on_gg() {
        set_time_limit(0);
        $this->load->model('campaign_model');
        $path_adsapi_php = APPPATH . '../plugin/campaign/adsapi_php.ini';
        $list_account_adsgoogle = $this->_get_list_account_google_ads();

        $handle = fopen($path_adsapi_php, 'r') or die('Cannot open file:  ' . $path_adsapi_php);
        $data_config = fread($handle, filesize($path_adsapi_php));
        $pattern = "/\"[\d\-]{12}\"/";

        foreach ($list_account_adsgoogle as $acc_value) {
            $data_config = preg_replace($pattern, '"' . $acc_value . '"', $data_config);
            $handle = fopen($path_adsapi_php, 'w') or die('Cannot open file:  ' . $path_adsapi_php);
            fwrite($handle, $data_config);
            fclose($handle);

            // Generate a refreshable OAuth2 credential for authentication.
            $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($path_adsapi_php)->build();

            // Construct an API session configured from a properties file and the
            // OAuth2 credentials above.
            $session = (new AdWordsSessionBuilder())->fromFile($path_adsapi_php)->withOAuth2Credential($oAuth2Credential)->build();
            $adWordsServices = new AdWordsServices();
            $campaignService = $adWordsServices->get(
                    $session, CampaignService::class
            );

            // Create AWQL query.
            $query = (new ServiceQueryBuilder())
                    ->select(['Id', 'Name', 'Status'])
                    ->orderByDesc('Id')
                    //     ->limit(0, self::PAGE_LIMIT)
                    ->build();

            // Make a request using an AWQL string. This request will return the
            // first page containing up to `self::PAGE_LIMIT` results
            $page = '';
            $page = $campaignService->query(sprintf('%s', $query));

            // Display results from second and subsequent pages.
            $list_campaign = array();
            if ($page->getEntries() !== null) {
                foreach ($page->getEntries() as $campaign) {
                    $campaign_id_google = $campaign->getId();
                    $campaign_name = $campaign->getName();
                    $list_campaign[] = array('campaign_id_google' => $campaign_id_google, 'name' => $campaign->getName());

                    //kiểm tra đã tồn tại campaign này chưa
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['campaign_id_google'] = $campaign_id_google;
                    $campaign_exist = '';
                    $campaign_exist = $this->campaign_model->load_all($input);
                    if (empty($campaign_exist)) {
                        $this->_insert_campaign_google($campaign_id_google, $campaign_name, $acc_value);
                    }
                }
            }
        }
    }

    public function insert_adset_exist_on_gg() {
        set_time_limit(0);
        $this->load->model('campaign_model');
        $this->load->model('adset_model');
        $input = array();
        $input['select'] = 'id,campaign_id_google,account_gg_id,marketer_id';
        $input['where']['channel_id'] = _KENH_GG_;
        $input['where']['campaign_id_google !='] = '';
        $input['where']['account_gg_id !='] = '';
        $input['order']['account_gg_id'] = 'asc';
        $list_campaign = $this->campaign_model->load_all($input);

        $path_adsapi_php = APPPATH . '../plugin/adset/adsapi_php.ini';
        $handle = fopen($path_adsapi_php, 'r') or die('Cannot open file:  ' . $path_adsapi_php);
        $data_acc = fread($handle, filesize($path_adsapi_php));
        $pattern = "/\"[\d\-]{12}\"/";
        $pre_acc = '';
        foreach ($list_campaign as $c_key => $c_value) {
            if ($pre_acc != $c_value['account_gg_id']) {
                $pre_acc = $c_value['account_gg_id'];
                $data_acc = preg_replace($pattern, '"' . $c_value['account_gg_id'] . '"', $data_acc);
                $handle = fopen($path_adsapi_php, 'w') or die('Cannot open file:  ' . $path_adsapi_php);
                fwrite($handle, $data_acc);
                fclose($handle);

                // Generate a refreshable OAuth2 credential for authentication.
                $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($path_adsapi_php)->build();

                // Construct an API session configured from a properties file and the
                // OAuth2 credentials above.
                $session = (new AdWordsSessionBuilder())->fromFile($path_adsapi_php)->withOAuth2Credential($oAuth2Credential)->build();
                $adWordsServices = new AdWordsServices();
                $adGroupService = $adWordsServices->get($session, AdGroupService::class);
            }

            // Create a selector to select all ad groups for the specified campaign.

            $selector = new Selector();
            $selector->setFields(['Id', 'Name', 'CampaignId']);
            $selector->setOrdering([new OrderBy('Name', SortOrder::ASCENDING)]);
            $selector->setPredicates(
                    [new Predicate('CampaignId', PredicateOperator::IN, [$c_value['campaign_id_google']])]
            );
            // $selector->setPaging(new Paging(0, self::PAGE_LIMIT));

            $totalNumEntries = 0;

            // Retrieve ad groups one page at a time, continuing to request pages
            // until all ad groups have been retrieved.
            $page = $adGroupService->get($selector);

            // Print out some information for each ad group.
            if ($page->getEntries() !== null) {
                foreach ($page->getEntries() as $adGroup) {
                    $id_ads = $adGroup->getId();
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['adset_id_google'] = $id_ads;
                    $adset = $this->adset_model->load_all($input);
                    if (empty($adset)) {
                        $data = array();
                        $data['name'] = $adGroup->getName();
                        $data['desc'] = $adGroup->getName();
                        $data['adset_id_google'] = $id_ads;
                        $data['time'] = time();
                        $data['active'] = 1;
                        $data['campaign_id'] = $c_value['id'];
                        $data['marketer_id'] = $c_value['marketer_id'];
                        $data['date_fb_create'] = time();
                        $data['channel_id'] = 3;
                        $data['account_gg_id'] = $c_value['account_gg_id'];
                        $this->adset_model->insert($data);
                    }
                }
            }
        }
    }

    function insert_ad_exist_on_gg() {
        set_time_limit(0);
        $this->load->model('campaign_model');
        $this->load->model('adset_model');
        $this->load->model('ad_model');
        $input = array();
        $input['select'] = 'id,adset_id_google,account_gg_id,marketer_id';
        $input['where']['channel_id'] = _KENH_GG_;
        $input['where']['adset_id_google !='] = '';
        $input['where']['account_gg_id !='] = '';
        $input['order']['account_gg_id'] = 'asc';
        $list_adset = $this->adset_model->load_all($input);

        $path_adsapi_php = APPPATH . '../plugin/ad/adsapi_php.ini';
        $handle = fopen($path_adsapi_php, 'r') or die('Cannot open file:  ' . $path_adsapi_php);
        $data_acc = fread($handle, filesize($path_adsapi_php));
        $pattern = "/\"[\d\-]{12}\"/";
        $pre_acc = '';
        foreach ($list_adset as $c_key => $c_value) {
            if ($pre_acc != $c_value['account_gg_id']) {
                $pre_acc = $c_value['account_gg_id'];
                $data_acc = preg_replace($pattern, '"' . $c_value['account_gg_id'] . '"', $data_acc);
                $handle = fopen($path_adsapi_php, 'w') or die('Cannot open file:  ' . $path_adsapi_php);
                fwrite($handle, $data_acc);
                fclose($handle);

                // Generate a refreshable OAuth2 credential for authentication.
                $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile($path_adsapi_php)->build();

                // Construct an API session configured from a properties file and the
                // OAuth2 credentials above.
                $session = (new AdWordsSessionBuilder())->fromFile($path_adsapi_php)->withOAuth2Credential($oAuth2Credential)->build();
                $adWordsServices = new AdWordsServices();
                $adGroupService = $adWordsServices->get($session, AdGroupService::class);
            }

            // Create a selector to select all ad groups for the specified campaign.

            $selector = new Selector();
            $selector->setFields(['Id', 'Name', 'Status']);
            $selector->setOrdering([new OrderBy('Id', SortOrder::ASCENDING)]);
            $selector->setPredicates(
                    [new Predicate('AdGroupId', PredicateOperator::IN, [$c_value['adset_id_google']])]
            );
            // $selector->setPaging(new Paging(0, self::PAGE_LIMIT));
            // Retrieve ad groups one page at a time, continuing to request pages
            // until all ad groups have been retrieved.
            $page = $adGroupService->get($selector);

            // Print out some information for each ad group.
            if ($page->getEntries() !== null) {
                foreach ($page->getEntries() as $ad) {

                    $array[$c_value['account_gg_id']][$c_value['adset_id_google']] = array(
                        'ad_id_google' => $ad->getId(),
                        'ad_name' => $ad->getName(),
                        'status' => $ad->getStatus()
                    );

                    $id_ad = $ad->getId();
                    $input = array();
                    $input['select'] = 'id';
                    $input['where']['ad_id_google'] = $id_ad;
                    $check = $this->ad_model->load_all($input);
                    if (empty($check)) {
                        $data = array();
                        $data['name'] = $ad->getName();
                        $data['desc'] = $ad->getName();
                        $data['ad_id_google'] = $id_ad;
                        $data['time'] = time();
                        $data['active'] = 1;
                        $data['adset_id'] = $c_value['id'];
                        $data['marketer_id'] = $c_value['marketer_id'];
                        $data['channel_id'] = 3;
                        $data['account_gg_id'] = $c_value['account_gg_id'];
                        $this->ad_model->insert($data);
                    }
                }
            }
        }
    }
	
	function find_campaign_id($campaign_id) {
    	$this->load->model('campaign_model');
    	$input['select'] = 'id, name';
		$input['where']['campaign_id_facebook'] = $campaign_id;
		$c = $this->campaign_model->load_all($input);
		return $c[0]['id'];
		// echo'<pre>';print_r($c);die();
	}

    function _insert_campaign_google($campaign_id_google, $campaign_name, $account_id = '') {
        $this->load->model('campaign_model');
        $this->load->model('staffs_model');
        $this->load->model('courses_model');

        //lấy danh sách nhân viên
        $input = array();
        $input['select'] = 'id,short_name';
        $input['where']['role_id'] = 6;
        $input['where']['active'] = 1;
        $staff = $this->staffs_model->load_all($input);
        foreach ($staff as $value) {
            $list_marketer[strtoupper($value['short_name'])] = $value['id'];
        }

        //lấy danh sách khóa học
        $input = array();
        $input['select'] = 'id,course_code';
        $input['where']['active'] = 1;
        $input['order']['id'] = 'desc';
        $course = $this->courses_model->load_all($input);
        $list_course = array();
        foreach ($course as $value) {
            $list_course[$value['course_code']] = $value['id'];
        }

        $campaign_name = strtoupper(str_replace('_', '-', preg_replace('/[^\w\s]/', '-', $campaign_name)));
        //tìm tên marketer trong tên campaign
        foreach ($list_marketer as $k_marketer => $v_marketer) {
            $marketer_id = 0;
            if (strlen(strstr($campaign_name, $k_marketer)) > 0) {
                $marketer_id = $v_marketer;
                break;
            }
        }
        //tìm tên khóa học, combo trong tên campaign
        foreach ($list_course as $k_course => $v_course) {
            $course_id = 0;
            if (strlen(strstr($campaign_name, $k_course)) > 0) {
                $course_id = $v_course;
                break;
            }
        }

        //kiểm tra bằng tên xem campaign đã tồn tại chưa
        $input = array();
        $input['select'] = 'id';
        $input['where']['name'] = $campaign_name;
        $input['where']['campaign_id_google'] = '';
        $input['where']['channel_id'] = 3;
        $check = $this->campaign_model->load_all($input);
        if (empty($check)) {
            $data = array();
            $data['name'] = $campaign_name;
            $data['desc'] = $campaign_name;
            $data['campaign_id_google'] = $campaign_id_google;
            $data['time'] = time();
            $data['active'] = 1;
            $data['course_id'] = $course_id;
            $data['channel_id'] = 3;
            $data['warehouse_id'] = 0;
            $data['account_gg_id'] = $account_id;
            $data['marketer_id'] = $marketer_id;
            $data['date_fb_create'] = time();
            $id = $this->campaign_model->insert_return_id($data, 'id');
            return $id;
        } else {
            $where = array('id' => $check[0]['id']);
            $data = array('campaign_id_google' => $campaign_id_google, 'account_gg_id' => $account_id);
            $this->campaign_model->update($where, $data);
            return $check[0]['id'];
        }
    }
	
	public function update_contact_to_make_report() {
		$this->load->model('contact_history_status_model');
		$this->contact_history_status_model->call_procedure();
	}

    public function delete_contact_test() {
        $this->contacts_model->call_pr();
    }
	
	public function account_active() {
		
        $input['select'] = 'id, name, account_active, phone, email, id_lakita';
        $input['where'] = array(
			'id_lakita !=' => '0', 
			'date_rgt >=' => '1551398400', 
			//'date_rgt <=' => '', 
			'account_active' => '0', 
			'cod_status_id' => '3'
		);
		
        $contact = $this->contacts_model->load_all($input);
		
        //echo '<pre>';
		//print_r($contact);
        //die();

        foreach ($contact as $value) {
            $st = $this->_account_active_lakita($value);
			
            if ($st != 0) {
                $where = array('id' => $value['id']);
                $data = array('account_active' => 1);
                $this->contacts_model->update($where, $data);
				echo 'good job'.'<br>';
            }
        }
    }

    private function _account_active_lakita($value) {
		//var_dump($value);die;
        require_once APPPATH . "libraries/Rest_Client.php";
        $config = array(
            'server' => 'https://lakita.vn/',
            'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
            'api_name' => 'lakita-key'
        );
        $restClient = new Rest_Client($config);
        $uri = "account_api/check_active_contact";
        $student = $restClient->post($uri, $value);
		
		//echo json_encode($student).'<br>';
		//var_dump($student);
        return $student;
    }
	
	/*
	public function cron_course_code() {
        $input['where'] = array('course_code' => '');
        $t = $this->contacts_model->load_all($input);
        // echo '<pre>';
        // print_r($t);
        // die();
        $this->load->model('contacts_backup_model');
        foreach ($t as $value) {
            $input2['where'] = array('id' => $value['id']);
            $m = $this->contacts_backup_model->load_all($input2);
            if ($m[0]['course_code'] != '') {
                $data = array('course_code' => $m[0]['course_code']);
				$where = array('id' => $m[0]['id']);
				$this->contacts_model->update($where, $data);
            }
        }
    } */
	
	public function course_L() {
    	$this->load->model('courses_model');
    	$input = array();
    	$input['where'] = array('active' => 1);
    	$course = $this->courses_model->load_all($input);
//		$input1 = array();
		$date_start = strtotime(date('2019-03-01 00:00:00'));
		$date_end = strtotime(date('2019-06-01 00:00:00'));
		
		//echo $date_start; die;
		
		foreach ($course as $value) {
			//L1
    		$input_L1['where'] = array(
    			'course_code' => $value['course_code'],
				'date_rgt >=' => $date_start,
				'date_rgt <' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0'
			);
    		$L1 = $this->contacts_model->load_all($input_L1);
//    		$sum_L[] = array('course_code' => $value['course_code'], 'L1' => count($L1));
//    		echo $value['course_code'] . ' có - '.count($L1) . ' L1 <br>';

			//L2
			$input_L2['where'] = array(
				'course_code' => $value['course_code'],
				'date_rgt >=' => $date_start,
				'date_rgt <' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4'
			);
			$L2 = $this->contacts_model->load_all($input_L2);

			//L6
			$input_L6['where'] = array(
				'course_code' => $value['course_code'],
				'date_rgt >=' => $date_start,
				'date_rgt <' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4'
			);
			$L6 = $this->contacts_model->load_all($input_L6);

			//L8
			$input_L8['where'] = array(
				'course_code' => $value['course_code'],
				'date_rgt >=' => $date_start,
				'date_rgt <' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4',
				'cod_status_id' => '3'
			);
			$L8 = $this->contacts_model->load_all($input_L8);

			//Hủy đơn
			$input_huydon['where'] = array(
				'course_code' => $value['course_code'],
				'date_rgt >=' => $date_start,
				'date_rgt <' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4',
				'cod_status_id' => '4'
			);
			$huy_don = $this->contacts_model->load_all($input_huydon);

			$sum_L[] = array(
				'course_code' => $value['course_code'],
				'L1' => count($L1),
				'L2' => count($L2),
				'L6' => count($L6),
				'L6' => count($L6),
				'L8' => count($L8),
				'huy_don' => count($huy_don),
				'L2/L1' => round(count($L2)/count($L1), 4)*100,
				'L6/L2' => round(count($L6)/count($L2), 4)*100,
				'huy_don/L6' => round(count($huy_don)/count($L6), 4)*100,
				'L8/L1' => round(count($L8)/count($L1), 4)*100	
			);
		}
		
		usort($sum_L, function($a, $b) {
			return $b['L1'] - $a['L1'];
		});
		
		//echo '<pre>';
    	//print_r($sum_L);
		
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		/*$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
		$template_file_print = $this->config->item('template_file_print');
		$objPHPExcel = $objPHPExcel->load($template_file_print);*/
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A1');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Khóa học');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'L1');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'L2');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'L6');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'L8');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Hủy đơn');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'L2/L1');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'L6/L2');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hủy đơn/L6');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'L8/L1');
		
		$rowCount = 2;
		foreach ($sum_L as $key => $value) {
			
			$columnName = 'A';
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $key + 1);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['course_code']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L1']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L2']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L6']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L8']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['huy_don']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L2/L1']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L6/L2']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['huy_don/L6']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L8/L1']);
			$rowCount++;
			
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Check_L1/L2/L6/L8' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
    }
	
	public function _course_L($mkt_id) {
    	$this->load->model('courses_model');
    	$input = array();
    	$input['where'] = array('active' => 1);
    	$course = $this->courses_model->load_all($input);
//		$input1 = array();
		$date_start = strtotime(date('2019-06-01 00:00:00'));
		$date_end = time();
		//echo time();die;
		$sum_L = array();
		foreach ($course as $value) {
			//L1
    		$input_L1['where'] = array(
    			'course_code' => $value['course_code'],
				'sale_staff_id' => $mkt_id,
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0'
			);
    		$L1 = $this->contacts_model->load_all($input_L1);
//    		$sum_L[] = array('course_code' => $value['course_code'], 'L1' => count($L1));
//    		echo $value['course_code'] . ' có - '.count($L1) . ' L1 <br>';

			//L2
			$input_L2['where'] = array(
				'course_code' => $value['course_code'],
				'sale_staff_id' => $mkt_id,
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4'
			);
			$L2 = $this->contacts_model->load_all($input_L2);

			//L6
			$input_L6['where'] = array(
				'course_code' => $value['course_code'],
				'sale_staff_id' => $mkt_id,
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4'
			);
			$L6 = $this->contacts_model->load_all($input_L6);

			//L8
			$input_L8['where'] = array(
				'course_code' => $value['course_code'],
				'sale_staff_id' => $mkt_id,
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4',
				'cod_status_id' => '3'
			);
			$L8 = $this->contacts_model->load_all($input_L8);

			//Hủy đơn
			$input_huydon['where'] = array(
				'course_code' => $value['course_code'],
				'sale_staff_id' => $mkt_id,
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end,
				'date_handover !=' => '0',
				'duplicate_id' => '0',
				'call_status_id' => '4',
				'ordering_status_id' => '4',
				'cod_status_id' => '4'
			);
			$huy_don = $this->contacts_model->load_all($input_huydon);

			if (count($L1) >= 5 && count($L6) > 0 && count($L2) > 0) {
				$sum_L[] = array(
					'course_code' => $value['course_code'],
					'L1' => count($L1),
					'L2' => count($L2),
					'L6' => count($L6),
					'L8' => count($L8),
					'huy_don' => count($huy_don),
					'L2/L1' => round(count($L2)/count($L1), 4)*100,
					'L6/L2' => round(count($L6)/count($L2), 4)*100,
					'huy_don/L6' => round(count($huy_don)/count($L6), 4)*100,
					'L8/L1' => round(count($L8)/count($L1), 4)*100
				);
			}
		}

		return $sum_L;
    	//echo '<pre>';
    	//print_r($sum_L);
		//die();
		
    }

    public function mkt_course() {

		$this->load->model('staffs_model');
		$input_mkt = array();
		$input_mkt['where'] = array('role_id' => 1, 'active' => 1);
		$mkt = $this->staffs_model->load_all($input_mkt);
		
		//echo '<pre>';
		//print_r($mkt);die;
		//unset($mkt[0], $mkt[1], $mkt[4], $mkt[5], $mkt[16], $mkt[17]);

		foreach ($mkt as $item) {
			$mkt_L[$item['name']] = $this->_course_L($item['id']);
			usort($mkt_L[$item['name']], function($a, $b) {
				return $b['L1'] - $a['L1'];
			});
		}
		
		//echo '<pre>';
		//print_r($mkt_L);
		
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
//		$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
//		$template_file_print = $this->config->item('template_file_print');
//		$objPHPExcel = $objPHPExcel->load($template_file_print);
		$objPHPExcel->setActiveSheetIndex(0);
//		$contact_export = $this->_contact_export($post['contact_id']);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Khóa học');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'L1');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'L2');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'L6');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'L8');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Hủy đơn');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'L2/L1');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'L6/L2');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hủy đơn/L6');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'L8/L1');
		
		$rowCount = 2;
		foreach ($mkt_L as $key => $val) {
			$columnName = 'A';
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $key);
			foreach ($val as $key => $value) {
				$columnName = 'B';	
				//$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['course_code']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L1']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L2']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L6']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L8']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['huy_don']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L2/L1']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L6/L2']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['huy_don/L6']);
				$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['L8/L1']);
				$rowCount++;
			}
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Contact_' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	
	public function landingpage() {
    	$this->load->model('landingpage_model');
		$this->load->model('staffs_model');
		
    	$input['where'] = array('active' => 1);
		//$input['or_where'] = array('active' => 1, 'group_course_code' => 'pha-che');
    	$lp = $this->landingpage_model->load_all($input);
    	//echo '<pre>';
    	//print_r($lp);die();
		$C = array();
		$date_start = strtotime(date('2019-01-01 00:00:00'));
		$date_end = strtotime(date('2019-06-01 00:00:00'));
		$price = 0;
		foreach ($lp as &$value) {

			/*
			 * Lấy số C3 & số tiền tiêu
			 */
			$total_c3 = array();
			$total_c3['select'] = 'id, price_purchase';
			$total_c3['where'] = array(
				'landingpage_id' => $value['id'],
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end
			);
			$C3 = $this->contacts_model->load_all($total_c3);
			foreach($C3 as $val) {
				$price = $price + $val['price_purchase'];
			}
			//lấy c2
			$this->load->model('c2_model');
			$total_c2 = array();
			$total_c2['select'] = 'id';
			$total_c2['where'] = array(
				'landingpage_id' => $value['id'],
				'date_rgt >=' => $date_start,
				'date_rgt <=' => $date_end
			);
			$C2 = count($this->c2_model->load_all($total_c2));

			$C3pC2 = ($C2 > 0) ? round((count($C3) / $C2), 4)*100 : '__';

			//$C['marketer_id'] = $this->staffs_model->find_staff_name($value['marketer_id']);
			
			if ($C2 >= 500) {
				$C[] = array(
					'landingpage_code' => $value['landingpage_code'],
					'C2' => $C2,
					'C3' => count($C3),
					'C3/C2' => $C3pC2,
					'price' => $price,
					'marketer' => $this->staffs_model->find_staff_name($value['marketer_id']),
					'link_landingpage' => $value['url']
				);
			}
		}
		
		usort($C, function ($a, $b) {
			return $b['C3/C2'] - $a['C3/C2'];
		});
		
		//echo '<pre>';
    	//print_r($C);die();

		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		/*$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
		$template_file_print = $this->config->item('template_file_print');
		$objPHPExcel = $objPHPExcel->load($template_file_print);*/
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mã Landingpage');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'C2');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'C3');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'C3/C2');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Giá');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Marketer');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Link');

		$rowCount = 2;
		foreach ($C as $key => $value) {

			$columnName = 'A';
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $key + 1);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['landingpage_code']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['C2']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['C3']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['C3/C2']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['price']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['marketer']);
			$objPHPExcel->getActiveSheet()->SetCellValue($columnName++ . $rowCount, $value['link_landingpage']);
			$rowCount++;

		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="C' . date('d/m/Y') . '.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	
	function get_contact(){
		echo 'sfsf'; die;
		
		$input['select'] = 'phone, level_contact_id, language_id';
		$input['where'] = array(
			'is_hide' => '0'
		);
		$cts = $this->contacts_model->load_all($input);
		print_arr($cts);
	}
	
}
