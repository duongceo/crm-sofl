<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td class="">
		<input type="checkbox" name="edit_status" value="1" data-off-text="Lớp đi lên"
			   data-on-text="Lớp mới" data-handle-width="100" <?php if($row['status'] == 1) { ?> checked="checked" <?php } ?>>

	</td>

</tr>

<script>

	$("[name='edit_status']").bootstrapSwitch();

</script>
