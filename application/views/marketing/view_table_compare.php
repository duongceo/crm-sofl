
<div class="row">

	<div class="col-md-10 col-md-offset-1">

		<h3 class="text-center marginbottom20"> Bảng so sánh với trong 3 tháng</h3>

	</div>

</div>

<form action="#" method="GET" id="action_contact" class="form-inline">

	<?php $this->load->view('common/content/filter'); ?>

</form>

<?php foreach ($report as $key => $value) { ?>

<div class="row">

	<table class="table table-bordered table-striped view_report gr4-table">
		<thead class="table-head-pos">
			<tr>
				<th ><h6 style="font-weight: bold;"><?php echo $key ?></h6></th>
				<th style="font-weight: bold;  background-color: #41658f">Contact (L1)</th>
				<th style="font-weight: bold; background-color: #41658f">Tổng chi phí</th>
				<th style="font-weight: bold; background-color: #41658f">Giá Contact</th>
				<th style="font-weight: bold; background-color: #3c7e5b">Đăng ký thành công (L5)</th>
				<th style="font-weight: bold; background-color: #3c7e5b">Doanh thu</th>
				<th style="font-weight: bold; background-color: #477e75">% Chốt</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($value as $key_2 => $item) { ?>
				<tr>
					<td style="background-color: #2f96ca ;color: #FFF;font-weight: bold"><?php echo $key_2 ?></td>
					<td><?php echo $item['L1'] ?></td>
					<td><?php echo $item['Ma_mkt']?> VNĐ</td>
					<td><?php echo $item['Gia_So']?> VNĐ</td>
					<td><?php echo $item['L5'] ?></td>
					<td><?php echo $item['Re_thuc_te']?> VNĐ</td>
					<td><?php echo $item['Chot']?> %</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

</div>
	<br>
<?php } ?>
