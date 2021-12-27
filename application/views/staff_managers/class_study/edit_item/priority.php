
<tr>

	<td class="text-right"> Ưu tiên </td>

	<td>

		<select class="form-control selectpicker" name="edit_priority_id">

			<option value="0"> Độ ưu tiên</option>

			<option value="1" <?php echo ($row['priority_id'] == 1) ? 'selected' : '' ; ?>> Ưu tiên 1 - Đã khai giảng</option>

			<option value="2" <?php echo ($row['priority_id'] == 2) ? 'selected' : '' ; ?>> Ưu tiên 2 - Chắc chắn khai giảng </option>

			<option value="3" <?php echo ($row['priority_id'] == 3) ? 'selected' : '' ; ?>> Ưu tiên 3 - Dự kiến khai giảng </option>

			<option value="4" <?php echo ($row['priority_id'] == 4) ? 'selected' : '' ; ?>> Ưu tiên 4 - Đã kết thúc </option>

		</select>

	</td>

</tr>
