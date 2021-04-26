
<tr class="filter_date_date_happen">

    <td class="text-right"> Ngày so sánh: </td>

    <td>

 		<input type="text" class="form-control daterangepicker" name="filter_date_date_happen_compare" style="position: static" autocomplete="off"

        	<?php if (filter_has_var(INPUT_GET, 'filter_date_date_happen_compare')) { ?>

			   value="<?php echo filter_input(INPUT_GET, 'filter_date_date_happen_compare') ;?>"

		   	<?php } ?>

		/>

    </td>

</tr>
