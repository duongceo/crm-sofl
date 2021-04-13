
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
		<div>
			<div class="col-md-10">
				<div class="row text-left">
					<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Nhập chi tiêu</a>
				</div>
			</div>
		</div>

		<table>
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
								<td class="text-right">
									Nội dung chi tiêu
								</td>
								<td>
									<div class="form-group">
										<textarea class="form-control" rows="4" cols="30" name="content_cost"></textarea>
									</div>
								</td>
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
