<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of MY_Controller2

 * @author chuyenpn ngày 09/07/2017

 * Class dùng để thực hiện hiển thị danh sách item trong 1 bảng,

 * thêm, sửa, xóa các iteam trong bảng

 * bao gồm cả phân trang, lọc, tìm kiếm, sắp xếp

 */

class MY_Table extends MY_Controller {

    /*

     * Các biến sử dụng gồm

     *      - kiểu text: hiển thị text (mặc định kiểu text nên ko cần truyền vào)

     *      - kiểu currency: kiểu giá cả ( 199.000 VNĐ)

     *      - kiểu datetime: giờ phút giây năm tháng ngày

     * $list_view_order: là 1 mảng các trường sẽ hiển thị (theo thứ tự)

     */

    /*

     * Biến chứa model tương ứng của danh mục

     */

    protected $model = '';

    /*

     * $conditional: biến lấy điều kiện khi hiển thị danh sách item,

     *      ví dụ khi hiển thị danh sách contact L8 thì điều kiện là cod_status_id = 3

     */

    private $conditional = '';

    /*

     *   $offset, $limit: dùng khi phân trang

     */

    private $offset = 0;

    private $limit = 0;

    /*

     * Biến khi hiển thị các trường thông tin của bảng ra ngoài view.

     * Mỗi trường là một mảng trong đó key là tên trường trong db, 

     * còn value là một mảng gồm các key: 

     * + type gồm có

     *      - type = text: hiển thị kiểu text (mặc định kiểu text nên cso thể ko cần truyền vào type = text)

     *      - type = currency: kiểu giá cả ( 199.000 VNĐ)

     *      - type = datetime: giờ phút giây năm tháng ngày

     *  + name_display: Tên hiển thị ra ngoài bảng

     *  + order (option): Sắp xếp theo trường đó

     *  + display = none : không hiển thị trường đó ra ngoài bảng

     */

    public $list_view = array();

    public $list_search = array();

    public $view_path = '';

    public $controller_path = '';

    /*

     * Phân trang

     */

    public $sub_folder = '';

    public $pagination_link = '';

    public $begin_paging = 0;

    public $end_paging = 0;

    public $total_paging = 0;

    public $num_segment = 3;

    /*

     * Chỉnh sửa item

     * Mỗi trường là một mảng trong đó key là tên trường trong db, 

     * còn value là một mảng gồm các key: 

     * + type gồm có

     *      - type = text: hiển thị kiểu text (mặc định kiểu text nên cso thể ko cần truyền vào type = text)

     *      - type = datetime: giờ phút giây năm tháng ngày (cho hiện datepicker)

     *      - type = custom

     *      - type = disable: không cho chỉnh sửa trường đó

     */

    public $list_edit = '';

    /*

     * Filter

     */

    public $list_filter = '';

    /*

     * add item

     */

    public $list_add = array();

    public $L = array(); //đếm số contact C3 hôm nay và tất cả

    public function __construct() {

        parent::__construct();

        $this->limit = $this->per_page;

        $this->data['load_js'] = array('common_real_filter_contact');

        $this->_loadCountListContact();

    }
    /*

     * Hàm hiển thị bảng các danh sách item

     * - Đầu vào: điều kiện query, điều kiện lọc, tìm kiếm, sắp xếp

     * - Đầu ra: danh sách item (lưu trong $this->data['rows']), tổng số item ( $this->data['total_rows'])

     * thông tin link phân trang ($this->pagination_link, $this->begin_paging,  $this->end_paging, $this->total_paging)

     * - Nếu ở controller con có cần thông tin gì thì viết thêm vào ở controller đó

     */
    public function index($offset = 0) {

        $conditional = array();

        $this->set_conditional($conditional);

        $this->set_offset($offset);

        $this->show_table();

        $data = $this->data;

        $data['slide_menu'] = 'manager/common/slide-menu';

        $data['top_nav'] = 'manager/common/top-nav';

        $data['list_title'] = 'Danh sách các danh mục';

        $data['edit_title'] = 'Sửa thông tin danh mục';

        $data['content'] = 'base/index';

        $data['load_js'] = array('common_real_filter_contact');

        $this->load->view(_MAIN_LAYOUT_, $data);

    }

