<?php 

/**
 * 
 */
class Campaign_spend_model extends MY_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'campaign_spend';
	}
}

?>