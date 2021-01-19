<tr>
	<td class="text-right"> Trạng thái học tập </td>
	<td>  <?php
		foreach ($level_study as $key => $value) {
			if ($value['level_id'] == $rows['level_study_id']) {
				echo $value['level_id'] .' - '. $value['name'];
				break;
			}
		}
		?>
	</td>
</tr>
