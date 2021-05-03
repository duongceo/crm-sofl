
<?php  $class_contact = ($this->agent->is_mobile()) ? '' : 'list_contact list_contact_2';?>
<div class="table-responsive">

	<table class="table table-bordered table-striped table-fixed-head <?php echo  $class_contact ?>">

		<?php

		$data['head_tbl'] = $this->list_view;
	//    echo'<pre>';print_r($data);die();

		$this->load->view('base/show_table/content/head', $data);

	   // $this->load->view('base/show_table/content/search', $data);

		$this->load->view('base/show_table/content/body', $data);

		?>

	</table>

</div>

<input type="submit" class="hidden" id="submit_get_form"/>



