
<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo chăm sóc khách hàng từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report gr4-table ">

	<thead>

	<tr>

		<th style="background: none" class="staff_0"></th>

		<?php foreach ($staffs as $value) { ?>

				<th style="background: #0f846c"  class="staff_<?php echo $value['id']; ?>">

					<?php echo $value['name']; ?>

				</th>

		<?php } ?>

		<th class="staff_sum">

			Tổng

		</th>

	</tr>

	</thead>

	<tbody>

	<?php

	$report = array(
		array('Xử Lý', 'XU_LY', $XU_LY),
		array('Nghe Máy', 'NGHE_MAY', $NGHE_MAY),
		array('Ko Nghe Máy', 'KO_NGHE_MAY', $KO_NGHE_MAY),
		array('Tham khảo', 'THAM_KHAO', $THAM_KHAO),
		array('Đồng ý đăng ký', 'DONG_Y', $DONG_Y),
		array('Từ chối', 'TU_CHOI', $TU_CHOI),
	);

	foreach ($report as $values) {

		list($name, $value2, $total) = $values;

		?>

		<tr>

			<td> <?php echo $name; ?> </td>

			<?php foreach ($staffs as $value) { ?>

				<td>

					<?php echo $value[$value2]; ?>

				</td>

			<?php } ?>

			<td class="show_detail">

				<?php echo $total; ?>

			</td>

		</tr>

	<?php } ?>

	</tbody>

</table>
