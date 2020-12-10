
<h4 class="text-center">Xem các cuộc gọi nhỡ của hôm qua</h4>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form action="<?php base_url() . 'sale/get_phone_missed_call'?>" method="POST">
			<div class="text-center">
				<?php $date = date('d/m/Y',strtotime("-1 days")) . ' - ' .date('d/m/Y',strtotime("-1 days")); ?>
				<input type="hidden" value="skip">
				<button type="submit" class="btn btn-primary">Bỏ qua</button>
				<a href="<?php echo base_url().'sale/view_history_call?filter_date_date_happen='.$date.'&filter_missed_call=1'?>" class="btn btn-success show_popup">Xem luôn</a>
			</div>
		</form>
	</div>
</div>
