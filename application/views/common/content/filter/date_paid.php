<tr class="filter_date_date_paid">

	<td class="text-right"> Ngày đóng tiền: </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_date_date_paid" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_date_date_paid')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_date_date_paid') ;?>"

			<?php }?>

		/>

	</td>

</tr>
