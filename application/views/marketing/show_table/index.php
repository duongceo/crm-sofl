
<style>
#th_fix_id_2 {
	width: 42px;
}

#th_fix_id_4 {
	width: 38px;
}

#th_fix_id_5 {
	width: 35px;
}

#th_fix_id_7 {
	width: 30px;
}

#th_fix_id_11 {
	width: 45px;
}
#th_fix_id_12 {
	width: 40px;
}

#th_fix_id_13 {
	width: 40px;
}
</style>

<table class="table table-bordered table-striped list_contact list_contact_2 table-fixed-head">

    <?php

    $data['head_tbl'] = $this->list_view;

    $this->load->view('marketing/show_table/content/head', $data);

    $this->load->view('marketing/show_table/content/search', $data);

    $this->load->view('marketing/show_table/content/body', $data);

    ?>

</table>

<input type="submit" class="hidden" id="submit_get_form"/>





