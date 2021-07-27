
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h3 class="text-center marginbottom20"> Báo cáo xử lý contact từng ngày trong tháng theo nguồn Data lạnh</h3>
	</div>
</div>

<form action="#" method="GET" id="action_contact" class="form-inline">
	<?php $this->load->view('common/content/filter'); ?>
</form>

<!--<div class="col-lg-1 col-md-1 col-xs-4" style="padding-right: 0">-->
<!--	<table class="table table-bordered table-striped view_report gr4-table ">-->
<!--		<thead>-->
<!--			<tr>-->
<!--				<th style="background-color: #147c67"></th>-->
<!--			</tr>-->
<!--			<tr>-->
<!--				<th style="background-color: #147c67">Ngày</th>-->
<!--			</tr>-->
<!--		</thead>-->
<!---->
<!--		<tbody>-->
<!--		--><?php //foreach ($report as $key => $values) { ?>
<!--			<tr>-->
<!--				<td style="background-color: #43bcdf96; height: 50px; font-size: 15px;"> --><?php //echo $key; ?><!-- </td>-->
<!--			</tr>-->
<!--		--><?php //} ?>
<!--		</tbody>-->
<!--	</table>-->
<!--</div>-->

<!--<div class="col-lg-11 col-md-11 col-xs-8" style="padding-left: 0">-->
	<div class="table-responsive">
		<table class="table table-bordered table-striped view_report gr4-table ">
			<thead>
				<tr>
					<th style="background-color: #147c67" rowspan="2">Ngày</th>
					<?php $report_2 = array('Xử Lý', 'KNM', 'L1', 'L2', 'L3', 'L4', 'L5', 'L2/XL', 'L5/XL') ?>
					<?php foreach ($date_for_report as $key => $value) { ?>
						<th colspan="<?php echo count($report_2)?>" style="background: #0f846c; height: 50px">
							<?php echo $value; ?>
						</th>
					<?php } ?>
				</tr>

				<tr>
					<?php foreach ($date_for_report as $staff) { ?>
						<?php foreach ($report_2 as $value) { ?>
							<th style="background: #086183">
								<?php echo $value; ?>
							</th>
						<?php } ?>
					<?php } ?>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($report as $key => $value) { ?>
					<tr>
						<td style="background-color: #43bcdf96; height: 50px; font-size: 15px;"> <?php echo $key; ?> </td>
						<?php foreach ($date_for_report as $date) { ?>
							<td><?php echo $value[$date]['XU_LY'] ?></td>
							<td><?php echo $value[$date]['KNM'] ?></td>
							<td><?php echo $value[$date]['L1'] ?></td>
							<td><?php echo $value[$date]['L2'] ?></td>
							<td><?php echo $value[$date]['L3'] ?></td>
							<td><?php echo $value[$date]['L4'] ?></td>
							<td><?php echo $value[$date]['L5'] ?></td>
							<td><?php echo ($value[$date]['XU_LY'] != 0) ? round(($value[$date]['L2'] / $value[$date]['XU_LY']) * 100, 2) . '%' : '0';?></td>
							<td><?php echo ($value[$date]['XU_LY'] != 0) ? round(($value[$date]['L5'] / $value[$date]['XU_LY']) * 100, 2) . '%' : '0';?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<!--</div>-->
