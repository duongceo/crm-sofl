<tr>
	<td class="text-right"> Tư vấn viên chăm sóc </td>
	<td>
		<select class="form-control selectpicker" name="status_sale_id">
			<option value="0">Trạng thái tư vấn viên</option>
			<?php foreach ($status_for_sale as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['status_sale_id']) echo 'selected'; ?>>
					<?php echo $value['status']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
