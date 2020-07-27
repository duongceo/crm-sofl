<tr>
	<td class="text-right"> Khóa đăng ký </td>
	<td>
		<select class="form-control selectpicker" name="level_language_id">
			<option value="">Chọn khóa học</option>
			<?php foreach ($level_language as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['level_language_id']) echo 'selected'; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
