<tr class="filter_missed_call">
	<td class="text-right"> Cuộc gọi nhỡ </td>
	<td>
		<select class="form-control selectpicker" name="filter_missed_call">
			<option value="" <?php if (!isset($_GET['filter_missed_call'])) { ?> selected="selected" <?php } ?>>
				Nothing
			</option>

			<option value="0" <?php if (isset($_GET['filter_missed_call']) && $_GET['filter_missed_call'] == '0') echo 'selected'; ?>>
				Không
			</option>

			<option value="1" <?php if (isset($_GET['filter_missed_call']) && $_GET['filter_missed_call'] == '1') echo 'selected'; ?>>
				Có
			</option>
		</select>
	</td>
</tr>
