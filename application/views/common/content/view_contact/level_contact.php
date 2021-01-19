<tr>
	<td class="text-right"> Trạng thái contact </td>
	<td>  <?php
		foreach ($level_contact as $key => $value) {
			if ($value['level_id'] == $rows['level_contact_id']) {
				echo $value['level_id'] .' - '. $value['name'];
				break;
			}
		}
		?>
	</td>
</tr>
