<tr>
	<td class="text-right"> Ngoại ngữ </td>
	<td>
		<select class="form-control selectpicker language_id" type="language" name="language_id">
			<option value="0">Chọn ngoại ngữ</option>
			<?php foreach ($language_study as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['language_id']) echo 'selected'; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>

<tr class="ajax_level_language_id">
	<td class="text-right">Khóa học</td>
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
