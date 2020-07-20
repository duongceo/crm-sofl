
<tr>

	<td class="text-right"> Giờ học</td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_time_id">

			<option value="0"> Giờ học</option>

			<?php foreach ($arr as $key => $value) { ?>s

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['times']?></option>

			<?php } ?>

		</select>

	</td>

</tr>
