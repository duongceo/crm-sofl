
<div class="row">
	<h3 class="text-center">Nhật ký đã nhập từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
	<h3 class="text-center marginbottom35"> Tổng chi phí MKT : <?php echo $total_spend; ?> VNĐ</h3>
	
	<div class="row">
		<div class="col-md-10">
			<form action="#" method="GET" id="action_contact" class="form-inline">
				<?php $this->load->view('common/content/filter'); ?>
			</form>
		</div>
	</div>
</div>

<div class="container" style="max-width: 910px;">
	<div class="row">
		<div class="col-md-10">
			<div class="text-left">
				<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập chi phí</a>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="height: 800px;display: block;overflow: scroll">
		<thead>
			<tr>
				<th>Kênh</th>
				<th>Ngôn ngữ</th>
				<th>Khu vực</th>
				<th>Ngày</th>
				<th>Chi phí</th>
				<th>Ngày nhập</th>
			</tr>
		</thead>
		<tbody id="log-body">
			<?php if (isset($spend) && !empty($spend)){ ?>
				<?php foreach ($spend as $item){ ?>
					<tr>
						<td class="text-center">
							<?php echo $item['channel_name']; ?>
						</td>
						<td class="text-center">
							<?php echo $item['language_name']; ?>
						</td>
						<td class="text-center">
							<?php echo $item['location']; ?>
						</td>
						<td class="text-center">
							<?php echo date('d-m-Y', $item['day_spend']); ?>
						</td>
						<td class="text-center">
							<?php echo $item['spend']; ?> VNĐ
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
</div>


<br>
<hr>
<div class="row">
	<div class="col-lg-2 col-md-2 col-xs-4" style="padding-right: 0">
		<div class="table-responsive">
			<table class="table table-bordered table-striped view_report">
				<thead class="table-head-pos">
					<tr>
						<th style="height: 50px; background: none;"></th>
						<th style="background-color: #147c67"">Tổng chi phí</th>
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

	<div class="col-lg-10 col-md-10 col-xs-8" style="padding-left: 0">
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
				<form action="<?php echo base_url('marketer/get_ma_mkt') ?>" method="POST" class="form-inline" role="form">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-1 table-view-1">
								<tr>
									<td class="text-right"> Ngoại ngữ </td>
									<td>
										<select class="form-control selectpicker" name="language_id">
											<option value="">Chọn ngoại ngữ</option>
											<?php foreach ($language_study as $key => $value) { ?>
												<option value="<?php echo $value['id']; ?>">
													<?php echo $value['name']; ?>
												</option>
											<?php } ?>
										</select>
									</td>
								</tr>

								<tr>
									<td class="text-right"> Kênh</td>
									<td>
										<select class="form-control selectpicker" name="channel_id">
											<option value="">Chọn kênh</option>
											<?php foreach ($channel as $key => $value) { ?>
												<option value="<?php echo $value['id']; ?>">
													<?php echo $value['name']; ?>
												</option>
											<?php } ?>
										</select>
									</td>
								</tr>

								<tr>
									<td class="text-right">Khu vực</td>
									<td>
										<select class="form-control selectpicker" name="location_id">
											<option value="">Chọn địa điểm</option>
											<?php foreach ($location as $key => $value) { ?>
												<option value="<?php echo $value['id']; ?>">
													<?php echo $value['location']; ?>
												</option>
											<?php } ?>
										</select>
								</tr>
							</table>
						</div>

						<div class="col-md-6">
							<table class="table table-striped table-bordered table-hover table-2 table-view-2">
								<tr>
									<td class="text-right">Ngày chi tiêu</td>
									<td>
										<div class="form-group">
											<input type="text" class="form-control datepicker" name="day_spend">
										</div><!-- /input-group -->
									</td>
								</tr>

								<tr>
									<td class="text-right">Chi phí</td>
									<td>
										<input type="text" class="form-control" name="spend" />
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



