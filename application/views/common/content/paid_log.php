<table class="table table-striped table-bordered table-hover call-log">
	<thead>
		<tr>
			<th>
				Lần đóng tiền
			</th>
			<th>
				Thời gian
			</th>
			<th>
				Tiền đóng
			</th>
			<th>
				Cơ sở
			</th>
			<th>
				Ngôn ngữ
			</th>
			<th>
				Cũ X Mới
			</th>
			<th>
				Nguồn thu
			</th>
			<th>
				Hình thức thanh toán
			</th>
            <?php if ($this->role_id == 3 || $this->role_id == 12) { ?>
                <th>
                    Xóa
                </th>
            <?php } ?>
		</tr>
	</thead>

	<tbody>
	<?php
        if (isset($paid_log)) {
            foreach ($paid_log as $key_paid_log => $value_paid_log) {
                ?>
                <tr>
                    <td class="text-center">
                        Lần đóng thứ <?php echo $key_paid_log + 1; ?>
                    </td>

                    <td class="text-center">
                        <?php echo date('d/m/Y H:i', $value_paid_log['time_created']); ?>
                    </td>

                    <td class="text-center">
                        <?php echo h_number_format($value_paid_log['paid']); ?>
                    </td>

                    <td class="text-center">
                        <?php echo $value_paid_log['branch_name']; ?>
                    </td>

                    <td class="text-center">
                        <?php echo $value_paid_log['language_name']; ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($value_paid_log['student_old'] == 1) ? 'Cũ' : 'Mới';?>
                    </td>

                    <td class="text-center">
                        <?php echo $value_paid_log['source_revenue_name']?>
                    </td>

                    <td class="text-center">
                        <?php echo $value_paid_log['payment_method_name']?>
                    </td>

                    <?php if ($this->role_id == 3 || $this->role_id == 12) { ?>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm delete_common" type_delete="paid" delete_id="<?php echo $value_paid_log['id'] ?>">Xóa</button>
                        </td>
                    <?php } ?>
                </tr>
                <?php
            }
        }
	?>

	</tbody>

</table>