    protected function show_table() {

        /* Lấy tổng các dòng*/

        $get = $this->input->get();
        unset($get['filter_date_date_happen']);

        $input_get_arr = $this->_get_query_condition_arr($get);

//         print_arr($get);

        /* Lấy điều kiện query từ các thao tác lọc, sắp xếp, tìm kiếm */

        $input_get = $input_get_arr['input_get'];

        $has_user_order = $input_get_arr['has_user_order'];

        $input_init = array();

        /* Lấy điều kiện query do người dùng truyền vào, ví dụ chỉ hiển thị danh sách contacts đã thu Lakita */

        if (!empty($this->conditional)) {

            foreach ($this->conditional as $key => $value) {

                if ($key == 'order' && $has_user_order == 1) {

                    continue;

                }

                if ($key == 'order') {

                    $has_user_order = 1;

                }
				
                $input_init[$key] = $value;

            }

        }

        /* Gộp 2 điều kiện query ta được điều kiện query tổng (lưu vào 1 mảng) */

        $input = array_merge_recursive($input_init, $input_get);

        $this->conditional = $input;

        $total_row = $this->{$this->model}->m_count_all_result_from_get($this->conditional);
		// print_arr($total_row);
        $this->data['total_rows'] = $total_row;

        /* lấy data sau khi phân trang
         * $offset_max, $offset_std: dùng để đề phòng khi người dùng cố tình nhập sau offset trên thanh URL */

        $offset_max = intval($total_row / $this->limit) * $this->limit;

        $offset_std = ($this->offset > $offset_max) ? $offset_max : ((($this->offset < 0) ? 0 : $this->offset));

        $this->offset = $offset_std;

        if ($this->limit != 0 || $this->offset != 0) {

            $this->conditional['limit'] = array($this->limit, $this->offset);

        }

        /* kiểm tra xem $this->conditional đã có order chưa, nếu chưa thì để mặc định là order theo id desc */

        if (!$has_user_order) {

            $this->conditional['order'] = array('id' => 'DESC');

        }

//        print_arr($this->conditional);

        $this->data['rows'] = $this->{$this->model}->load_all($this->conditional);
//		echoQuery();die();
//        print_arr($this->data['rows']);

        if ($this->controller == 'class_study') {
        	foreach ($this->data['rows'] as &$value) {
				$value['number_student'] = $this->get_student_current($value['class_study_id']);
				$value['notes'] = $this->get_note($value['id']);
			}
		}
        unset($value);

        // echoQuery();

        /* Thấy thông tin hiển thị phân trang: thông tin hiển thị contact đầu, contact cuối và tổng contact */

        $base_url = ($this->sub_folder == '') ? $this->controller . '/' . $this->method : $this->sub_folder . '/' . $this->controller . '/' . $this->method;

        $this->num_segment = ($this->sub_folder == '') ? 3 : 4;

        $this->pagination_link = $this->_create_pagination_link($total_row, $base_url, $this->num_segment);

        $this->begin_paging = ($total_row == 0) ? 0 : $this->offset + 1;

        $this->end_paging = (($this->offset + $this->limit) < $total_row) ? ($this->offset + $this->limit) : $total_row;

        $this->total_paging = $total_row;

    }

    function show_add_item() {

        $this->load->view('base/add_item/ajax_content');

    }

