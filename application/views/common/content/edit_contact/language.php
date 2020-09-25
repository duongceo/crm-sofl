<tr>
	<td class="text-right"> Ngoại ngữ </td>
	<td>
		<select class="form-control selectpicker" name="language_id">
			<option value="0">Chọn ngoại ngữ</option>
			<?php foreach ($language_study as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['language_id']) echo 'selected'; ?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
