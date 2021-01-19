<tr>
	<td class="text-right"> Trạng thái học tập </td>
	<td>
		<select class="form-control selectpicker" name="level_study_id">
			<option value="">Trạng thái học tập</option>
			<?php foreach ($level_study as $key => $value) { ?>
				<option value="<?php echo $value['level_id']; ?>">
					<?php echo $value['level_id'] . ' - ' .$value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>

<tr class="ajax_level_study_id">
	<td class="text-right">Trạng thái chi tiết</td>
	<td>
		<input class="form-control" name="level_study_detail" type="hidden" value="<?php echo (isset($rows['level_study_id'])) ? $rows['level_study_id'] : ''?>">
		<?php echo (isset($rows['level_study_name'])) ? $rows['level_study_name'] : ''; ?>
	</td>
</tr>
