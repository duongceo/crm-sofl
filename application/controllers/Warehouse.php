<?php

// manager email warehouse
/**
 * Warehouse
 */
class Warehouse extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->L['C3'] = '';
    }

    function index() {
        $this->load->library('form_validation');
        $this->load->model('Channel_model');
        $this->load->helper('security');

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Channel', 'required|xss_clean');

            if ($this->form_validation->run()) {
                
            }
        }

        $this->load->model('Warehouse_model');
        $total = $this->Warehouse_model->m_count_all_result_from_get(array());
        $per_page = 20;
        $index = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $input = array(
            'limit' => array($per_page, $index)
        );
        $this->data['warehouses'] = $this->Warehouse_model->load_all($input);

        // Phân trang
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'warehouse/index/';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $data['list_title'] = 'Danh sách các Kho';

        $data['edit_title'] = 'Sửa thông tin Kho';
        $this->data['total'] = $total;
        $this->data['pagination_link'] = $this->pagination->create_links();
        $this->data['content'] = 'warehouse/index';

        $this->load->view(_MAIN_LAYOUT_, $this->data);
    }

    function create() {

        $post = $this->input->post();

        if (!empty($post)) {

            if (trim($post['name']) == '') {

                redirect_and_die('Hãy nhập tên kho!');
            }

            $param = array(
                'name' => $post['name'],
                'lakita' => isset($post['lakita']) ? 1 : 0,
                'active' => isset($post['active']) ? 1 : 0,
                'creater' => $post['creater']
            );
            $this->load->model('Warehouse_model');

            $this->Warehouse_model->insert($param);

            show_error_and_redirect('Thêm kho mới thành công!');
        }
    }

    function edit() {
        
    }

    function edit_active() {
        
    }

    // Nhập chi phí marketing hàng tháng cho các kho
    function cost() {
        $this->load->model('Warehouse_model');
        $this->load->model('Cost_warehouse_model');

        $input = array();

        $input['where'] = array('active' => 1);

        $warehouses = $this->Warehouse_model->load_all($input);
        /*
          $input = array();
          $input['order'] = array('created' => 'DESC');
          $logs = $this->Cost_warehouse_model->load_all($input); */


        $this->data['warehouses'] = $warehouses;
        //$this->data['logs'] = $logs;
        $this->data['content'] = 'warehouse/cost';
        $this->load->view(_MAIN_LAYOUT_, $this->data);
    }

    // Khi click nhập chi phí
    function action_add_cost() {
        $this->load->helper('common_helper');
        $this->load->model('cost_warehouse_model');
        $post = $this->input->post();

        if ($post) {
            $warehouse_id = $post['warehouse_id'];
            $value = $post['value'];
            $date = $post['date'];
            $date = explode('-', $date);
            $year = $date[0];
            $month = $date[1];
            $num_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $spend = round($value / $num_day);
            $error = 0;
            for ($i = 1; $i <= $num_day; $i++) {
                $data = array();
                $data['warehouse_id'] = $warehouse_id;
                $data['time'] = strtotime($i . '-' . $month . '-' . $year);
                $data['spend'] = $spend;

                $input = array();
                $input['where']['warehouse_id'] = $warehouse_id;
                $input['where']['time'] = strtotime($i . '-' . $month . '-' . $year);

                $exist = $this->cost_warehouse_model->load_all($input);
                if ($exist) {
                    if ($this->cost_warehouse_model->update(array('id' => $exist[0]['id']), $data)) {
                        $error = 0;
                    } else {
                        $error = 1;
                    }
                } else {
                    if ($this->cost_warehouse_model->insert($data)) {
                        $error = 0;
                    } else {
                        $error = 1;
                    }
                }
            }

            if ($error == 0) {
                $response = array(
                    'notify' => '<p class="cost-errors text-danger">Nhập chi phí thành công!</p>'
                );
            } else {
                $response = array(
                    'notify' => '<p class="cost-errors text-danger">Có lỗi xảy ra!</p>'
                );
            }
            die(json_encode($response));
            /*
              if ($this->Cost_warehouse_model->insert($data)) {
              $this->load->model('Warehouse_model');
              $input = array(
              'select' => array('name'),
              'where' => array('id' => $data['warehouse_id'])
              );
              $response = array(
              'notify' => '<p class="cost-success text-success">Thao tác thành công!</p>',
              'warehouse_name' => $this->Warehouse_model->load_all($input)[0],
              'month' => $data['month'],
              'value' => $data['value'],
              'creater' => $data['creater']
              );
              die(json_encode($response));
              } else {
              $response = array(
              'notify' => '<p class="cost-errors text-danger">Có lỗi xảy ra, có thể đã nhập rồi!</p>'
              );
              die(json_encode($response));
              } */
        } else {
            redirect();
        }
    }

}

?>