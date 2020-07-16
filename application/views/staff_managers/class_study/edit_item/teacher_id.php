
<tr>

	<td class="text-right">Giảng viên </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="edit_teacher_id">

			<option value="0"> Chọn giảng viên</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"<?php echo ($row['teacher_id'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
