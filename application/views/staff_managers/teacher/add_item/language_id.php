
<tr>

	<td class="text-right"> Ngoại ngữ</td>

	<td>

		<select class="form-control select_course_code selectpicker" name="add_language_id">

			<option value="0"> Ngoại ngữ</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
