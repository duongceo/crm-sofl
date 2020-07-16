
<tr>

	<td class="text-right"> Mã ngôn ngữ học </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_language_id">

			<option value="0"> Chọn mã ngôn ngữ</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['language_id'] ?>"<?php echo ($row['language_id'] == $value['language_id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
