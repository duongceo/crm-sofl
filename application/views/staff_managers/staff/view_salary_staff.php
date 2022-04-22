
<div class="row">
	<h1 class="text-center">Nhật ký thu chi từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h1>
	<h1 class="text-center marginbottom35" style="color: #04a2df"> Tổng chi tiêu : <?php echo $total_cost; ?> VNĐ</h1>
</div>

<div class="container" >
	<div>
		<form action="#" method="GET" id="action_contact" class="form-inline">
			<?php $this->load->view('common/content/filter'); ?>
		</form>
	</div>

	<div class="row">
		<div class="col-md-10">
			<div class="text-left">
				<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập thu chi</a>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="display: block;overflow: scroll; height: 600px;">
			<thead>
				<tr>
					<th>Họ tên</th>
					<th>Lương cơ bản</th>
					<th>Công cơ bản/Tháng</th>
					<th>Ngày công chuyên cần</th>
					<th>Ngày OT</th>
					<th>Lương thực lĩnh</th>
					<th>Lương OT/Tháng</th>
					<th>Phạt muộn</th>
					<th>Com</th>
					<th>KPI/KOL</th>
					<th>Công đoàn</th>
					<th>Chi khác</th>
					<th>Bảo hiểm</th>
					<th>Phụ cấp</th>
					<th>Lương khác</th>
					<th>Tổng thực lĩnh</th>
					<th>Lấy phép</th>
					<th>Ngày nhập</th>
					<th>Người nhập</th>
					<th>Thao tác</th>
				</tr>
			</thead>

			<tbody id="log-body">
			<?php if (isset($salary) && !empty($salary)) { ?>
				<?php foreach ($salary as $item){ ?>
					<?php
						$salary_month = ($item['salary_basic']/ $item['work_per_month']) * $item['work_diligence'];
						$salary_real = (($item['salary_basic']/ $item['work_per_month']) * 1.5) * $item['work_diligence'];
						$total_salary_real = $salary_month + $salary_real - $item['punish_late'] + $item['com'] + $item['kpi_per_kol'] - $item['federation'] - $item['cost_other'] - $item['insurance'] + $item['allowance'] + $item['salary_other'];
					?>
					<tr>
						<td class="text-center">
							<?php echo html_entity_decode($item['name']) ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['salary_basic']); ?>
						</td>
						<td class="text-center">
							<?php echo $item['work_per_month']; ?>
						</td>
						<td class="text-center">
							<?php echo $item['work_diligence']; ?>
						</td>
						<td class="text-center">
							<?php echo $item['work_OT']; ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($salary_month); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($salary_real); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['punish_late']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['com']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['kpi_per_kol']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['federation']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['cost_other']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['insurance']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['allowance']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['salary_other']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($total_salary_real); ?>
						</td>
						<td class="text-center">
							<?php echo date('d-m-Y', $item['day_salary']); ?>
						</td>
						<td class="text-center">
							<?php echo $item['on_leave']; ?>
						</td>
						<td class="text-center cost_branch">
							<?php if ($item['paid_status']) { ?>
								<p class="bg-success">Đã thanh toán</p>
							<?php } else { ?>
								<p class="bg-warning">Chưa thanh toán</p>
								<?php if ($this->role_id == 13) { ?>
									<button class="btn btn-xs btn-primary" salary_id="<?php echo $item['id'] ?>">Thanh toán</button>
								<?php } ?>
							<?php } ?>
						</td>
						<td class="text-center">
							<?php echo date('d-m-Y H:i:s', $item['time_created']); ?>
						</td>
						<td class="text-center text-primary">
							<button class="btn btn-sm btn-success paid_salary_staff" salary_id="<?php echo $item['id'] ?>">
								Đã gửi lương
							</button>
							<button class="btn btn-sm btn-warning send_mail_salary_staff" salary_id="<?php echo $item['id'] ?>">
								Gửi mail lương
							</button>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!--<hr>-->
<!--<h3 class="text-center">Thống kê đã chi tiêu</h3>-->
<!--<div class="row">-->
<!--	<div class="col-lg-2 col-md-2 col-xs-5" style="padding-right: 0">-->
<!--		<div class="table-responsive">-->
<!--			<table class="table table-bordered table-striped view_report">-->
<!--				<thead class="table-head-pos">-->
<!--				<tr>-->
<!--					<th style="height: 50px; background: none;"></th>-->
<!--					<th style="background-color: #147c67"">Tổng chi tiêu</th>-->
<!--				</tr>-->
<!--				</thead>-->
<!---->
<!--				<tbody>-->
<!--				--><?php //foreach ($report_cost as $key_report => $item_report_cost) { ?>
<!--					<tr>-->
<!--						<td style="background: #48baad; height: 50px;"> --><?php //echo $key_report; ?><!-- </td>-->
<!--						<td> --><?php //echo number_format($item_report_cost['total'], 0, ",", "."); ?><!-- </td>-->
<!--					</tr>-->
<!--				--><?php //} ?>
<!--				</tbody>-->
<!--			</table>-->
<!--		</div>-->
<!--	</div>-->
<!---->
<!--	<div class="col-lg-10 col-md-10 col-xs-7" style="padding-left: 0">-->
<!--		<div class="table-responsive">-->
<!--			<table class="table table-bordered table-striped view_report gr4-table">-->
<!--				<thead class="table-head-pos">-->
<!--				<tr>-->
<!--					--><?php //foreach ($date as $item) { ?>
<!--						<th style="min-width: 180px; height: 50px; background-color: #4689c8"> --><?php //echo $item ?><!--</th>-->
<!--					--><?php //} ?>
<!--				</tr>-->
<!--				</thead>-->
<!--				<tbody>-->
<!--				--><?php //foreach ($report_cost as $key_report => $item_report) { ?>
<!--					<tr>-->
<!--						--><?php //foreach ($date as $item) { ?>
<!--							<td style="height: 50px;">--><?php //echo number_format($item_report[$item], 0, ",", ".")?><!--</td>-->
<!--						--><?php //} ?>
<!--					</tr>-->
<!--				--><?php //} ?>
<!--				</tbody>-->
<!--			</table>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->

<div class="modal fade" id="modal-id" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nhập lương nhân viên</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('staff_managers/staff/view_salary_staff') ?>" method="POST" class="form-inline" role="form">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-1 table-view-1">
								<tr>
									<td class="text-right">Họ tên</td>
									<td>
										<input type="text" class="form-control" name="name" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Lương cơ bản</td>
									<td>
										<input type="text" class="form-control money" name="salary_basic" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td class="text-right">Công cơ bản/Tháng</td>
									<td>
										<input type="text" class="form-control" name="work_per_month" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td class="text-right">Ngày công chuyên cần</td>
									<td>
										<input type="text" class="form-control" name="work_diligence" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Ngày OT</td>
									<td>
										<input type="text" class="form-control" name="work_OT" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Phạt muộn</td>
									<td>
										<input type="text" class="form-control money" name="punish_late" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Com</td>
									<td>
										<input type="text" class="form-control money" name="com" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Ngày chi tiêu</td>
									<td>
										<input type="text" class="form-control datepicker" name="day_cost" style="width: 100%;">
									</td>
								</tr>
							</table>
						</div>

						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-2 table-view-2">
								<tr>
									<td  class="text-right">KPI/KOL</td>
									<td>
										<input type="text" class="form-control money" name="kpi_per_kol" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Công đoàn</td>
									<td>
										<input type="text" class="form-control money" name="federation" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Chi khác</td>
									<td>
										<input type="text" class="form-control money" name="cost_other" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Bảo hiểm</td>
									<td>
										<input type="text" class="form-control money" name="insurance" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Phụ cấp</td>
									<td>
										<input type="text" class="form-control money" name="allowance" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Lương khác</td>
									<td>
										<input type="text" class="form-control money" name="salary_other" style="width: 100%;" />
									</td>
								</tr>
								<tr>
									<td  class="text-right">Lương tháng</td>
									<td>
										<input type="text" class="form-control datepicker" name="day_salary" style="width: 100%;">
									</td>
								</tr>
								<tr>
									<td  class="text-right">Lấy phép</td>
									<td>
										<input type="text" class="form-control" name="on_leave" style="width: 100%;" />
									</td>
								</tr>
							</table>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-success btn-lg" style="width: 130px;">Lưu</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(".switch_select").bootstrapSwitch();
</script>

<script type="text/javascript">
	$('.money').simpleMoneyFormat();
</script>
