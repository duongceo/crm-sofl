<tr class="filter_study_date_start">

	<td class="text-right"> Ngày khai giảng: </td>

	<td>

		<input type="text" class="form-control daterangepicker" name="filter_study_date_start" style="position: static" autocomplete="off"

			<?php if (filter_has_var(INPUT_GET, 'filter_study_date_start')) { ?>

				value="<?php echo filter_input(INPUT_GET, 'filter_study_date_start') ;?>"

			<?php }?>

		/>

	</td>

</tr>
