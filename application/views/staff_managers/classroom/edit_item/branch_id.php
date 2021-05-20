
<tr>

	<td class="text-right"> Cơ sở </td>

	<td>

		<select class="form-control selectpicker" name="edit_branch_id">

			<option value=""> Chọn cơ sở</option>

			<?php foreach ($arr as $key => $value) { ?>

				<option value="<?php echo $value['id'] ?>" <?php echo ($row['branch_id'] == $value['id'])?'selected':''?>> <?php echo $value['name'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>
