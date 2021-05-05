
<div class="row">
	<h1 class="text-center">Nhật ký chi tiêu từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h1>
	<h1 class="text-center marginbottom35" style="color: #04a2df"> Tổng chi tiêu : <?php echo $total_cost; ?> VNĐ</h1>

	<div class="row">
		<div class="col-md-10">
			<form action="#" method="GET" id="action_contact" class="form-inline">
				<?php $this->load->view('common/content/filter'); ?>
			</form>
		</div>
	</div>
</div>

<div class="container" style="max-width: 910px">
	<div class="col-md-10">
		<div class="row text-left">
			<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập chi tiêu</a>
		</div>
	</div>

	<table class="table table-bordered table-striped" style="display: block;overflow: scroll; height: 600px;">
		<thead>
			<tr>
				<th>Ngày chi tiêu</th>
				<th>Chi phí</th>
				<th>Nội dung</th>
				<th>Ngày nhập</th>
			</tr>
		</thead>

		<tbody id="log-body">
		<?php if (isset($cost) && !empty($cost)) { ?>
			<?php foreach ($cost as $item){ ?>
				<tr>
					<td class="text-center">
						<?php echo date('d-m-Y', $item['day_cost']); ?>
					</td>
					<td class="text-center">
						<?php echo $item['cost']; ?> VNĐ
					</td>
					<td class="text-justify">
						<?php echo $item['content_cost']; ?>
					</td>
					<td class="text-center">
						<?php echo date('d-m-Y H:i:s', $item['time_created']); ?>
					</td>
				</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</div>
<br>
<hr>
<div class="row">
	<div class="col-lg-2 col-md-2 col-xs-5" style="padding-right: 0">
		<div class="table-responsive">
			<table class="table table-bordered table-striped view_report">
				<thead class="table-head-pos">
				<tr>
					<th style="height: 50px; background: none;"></th>
					<th style="background-color: #147c67"">Tổng chi tiêu</th>
				</tr>
				</thead>

				<tbody>
				<?php foreach ($report as $key_report => $item_report) { ?>
					<tr>
						<td style="background: #48baad; height: 50px;"> <?php echo $key_report; ?> </td>
						<td> <?php echo number_format($item_report['total'], 0, ",", "."); ?> </td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-lg-10 col-md-10 col-xs-7" style="padding-left: 0">
		<div class="table-responsive">
			<table class="table table-bordered table-striped view_report gr4-table" style="display: block;overflow: scroll">
				<thead class="table-head-pos">
				<tr>
					<?php foreach ($date as $item) { ?>
						<th style="min-width: 180px; height: 50px; background-color: #4689c8"> <?php echo $item ?></th>
					<?php } ?>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($report as $key_report => $item_report) { ?>
					<tr>
						<?php foreach ($date as $item) { ?>
							<td style="height: 50px;"><?php echo number_format($item_report[$item], 0, ",", ".")?></td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-id" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Nhập chi phí</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url('student/cost_branch') ?>" method="POST" class="form-inline" role="form">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-1 table-view-1">
								<tr>
									<td  class="text-right">Ngày chi tiêu</td>
									<td>
										<input type="text" class="form-control datepicker" name="day_cost">
									</td>
								</tr>

								<tr>
									<td  class="text-right">Số tiền chi tiêu</td>
									<td>
										<input type="text" class="form-control" name="cost" />
									</td>
								</tr>
							</table>
						</div>

						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-2 table-view-2">
								<tr>
									<td class="text-right">
										Nội dung chi tiêu
									</td>
									<td>
										<div class="form-group">
											<textarea class="form-control" rows="4" cols="30" name="content_cost"></textarea>
										</div>
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
