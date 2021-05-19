
<tr>

	<td class="text-right"> Đặc điểm lớp</td>

	<td>

		<select class="form-control selectpicker" name="edit_character_class_id">

			<option value="0"></option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>" <?php echo ($row['character_class_id'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
