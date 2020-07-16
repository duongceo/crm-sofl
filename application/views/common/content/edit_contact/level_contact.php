<tr>
	<td class="text-right"> Trạng thái contact </td>
	<td>
		<select class="form-control level_contact_id selectpicker" name="level_contact_id">
			<option value="">Trạng thái contact</option>
			<?php
			foreach ($level_contact as $key => $value) {
				?>
				<option value="<?php echo $value['level_id']; ?>" <?php if ($value['level_id'] == $rows['level_contact_id']) echo 'selected'; ?>>
					<?php echo $value['level_id'] . ' - ' .$value['name']; ?>
				</option>
				<?php
			}
			?>
		</select>
	</td>
</tr>

<tr class="ajax_level_contact_id">
	<td></td>
</tr>
