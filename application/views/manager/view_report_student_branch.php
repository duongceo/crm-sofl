<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo học viên tại cơ sở từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report">

	<thead>
		<tr>
			<th style="background: none"></th>
			<th colspan="5" style="background-color: #e94600">Hàn</th>
			<th colspan="5" style="background-color: #E94600">Nhật</th>
			<th colspan="5" style="background-color: #E94600">Trung</th>
			<th style="background-color: #1e5f24" colspan="2">Tổng</th>
		</tr>

		<tr>

			<th style="background: none"></th>

			<?php

			$report = array('L1', 'L2', 'L3', 'L5', 'L8');
			foreach ($language_study as $item) {
				foreach ($report as $value) {

					?>

					<th style="background-color: #1b6d85">

						<?php echo $value; ?>

					</th>

					<?php

				}
			}

			?>

			<th style="background-color: #2e6da4">
				L5
			</th>

			<th style="background-color: #2e6da4">
				L8
			</th>

		</tr>

	</thead>

	<tbody>

	<?php

	foreach ($branch as $key => $value) {
		$total_L5 = 0;
		$total_L8 = 0;
		?>
		<tr>
			<td style="background-color: #8aa6c1;"><h6><?php echo $value['name']?></h6></td>
			<?php
			foreach ($language_study as $item) {

				$total_L5 += $value[$item['id']]['L5'];
				$total_L8 += $value[$item['id']]['L8'];
				?>
				<td>
					<?php echo $value[$item['id']]['L1']; ?>
				</td>

				<td>
					<?php echo $value[$item['id']]['L2']; ?>
				</td>

				<td>
					<?php echo $value[$item['id']]['L3']; ?>
				</td>

				<td>
					<?php echo $value[$item['id']]['L5']; ?>
				</td>

				<td>
					<?php echo $value[$item['id']]['L8']; ?>
				</td>

				<?php
			} ?>

			<td><?php echo $total_L5 ?></td>
			<td><?php echo $total_L8 ?></td>
		</tr>
		<?php
	}

	?>

	</tbody>

</table>



