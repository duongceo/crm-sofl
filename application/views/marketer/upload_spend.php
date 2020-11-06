


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

	<div class="container" style="max-width: 910px">
		<div>
			<div class="col-md-10">
				<div class="row text-left">
					<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập chi phí</a>
				</div>
			</div>
		</div>

		<table>
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
							<?php echo date('d-m-Y H:m:s', $item['time_created']); ?>
						</td>

					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
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
							<div class="col-md-2">
								<div class="form-group">
									<div>
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
									</div>
								</div>
							</div>

							<div class="col-md-10">
								<div class="form-group">
									<div>
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
									</div>
								</div>

								<div class="form-group">
									<div>
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
										</td>
									</div>
								</div>

								<div class="form-group">
									<div>
										<div>Ngày chi tiêu</div>
										<td>
											<div class="form-group">
												<input type="text" class="form-control datepicker" name="day_spend">
											</div><!-- /input-group -->
										</td>
									</div>
								</div>

								<div class="form-group">
									<div>Chi phí</div>
									<div class="form-group">
										<input type="text" class="form-control" name="spend" />
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="text-center">
							<button type="submit" class="btn btn-success btn-lg" style="width: 130px;">Lưu</button>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	



