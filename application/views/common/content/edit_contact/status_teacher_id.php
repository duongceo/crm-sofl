<tr>
	<td class="text-right"> Giảng viên </td>
	<td>
		<select class="form-control selectpicker" name="status_teacher_id">
			<option value="0">Trạng thái giảng viên</option>
			<?php foreach ($status_for_teacher as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['status_teacher_id']) echo 'selected'; ?>>
					<?php echo $value['status']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
