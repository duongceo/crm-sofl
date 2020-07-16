
<tr>

	<td class="text-right"> Mã lớp học </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="edit_class_study_id">

			<option value=""> Chọn mã lớp học</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['class_study_id'] ?>"<?php echo ($row['class_study_id'] == $value['class_study_id'])?'selected':''?>> <?php echo $value['class_study_id'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
