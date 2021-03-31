<tr class="filter_date_date_confirm">

	<td class="text-right"> Ngày cskh gọi: </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_date_date_customer_care_call" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_date_date_customer_care_call')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_date_date_customer_care_call') ;?>"

			<?php }?>

		/>

	</td>

</tr>
