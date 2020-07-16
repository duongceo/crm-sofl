
<tr>

	<td class="text-right"> Mã phòng học </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="edit_classroom_id">

			<option value=""> Chọn mã phòng học</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['classroom_id'] ?>"<?php echo ($row['classroom_id'] == $value['classroom_id'])?'selected':''?>> <?php echo $value['classroom_id'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
