
<div class="row">
	<h3 class="text-center">Lịch sử cuộc gọi từ ngày <?php echo date('d-m-Y', $startDate); ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
	<h3 class="text-center marginbottom35"> Tổng cước phí gọi : <?php echo h_number_format($total_fee_call); ?> VNĐ</h3>

	<div class="row">
		<div class="col-md-10">
			<form action="#" method="GET" id="action_contact" class="form-inline">
				<?php $this->load->view('common/content/filter'); ?>
			</form>
		</div>
	</div>

	<div class="container" style="max-width: 910px">
		<table>
			<thead>
				<tr>
					<th>Thời điểm gọi</th>
					<th>SĐT khách</th>
					<th>Sale</th>
					<th>Thời lượng gọi</th>
					<th>Cước phí</th>
					<th>File ghi âm</th>
				</tr>
			</thead>
			<tbody id="log-body">
			<?php if (isset($history_call) && !empty($history_call)){ ?>
				<?php foreach ($history_call as $item){ ?>
					<tr>
						<td class="text-center">
							<?php echo date('d/m/Y H:i:s', $item['time_created']); ?>
						</td>
						<td class="text-center">
							<?php echo ($item['missed_call'] == 1) ? $item['source_number'] : $item['destination_number']; ?>
						</td>
						<td class="text-center">
							<?php echo $item['sale_name']; ?>
						</td>
						<td class="text-center">
							<?php echo gmdate('i:s', $item['time_call']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($item['fee_call']); ?> VNĐ
						</td>
						<td class="text-center">
							<?php if ($item['link_conversation'] != '') { ?>
								<a target="_blank" href="<?php echo $item['link_conversation']?>">File ghi âm <span class="glyphicon glyphicon-earphone"></span></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>