    function show_edit_item($inputData = []) {

        $canEdited = 1;

        $data = $inputData;

        $post = $this->input->post();

        $input = array();

        $input['where'] = array('id' => $post['item_id']);

        $rows = $this->{$this->model}->load_all($input);

        if (empty($rows)) {

            echo 'Không tồn tại danh mục này!';

            die;

        }

        if ($this->role_id != 7) {

            if (isset($rows[0]['marketer_id']) && $rows[0]['marketer_id'] != $this->user_id && $rows[0]['marketer_id'] != 0) {

                $canEdited = 0;

            }

        }

        if ($this->controller_path == 'staff_managers/class_study') {
            $this->load->model('notes_model');
            $input_note['where'] = array(
                'class_study_id' => $rows[0]['id']
            );
            $rows[0]['notes'] = $this->notes_model->load_all($input_note);
		}

		$data['canEdited'] = $canEdited;
		if ($this->role_id == 6 && $this->controller_path == 'MANAGERS/landingpage' && $this->method == 'show_edit_item') {
			$data['canEdited'] = 1;
		}

		if ($this->role_id == 6 && $this->controller_path == 'MANAGERS/landingpage' && $this->method == 'show_plugin_landingpage') {
            $data['canEdited'] = 1;

            $rows[0]['clock_plugin'] = "<style>
					.timer-label {    font-family: Open Sans, sans-serif;    font-weight: 400;    display: inline;    margin: 0 28px; margin: 0px 25px;}
					.timer-box {background-color: #7e0000;    display: inline-block;    float: left;    margin: 19px 13px;    padding: 17px 10px 6px;}
					.timer-values { font-size: 36px !important; }
					#HTML496 { width: 48% !important; float: left; left: 0 !important; top: 200px !important; }
					#HTML494 { width: 48% !important; float: right; right: 0 !important; top: 200px !important;}
					#element-2555 div.timer {
						width: 360px;
						height: 90px;
					}
					#element-2555 div.timer-labels {
						font-size: 12px;
						color: #ffffff;
					}
					#element-2555 div.timer-labels div.timer-label {
						font-family: Open Sans, sans-serif;
						font-weight: 400;
					}
					#element-2555 span.timer-values {
						font-size: 54px;
						color: rgb(255, 255, 255);
					}
					#element-2555 div.timer-box {
						background-color: #860f0f;
						border-radius: 5px;
					}
					#element-2555 div.colon div {
						background-color: #860f0f;
					}
					#element-2555 div.colon div {
						background-color: #860f0f;
					}
				</style>
				<div class='page-element widget-container page-element-type-timer widget-timer' id='element-2555'>
					<div id='timer-widget-2555' class='widget-container widget-timer'>
						<div class='timer  eng '>
							<div class='timer-labels'>
								<div class='timer-label first-label'>NGÀY</div>
								<div class='timer-label'>GIỜ</div>
								<div class='timer-label'>PHÚT</div>
								<div class='timer-label'>GIÂY</div>
							</div>
							<div class='days timer-box'>
								<span class='timer-values'>00</span>
							</div>
							<div class='colon'>
								<div class='colon-top'></div>
								<div class='colon-bottom'></div>
							</div>
							<div class='hours timer-box'>
								<span class='timer-values num-hour'>07</span>
							</div>
							<div class='colon'>
								<div class='colon-top'></div>
								<div class='colon-bottom'></div>
							</div>
							<div class='minutes timer-box'>
								<span class='timer-values num-minute'>24</span>
							</div>
							<div class='colon'>
								<div class='colon-top'></div>
								<div class='colon-bottom'></div>
							</div>
							<div class='seconds timer-box'>
								<span class='timer-values num-second'>47</span>
							</div>
						</div>
					</div>
					<script type='text/javascript'>
						setInterval(function () {
							countdown();
						}, 1000);
						function countdown() {
							console.log(1);
							var d = new Date();
							var r_hours = 24 - d.getHours();
							r_hours = (r_hours < 10) ? '0' + r_hours : r_hours;
							var r_minus = 59 - d.getMinutes();
							r_minus = (r_minus < 10) ? '0' + r_minus : r_minus;
							var r_seconds = 59 - d.getSeconds();
							r_seconds = (r_seconds < 10) ? '0' + r_seconds : r_seconds;
			
							$('.num-hour').text(r_hours);
							$('.num-minute').text(r_minus);
							$('.num-second').text(r_seconds);
						}
					</script>
				</div>";

            $this->load->model('branch_model');
			$input = array();
            $input['where'] = array(
            	'active' => 1,
				'location_id !=' => '0'
			);
            $branch = $this->branch_model->load_all($input);

            $this->load->model('level_language_model');
            $input_level['where'] = array(
            	'active' => 1,
				'language_id' => $rows[0]['language_id'],
				'use_in_ladipage' => 1
			);
			$level_language = $this->level_language_model->load_all($input_level);

			$action = 'https://crm2.sofl.edu.vn/cam-on-da-dang-ky.html';
			
            $rows[0]['form_plugin'] = '<div class="widget-content">
				<form class="form-border-white e_submit e_form_submit" role="form" id="dang-ky-2" method="POST"  name="fr_register" action="'.$action.'">
					<div class="form-input"><input type="text" required="required" name="name" placeholder="Họ tên *"></div>
					<!--<div class="form-input"><input type="text" name="email" placeholder="Email *"></div>-->
					<div class="form-input"><input type="text" required="required" name="phone" placeholder="Số điện thoại *"></div>
					<div class="form-input">
						<select name="branch_id">
							<option>Chọn cơ sở gần bạn nhất</option>';
							foreach ($branch as $value) {
								$rows[0]['form_plugin'] .= "<option value='{$value['id']}'>{$value['name']} : {$value['address']}</option>";
							}
			$rows[0]['form_plugin'] .= '</select>
					</div>';

			$rows[0]['form_plugin'] .= '<div class="form-input">
				<select name="level_language_id" required="required">
					<option>Chọn học mà bạn quan tâm</option>';

					foreach ($level_language as $value) {
						$rows[0]['form_plugin'] .= "<option value='{$value['id']}'>{$value['name']}</option>";
					}
					
			$rows[0]['form_plugin'] .= '</select>
					</div>';

			$rows[0]['form_plugin'] .= '<input type="hidden" value="" name="link_id" />
					<input type="hidden" value="'.$rows[0]['code'].'" name="code_landingpage" />
					<div class="form-input"><input type="text" name="source_id" placeholder="Không bắt buộc"></div>
					<div class="btn-submit e_btn_submit"><button type="submit">ĐĂNG KÝ</button></div>
				</form>

				<style>
					.form-border-white input[type="text"] {
						width: 100%;
						outline: none;
						font-size: 15px;
						font-weight: 500;
						line-height: 40px;
						height: 40px;
						margin-right: 0px;
						background: #fff;
						border: none;
						outline: none;
						margin-bottom: 0px;
						padding: 0px;
						color: #000;
					}
					.form-border-white select{
						width: 100%;
						outline: none;
						font-size: 15px;
						font-weight: 500;
						line-height: 40px;
						height: 40px;
						margin-right: 0px;
						background: #fff;
						border: none;
						outline: none;
						margin-bottom: 0px;
						padding: 0px;
						color: #000;
					}
					.form-border-white .btn-submit button {
						color: #ffe305;
						text-decoration: none;
						font-size: 24px;
						background: #c9302c;
						width: 100%;
						border-radius: 5px;
						line-height: 45px;
						font-weight: bold;
						-webkit-transition: all 0.3s ease-in-out;
						-o-transition: all 0.3s ease-in-out;
						transition: all 0.3s ease-in-out;
					}
					.form-border-white .btn-submit button:hover {
						background-color: #6bc5e6;
					}
					.form-border-white .form-input {
						background: #fff;
						border-radius: 20px;
						margin-bottom: 10px;
						padding: 0 20px;
						border: solid 2px #9da0a5;
					}
				</style>
				</div>
				<script>
					var $_GET = {};
					document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
						function decode(s) {
							return decodeURIComponent(s.split("+").join(" "));
						}
						$_GET[decode(arguments[1])] = decode(arguments[2]);
					});';

			$rows[0]['form_plugin'] .= '$("';
			$rows[0]['form_plugin'] .= "input[name='link_id']";
			$rows[0]['form_plugin'] .= '").val(($_GET["link"]) ? $_GET["link"] : 0);$.get( "https://lakita.vn/landingpage/save_c2", { link: ($_GET["link"]) ? $_GET["link"] : 0 } );</script>';

			$rows[0]['fb_cmt_plugin'] = '<div class="row receiveLetter" style="display:none;">
				<form id ="myform" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post">
				<!-- Tên -->
				name: <input type="text" id="name_grp" name="name"/><br/>
				<!-- Trường email (bắt buộc) -->
				email: <input type="text" id="email_grp" name="email"/><br/>
				<!-- Mã thông báo chiến dịch -->
				<!-- Nhận mã thông báo tại: https://app.getresponse.com/campaign_list.html https://app.getresponse.com/campaign_list.html -->
				<input type="hidden" name="campaign_token" value="arq1i" />
				<!-- Nút Người đăng ký -->
				<input id="sub_mail" type="submit" value="Subscribe"/>
				</form>
				</div>';

			$rows[0]['fb_cmt_plugin'] .= "<div id='fb-root'></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0&appId=162078224495583&autoLogAppEvents=1';
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class='container'>
					<div class='fb-comments' data-href='" . $rows[0]['url'] . "' data-width='100%' data-numposts='10' data-order-by='reverse_time'></div>
				</div>";


			$rows[0]['header_plugin'] = '<meta property="fb:admins" content="100004021107387"/>
				<meta property="fb:app_id" content="162078224495583" />
				<link rel="shortcut icon" href="http://crm.sofl.edu.vn/style/img/logo.png" type="image/x-icon" />
				<script src="https://code.jquery.com/jquery-3.3.1.js" 
					integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
				</script>
					<!-- Hotjar Tracking Code for https://lakita.vn/ -->
				<script>
					(function(h,o,t,j,a,r){
						h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
						h._hjSettings={hjid:1123274,hjsv:6};
						a=o.getElementsByTagName("head")[0];
						r=o.createElement("script");r.async=1;
						r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
						a.appendChild(r);
					})(window,document,"https://static.hotjar.com/c/hotjar-",".js?sv=");
				</script>
				<!-- Global site tag (gtag.js) - Google Analytics -->
				<script async src="https://www.googletagmanager.com/gtag/js?id=UA-86217325-2"></script>
				<script>
				  window.dataLayer = window.dataLayer || [];
				  function gtag(){dataLayer.push(arguments);}
				  gtag("js", new Date());
				  gtag("config", "UA-86217325-2");
				</script>';

			$rows[0]['header_plugin'] .= '<script src="http://crm.sofl.edu.vn/syle/js/my2.js" type="text/javascript"></script>';
			$rows[0]['header_plugin'] .= '<script type="text/javascript" src="http://crm.sofl.edu.vn/syle/js/realtime_popuprealtime_popup.js"></script>';

