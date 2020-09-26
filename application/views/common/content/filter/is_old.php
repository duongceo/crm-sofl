<tr class="filter_tv_dk">
	<td class="text-right"> Contact Mới/Cũ </td>
	<td>
		<select class="form-control filter selectpicker" name="filter_is_old">
			<option value="" <?php if (!isset($_GET['filter_is_old']) || $_GET['filter_is_old'] == '') { ?> selected="selected" <?php } ?>>
				Nothing selected
			</option>

			<option value="0" <?php if (isset($_GET['filter_is_old']) && $_GET['filter_is_old'] == 0) echo 'selected'; ?>> Mới
			</option>

			<option value="1" <?php if (isset($_GET['filter_is_old']) && $_GET['filter_is_old'] == 1) echo 'selected'; ?>> Cũ
			</option>
		</select>
	</td>
</tr>
