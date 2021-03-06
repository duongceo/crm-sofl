<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Ten table
    protected $table = '';

    function insert($data) {
        $result = FALSE;
        $data2 = array();
        foreach ($data as $key => $value) {
            $data2[$key] = htmlentities($value);
        }
        if ($this->db->insert($this->table, $data2)) {
            $result = TRUE;
        }
        return $result;
    }

    function insert_return_id($data, $field) {
        $data2 = array();
        foreach ($data as $key => $value) {
            $data2[$key] = htmlentities(($value));
        }
        $this->db->insert($this->table, $data2);
        $sql = "SELECT MAX($field) AS id FROM tbl_" . $this->table;
        $admin = $this->db->query($sql)->result();
        return $admin[0]->id;
    }

    function insert_from_mol($data) {
        $this->db->insert($this->table, $data);
    }

    function find($id) {
        $this->db->where('id', $id);
        //thuc hien truy van du lieu
        $query = $this->db->get($this->table);
        //echo $this->db->last_query();
        return $query->result_array();
    }

    function update($where = array(), $data = array()) {
        $result = FALSE;
        foreach ($where as $key => $value) {
            if ($value == "NO-VALUE") {
                $this->db->where($key);
            } else {
                $this->db->where($key, $value);
            }
        }
        $this->db->update($this->table, $data);
        if ($this->db->affected_rows() >= 0) {
            $result = TRUE;
        }
        return $result;
    }

    function delete($where) {
        $result = FALSE;
        if (isset($where) && !empty($where)) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
            $this->db->delete($this->table);
        }
        if ($this->db->affected_rows() >= 0) {
            $result = TRUE;
        }
        return $result;
    }
    
     function delete_all() {
        $this->db->empty_table($this->table);
    }

    /**
     * Th???c hi???n c??u l???nh query
     * tr??? v??? s??? d??ng query ??c
     */
    function query($sql) {
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    // tr??? v??? k???t qu??? query v??o m???ng
    function query2($sql) {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Lay danh sach
     * $input : mang cac du lieu dau vao
     */
    function load_all($input = array()) {
        $data = array();
//    	print_arr($input);
        //xu ly ca du lieu dau vao
        $this->get_list_set_input($input);

//        echo '<pre>';print_r($input);die();
        //thuc hien truy van du lieu
        $query = $this->db->get($this->table);
        //echo $this->db->last_query();
        if ($query !== FALSE && $query->num_rows() > 0) {
            $data = $query->result_array();
        }
        // return $query->result_array();
        return $data;
        //var_dump($query->result_array());
    }

    /**
     * Gan cac thuoc tinh trong input khi lay danh sach
     * $input : mang du lieu dau vao
     */
    protected function get_list_set_input($input = array()) {
        // Th??m ??i???u ki???n cho c??u truy v???n truy???n qua bi???n $input['select'] 
        //(vi du: $input['select'] = '';
        if (isset($input['select'])) {
            $this->db->select($input['select']);
        }
        
        if(isset($input['distinct'])){
             $this->db->distinct();
             $this->db->select($input['distinct']);
        }

        // Th??m ??i???u ki???n cho c??u truy v???n truy???n qua bi???n $input['where'] 
        //(vi du: $input['where'] = array('email' => 'hocphp@gmail.com'))
        if (isset($input['where']) && !empty($input['where'])) {
            //print_r($input['where']);
            foreach ($input['where'] as $key => $value) {
                if ($value == "NO-VALUE") {
                    $this->db->where($key);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        if (isset($input['group_start_where']) && !empty($input['group_start_where'])) {
            $this->db->group_start();
            foreach ($input['group_start_where'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if (isset($input['or_where']) && !empty($input['or_where'])) {
            foreach ($input['or_where'] as $key => $value) {
                $this->db->or_where($key, $value);
            }
        }
		
		if (isset($input['or_where_in']) && !empty($input['or_where_in'])) {
            foreach ($input['or_where_in'] as $key => $value) {
                $this->db->or_where_in($key, $value);
            }
        }

        if (isset($input['group_end_or_where']) && !empty($input['group_end_or_where'])) {
            foreach ($input['group_end_or_where'] as $key => $value) {
                $this->db->or_where($key, $value);
            }
            $this->db->group_end();
        }

        //where in
        if (isset($input['where_in']) && !empty($input['where_in'])) {
            foreach ($input['where_in'] as $key => $value) {
                $this->db->where_in($key, $value);
            }
        }

        //where not in
        if (isset($input['where_not_in']) && !empty($input['where_not_in'])) {
            foreach ($input['where_not_in'] as $key => $value) {
                $this->db->where_not_in($key, $value);
            }
        }

        //like
        // $input['like'] = array('name' => 'abc');
        if ((isset($input['like'])) && !empty($input['like'])) {
            foreach ($input['like'] as $key => $value) {
                $this->db->like($key, $value);
            }
        }

        //like group_start
        // $input['like'] = array('name' => 'abc');
        if ((isset($input['group_start_like'])) && !empty($input['group_start_like'])) {
            $this->db->group_start();
            foreach ($input['group_start_like'] as $key => $value) {
                $this->db->like($key, $value);
            }
        }

        // $input['like_before'] = array('name' => 'abc');
        if ((isset($input['like_before'])) && !empty($input['like_before'])) {
            foreach ($input['like_before'] as $key => $value) {
                $this->db->like($key, $value, 'before');
            }
        }

        // $input['like_after'] = array('name' => 'abc');
        if ((isset($input['like_after'])) && !empty($input['like_after'])) {
            foreach ($input['like_after'] as $key => $value) {
                $this->db->like($key, $value, 'after');
            }
        }

        //not like
        // $input['not_like'] = array('name' => 'abc');
        if ((isset($input['not_like'])) && !empty($input['not_like'])) {
            foreach ($input['not_like'] as $key => $value) {
                $this->db->not_like($key, $value);
            }
        }

        // $input['not_like_before'] = array('name' => 'abc');
        if ((isset($input['not_like_before'])) && !empty($input['not_like_before'])) {
            foreach ($input['not_like_before'] as $key => $value) {
                $this->db->not_like($key, $value, 'before');
            }
        }

        // $input['not_like_after'] = array('name' => 'abc');
        if ((isset($input['not_like_after'])) && !empty($input['not_like_after'])) {
            foreach ($input['not_like_after'] as $key => $value) {
                $this->db->not_like($key, $value, 'after');
            }
        }

        // $input['or_like'] = array('name' => 'abc');
        if ((isset($input['or_like'])) && !empty($input['or_like'])) {
            foreach ($input['or_like'] as $key => $value) {
                $this->db->or_like($key, $value);
            }
        }

        // group_end
        if ((isset($input['group_end_or_like'])) && !empty($input['group_end_or_like'])) {
            foreach ($input['group_end_or_like'] as $key => $value) {
                $this->db->or_like($key, $value);
            }
            $this->db->group_end();
        }

        // Th??m s???p x???p d??? li???u th??ng qua bi???n $input['order']
        if (isset($input['order']) && !empty($input['order'])) {
            foreach ($input['order'] as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        // Th??m ??i???u ki???n limit cho c??u truy v???n th??ng qua bi???n $input['limit'] 
        //(v?? d??? $input['limit'] = array('10' ,'0')) 
        if (isset($input['limit'][0]) && isset($input['limit'][1])) {
            $this->db->limit($input['limit'][0], $input['limit'][1]);
        }

        //nh??m
        if (isset($input['group_by']) && !empty($input['group_by'])) {
            foreach ($input['group_by'] as $value) {
                $this->db->group_by($value);
            }
        }
        
        //l???y nh???ng d??? li???u th???a m??n 
        if (isset($input['having']) && !empty($input['having'])) {
            foreach ($input['having'] as $key => $value) {
                $this->db->having($key, $value); 
            }
        }

//		if (isset($input['join']) && !empty($input['join'])) {
//			$this->db->join($input['join'], 'tbl_call_log.contact_id = tbl_contact.id');
//		}

    }

    function m_count_all_result_from_get($input) {
//		if (isset($input['join']) && !empty($input['join'])) {
//			$this->db->select('tbl_contact.id');
//		} else {
//			$this->db->select('id');
//		}
		$this->db->select('id');
        $this->db->from($this->table);
        $this->get_list_set_input($input);
		return $this->db->count_all_results();
	}

    function check_exists($where = array()) {
        $result = FALSE;
        $this->db->where($where);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $result = TRUE;
        }
        return $result;
    }

}
