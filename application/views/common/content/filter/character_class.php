<tr>
	<td class="text-right"> Trạng thái lớp học </td>
	<td>
		<select class="form-control selectpicker" name="filter_character_class_id[]" multiple>
			<?php foreach ($character_class as $key => $value) {
				?>
				<option value="<?php echo $value['id']; ?>"
					<?php
					if (isset($_GET['filter_character_class_id'])) {
						foreach ($_GET['filter_character_class_id'] as $value2) {
							if ($value2 == $value['id']) {
								echo 'selected';
								break;
							}
						}
					}
					?>>
					<?php echo $value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>
