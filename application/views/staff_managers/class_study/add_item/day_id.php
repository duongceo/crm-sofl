
<tr>

	<td class="text-right"> Ngày học</td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_day_id">

			<option value="0"> Ngày học</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['days']?></option>

			<?php } ?>

		</select>

	</td>

</tr>
