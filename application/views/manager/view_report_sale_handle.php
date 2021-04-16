
<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo xử lý contact từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<table class="table table-bordered table-striped view_report gr4-table ">

	<thead>

		<tr>

			<th style="background: none" class="staff_0"></th>

			<?php
			foreach ($staffs as $value) {

				if ($value['XU_LY'] > 0) {

					?>

					<th style="background: #0f846c"  class="staff_<?php echo $value['id']; ?>">

						<?php echo $value['name']; ?>

					</th>

					<?php

				}

			}

			?>

		</tr>

	</thead>

	<tbody>

		<?php

		$report = array(
			array('Xử Lý', 'XU_LY', $XU_LY),
			array('1 Lần', 'LAN_1', $LAN_1),
			array('2 Lần', 'LAN_2', $LAN_2),
			array('3 Lần', 'LAN_3', $LAN_3),
			array('4 Lần', 'LAN_4', $LAN_4),
			array('5 Lần', 'LAN_5', $LAN_5)
		);

		foreach ($report as $values) {

			list($name, $value2, $total) = $values;

			?>

			<tr>

				<td> <?php echo $name; ?> </td>

				<?php

				foreach ($staffs as $value) {
					if ($value['XU_LY'] > 0) {

						?>

						<td>
							<?php echo $value[$value2]; ?>
						</td>

						<?php

					}

				}

				?>

<!--				<td class="show_detail">-->
<!---->
<!--					--><?php //echo $total; ?>
<!---->
<!--				</td>-->

			</tr>

			<?php

		}

		?>

	</tbody>

</table>
