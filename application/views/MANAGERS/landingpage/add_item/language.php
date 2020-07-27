
<tr>

	<td class="text-right"> Ngoại Ngữ </td>

	<td>

		<select class="form-control selectpicker" name="add_language_id">

			<option value="0"> Ngoại Ngữ </option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>

