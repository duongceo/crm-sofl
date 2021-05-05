<div class="container" style="width: 950px">
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
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Thời điểm gọi</th>
					<th>SĐT khách</th>
					<th>Sale</th>
					<th>Thời lượng gọi</th>
					<th>Cước phí</th>
					<th>File ghi âm</th>
					<th>Thao tác</th>
				</tr>
			</thead>
			<tbody id="log-body">
			<?php if (isset($history_call) && !empty($history_call)){ ?>
				<?php foreach ($history_call as $item){ ?>
					<tr>
						<td class="text-center">
							<?php echo date('d/m/Y H:i:s', $item['time_created']); ?>
						</td>
						<td style="cursor: pointer" class="text-center search_phone" type="<?php echo ($item['missed_call'] == 1) ? $item['source_number'] : $item['destination_number']?>">
							<?php echo ($item['missed_call'] == 1) ? $item['source_number'] : $item['destination_number']?> <span class="glyphicon glyphicon-search">
	<!--						--><?php //if ($item['missed_call'] == 1) { ?>
	<!--							<a target="_blank" href="--><?php //echo $_SERVER['REQUEST_URI'] . '#search='. $item['source_number']?><!--"> --><?php //echo $item['source_number']?><!-- <span class="glyphicon glyphicon-search"></span></a>-->
	<!--						--><?php //} else { ?>
	<!--							<a target="_blank" href="--><?php //echo $_SERVER['REQUEST_URI'] . '#search='. $item['destination_number']?><!--">--><?php //echo $item['destination_number']?><!-- <span class="glyphicon glyphicon-search"></span></a>-->
	<!--						--><?php //} ?>
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
	<!--							--><?php //echo $item['link_conversation']; ?>
								<a target="_blank" href="<?php echo $item['link_conversation']?>">File ghi âm <span class="glyphicon glyphicon-earphone"></span></a>
							<?php } ?>
						</td>
						<td class="text-center">
							<?php if ($item['missed_call'] == 1) { ?>
								<a style="margin: 0px;" class="btn btn-primary btn-sm recall_missed">Xử lý</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php $this->load->view('sale/modal/view_contact_from_ipphone'); ?>
