<tr>

	<td class="text-right">

		<?php echo h_find_name_display($key, $this->list_view); ?>

	</td>

	<td class="">
		<input type="checkbox" name="edit_active" value="1" data-off-text="Ko hoạt động" data-on-text="Hoạt động" data-handle-width="100" <?php if($row['active'] == 1) { ?>

			checked="checked" <?php } ?>>

	</td>

</tr>

<script>

	$("[name='edit_active']").bootstrapSwitch();

</script>
