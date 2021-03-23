<tr class="filter_date_date_recall">

	<td class="text-right"> Ngày hẹn gọi lại: </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_date_date_recall_customer_care" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_date_date_recall_customer_care')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_date_date_recall_customer_care') ;?>"

			<?php }?>

		/>

	</td>

</tr>
