<tr class="filter_tbl_cod_level">

	<td class="text-right"> Contact Black ? </td>

	<td class="is_black">
		<input type="checkbox" name="is_black" value="1"
			   data-off-text="Không" data-on-text="Có" data-handle-width="100" <?php if($rows['is_black'] == 1) { ?> checked="checked" <?php } ?>>
	</td>

</tr>

<script>
	<?php if ($rows['is_black'] == 1) { ?>
		$("[name='is_black']").bootstrapSwitch('state', true);
	<?php } else { ?> 
		$("[name='is_black']").bootstrapSwitch('state', false);
	<?php } ?>

</script>
