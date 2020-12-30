<tr class="filter_complete_fee">
	<td class="text-right"> Hoàn thành học phí </td>
	<td>
		<select class="form-control selectpicker" name="filter_complete_fee">
			<option value="" <?php if (!isset($_GET['filter_complete_fee']) || $_GET['filter_complete_fee'] == '') { ?> selected="selected" <?php } ?>>
				Nothing selected
			</option>

			<option value="0" <?php if (isset($_GET['filter_complete_fee']) && $_GET['filter_complete_fee'] == '0') echo 'selected'; ?>> Chưa Hoàn Thành
			</option>

			<option value="1" <?php if (isset($_GET['filter_complete_fee']) && $_GET['filter_complete_fee'] == 1) echo 'selected'; ?>> Đã Hoàn Thành
			</option>
		</select>
	</td>
</tr>
