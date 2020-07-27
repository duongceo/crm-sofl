<tr>
	<td class="text-right"> Cơ sở </td>
	<td>
		<select class="form-control selectpicker" name="branch_id">
			<option value="">Chọn cơ sở</option>
			<?php foreach ($branch as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $rows['branch_id']) ? 'selected' : ''; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
