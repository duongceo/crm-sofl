
<tr>

	<td class="text-right">Thời gian học </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="edit_class_time_id">

			<option value="0"> Chọn thời gian học</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"<?php echo ($row['class_time_id'] == $value['id'])?'selected':''?>> <?php echo $value['classroom_id'].' : '.$value['time'].' : '. $value['days']?></option>

			<?php } ?>

		</select>

	</td>

</tr>
