<?php

class Log_study_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'log_study';
    }
}

