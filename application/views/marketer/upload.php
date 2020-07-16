
<div class="row">
	<div>
		<h3 class="text-center marginbottom35"> Tải file chi phí MKT :
			<form action="<?php echo base_url('marketer/get_ma_mkt')?>" method="POST" class="form-inline" role="form" enctype="multipart/form-data">

				<div class="form-group">

					<input type="file" name="file" class="form-control" value="">

				</div>

				<button type="submit" class="btn btn-primary">Gửi</button>
			</form>
		</h3>
		
	</div>
</div>

<div class="row">
	<div class="col-md-10">
		<form action="#" method="GET" id="action_contact" class="form-inline">
			<?php $this->load->view('common/content/filter'); ?>
		</form>
	</div>
</div>

<div class="row">
	<h3 class="text-center">Nhật ký đã nhập từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
	<h3 class="text-center marginbottom35"> Tổng chi phí MKT : <?php echo $total_spend; ?> $</h3>
	<div class="container" style="max-width: 910px">
		<table>
			<thead>
			<tr>
				<th>Campain</th>
				<th>ID Campain</th>
				<th>Tài Khoản</th>
				<th>Ngày</th>
				<th>Lượng tiền (Vnđ)</th>
				<th>Người nhập</th>
				<th>Ngày nhập</th>
			</tr>
			</thead>
			<tbody id="log-body">
			<?php if (isset($campaign) && !empty($campaign)){ ?>
				<?php foreach ($campaign as $item){ ?>
					<tr>
						<td><?php echo $item['campaign_name']; ?></td>
						<td class="text-center">
							<?php echo $item['id_fb']; ?>
						</td>
						<td><?php echo $item['account']; ?></td>
						<td class="text-center">
							<?php echo date('d-m-Y', $item['time']); ?>
						</td>
						<td class="text-center"><?php echo $item['spend']; ?></td>
						<td><?php echo $item['user_create']; ?></td>
						<td><?php echo date('d-m-Y H:m:s', $item['date_create']); ?></td>

					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>



