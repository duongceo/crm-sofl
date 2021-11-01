
<tr>

	<td class="text-right"> Trình độ</td>

	<td>

		<select class="form-control selectpicker" name="edit_level_language_id">

			<option value="0"> Trình độ</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"<?php echo ($row['level_language_id'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
