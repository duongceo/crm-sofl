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

            $report = array('Cũ', 'Mới', 'Tổng');

            foreach ($report as $value) {

                ?>

                <th>

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

		<?php

		$report = array('Cũ', 'Mới', 'Tổng');

		foreach ($report as $value) {

			?>

			<th>

				<?php echo $value; ?>

			</th>

			<?php

		}

		?>

	</tr>

	</thead>

	<tbody>

	<?php
	$total_re = 0;
	$total_re_new = 0;
	$total_re_old = 0;

	foreach ($branch_re as $value) {

		$total_re += $value['re_total'];
		$total_re_new += $value['re_new'];
		$total_re_old += $value['re_old'];

		?>

		<tr>

			<td>

				<?php echo $value['branch_name']; ?>

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



