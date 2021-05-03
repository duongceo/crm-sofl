
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

			<th style="background: none" class="staff_0"></th>

			<?php foreach ($level_study as $value) { ?>

				<th style="background: #0f846c">

					<?php echo $value['level_id']; ?>

				</th>

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

				<?php foreach ($level_study as $value_study) { ?>

					<td>

						<?php echo $value_report[$value_study['level_id']]; ?>

					</td>

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

