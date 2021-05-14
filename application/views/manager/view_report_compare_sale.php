<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h3 class="text-center marginbottom20"> So sánh thống kê từ đầu tháng đến hiện tại so với cùng kỳ tháng trước </h3>
	</div>
</div>

<form action="#" method="GET" id="action_contact" class="form-inline">
	<?php $this->load->view('common/content/filter'); ?>
</form>

<div class="table-responsive">
	<table class="table table-bordered table-striped view_report">
		<thead>
			<tr>
				<th style="background: none" rowspan="2"></th>
				<?php foreach ($report as $key => $value) { ?>
					<th style="background-color: #1e5f24" colspan="3"><h5><?php echo $key?></h5></th>
				<?php } ?>
			</tr>

			<tr>
				<?php
					$report_2 = array('L1', 'L5', 'L5/L1');
					foreach ($report as $key_1 => $value_1) {
						foreach ($report_2 as $value_2) { ?>
						<th style="background-color: #9d7726"><?php echo $value_2?></th>
					<?php } ?>
				<?php } ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($staffs as $item_2) { ?>
				<tr>
					<td style="background-color: #43bcdf96"><?php echo $item_2['name'] ?></td>
					<?php foreach ($report as $item) { ?>
						<td>
							<?php echo $item[$item_2['name']]['L1']; ?>
						</td>
						<td>
							<?php echo $item[$item_2['name']]['L5']; ?>
						</td>
						<td style="background-color: #a5d2e9">
							<?php echo ($item[$item_2['name']]['L1'] != 0) ? round(($item[$item_2['name']]['L5'] / $item[$item_2['name']]['L1']) * 100, 2) . '%' : 'NAN'; ?>
						</td>
					<?php }	?>
				</tr>
			<?php }	?>
		</tbody>
	</table>
</div>


