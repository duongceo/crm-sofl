<tr class="filter_date_date_transfer">

	<td class="text-right"> Ngày chuyển contact : </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_date_date_transfer" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_date_date_transfer')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_date_date_transfer') ;?>"

			<?php } ?>

		/>

	</td>

</tr>
