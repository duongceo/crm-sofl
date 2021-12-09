<tr>
	<td class="text-right"> Trạng thái contact </td>
	<td>
		<select class="form-control level_contact_id selectpicker" name="level_contact_id">
			<option value="">Trạng thái contact</option>
			<?php
            if ($this->role_id == 1 && $this->sale_study_abroad != 1) array_pop($level_contact);
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
	<td class="text-right">Trạng thái chi tiết</td>
	<td>
<!--		<input class="form-control" name="level_contact_detail" type="hidden" value="--><?php //echo (isset($rows['level_contact_detail'])) ? $rows['level_contact_detail'] : ''?><!--">-->
<!--		--><?php //echo (isset($rows['level_contact_name'])) ? $rows['level_contact_name'] : ''; ?>
        <select class="form-control selectpicker" name="level_contact_detail">
            <option value="">Trạng thái chi tiết</option>
            <?php foreach ($level_contact_detail as $key => $value) { ?>
                <option value="<?php echo $value['level_id']; ?>" <?php if ($value['level_id'] == $rows['level_contact_detail']) echo 'selected'; ?>>
                    <?php echo $value['level_id'] . ' - ' .$value['name']; ?>
                </option>
            <?php } ?>
        </select>
	</td>
</tr>
