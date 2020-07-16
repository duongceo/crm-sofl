<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td class="">
		<input type="checkbox" name="edit_empty" value="1" data-off-text="Ko còn Trống"
			   data-on-text="Còn Trống" data-handle-width="100" <?php if($row['empty'] == 0) { ?> checked="checked" <?php } ?>>
	</td>

</tr>

<script>

	$("[name='edit_empty']").bootstrapSwitch();

</script>
