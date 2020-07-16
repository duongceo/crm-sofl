
<tr>

	<td class="text-right"> Vị trí </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_role_id">

			<option value=""> Chọn vị trí</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['position'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>

<tr class="ajax_kpi">

</tr>
