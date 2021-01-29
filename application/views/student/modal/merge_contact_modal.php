<div class="modal fade merge_contact_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ghép contact "<span class="contact_name_replacement"></span>"</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url(); ?>student/merge_contact" method="POST" id="merge_contact">
					<input type="hidden" name="contact_id" id="contact_id_input_merger" />
					<div class="form-group">
						<h5><b>Nhập SĐT cần ghép</b></h5>
						<input type="text" class="form-control" name="phone_merger" />
					</div>

					<div class="form-group">
						<input class="btn btn-success btn-block btn-lg" type="submit" value="Ghép Contact" />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
