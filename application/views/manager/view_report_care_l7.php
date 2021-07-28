
<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo các trạng thái L7 từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<div class="table-responsive">

	<table class="table table-bordered table-striped view_report gr4-table ">

		<thead>

			<tr>

				<th  style="background: none" class="staff_0"></th>
				<?php foreach ($language_study as $value_language) { ?>

					<th colspan="<?php echo count($level_study)?>">

						<?php echo $value_language['name']; ?>

					</th>

				<?php } ?>
			</tr>

			<tr>

				<th style="background: none" class="staff_0"></th>
				<?php foreach ($language_study as $value_language) { ?>

					<?php foreach ($level_study as $value_level_study) { ?>

						<th style="background: #0f846c">

							<?php echo $value_level_study['level_id']; ?>

						</th>

					<?php } ?>

				<?php } ?>

		<!--		<th class="staff_sum">-->
		<!---->
		<!--			Tổng-->
		<!---->
		<!--		</th>-->

			</tr>

		</thead>

		<tbody>

			<?php foreach ($report as $key_report => $value_report) { ?>

				<tr>

					<td style="background-color: #8aa6c1"> <?php echo $key_report; ?> </td>
					
					<?php foreach ($language_study as $value_language) { ?>

						<?php foreach ($level_study as $value_study) { ?>

							<td>

								<?php echo $value_report[$value_language['name']][$value_study['level_id']]; ?>

							</td>

						<?php } ?>

					<?php } ?>


	<!--				<td class="show_detail">-->
	<!---->
	<!--					--><?php //echo $total; ?>
	<!---->
	<!--				</td>-->

				</tr>

			<?php } ?>

		</tbody>

	</table>

</div>

<h5>Chú thích</h5>
<h5> L7.1: Học viên bảo lưu </h5>
<h5> L7.2: Học viên bỏ học </h5>
<h5> L7.3: Học viên chuyển lớp </h5>
<h5> L7.4: Học viên kết thúc khóa học </h5>
<h5> L7.5: Học viên không đăng ký tiếp </h5>

<hr>
<?php foreach ($report_class as $key => $item) { ?>
	<div class="table-responsive">
		<table class="table table-bordered table-striped view_report">
			<thead>
				<tr>
					<th style="background-color: #227674"><?php echo $key?></th>
					<th style="background-color: #2b669a">Sĩ Số</th>
					<?php foreach ($level_study as $value_study) { ?>
						<th style="background-color: #2b669a"><?php echo $value_study['level_id']?></th>
					<?php } ?>
					<th style="background-color: #2b669a">HV đăng ký lên</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($item as $key_2 => $item_2) { ?>
					<tr>
						<td style="background-color: #43bcdf96"><h5><?php echo $key_2 ?></h5></td>
						<td>
							<h5><?php echo $item_2['student'] ?></h5>
						</td>
						<?php foreach ($level_study as $value_study) { ?>
						<td>
							<h5><?php echo $item_2[$value_study['level_id']] ?></h5>
						</td>
						<?php }	?>
						<td>
							<h5><?php echo $item_2['student_L8'] ?></h5>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>

