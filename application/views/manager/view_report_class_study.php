<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Thống kê số lượng các lớp từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report">
	<thead>
		<tr>
			<th style="background: none"></th>
<!--			<th colspan="2">Hàn</th>-->
<!--			<th colspan="2">Nhật</th>-->
<!--			<th colspan="2">Trung</th>-->
			<?php foreach ($language_study as $item) { ?>
				<th colspan="3">
					<?php echo $item['name']; ?>
				</th>
			<?php } ?>
		</tr>

		<tr>
			<th style="background: none"></th>
			<?php
			$report = array('Đã Khai Giảng', 'Đã Kết Thúc', 'Dự Kiến Kết Thúc');
			foreach ($language_study as $item) {
				foreach ($report as $value) {
				?>
					<th style="background-color: #1b6d85">
						<?php echo $value; ?>
					</th>
				<?php } ?>
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
					<td><?php echo $item['DK_KT']; ?></td>
				<?php } ?>
			</tr>
		<?php } ?>

	</tbody>
</table>

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h3 class="text-center marginbottom20"> Thống kê số lượng học viên khai giảng và kết thúc từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>
	</div>
</div>

<table class="table table-bordered table-striped view_report">
	<thead>
		<tr>
			<th style="background-color: #4c28c6b3"></th>

			<?php foreach ($language_study as $item_1) { ?>
				<th style="background-color: #1e5f24" colspan="7"><?php echo $item_1['name']?></th>
			<?php } ?>
		</tr>

		<tr>
			<th style="background: none"></th>
			<?php
			foreach ($language_study as $item_1) {
				$report = array();
				$report = array('HV Khai Giảng', 'HV Kết Thúc', 'HV DK Kết Thúc', 'L7', 'L8', 'L7/KT', 'L8/KT');
				foreach ($report as $value) {
					?>
					<th style="background-color: #1b6d85">
						<?php echo $value; ?>
					</th>
				<?php } ?>
			<?php } ?>
			<!--		<th style="background-color: #1e5f24"> Tổng </th>-->
		</tr>
	</thead>

	<tbody>
		<?php
//			print_arr($branch);
			foreach ($branch as $key_branch => $value_branch) { ?>
			<tr>
				<td style="background-color: #8aa6c1"><?php echo $key_branch; ?></td>
				<?php foreach ($value_branch as $item) { ?>
					<td><?php echo $item['HV_ĐA_KG']; ?></td>
					<td><?php echo $item['HV_ĐA_KT']; ?></td>
					<td><?php echo $item['HV_DK_KT']; ?></td>
					<td><?php echo $item['L7']; ?></td>
					<td><?php echo $item['L8']; ?></td>
					<td style="background-color: #9cc2cb"><?php echo round($item['L7'] / $item['HV_ĐA_KT'] * 100, 2) . '%'; ?></td>
					<td style="background-color: #9cc2cb"><?php echo round($item['L8'] / $item['HV_ĐA_KT'] * 100, 2) . '%'; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
	</tbody>
</table>
