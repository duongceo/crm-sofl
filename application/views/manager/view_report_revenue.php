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

		<?php

		$report = array('Học Viên Cũ', 'Học Viên Mới', 'Tổng');

		foreach ($report as $value) {

			?>

			<th <?php if ($value == 'Tổng') echo 'style="background-color: #1e5f24"'?>>

				<?php echo $value; ?>

			</th>

			<?php

		}

		?>

	</tr>

	</thead>

	<tbody>

	<?php

	$total_L7L8 = 0;

	foreach ($language_re as $value) {

		$total_re += $value['re_total'];
		$total_re_new += $value['re_new'];
		$total_re_old += $value['re_old'];

		?>

		<tr>

			<td>

				<?php echo $value['language_name']; ?>

			</td>

			<td>

				<?php echo number_format($value['re_new'], 0, ",", "."); ?>

			</td>

			<td>

				<?php echo number_format($value['re_old'], 0, ",", "."); ?>

			</td>

			<td>

				<?php echo number_format($value['re_total'], 0, ",", "."); ?>

			</td>

		</tr>

		<?php

	}

	?>

	<tr>

		<td> Tổng </td>

		<td> <h4> <?php echo number_format($total_re_new, 0, ",", ".") . " VNĐ"; ?></h4></td>

		<td> <h4> <?php echo number_format($total_re_old, 0, ",", ".") . " VNĐ"; ?></h4></td>

		<td colspan="3"> <h4> <?php echo number_format($total_re, 0, ",", ".") . " VNĐ"; ?></h4></td>

	</tr>

	</tbody>

</table>

<table class="table table-bordered table-striped view_report">

	<thead>

		<tr>
			<th style="background: none"></th>
			<th colspan="2">Hàn</th>
			<th colspan="2">Nhật</th>
			<th colspan="2">Trung</th>
			<th style="background-color: #1e5f24" rowspan="2">Tổng</th>
		</tr>

		<tr>

			<th style="background: none"></th>

			<?php

			$report = array('Học Viên Cũ', 'Học Viên Mới', 'Học Viên Cũ', 'Học Viên Mới', 'Học Viên Cũ', 'Học Viên Mới');

			foreach ($report as $value) {

				?>

				<th style="background-color: #1b6d85">

					<?php echo $value; ?>

				</th>

				<?php

			}

			?>

		</tr>

	</thead>

	<tbody>

		<?php
		$total_all = 0;
		foreach ($re as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['branch_name']?></td>
		<?php
			$total_re = 0;
			foreach ($language_study as $item) {
				$total_re += $value[$item['id']]['re_new'] + $value[$item['id']]['re_old'];
				$total_all += $value[$item['id']]['re_new'] + $value[$item['id']]['re_old'];
				?>

					<td>

						<?php echo number_format($value[$item['id']]['re_old'], 0, ",", "."); ?>

					</td>

					<td>

						<?php echo number_format($value[$item['id']]['re_new'], 0, ",", "."); ?>

					</td>

				<?php
			} ?>

				<td><?php echo number_format($total_re, 0, ",", ".") . " VNĐ";?></td>
			</tr>
		<?php
		}

		?>

		<tr>

			<td> Tổng </td>
			<?php foreach ($total as $item) { ?>
				<td> <h5> <?php echo number_format($item['total_re_old'], 0, ",", ".") . " VNĐ"; ?></h5></td>
				<td> <h5> <?php echo number_format($item['total_re_new'], 0, ",", ".") . " VNĐ"; ?></h5></td>
			<?php } ?>

			<td> <h5> <?php echo number_format($total_all, 0, ",", ".") . " VNĐ"; ?></h5></td>

		</tr>

	</tbody>

</table>



