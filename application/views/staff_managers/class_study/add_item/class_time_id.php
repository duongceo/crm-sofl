
<tr>

	<td class="text-right"> Phòng & Ca học</td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_class_time_id">

			<option value="0"> Chọn phòng & ca học</option>

			<?php foreach ($arr as $key => $value) { ?>s

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['classroom_id'].' : '.$value['time'].' : '. $value['days']?></option>

			<?php } ?>

		</select>

	</td>

</tr>
