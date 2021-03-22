<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo doanh thu từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report">
	<thead>
	<tr>
		<th style="background: none"></th>
		<?php foreach ($payment_method_rgt as $value) { ?>
			<th>
				<?php echo $value['method']; ?>
			</th>
		<?php } ?>
	</tr>
	</thead>

	<tbody>
	<?php foreach ($re as $value) { ?>
		<tr>
		<td style="background-color: #8aa6c1">
			<?php echo $value['branch_name']; ?>
		</td>
			<?php foreach ($payment_method_rgt as $value_payment) { ?>
				<td>
					<?php echo number_format($value[$value_payment['id']]['re_total'], 0, ",", "."); ?>
				</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>
