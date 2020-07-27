
<tr>

	<td class="text-right"> Ngoại ngữ </td>

	<td>

		<select class="form-control selectpicker" name="edit_language_id">

			<option value=""> Ngoại ngữ </option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>" <?php echo ($row['language_id'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
