<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Thống kê lớp từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report">
	<thead>
	<tr>
		<th style="background: none"></th>
		<th colspan="2">Hàn</th>
		<th colspan="2">Nhật</th>
		<th colspan="2">Trung</th>
<!--		<th style="background-color: #1e5f24" colspan="3">Tổng</th>-->
	</tr>

	<tr>
		<th style="background: none"></th>
		<?php
		$report = array('Đã Khai Giảng', 'Đã Kết Thúc', 'Đã Khai Giảng', 'Đã Kết Thúc', 'Đã Khai Giảng', 'Đã Kết Thúc');
		foreach ($report as $value) {
			?>
			<th style="background-color: #1b6d85">
				<?php echo $value; ?>
			</th>
		<?php } ?>
<!--		<th style="background-color: #1e5f24"> Tổng </th>-->
	</tr>
	</thead>

	<tbody>
		<?php
		foreach ($branch as $key => $value) { ?>
			<tr>
				<td style="background-color: #8aa6c1"><?php echo $key; ?></td>
			<?php foreach ($value as $item) { ?>
				<td><?php echo $item['ĐA_KG']; ?></td>
				<td><?php echo $item['ĐA_KT']; ?></td>
			<?php } ?>
		<?php } ?>
		</tr>
	</tbody>
</table>
