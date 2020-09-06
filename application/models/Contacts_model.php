<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contact_model
 *
 * @author CHUYEN
 */
class Contacts_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'contact';
    }

    function load_all_contacts($input) {
        $this->load->model('Staffs_model');
        $contacts = $this->load_all($input);
        if (!empty($contacts)) {
            foreach ($contacts as $key => $value) {
                $contacts[$key]['staff_name'] = $this->Staffs_model->find_staff_name($value['sale_staff_id']);
            }
        }
        return $contacts;
    }

    public function get_contact_code($id) {
        $code = '';
        $input = array();
        $input['where'] = array('id' => $id);
        $rows = $this->load_all($input);
        $code = $rows[0]['phone'] . '_' . $rows[0]['level_language_id'];
        return $code;
    }

    function get_contact_phone($id) {
        $code = '';
        $input = array();
        $input['where'] = array('id' => $id);
        $rows = $this->load_all($input);
        $code = $rows[0]['phone'];
        return $code;
    }
	
	//Quét các contact
    function check_account() {
        $day_check = strtotime(date('Y-m-d H:i:s'));
        $day_check = strtotime('17-07-2019');
       // $day_check = $day_check - 14400;
        $input = array();
		$input['select'] = 'id, name, phone, email, course_code, ordering_status_id, date_confirm, payment_method_rgt, id_lakita';
        $input['where'] = array(
            'ordering_status_id' => 4,
            'date_confirm >=' => $day_check,
            'payment_method_rgt' => 1,
            'id_lakita' => '0'
        );
        $rows = $this->load_all($input);
        return $rows;
    }

    function call_pr(){
        $query = $this->db->query("CALL pr_delete_contact_test()");
    }

}
