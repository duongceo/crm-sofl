<tr>
	<td class="text-right"> Trạng thái gọi </td>
	<td>
		<select class="form-control selectpicker" name="customer_care_call_id">
			<option value="0">Trạng thái gọi</option>
			<?php foreach ($customer_call_status as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['customer_care_call_id']) echo 'selected'; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
