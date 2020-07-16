<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Config extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function sale() {
        $sale_id = $this->input->post('sale_id');
        if (isset($sale_id)) {
            $this->load->model('staffs_model');
            $this->staffs_model->update([], array('active' => '0'));
            $where = array('id' => $sale_id);
            $data = array('active' => 1);
            $this->staffs_model->update_where_in($where, $data);
            show_error_and_redirect('Cập nhật thành công!');
        }
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            )
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        switch ($this->user_id) {
            case 1: {
				$data['slide_menu'] = 'manager/common/slide-menu';
				$data['top_nav'] = 'manager/common/top-nav';
				break;
			}
        }

        $data['content'] = 'config/sale';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
    
    public function course() {
        $course_id = $this->input->post('course_id');
        if (isset($course_id)) {
            $this->load->model('courses_model');
            $this->courses_model->update([], array('active' => '0'));
            $where = array('id' => $course_id);
            $data = array('active' => 1);
            $this->courses_model->update_where_in($where, $data);
            show_error_and_redirect('Cập nhật thành công!');
        }
        $require_model = array(
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
//        echo '<pre>';
//        print_r($data);
//        die();
        switch ($this->user_id) {
            case 1: {
            	$data['slide_menu'] = 'manager/common/slide-menu';
            	$data['top_nav'] = 'manager/common/top-nav';
            	break;
            }
        }

        $this->load->model('group_course_model');
        $this->load->model('brand_model');
        $input['where'] = array('active' => 1);
		$data['group_course'] = $this->group_course_model->load_all($input);
		$data['brand'] = $this->brand_model->load_all(array('where' => array('active' => 1)));
//		echo '<pre>';print_r($data);die();
        $data['content'] = 'config/course';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    public function update_course() {
    	$post = $this->input->post();
		//var_dump($post);die();
		$this->load->model('courses_model');
		$where = array('id' => $post['id']);
		$data = array('group_course_id' => $post['group_course_id'], 'brand_id' => $post['brand_id']);
		$this->courses_model->update($where, $data);
		show_error_and_redirect('Cập nhật thành công!');
	}

}
