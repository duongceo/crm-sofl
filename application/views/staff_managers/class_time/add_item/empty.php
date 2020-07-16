<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td class="">
		<input type="checkbox" name="add_empty" value="1" data-off-text="Không còn Trống "
			   data-on-text="Còn Trống" data-handle-width="100" <?php if($row['empty'] == 1) { ?> checked="checked" <?php } ?>>

	</td>

</tr>

<script>

	$("[name='add_empty']").bootstrapSwitch();

</script>
