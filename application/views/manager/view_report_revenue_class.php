<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Báo cáo doanh thu lớp học từ ngày <?php echo date('d-m-Y', $startDate); ?> đến hết ngày <?php echo date('d-m-Y', $endDate); ?></h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<?php foreach ($report as $key => $item) { ?>
	<table class="table table-bordered table-striped view_report">
		<thead>
			<tr>
				<th style="background-color: #2b669a"><?php echo $key?></th>
				<th style="background-color: #2b669a">Số lượng học viên</th>
				<th style="background-color: #2b669a">Doanh Thu</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($item as $key_2 => $item_2) { ?>
				<tr>
					<td style="background-color: #43bcdf96"><h5><?php echo $key_2 ?></h5></td>
					<td>
						<h5><?php echo $item_2['student'] ?></h5>
					</td>
					<td>
						<h5><?php echo h_number_format($item_2['RE']) . ' VNĐ'; ?></h5>
					</td>
				</tr>
			<?php }	?>
		</tbody>
	</table>
<?php } ?>


