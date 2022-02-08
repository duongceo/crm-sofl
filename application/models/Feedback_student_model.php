<?php

class Feedback_student_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'feedback_student';
    }

}
