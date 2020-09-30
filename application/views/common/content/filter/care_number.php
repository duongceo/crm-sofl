<tr>
	<td class="text-right"> Số lần gọi </td>
	<td>
		<select class="form-control selectpicker" name="filter_care_number">
			<option value="" <?php if (isset($_GET['filter_care_number']) && $_GET['filter_care_number'] == '') {echo 'selected';}?>>Nothing selected</option>
			<?php for ($i = 1; $i < 6; $i++) { ?>
				<option value="<?php echo $i?>" <?php if (isset($_GET['filter_care_number']) && $_GET['filter_care_number'] == $i) {echo 'selected';}?>> <?php echo $i?> Lần</option>
			<?php } ?>
s		</select>
	</td>
</tr>
