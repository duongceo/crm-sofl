<tr>
	<td class="text-right"> Trạng thái học viên </td>
	<td>
		<select class="form-control selectpicker" name="level_student_id">
			<option value="">Trạng thái học viên</option>
			<?php foreach ($level_student as $key => $value) { ?>
				<option value="<?php echo $value['level_id']; ?>" <?php if ($value['level_id'] == $rows['level_student_id']) echo 'selected'; ?>>
					<?php echo $value['level_id'] . ' - ' .$value['name']; ?>
				</option>
			<?php } ?>
		</select>
	</td>
</tr>

<!--<tr class="ajax_level_student_id">-->
<!--	<td class="text-right">Trạng thái chi tiết</td>-->
<!--	<td>-->
<!--		<input class="form-control" name="level_student_detail" type="hidden" value="--><?php //echo (isset($rows['level_student_id'])) ? $rows['level_student_id'] : ''?><!--">-->
<!--		--><?php //echo (isset($rows['level_student_name'])) ? $rows['level_student_name'] : ''; ?>
<!--	</td>-->
<!--</tr>-->
