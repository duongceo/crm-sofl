
<tr>

	<td class="text-right"> Trình độ lớp học </td>

	<td>

		<select class="form-control select_course_code selectpicker" name="edit_level_language_id">

			<option value="0"> Trình độ lớp học</option>
			<option value="CB" <?php echo ($row['level_language_id'] == 'CB')?'selected':''?>> Cơ Bản</option>
			<option value="NC" <?php echo ($row['level_language_id'] == 'NC')?'selected':''?>> Nâng Cao</option>

		</select>

	</td>

</tr>
