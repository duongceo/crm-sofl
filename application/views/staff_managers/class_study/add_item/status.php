<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td>
		<input type="checkbox" name="add_status" value="1" data-off-text="Lớp đi lên" data-on-text="Lớp mới" data-handle-width="100">
	</td>

</tr>

<script>

	$("[name='add_status']").bootstrapSwitch();

</script>
