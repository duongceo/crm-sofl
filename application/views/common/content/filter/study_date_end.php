<tr class="filter_study_date_end">

	<td class="text-right"> Ngày kết thúc: </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_study_date_end" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_study_date_end')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_study_date_end') ;?>"

			<?php }?>

		/>

	</td>

</tr>
