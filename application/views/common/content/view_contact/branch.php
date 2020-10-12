<tr>
	<td class="text-right">Cơ sở</td>
	<td>  <?php
		if (isset($rows['branch_id'])) {
			foreach ($branch as $key => $value) {
				if ($value['id'] == $rows['branch_id']) {
					echo $value['name'];
					break;
				}
			}
		} else echo "UNKNOWN";
		
		?>
	</td>
</tr>
