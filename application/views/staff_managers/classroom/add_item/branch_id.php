
<tr>

	<td class="text-right"> Cơ sở </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_branch_id">

			<option value=""> Chọn cơ sở</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
