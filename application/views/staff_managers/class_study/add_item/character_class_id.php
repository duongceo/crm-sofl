
<tr>

	<td class="text-right"> Đặc điểm lớp</td>

	<td>

		<select class="form-control selectpicker" name="add_character_class_id">

			<option value="1">Chưa Khai Giảng</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>"> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
