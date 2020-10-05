
<?php if (!empty($paid)) { ?>
	<tr>
		<td class="text-right"> Nhật ký đóng tiền</td>
		<td>
			<table class="table table-bordered table-striped call-log">
				<thead>
				<tr>
					<th>
						Lần đóng
					</th>
					<th>
						Thời gian
					</th>
					<th>
						Tiền
					</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($paid as $key => $value) { ?>
					<tr>
						<td class="text-center">
							Lần <?php echo $key + 1; ?>
						</td>
						<td class="text-center">
							<?php echo date('d/m/Y H:i', $value['time_created']); ?>
						</td>
						<td class="text-center">
							<?php echo h_number_format($value['paid']); ?>
						</td>

					</tr>
				<?php } ?>
				</tbody>
			</table>
		</td>
	</tr>
<?php } ?>
