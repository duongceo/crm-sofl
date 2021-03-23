<tr>
	<td class="text-right"> Trạng thái đăng ký lên </td>
	<td>
		<select class="form-control selectpicker" name="status_end_student_id">
			<option value="0">Trạng thái đăng ký lên</option>
			<?php foreach ($status_end_student as $key => $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $rows['status_end_student_id']) echo 'selected'; ?>>
					<?php echo $value['status']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