//			print_arr($rows);

			$data['edit_title'] = 'Thành phần gắn Landingpage';
			$data['landingpage_hide'] = 1;

		}

        $data['row'] = $rows[0];

        $this->load->view('base/edit_item/ajax_content', $data);

    }

    public function delete_item() {

        $post = $this->input->post();

        if (!empty($post['item_id'])) {

            $where = array('id' => $post['item_id']);

            $this->{$this->model}->delete($where);

            echo '1';

        }

    }

    public function delete_multi_item() {

        $post = $this->input->post();

        if (!empty($post['item_id'])) {

            foreach ($post['item_id'] as $value) {

                $where = array('id' => $value);

                $this->{$this->model}->delete($where);

            }

        }

        show_error_and_redirect('Xóa thành công các dòng đã chọn!');

    }

    public function edit_active() {

        $post = $this->input->post();

        if (!empty($post['item_id'])) {

            $where = array('id' => $post['item_id']);

            $data = array('active' => $post['active']);

            $this->{$this->model}->update($where, $data);

            echo '1';

        }

    }

    protected function _get_query_condition_arr($get) {

        $input_get = array();

        $has_user_order = 0; //cờ kiểm tra nếu người dùng chọn order rồi thì ko order mặc định là id nữa

//        print_arr($get);

        if (is_array($get) && !empty($get)) {

            foreach ($get as $key => $value) {

                /* tìm kiếm tại ô trong bảng*/

                if (strpos($key, "find_") !== FALSE && $value != '') { //nếu tồn tại biến get tìm kiếm

                    $column_name = substr($key, strlen("find_"));

                    $input_get['like'][$column_name] = $value;

                }

                /* tìm kiếm tại ô trong bảng (các ô cố định khi người dùng cuộn chuột xuống)*/
                /*
                if (strpos($key, "search_") !== FALSE && $value != '') { //nếu tồn tại biến get tìm kiếm

                    $column_name = substr($key, strlen("search_"));

                    $input_get['like'][$column_name] = $value;

                }*/
                /*
                 *  search all
                 */
                if (isset($get['search_all']) && trim($get['search_all']) != '') {

					$searchStr = trim($get['search_all']);

					$input_get['group_start_like']['phone'] = $searchStr;

					$input_get['or_like']['phone_foreign'] = $searchStr;

					$input_get['or_like']['name'] = $searchStr;

					$input_get['or_like']['email'] = $searchStr;

//					$input_get['or_like']['matrix'] = $searchStr;

					$input_get['group_end_or_like']['id'] = $searchStr;

				}

                if (isset($get['filter_class_id']) && trim($get['filter_class_id']) != '') {
                	$search_class = trim($get['filter_class_id']);
                	$input_get['like']['class_study_id'] = $search_class;
                	$input_get['or_like']['id'] = $search_class;
                	$input_get['or_like']['name_class'] = $search_class;
				}
                
                if ($key == 'filter_distance') {
                	if ($value == 'gd2') {
						$input_get['where']['lesson_learned = FLOOR(total_lesson/2)'] = 'NO-VALUE';
						$input_get['where']['character_class_id'] = 2;
					} else if ($value == 'gd3') {
                		$input_get['where']['FLOOR(total_lesson - lesson_learned) <= 3'] = 'NO-VALUE';
                		$input_get['where']['FLOOR(total_lesson - lesson_learned) > 0'] = 'NO-VALUE';
//						$query = 'FLOOR((`time_end_expected` - ' . time() . ') / (60 * 60 * 24)) = 9';
//						$input_get['where'][$query] = 'NO-VALUE';
					}
				}

                /*sắp xếp*/
                if (strpos($key, "order_new_") !== FALSE && $value != '0' && $value != '') { //nếu tồn tại biến get order

                    $column_name = substr($key, strlen("order_new_"));

                    $input_get['order'][$column_name] = $value;

                    $has_user_order = 1;

                }

                /* lọc theo các loại ngày */

                if (strpos($key, "filter_date_from_") !== FALSE && $value != '') {

                    $column_name = substr($key, strlen("filter_date_from_"));

                    $input_get['where'][$column_name . '>='] = strtotime($value);

                }

                if (strpos($key, "filter_date_end_") !== FALSE && $value != '') {

                    $column_name = substr($key, strlen("filter_date_end_"));

                    $input_get['where'][$column_name . '<='] = strtotime($value) + 3600 * 24 - 1;

                }

                if (strpos($key, "filter_date_") !== FALSE && $value != '') {

                    $dateArr = explode('-', $value);

                    $date_from = trim($dateArr[0]);

                    $date_from = strtotime(str_replace("/", "-", $date_from));

                    $date_end = trim($dateArr[1]);

                    $date_end = strtotime(str_replace("/", "-", $date_end));

                    $column_name = substr($key, strlen("filter_date_"));

                    $input_get['where'][$column_name . '>='] = $date_from;

                    $input_get['where'][$column_name . '<='] = $date_end;

                }

                /*Lọc theo mảng (chọn nhiều)*/
                if (strpos($key, "filter_arr_multi_") !== FALSE && !empty($value)) {

                    $column_name = substr($key, strlen("filter_arr_multi_"));

                    if ($column_name == 'teacher_id') $column_name = 'id';

                    $input_get['where_in'][$column_name] = $value;

                } elseif (strpos($key, "filter_arr_") !== FALSE && !empty($value)) {

					$column_name = substr($key, strlen("filter_arr_"));

					$input_get['where'][$column_name] = $value;
				}

                /*Lọc nhị phân*/

                if (strpos($key, "filter_binary_") !== FALSE && $value == 'yes') {

                    $column_name = substr($key, strlen("filter_binary_"));

                    $input_get['where'][$column_name . '!='] = '0';

                }

                if (strpos($key, "filter_binary_") !== FALSE && $value == 'no') {

                    $column_name = substr($key, strlen("filter_binary_"));

                    $input_get['where'][$column_name] = '0';

                }

            }

        }


        return array(

            'input_get' => $input_get,

            'has_user_order' => $has_user_order

        );

    }

    public function set_conditional($conditional) {

        $this->conditional = $conditional;

    }

    public function get_conditional() {

        return $this->conditional;

    }

    public function set_offset($offset) {

        $this->offset = $offset;

    }

    public function get_offset() {

        return $this->offset;

    }

    public function set_limit($limit) {

        $this->limit = $limit;

    }

    public function get_limit() {

        return $this->limit;

    }

    public function set_model($model) {

        $this->model = $model;

    }

    public function get_model() {

        return $this->model;

    }

    public function set_list_view($list_view) {

        $this->list_view = $list_view;

    }

    protected function _loadCountListContact() {

        $input = array();

        $input['select'] = 'id';

        $input['where']['date_rgt >'] = strtotime(date('d-m-Y'));

		$input['where']['marketer_id'] = $this->user_id;

        $this->L['C3'] = count($this->contacts_model->load_all($input));

        $input = array();

        $input['select'] = 'id';

		$input['where']['marketer_id'] = $this->user_id;

        $this->L['all'] = count($this->contacts_model->load_all($input));

    }

    protected function GetProccessMarketerToday() {

        $marketers = $this->staffs_model->GetActiveMarketers();

        foreach ($marketers as $key => &$marketer) {

            if ($marketer['username'] == 'trinhnv2' || $marketer['username'] == 'congnn2') {

                unset($marketers[$key]);

                continue;

            }

            $inputContact = array();

            $inputContact['select'] = 'id';

            $inputContact['where'] = array('marketer_id' => $marketer['id'], 'date_rgt >' => strtotime(date('d-m-Y')));

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

        // print_arr($marketers);

        return array('marketers' => $marketers, 'C3Team' => $C3Team);

    }

    protected function GetProccessMarketerThisMonth() {

        $marketers = $this->staffs_model->GetActiveMarketers();

        foreach ($marketers as $key => &$marketer) {

            $inputContact = array();

            $inputContact['select'] = 'id';

            $inputContact['where'] = array('marketer_id' => $marketer['id'], 'date_rgt >' => strtotime(date('01-m-Y')));

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

        $inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')));

        $today = $this->contacts_model->load_all($inputContact);

        $C3Team = count($today);

        // print_arr($marketers);

        return array('marketers' => $marketers, 'C3Team' => $C3Team);

    }

	protected function get_data_from_model($table, $key='') {
		$model = $table . '_model';
		$this->load->model($model);

		$input = array();

		$input['where']['active'] = '1';

//		các điều kiện lấy dữ liệu từng bảng và dùng cho thêm mới, chỉnh sửa
		if ($key != 'show') {
			if ($table == 'class_time') {
				$input['where']['empty'] = '0';
			}
		}

		$table = $this->{$model}->load_all($input);

		return $table;
	}

	private function get_student_current($class_id) {
    	$input['where'] = array(
    		'class_study_id' => $class_id,
			'level_contact_id' => 'L5',
			'level_contact_detail !=' => 'L5.4',
		);
        $input['where_in']['level_study_id'] = array('L7', '');
    	return count($this->contacts_model->load_all($input));
	}

	private function get_note($class_id) {
    	$this->load->model('notes_model');
		$input = array();
		$input['where'] = array('class_study_id' => $class_id);
		$input['order'] = array('id' => 'DESC');
		$last_note = $this->notes_model->load_all($input);
		$notes = '';
		if (!empty($last_note)) {
			$notes .= '<p>' . date('d/m/Y', $last_note[0]['time_created']) . ' ==> ' . $last_note[0]['content'] . '</p>';
//			foreach ($last_note as $value2) {
//				$notes .= '<p>' . date('d/m/Y', $value2['time_created']) . ' ==> ' . $value2['content'] . '</p>';
//			}
		}
		return $notes;
	}

//	public function search($offset = 0) {
//		parent::search($offset); // TODO: Change the autogenerated stub
//	}

}

