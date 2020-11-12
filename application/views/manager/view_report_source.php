<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo tỷ lệ theo nguồn từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report">

	<thead>
	<tr>
		<th style="background-color: #2b669a">HÀN</th>

		<?php foreach ($HQ as $key => $item) { ?>
			<th style="background-color: #1e5f24"><?php echo $key?></th>
		<?php } ?>
	</tr>

	</thead>

	<tbody>

		<?php
		$report = array('L1', 'L2', 'L3', 'L5', 'L8', 'RE');
		foreach ($report as $item) { ?>

			<tr>
			<td style="background-color: #43bcdf96"><?php echo $item ?></td>

			<?php foreach ($HQ as $value) { ?>

				<td>

					<?php
					if ($item == 'RE') {
						echo h_number_format($value[$item]);
					} else {
						echo $value[$item];
					}
					?>

				</td>

			<?php } ?>
			</tr>
		<?php }	?>

		<?php

		$report2 = array(
			array('L5/L1', 'L5', 'L1', 30),
		);

		foreach ($report2 as $values) {

			list($name, $tu_so, $mau_so, $limit) = $values;

			?>

			<tr>

				<td style="background-color: #279a9d;"> <?php echo $name; ?> </td>

				<?php foreach ($HQ as $value) { ?>

					<td <?php

					if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

						echo 'style="background-color: #a71717;color: #fff;"';

					} else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

						echo 'style="background-color: #0C812D;color: #fff;"';

					}

					?>>

						<?php

						echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

						?>

					</td>

					<?php } ?>

			</tr>

			<?php

		}

		?>

	</tbody>

</table>

<table class="table table-bordered table-striped view_report">

	<thead>
	<tr>
		<th style="background-color: #2b9a74">NHẬT</th>

		<?php foreach ($NB as $key => $item) { ?>
			<th style="background-color: #1e5f24"><?php echo $key?></th>
		<?php } ?>
	</tr>

	</thead>

	<tbody>

		<?php
		$report = array('L1', 'L2', 'L3', 'L5', 'L8', 'RE');
		foreach ($report as $item) {
			?>
			<tr>
				<td style="background-color: #43bcdf96"><?php echo $item ?></td>
				<?php foreach ($NB as $value) { ?>
					<td>
						<?php
						if ($item == 'RE') {
							echo h_number_format($value[$item]);
						} else {
							echo $value[$item];
						}
						?>
					</td>
				<?php } ?>
			</tr>
		<?php }	?>

		<?php

		$report2 = array(
			array('L5/L1', 'L5', 'L1', 30),
		);

		foreach ($report2 as $values) {

			list($name, $tu_so, $mau_so, $limit) = $values;

			?>

			<tr>

				<td style="background-color: #279a9d;"> <?php echo $name; ?> </td>

				<?php foreach ($NB as $value) { ?>

					<td <?php

					if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

						echo 'style="background-color: #a71717;color: #fff;"';

					} else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

						echo 'style="background-color: #0C812D;color: #fff;"';

					}

					?>>

						<?php

						echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

						?>

					</td>

				<?php } ?>

			</tr>

			<?php

		}

		?>

	</tbody>

</table>

<table class="table table-bordered table-striped view_report">

	<thead>
	<tr>
		<th style="background-color: #9a612b">TRUNG</th>

		<?php foreach ($TQ as $key => $item) { ?>
			<th style="background-color: #1e5f24"><?php echo $key?></th>
		<?php } ?>
	</tr>

	</thead>

	<tbody>

		<?php
		$report = array('L1', 'L2', 'L3', 'L5', 'L8', 'RE');
		foreach ($report as $item) { ?>

			<tr>
				<td style="background-color: #43bcdf96"><?php echo $item ?></td>

				<?php foreach ($TQ as $value) { ?>

					<td>

						<?php
						if ($item == 'RE') {
							echo h_number_format($value[$item]);
						} else {
							echo $value[$item];
						}
						?>

					</td>

				<?php } ?>
			</tr>
		<?php }	?>

		<?php

		$report2 = array(
			array('L5/L1', 'L5', 'L1', 30),
		);

		foreach ($report2 as $values) {

			list($name, $tu_so, $mau_so, $limit) = $values;

			?>

			<tr>

				<td style="background-color: #279a9d;"> <?php echo $name; ?> </td>

				<?php foreach ($TQ as $value) { ?>

					<td <?php

					if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

						echo 'style="background-color: #a71717;color: #fff;"';

					} else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

						echo 'style="background-color: #0C812D;color: #fff;"';

					}

					?>>

						<?php

						echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

						?>

					</td>

				<?php } ?>

			</tr>

			<?php

		}

		?>

	</tbody>

</table>

<table class="table table-bordered table-striped view_report">

	<thead>
	<tr>
		<th style="background-color: #4c28c6b3">TỔNG</th>

		<?php foreach ($sources as $item) { ?>
			<th style="background-color: #1e5f24"><?php echo $item['name']?></th>
		<?php } ?>
	</tr>

	</thead>

	<tbody>

	<?php
	$report = array('L1', 'L2', 'L3', 'L5', 'L8');
	foreach ($report as $item) {
		?>
		<tr>
			<td style="background-color: #43bcdf96"><?php echo $item ?></td>
			<?php foreach ($sources as $value) { ?>
				<td>
					<?php echo $value[$item]; ?>
				</td>
			<?php } ?>
		</tr>
	<?php }	?>

	<?php

	$report2 = array(
		array('L5/L1', 'L5', 'L1', 30),
	);

	foreach ($report2 as $values) {

		list($name, $tu_so, $mau_so, $limit) = $values;

		?>

		<tr>

			<td style="background-color: #279a9d;"> <?php echo $name; ?> </td>

			<?php foreach ($sources as $value) { ?>

				<td <?php

				if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) < $limit && $limit > 0) {

					echo 'style="background-color: #a71717;color: #fff;"';

				} else if ($value[$mau_so] != 0 && round(($value[$tu_so] / $value[$mau_so]) * 100) >= $limit && $limit > 0) {

					echo 'style="background-color: #0C812D;color: #fff;"';

				}

				?>>

					<?php

					echo ($value[$mau_so] != 0) ? round(($value[$tu_so] / $value[$mau_so]) * 100, 2) . '%' : 'không thể chia cho 0';

					?>

				</td>

			<?php } ?>

		</tr>

		<?php

	}

	?>

	</tbody>

</table>




