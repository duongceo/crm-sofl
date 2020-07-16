
<tr>

	<td class="text-right"> Giảng viên </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_teacher_id">

			<option value="0"> Chọn giảng viên</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
