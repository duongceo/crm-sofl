<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td>
<!--		--><?php //print_arr($arr_data); ?>

		<select class="form-control selectpicker" name="filter_arr_<?php echo $key;?>">

			<option value=""> Chọn <?php echo h_find_name_display($key, $this->list_view); ?> </option>

			<?php foreach ($arr_data as $key => $value1) { ?>

				<option value="<?php echo $value1['classroom_id'] ?>"> <?php echo $value1['classroom_id'] ?></option>

			<?php } ?>

		</select>

	</td>

</tr>

